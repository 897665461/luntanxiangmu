<?php
namespace app\admin\controller;

use app\index\model\Tiezi;
use app\index\model\User;
use app\index\model\Tag;
use app\index\model\Reply;
use app\index\model\Zan;
use think\Controller;

class Index extends Controller
{
    public function index()
    {
        $tiezi = new Tiezi();
        //统计信息传递
        $tiezisum = $tiezi->tiezisum();
        $this->assign('tiezisum',$tiezisum);

        $user = new User();
        $usersum = $user->usersum();
        $this->assign('usersum',$usersum);

        $tag = new Tag();
        $tagsum = $tag->tagsum();
        $this->assign('tagsum',$tagsum);

        $reply = new Reply();
        $replysum = $reply->replysum();
        $this->assign('replysum',$replysum);

        $zan = new Zan();
        $zansum = $zan->zansum();
        $this->assign('zansum',$zansum);
        return $this->fetch();
    }
    public function user()
    {
        $user = new User();
        $users = $user->users();
        $this->assign('users',$users);
        return $this->fetch();
    }
    public function cdel()
    {
        $user_id = $_GET['id'];
        $user = new User();
        $res = $user->mdel($user_id);
        if(empty($res)){
            $this->success('删除失败','admin/index/user');
        }else{
            $this->success('删除成功','admin/index/user');
        }
    }
    public function cqdel()
    {
        $user_id = $_GET['id'];
        $user = new User();
        $res = $user->mcdel($user_id);
        if(empty($res)){
            $this->success('取消失败','admin/index/user');
        }else{
            $this->success('取消删除成功','admin/index/user');
        }
    }
    public function tiezi()
    {
        $this->assign('type','shouye');

        //传递当前页的信息
        $yema = empty($_GET['yema'])?1:$_GET['yema'];
        $tiezi = new Tiezi();
        $fenye = $tiezi->liebiao($yema);
        $liebiao = array_shift($fenye);
        $this->assign('liebiao',$liebiao);
        $this->assign('fenye',$fenye);
        $this->assign('user', session('user'));
        return $this->fetch();
    }
    public function cdeltiezi()
    {
        $tie_id = $_GET['tie_id'];
        $user = new Tiezi();
        $res = $user->mdeltiezi($tie_id);
        if(empty($res)){
            $this->success('删除失败','admin/index/tiezi');
        }else{
            $this->success('删除成功','admin/index/tiezi');
        }
    }

    public function chuifutiezi()
    {
        $tie_id = $_GET['tie_id'];
        $user = new Tiezi();
        $res = $user->mhuifutiezi($tie_id);
        if(empty($res)){
            $this->success('恢复失败','admin/index/tiezi');
        }else{
            $this->success('恢复成功','admin/index/tiezi');
        }
    }
}
