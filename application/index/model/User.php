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
    static public function naTopa($name)
    {
        $res = Db::table('luntan_user')->where('name','eq',$name)->find();
        return $res;
    }
    public function usersum()
    {
        $res = Db::table('luntan_user')->count();
        return $res;
    }
    public function updatepa($name,$password)
    {
        $arr['name'] = $name;
        $arr1['password'] = $password;
        Db::table('luntan_user')->where($arr)->update($arr1);
    }
    public function users()
    {
        $res = Db::table('luntan_user')->select();
        return $res;
    }
    public function mdel($user_id)
    {
        $arr['id'] = $user_id;
        $arr1['is_del'] = 1;
        return Db::table('luntan_user')->where($arr)->update($arr1);
    }
    public function mcdel($user_id)
    {
        $arr['id'] = $user_id;
        $arr1['is_del'] = 0;
        return Db::table('luntan_user')->where($arr)->update($arr1);
    }


}