<?php
namespace app\index\controller;
use app\index\model\My;
use app\index\model\User;
use app\index\model\Tiezi;
use app\index\model\Tag;
use app\index\model\Reply;
use app\index\model\Zan;
use think\Controller;
use think\Request;
use think\Db;

class Index extends Controller
{
    public $user_id;
    /*
     * 跳转到注册页面
     * */
    public function zhuce( )
    {
        return $this->fetch();
    }
    /*
     * 接受密码
     * 检验密码
     * 存储密码
     * */
    public function zhuceshou(Request $response)
    {
        $res = $response->post();
        if(!$res)
        {
            return $this->success('信息错误');
        }
        extract($res);
        date_default_timezone_set('PRC');
        $ctime = date('Y-m-d H:i:s');
        if($password!==$password1) {
            echo "<script>alert('密码不相同,请重新输入。');window.location.href='/luntan/public/index.php/index/index/zhuce'</script>";
        }else{
            $user = new User();
            $user->name = $name;
            $user->email = $email;
            $user->password = md5(md5(trim($password)));
            $user->avatar = '';
            $user->ctiime = $ctime;
            $user->is_del = 0;
            $user->is_admin = 0;
            $user->save();
            return $this->success('恭喜注册成功','index/index/denglu');    //非常nice
        }
    }
    /*
     * 跳转到登陆页
     * */

