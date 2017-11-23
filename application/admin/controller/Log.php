<?php

namespace app\admin\controller;

use app\common\model\Log as LogModel;
use app\common\model\AdminLog as AdminLogModel;

class Log extends Base
{
    /*流量日志*/
    public function view_page()
    {
        list($logs, $page) = LogModel::getList(array(), 20);
        return $this->fetch('', compact('logs', 'page'));
    }

    /*管理员日志*/
    public function admin_view_page()
    {
        list($logs, $page) = AdminLogModel::getList(array(), 20);
        return $this->fetch('', compact('logs', 'page'));
    }
}
