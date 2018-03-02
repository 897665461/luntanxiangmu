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

}