    public function denglu()
    {
        return $this->fetch();
    }
    /*
     * 验证登陆信息，成功则跳转到首页
     * */
    public function denglushou(Request $request)
    {
        $res = $request->post();

        $name= $res['name'];
        $password1 = trim(md5(md5($res['password'])));

        $result = User::naTopa($name);
        $password2 = trim($result['password']);
        if($result['is_del'])
        {
            $this->success('此号已被封印','index/index/denglu');
        }
        if($password1==$password2)
        {
            session('user_id',$result['id']);
            session('user',$result['name']);
            $this->success('登陆成功','index/index/shouye');
        }else{
            $this->success('密码错误，请重新登陆。','index/index/denglu');
        }
    }
    /*
     * 跳转到首页
     * */
    public function shouye(Request $request)
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
        //传递热门标签
        $hot_tag = $tiezi->hottag();
        $hot_tag_id =$hot_tag['id'];
        $hot_tag_name =$tag->id_to_t( $hot_tag_id );
        $this->assign('hot_tag_name',$hot_tag_name);
        $this->assign('hot_tag_tiaoshu',$hot_tag['tiaoshu']);
        //调用首页界面
        return $this->fetch();
    }
    /*
     * 按照赞的排序来显示首页页面
     * */
    public function zan()
    {
        //传递列表信息
        $yema = empty($_GET['yema'])?1:$_GET['yema'];
        $tiezi = new Tiezi();
        $fenye = $tiezi->zanfenye($yema);
        $liebiao = array_shift($fenye);
        $this->assign('liebiao',$liebiao);
        $this->assign('fenye',$fenye);
        $this->assign('user', session('user'));
        $this->assign('type','zan');
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
        //传递热门标签
        $hot_tag = $tiezi->hottag();
        $hot_tag_id =$hot_tag['id'];
        $hot_tag_name =$tag->id_to_t( $hot_tag_id );
        $this->assign('hot_tag_name',$hot_tag_name);
        $this->assign('hot_tag_tiaoshu',$hot_tag['tiaoshu']);
        //调用首页界面
        return $this->fetch('shouye');
    }
    /*
     * 按照回复的数量的排序来显示首页页面
     * */
    public function hui()
    {
        $this->assign('type','hui');

        $yema = empty($_GET['yema'])?1:$_GET['yema'];
        $tiezi = new Tiezi();
        $fenye = $tiezi->huifenye($yema);
        $liebiao = array_shift($fenye);
        $this->assign('liebiao',$liebiao);
        $this->assign('fenye',$fenye);
        $this->assign('user', session('user'));
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
        //传递热门标签
        $hot_tag = $tiezi->hottag();
        $hot_tag_id =$hot_tag['id'];
        $hot_tag_name =$tag->id_to_t( $hot_tag_id );
        $this->assign('hot_tag_name',$hot_tag_name);
        $this->assign('hot_tag_tiaoshu',$hot_tag['tiaoshu']);
        //调用首页界面
        return $this->fetch('shouye');
    }
    /*
     * 我的回复的界面
     * */
    public function myhui()
    {
        $this->assign('type','hui');

        $yema = empty($_GET['yema'])?1:$_GET['yema'];
        $tiezi = new Tiezi();
        $user_id = session('user_id');
        $fenye = $tiezi->myreply($yema,$user_id);
        $liebiao = array_shift($fenye);
        $this->assign('liebiao',$liebiao);
        $this->assign('fenye',$fenye);
        $this->assign('user', session('user'));
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
        //传递热门标签
        $hot_tag = $tiezi->hottag();
        $hot_tag_id =$hot_tag['id'];
        $hot_tag_name =$tag->id_to_t( $hot_tag_id );
        $this->assign('hot_tag_name',$hot_tag_name);
        $this->assign('hot_tag_tiaoshu',$hot_tag['tiaoshu']);
        //调用首页界面
        return $this->fetch('shouye');
    }
    /*
     * 跳转到帖子的详情界面
     * */
    public function post(Request $request)
    {
        //通过id直接返回，还是通过搜索返回
        if($request->get('title')){
            $title = $request->get('title');
            $tiezi = new Tiezi();
            $id = $tiezi->tiToid($title);
        }else{
            $id = $request->get('id');
        }
        //传递当前帖子信息
        $tiezi = new Tiezi();
        $tiezi->yuedu($id);//增加阅读的次数
        $yuedutime =  $tiezi->yuetime($id);//阅读次数的传递

        $this->assign('yuedutime',$yuedutime);
        $xiangqing = $tiezi->xiangqing($id);
        if($xiangqing[0]['is_del']==1)
        {
            $this->success('此贴已被封印','index/index/shouye');
        }
        $this->assign('xiangqing',$xiangqing[0]);

        $tag = new Tag();
        $biaoqian = $tag->ttag($xiangqing['0']['tag_id']);
        $this->assign('biaoqian',$biaoqian['0']['name']);

        $reply = new Reply();
        $replybiao = $reply->replybiao($id);
        $replysum = count($replybiao);
        $this->assign('replysum',$replysum);
        $this->assign('replybiao',$replybiao);
        $this->assign('user',session('user'));
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
        //传递热门标签
        $hot_tag = $tiezi->hottag();
        $hot_tag_id =$hot_tag['id'];
        $hot_tag_name =$tag->id_to_t( $hot_tag_id );
        $this->assign('hot_tag_name',$hot_tag_name);
        $this->assign('hot_tag_tiaoshu',$hot_tag['tiaoshu']);
        //回复总数
        $tie_reply_sum = $reply->tie_reply_sum($id);
        $this->assign('tie_reply_sum',$tie_reply_sum);
        //赞的信息
        $zan = new Zan();
        $zanshu = $zan->quzan($id);
        $this->assign('zanshu',$zanshu);
        //已回复标志修改
        if(session('user_id')==$xiangqing[0]['zuozhe_id']) {
            $reply->yihuifu($id);
        }
        //调用帖子详情页面
        return $this->fetch();
    }
    /*
     * 跳转到发帖页面
     * */
    public function fatie()
    {
        $tag = new Tag();
        $tag = $tag->tag();
        $this->assign('user', session('user'));
        $this->assign('tag',$tag);
        return $this->fetch();
    }
    /*
     * 从相应的数据库中取出相应信息
     * 再将帖子的信息保存到数据库
     * */
    public function shoutie(Request $request)
    {
        extract($request->post());
        $tiezi = new Tiezi();
        $tiezi->title = $title ;
        $tiezi->content = $content;
        $tiezi->user_id= session('user_id');
        $tiezi->category_id= $category;
        list($weimiao,$time) = explode(' ',microtime());
        $tiezi->create_at = $time+$weimiao;
        $tiezi->is_del =  0;
        $tiezi->tag_id = $tag;

        $tiezi->save();
        $this->success('发帖成功','index/index/fatie');
    }
    /*
     * 退出
     * 即删除session，跳转到登陆界面
     * */
    public function tuichu()
    {
        $user = session('user',null);//第二个参数不能为'',否则和session('user')是一样的
        return $this->fetch('denglu');
    }
    /*
     * 跳转到我的主页
     * */
    public function my()
    {

        $user_id = session('user_id');

        $my = new My();
        $image = $my->qu(session('user_id'));
        $this->assign('image',$image);

        $xmy = $my->quchu($user_id);
        $this->assign('xmy',$xmy);

        $this->assign('user',session('user'));
        $this->assign('user_id',session('user_id'));

        return $this->fetch();
    }
    public function shoumy(Request $request)
    {
        var_dump($request->post());
    }
    /*
     * 转到头像界面
     * */
    public function avatar()
    {
        $my = new My();
        $image = $my->qu(session('user_id'));
        $this->assign('image',$image);

        $this->assign('user',session('user'));
        $this->assign('user_id',session('user_id'));
        return $this->fetch();
    }
    /*
     * 跳转到修改密码界面
     * */
    public function password()
    {
        $my = new My();
        $image = $my->qu(session('user_id'));
        $this->assign('image',$image);

        $this->assign('user',session('user'));
        $this->assign('user_id',session('user_id'));
        return $this->fetch();
    }
    /*
     * 修改数据库中的密码
     * */
    public function shoupassword(Request $request)
    {
        $result = $request->post();
        $name = session('user');
        $res =  User::naTopa($name);
        $password = $res['password'];
        if($result['password1']==$result['password2']){
            if($password==md5(md5($result['password0']))){
                $user = new User();
                $user->updatepa($name,md5(md5($result['password1'])));
                $this->success('修改成功','index/index/Password');
            }else{
                $this->success('密码错误');
            }

        }else{
            $this->success('密码不一致，请重新输入。');
        }

    }
    /*
     *跳转到通知页面
     * */
    public function message()
    {

        $this->assign('user',session('user'));
        return $this->fetch();
    }
    /*
     * 转到帖子积分界面
     * */
    public function score()
    {
        $this->assign('user',session('user'));
        return $this->fetch();
    }
    /*
     * 转到帖子主题界面
     * */
    public function tag()
    {
        $this->assign('user',session('user'));
        return $this->fetch();
    }
    /*
     * 转到帖子话题界面
     * */
    public function thread()
    {
        $this->assign('user',session('user'));
        return $this->fetch();
    }
}
