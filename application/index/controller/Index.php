<?php
namespace app\index\controller;
use app\index\model\User;
use think\Controller;
use think\View;
use think\Request;

class Index extends Controller
{
    public function index()
    {
        return '<style type="text/css">*{ padding: 0; margin: 0; } .think_default_text{ padding: 4px 48px;} a{color:#2E5CD5;cursor: pointer;text-decoration: none} a:hover{text-decoration:underline; } body{ background: #fff; font-family: "Century Gothic","Microsoft yahei"; color: #333;font-size:18px} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.6em; font-size: 42px }</style><div style="padding: 24px 48px;"> <h1>:)</h1><p> ThinkPHP V5<br/><span style="font-size:30px">十年磨一剑 - 为API开发设计的高性能框架</span></p><span style="font-size:22px;">[ V5.0 版本由 <a href="http://www.qiniu.com" target="qiniu">七牛云</a> 独家赞助发布 ]</span></div><script type="text/javascript" src="http://tajs.qq.com/stats?sId=9347272" charset="UTF-8"></script><script type="text/javascript" src="http://ad.topthink.com/Public/static/client.js"></script><thinkad id="ad_bd568ce7058a1091"></thinkad>';
    }
    public function zhuce()
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
            $user->password = md5(md5($password));
            $user->avatar = '';
            $user->ctiime = $ctime;
            $user->is_del = 0;
            $user->is_admin = 0;

            $user->save();
            return $this->success('恭喜注册成功');    //非常nice
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
        $cond = [];
        $cond['name'] = $res['user'];
        //$cond['password'] = md5(md5($res['password']));

        $q = User::get($cond);
        if($q)
        {
            //session_start();   有自动开启sessino的配置项
            session('user',$res['user']);
            $this->success('登陆成功','index/index/shouye');
        }else{
            $this->success('密码错误，请重新登陆。','index/index/denglu');
        }

    }
    /*
     * 跳转到首页
     * */
    public function shouye()
    {
        $user = session('user');
        $this->assign('user',$user);
        return $this->fetch();
    }

    /*
     * 删除session
     * */
    public function qshouye()
    {
        $user = session('user',null);//第二个参数不能为'',否则和session('user')是一样的
        $this->assign('user',$user);
        return $this->fetch('shouye');
    }

    /*
     * 跳转到发帖页面
     * */
    public function fatie()
    {
        return $this->fetch();
    }

    /*
     * 将帖子的信息保存到数据库
     * */
    public function shoutie(Request $request)
    {
        var_dump($request->post());

    }
    /*
     * 跳转到我的主页
     * */
    public function my()
    {
        return $this->fetch();
    }
    public function shoumy(Request $request)
    {
        var_dump($request->post());
    }
    /*
     * 跳转到修改密码界面
     * */
    public function password()
    {
        return $this->fetch();
    }
    /*
     * 修改数据库中的密码
     * */
    public function shoupassword(Request $request)
    {
        var_dump($request->post());
    }
    public function message()
    {
        return $this->fetch();
    }


}
