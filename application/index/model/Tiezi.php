<?php
namespace app\index\model;
use think\Model;
use app\index\model\My;
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
        $liebiao = Db::table('luntan_tiezi')->limit($tiaoma,10)->order('create_at desc')->select();
        $zan = new Zan();
        $my = new My();
        $reply = new Reply();
        for($i=0;$i<10;$i++) {
            if(isset($liebiao["$i"])) {
                $liebiao["$i"]['create_at'] = date("Y-m-d H:i:s", ceil($liebiao["$i"]['create_at']));
                $liebiao["$i"]['image'] = $my->qu($liebiao["$i"]['user_id']);
                $liebiao["$i"]['user_id'] = User::id_to_n($liebiao["$i"]['user_id']);
                $liebiao["$i"]['tag_id'] = Tag::id_to_t($liebiao["$i"]['tag_id']);
                $liebiao["$i"]['rsum'] = Reply::id_to_sum($liebiao["$i"]['id']);
                $liebiao["$i"]['zanshu'] = $zan->quzan( $liebiao["$i"]['id']);
                $liebiao["$i"]['weihuifu'] = $reply->weihuifu($liebiao["$i"]['id']);

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
    /*
     * 根据赞的数量的分页系统
     * */
    public function zanfenye($yema)
    {
        $liebiao = Db::table('luntan_tiezi')->order('create_at desc')->select();
        $zan = new Zan();
        $my = new My();
        //构建列表详情的数组
        for($i=0;$i<count($liebiao);$i++) {
            if(isset($liebiao["$i"])) {
                $liebiao["$i"]['create_at'] = date("Y-m-d H:i:s", ceil($liebiao["$i"]['create_at']));
                $liebiao["$i"]['image'] = $my->qu($liebiao["$i"]['user_id']);
                $liebiao["$i"]['user_id'] = User::id_to_n($liebiao["$i"]['user_id']);
                $liebiao["$i"]['tag_id'] = Tag::id_to_t($liebiao["$i"]['tag_id']);
                $liebiao["$i"]['rsum'] = Reply::id_to_sum($liebiao["$i"]['id']);
                $liebiao["$i"]['zanshu'] = $zan->quzan( $liebiao["$i"]['id']);

            }
        }
        //对数组进行排序
        for($i=0;$i<count($liebiao);$i++) {
            if(isset($liebiao["$i"])) {
               $arr["$i"] = $liebiao["$i"]['zanshu'];
            }
        }
        arsort($arr);
        $yeshu = $liebiaozan['0'] = ceil(count($liebiao)/10);
        foreach($arr as $key=>$value)
        {
            $liebiaozan[] = $liebiao["$key"];

        }
        $tiaoma = ($yema-1)*10+1;
        for($i=$tiaoma;$i<$tiaoma+10;$i++)
        {
            if(isset($liebiaozan[$i])) {
                $zanbiao[] = $liebiaozan[$i];
            }
        }
        // $zanbiao['yeshu'] = $yeshu;

        $fenye['liebiao'] = $zanbiao;
        $fenye['yeshu'] = $yeshu;
        $fenye['yema'] = $yema;
        return $fenye;

    }
    /*
     * 最多回复的分页系统
     * */
    public function huifenye($yema)
    {
        $liebiao = Db::table('luntan_tiezi')->order('create_at desc')->select();
        $reply = new Reply();
        $my = new My();
        //构建列表详情的数组
        for($i=0;$i<count($liebiao);$i++) {
            if(isset($liebiao["$i"])) {
                $liebiao["$i"]['create_at'] = date("Y-m-d H:i:s", ceil($liebiao["$i"]['create_at']));
                $liebiao["$i"]['image'] = $my->qu($liebiao["$i"]['user_id']);
                $liebiao["$i"]['user_id'] = User::id_to_n($liebiao["$i"]['user_id']);
                $liebiao["$i"]['tag_id'] = Tag::id_to_t($liebiao["$i"]['tag_id']);
                $liebiao["$i"]['rsum'] = Reply::id_to_sum($liebiao["$i"]['id']);
                $liebiao["$i"]['zanshu'] = $reply->tie_reply_sum( $liebiao["$i"]['id']);

            }
        }
        //对数组进行排序
        for($i=0;$i<count($liebiao);$i++) {
            if(isset($liebiao["$i"])) {
                $arr["$i"] = $liebiao["$i"]['zanshu'];
            }
        }
        arsort($arr);
        $yeshu = $liebiaozan['0'] = ceil(count($liebiao)/10);
        foreach($arr as $key=>$value)
        {
            $liebiaozan[] = $liebiao["$key"];

        }
        $tiaoma = ($yema-1)*10+1;
        for($i=$tiaoma;$i<$tiaoma+10;$i++)
        {
            if(isset($liebiaozan[$i])){
            $zanbiao[] = $liebiaozan[$i];
            }
        }
        // $zanbiao['yeshu'] = $yeshu;

        $fenye['liebiao'] = $zanbiao;
        $fenye['yeshu'] = $yeshu;
        $fenye['yema'] = $yema;
        return $fenye;
    }
    public function myreply($yema,$user_id)
    {
        $liebiao = Db::table('luntan_tiezi')->where('user_id','eq',$user_id)->order('create_at desc')->select();
        $reply = new Reply();
        $my = new My();
        //构建列表详情的数组
        for($i=0;$i<count($liebiao);$i++) {
            if(isset($liebiao["$i"])) {
                $liebiao["$i"]['create_at'] = date("Y-m-d H:i:s", ceil($liebiao["$i"]['create_at']));
                $liebiao["$i"]['image'] = $my->qu($liebiao["$i"]['user_id']);
                $liebiao["$i"]['user_id'] = User::id_to_n($liebiao["$i"]['user_id']);
                $liebiao["$i"]['tag_id'] = Tag::id_to_t($liebiao["$i"]['tag_id']);
                $liebiao["$i"]['rsum'] = Reply::id_to_sum($liebiao["$i"]['id']);
                $liebiao["$i"]['zanshu'] = $reply->tie_reply_sum( $liebiao["$i"]['id']);

            }
        }
        //对数组进行排序
        for($i=0;$i<count($liebiao);$i++) {
            if(isset($liebiao["$i"])) {
                $arr["$i"] = $liebiao["$i"]['zanshu'];
            }
        }
        arsort($arr);
        $yeshu = $liebiaozan['0'] = ceil(count($liebiao)/10);
        foreach($arr as $key=>$value)
        {
            $liebiaozan[] = $liebiao["$key"];

        }
        $tiaoma = ($yema-1)*10+1;
        for($i=$tiaoma;$i<$tiaoma+10;$i++)
        {
            if(isset($liebiaozan[$i])){
                $zanbiao[] = $liebiaozan[$i];
            }
        }
        // $zanbiao['yeshu'] = $yeshu;
        $fenye['liebiao'] = $zanbiao;
        $fenye['yeshu'] = $yeshu;
        $fenye['yema'] = $yema;
        return $fenye;
    }
    /*
     * 根据帖子的id取出对应帖子的全部信息
     * */
    public function xiangqing($id)
    {
        $xiangqing = Db::table('luntan_tiezi')->where('id','eq',"$id")->select();
        $xiangqing[0]['create_at'] = date('Y-m-d H:i:s',ceil($xiangqing[0]['create_at']));
        $xiangqing[0]['zuozhe_id'] =$xiangqing[0]['user_id'];
        $xiangqing[0]['user_id'] = User::id_to_n($xiangqing[0]['user_id']);
        return $xiangqing;
    }
    //统计帖子的总数
    public function tiezisum()
    {
        return Db::table('luntan_tiezi')->count();
    }
    /*
     *返回热门标签的id,及条数
     * */
    public function hottag()
    {
        $tagids = Db::table('luntan_tag')->field('id')->select();
        $tagtiaoshu = 0;
        foreach($tagids as $tagid)
        {
            $tagtiaoshuz = Db::table('luntan_tiezi')->where('tag_id','eq',$tagid['id'])->count();
            if( $tagtiaoshuz>$tagtiaoshu)
            {
                $tagtiaoshu = $tagtiaoshuz;
                $hottag['id'] = $tagid['id'];
                $hottag['tiaoshu'] = $tagtiaoshu;
            }
        }
        return $hottag;
    }
    /*
     * 阅读次数自动加一
     * */
    public function yuedu($tie_id)
    {
        $res = Db::table('luntan_yuedu')->where('tie_id','eq',$tie_id)->find();
        if(!$res) {
            $arr['tie_id'] = $tie_id;
            $arr['time'] = 1;
            Db::table('luntan_yuedu')->insert($arr);
        }
        else {
            $res = Db::table('luntan_yuedu')->where('tie_id','eq',$tie_id)->find();
            $res['time'] = $res['time']+1;
            //$res['tie_id'] = $tie_id;
            Db::table('luntan_yuedu')->where('tie_id','eq',$tie_id)->update($res);
        }
    }
    /*
     * 输入文章id
     * 返回文章次数
     * */
    public function yuetime($tie_id)
    {
        $res = Db::table('luntan_yuedu')->where('tie_id', 'eq', $tie_id)->find();
        return $res['time'];
    }
    /*
     * 输入帖子的标题
     * 返回帖子的id
     * */
    public function tiToid($titie)
    {
        $res = Db::table('luntan_tiezi')->where('title', 'eq', $titie)->find();
        return $res['id'];
    }

    /**
     * @param $id
     * @return mixed
     * 输入帖子id 返回帖子的name
     */
    public static function idToname($id)
    {
        $res = Db::table('luntan_tiezi')->where('id', 'eq', $id)->find();
        return $res['name'];
    }

    /**
     * @param $tie_id
     * @return int|string
     * @throws \think\Exception
     * 输入帖子id 将此帖子删除标志改为1
     */
    public function mdeltiezi($tie_id)
    {
        $arr['id'] = $tie_id;
        $arr1['is_del'] = 1;
        return Db::table('luntan_tiezi')->where($arr)->update($arr1);
    }
    /**
     * @param $tie_id
     * @return int|string
     * @throws \think\Exception
     * 输入帖子id 将此帖子删除标志改为0
     */
    public function mhuifutiezi($tie_id)
    {
        $arr['id'] = $tie_id;
        $arr1['is_del'] = 0;
        return Db::table('luntan_tiezi')->where($arr)->update($arr1);
    }


}