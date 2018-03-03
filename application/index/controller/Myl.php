<?php
namespace app\index\controller;
use app\index\model\My;
use think\Controller;
use think\Request;

class Myl extends Controller
{
    public function shoumy(Request $request)
    {
        $data = $request->post();
        extract($data);
        $id = session('user_id');

        $my = new My();
        $my->gengxin($id,$city,$company,$wangzhi,$qianming,$jieshao,$language);
        echo "<script>alert('更新成功');window.location.href='/luntan/public/index.php/index/index/my.html'</script>";
    }
    public function shouimage()
    {
        $image = $_FILES['avatar'];

        $my = new My();
        $arr['image'] =  $my->cunimage($image);

        $arr['user_id']= session('user_id');
        $my->cun($arr);

        echo "<script>alert('更新成功');window.location.href='/luntan/public/index.php/index/index/avatar.html'</script>";

    }
}