<?php
namespace app\index\model;
use think\Model;
use think\Db;

class My extends Model
{
    /*
     * 已有数据则更新
     * 否则添加
     * */
    public function gengxin($id,$city,$company,$wangzhi,$qianming,$jieshao,$language)
    {
        $res = Db::table('luntan_my')->where('user_id','eq',$id)->find();
        if(!$res) {

            $my = new My();
            $my->user_id = $id;
            $my->city = $city;
            $my->company = $company;
            $my->wangzhi = $wangzhi;
            $my->qianming = $qianming;
            $my->jieshao = $jieshao;
            $my->language = $language;
            $my->save();

        }else{
            $arr['user_id'] = $id;
            $arr['city'] = $city;
            $arr['company'] = $company;
            $arr['wangzhi'] = $wangzhi;
            $arr['qianming'] = $qianming;
            $arr['jieshao'] = $jieshao;
            $arr['language'] = $language;
            Db::table('luntan_my')->where('user_id','eq',$id)->update($arr);
        }
    }
    /*
     *传入user_id，取出相应的信息
     * */
    public function quchu($user_id)
    {
        return Db::table('luntan_my')->where('user_id','eq',$user_id)->find();
    }
    /*
     * 将图片信息上传到指定文件
     * 并返回文件名
     * */
    public function cunimage($tupianxinxi)
    {
        $wenjian = '';
        if ($tupianxinxi['error'] > 0) {
            switch ($tupianxinxi['error']) {
                case 1;
                    echo '图片' . "上传的文件过大";
                    break;
                case 2;
                    echo '图片' . "上传的文件过大";
                    break;
                case 3;
                    echo '图片' . "网络出现问题";
                    break;
                case 4;
                    echo '图片' . "未选中";
                    break;
            }
        }else{
            $file = $tupianxinxi['name'];
            move_uploaded_file($tupianxinxi['tmp_name'],ROOT.'\static\images\\'.$file);
            $wenjian = $file;
        }
        return $wenjian;
    }
    /*
     *更新数据库中的头像文件
     * */
    public function cun($arr)
    {
       $res = Db::table('images')->where('user_id','eq',$arr['user_id'])->find();
        if($res)
        {
            Db::table('images')->where('user_id','eq',$arr['user_id'])->update($arr);
        }else {
            Db::table('images')->insert($arr);
        }
    }
    public function qu($user_id)
    {
        $res = Db::table('images')->where('user_id','eq',$user_id)->find();
        return $res['image'];
    }
}
