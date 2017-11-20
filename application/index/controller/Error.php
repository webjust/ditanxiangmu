<?php

namespace app\index\controller;

use think\Controller;

class Error extends Controller
{
    public function index()
    {
        $this->view->engine->layout(false);
        return $this->fetch();
    }

    public function check()
    {
        if (request()->isPost())
        {
            $pass = input('post.pass');
            if (md5($pass) == md5(config('pass'))) {
                session('ip', md5($pass));
                return $this->success("登录成功", "Index/Index/index");
            } else {
                return $this->error("密码错误");
            }
        }
    }
}
