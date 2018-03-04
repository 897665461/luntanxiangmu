<?php
namespace app\index\model;
use think\Model;
use think\Db;
class User extends Model
{
    static public function id_to_n($id)
    {
        $res = Db::table('luntan_user')->where('id','eq',$id)->find();
        return $res['name'];
    }
    public function usersum()
    {
        $res = Db::table('luntan_user')->count();
        return $res;
    }

}