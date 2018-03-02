<?php
namespace app\index\model;
use think\Model;
use think\Db;

class Tiezi extends Model
{
    /*
     * 分页系统
     * 输入页码
     * 返回页数，页码，当前页的列表
     * */
    public function liebiao($yema)
    {
        $tiaoma = ($yema-1)*10;
        $liebiao = Db::table('luntan_tiezi')->limit($tiaoma,10)->select();
        $suoyouliebiao = Db::table('luntan_tiezi')->field('id')->select();
        $tiaoshu = count($suoyouliebiao);
        $yeshu = ceil($tiaoshu/10);
        $fenye = array();
        $fenye['liebiao'] = $liebiao;
        $fenye['yeshu'] = $yeshu;
        $fenye['yema'] = $yema;
        return $fenye;
    }
    public function xiangqing()
    {

    }

}