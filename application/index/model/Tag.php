<?php
namespace app\index\model;
use think\Model;
use think\Db;

class Tag extends Model
{
    public function tag()
    {
        return Db::table('luntan_tag')->field('id,name')->select();
    }
    public function ttag($id)
    {
        return Db::table('luntan_tag')->field('name')->where('id','eq',$id)->select();
    }
    static public function id_to_t($id)
    {
        $res = Db::table('luntan_tag')->field('name')->where('id','eq',$id)->find();//返回的是以字段名为键值的数组
        return $res['name'];
    }


}