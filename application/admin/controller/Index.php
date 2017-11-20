<?php

namespace app\admin\controller;

use app\common\model\Admin;

class Index extends Base
{
    public function index()
    {
        return $this->fetch();
    }

    public function welcome()
    {
        return $this->fetch();
    }
}
