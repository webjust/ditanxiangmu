<?php

namespace app\admin\controller;

use app\common\model\Admin;

class Article extends Base
{
    // 列表页
    public function index()
    {
        return $this->fetch();
    }
}
