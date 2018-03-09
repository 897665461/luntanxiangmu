<?php
namespace app\index\model;
use think\Db;
use think\Model;
class Zan extends Model
{
    public function zan($user_id,$tie_id)
    {
        $dianzanren = session('user_id');
        if(!$dianzanren)
        {
            return "<script>alert('请登陆')</script>";
        }
        $res['user_id'] = $user_id;
        $res['tie_id'] = $tie_id;
        $if =  Db::table('luntan_zan')->where($res)->find();
        if(empty($if))
        {
            $arr['user_id'] = $user_id;
            $arr['tie_id'] = $tie_id;
            $create_at = round(microtime());
            $arr['create_at'] = $create_at;
            Db::table('luntan_zan')->insert($arr);
        }else{
            return 1;
        }
    }
    public function quzan($tie_id)
    {
        $res['tie_id'] = $tie_id;
        $r = Db::table('luntan_zan')->where($res)->count();
        return $r;
    }
    public function cai($user_id,$tie_id)
    {
        $res['user_id'] = $user_id;
        $res['tie_id'] = $tie_id;
        return Db::table('luntan_zan')->where($res)->delete();
    }
    public function zansum()
    {
        return Db::table('luntan_zan')->count();
    }
}
