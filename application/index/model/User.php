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


}