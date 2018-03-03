<?php
namespace app\index\model;
use app\index\model\User;
use think\Model;
use think\Db;
class Reply extends Model
{
    /*
     * 从reply数据表中取出相应文章的回复信息
     * 把时间转化成正常的格式
     * 根据user_id从user表中取出相应的name，并做修改
     * */
    public function replybiao($tie_id)
    {
        $replybiao =  Db::table('luntan_reply')->where('tie_id','eq',$tie_id)->select();

        for($i=0;$i<count($replybiao);$i++) {
            $replybiao["$i"]['create_at'] = date("Y-m-d H:i:s", ceil($replybiao["$i"]['create_at']));
            $replybiao["$i"]['user_id'] = User::id_to_n( $replybiao["$i"]['user_id']);
        }

        return $replybiao;
    }
    static public function id_to_sum($tie_id)
    {
        $replybiao =  Db::table('luntan_reply')->where('tie_id','eq',$tie_id)->select();
        return count($replybiao);
    }
}