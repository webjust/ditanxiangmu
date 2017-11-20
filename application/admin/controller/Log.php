<?php

namespace app\admin\controller;

use app\common\model\Log as LogModel;

class Log extends Base
{
    public function view_page()
    {
        list($logs, $page) = LogModel::getList(array(), 20);
        return $this->fetch('', compact('logs', 'page'));
    }
}
