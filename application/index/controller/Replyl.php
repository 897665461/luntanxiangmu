<?php
namespace app\index\controller;
use think\Request;
use app\index\model\Reply;
use  app\index\model\Zan;
use think\Controller;

class Replyl extends controller
{
    /*
     * 接受回复的信息，存到数据库
     * */
    public function reply(Request $request)
    {
        $data = $request->post();
        var_dump($data);

        $id = $data['id'];
        $reply_id = isset($data['reply_id'])?$data['reply_id']:0;
        if(!empty(trim($data['reply']))) {
            $reply = new Reply();
            $reply->reply_id = $reply_id;
            $reply->tie_id = $data['id'];
            $reply->content = $data['reply'];
            $reply->user_id = session('user_id');
            list($haomiao, $miao) = explode(' ', microtime());
            $reply->create_at = $miao + $haomiao;
            $reply->save();
           echo "<script>alert('回复成功');window.location.href='/luntan/public/index.php/index/index/post.html?id=$id'</script>";
        }
        else
        {
            echo "<script>alert('请填写回复内容');window.location.href='/luntan/public/index.php/index/index/post.html?id=$id'</script>";
        }

    }
    public function dianzan()
    {
        $user_id = session('user_id');
        $tie_id =$_GET['tid'];
        $zan = new Zan();
        $res = $zan->zan($user_id,$tie_id);
        if($res==1)
        {
            $this->success('您已经点赞');
        }else{
            $this->success('点赞成功');
        }
    }
    public function quxiao()
    {
        $user_id = session('user_id');
        $tie_id =$_GET['tid'];
        $zan = new Zan();
        $res = $zan->cai($user_id,$tie_id);
        if($res==1 )
        {
            $this->success('取消成功');
        }else{
            $this->success('取消失败');
        }
    }
    public function replyuser(Request $request)
    {
        var_dump($request->post());
    }





}