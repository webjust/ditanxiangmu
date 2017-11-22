<?php

namespace app\admin\controller;

use app\common\model\Log as LogModel;

class Index extends Base
{
    public function index()
    {
        // 浏览页面数量
        $yesterday = LogModel::viewPageCount(1);  // 昨天
        $week = LogModel::viewPageCount('week');            // 上一周
        $month = LogModel::viewPageCount(30);          // 过去30天
        $days = [
            LogModel::viewPageCount(1),
            LogModel::viewPageCount(2),
            LogModel::viewPageCount(3),
            LogModel::viewPageCount(4),
            LogModel::viewPageCount(5),
            LogModel::viewPageCount(6),
            LogModel::viewPageCount(7),
        ];
        return $this->fetch('', compact('yesterday', 'week', 'month', 'days'));
    }

    public function welcome()
    {
        return $this->fetch();
    }
}
