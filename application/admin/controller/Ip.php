<?php

namespace app\admin\controller;

use app\common\model\Admin;

class Ip extends Base
{
    // 列表页
    public function index()
    {
        return $this->fetch();
    }

    // 添加屏蔽IP
    // 修改状态：开启 关闭 删除
}
