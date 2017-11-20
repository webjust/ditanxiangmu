<?php

namespace app\admin\controller;

use think\Controller;

class Base extends Controller
{
    protected $account;

    public function _initialize()
    {
        parent::_initialize();
        if (!$this->isLogin()) {
            $this->redirect('Login/index');
        }
        $this->assign('account', $this->account->toArray());
        $this->assign('action_name', strtolower(request()->controller()));
    }

    public function isLogin()
    {
        $user = $this->getLoginUser();
        if ($user && $user->admin_id) {
            return true;
        } else {
            return false;
        }
    }

    public function getLoginUser()
    {
        if (!$this->account) {
            $this->account = session('admin');
        }
        return $this->account;
    }
}
