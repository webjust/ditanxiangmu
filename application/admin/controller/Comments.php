<?php

namespace app\admin\controller;

use app\common\model\Admin;

class Comments extends Base
{
    // 列表页
    public function index()
    {
        return $this->fetch();
    }

    // 删除，修改状态
    //
}
