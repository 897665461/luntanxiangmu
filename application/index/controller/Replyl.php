<?php
namespace app\index\controller;
use think\Request;
use app\index\model\Reply;
use think\Controller;

class Replyl extends controller
{
    /*
     * 接受回复的信息，存到数据库
     * */
    public function reply(Request $request)
    {
        $data = $request->post();
        $id = $data['id'];

        if(!empty(trim($data['reply']))) {
            $reply = new Reply();
            $reply->reply_id = 0;
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

}