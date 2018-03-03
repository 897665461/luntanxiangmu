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


        for($i=0;$i<10;$i++) {
            if(isset($liebiao["$i"])) {
                $liebiao["$i"]['create_at'] = date("Y-m-d H:i:s", ceil($liebiao["$i"]['create_at']));
                $liebiao["$i"]['user_id'] = User::id_to_n($liebiao["$i"]['user_id']);
                $liebiao["$i"]['tag_id'] = Tag::id_to_t($liebiao["$i"]['tag_id']);
                $liebiao["$i"]['rsum'] = Reply::id_to_sum($liebiao["$i"]['id']);
            }
        }


        $suoyouliebiao = Db::table('luntan_tiezi')->field('id')->select();
        $tiaoshu = count($suoyouliebiao);
        $yeshu = ceil($tiaoshu/10);
        $fenye = array();
        $fenye['liebiao'] = $liebiao;
        $fenye['yeshu'] = $yeshu;
        $fenye['yema'] = $yema;
        return $fenye;
    }
    public function xiangqing($id)
    {
        return Db::table('luntan_tiezi')->where('id','eq',"$id")->select();

    }

}