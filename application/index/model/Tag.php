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

}