<?php

namespace app\admin\controller;

use app\common\model\Admin;
use app\common\model\AdminLog;
use app\common\validate\LoginUserValidate;
use app\common\model\AdminLog as AdminLogModel;
use think\Controller;
use think\Exception;

class Login extends Controller
{
    public function index()
    {
        $user = session('admin');
        if ($user && $user->admin_id) {
            $this->redirect('index/index');
        }
        return $this->fetch();
    }

    public function doLogin()
    {
        if (request()->isPost()) {
            // 接收数据
            $username = input('param.username');

            // 校验
            $data = input('param.');
            (new LoginUserValidate())->goCheck();

            $ret = model('Admin')->get(['username' => $username]);
            //print_r($ret->toArray());
            if (!$ret || $ret->status != 1) {
                $this->error("该用户不存在或者该用户已经被禁用");
            }
            $password = input('param.password');
            dump($ret->password);
            dump(md5($password . config('pre_md5')));
            exit();
            if ($ret->password != md5($password . config('pre_md5'))) {
                $this->error("输入密码错误");
            }
            $AdminModel = new Admin();
            try {
                $AdminModel->updateById(['last_login_ip' => request()->ip()], $ret->admin_id);
            } catch (\Exception $e) {
                $this->error($e->getMessage());
            }
            // 记录登录信息
            try {
                AdminLogModel::addAdminLog($ret->admin_id, $ret->username, request()->ip());
            } catch (Exception $e) {
                $this->error($e->getMessage());
            }
            // 记录Session
            session('admin', $ret);
            // 跳转到后台首页
            return $this->redirect('Admin/Index/index');
        } else {
            $this->error("非法请求", url('Admin/Login/index'));
        }
    }

    public function logout()
    {
        session('admin', null);
        return $this->redirect('login/index');
    }
}
