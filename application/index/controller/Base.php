<?php

namespace app\index\controller;

use app\common\model\Goods;
use app\common\model\IpAddress;
use app\common\model\Log;
use think\Controller;

class Base extends Controller
{
    public function _initialize()
    {
        $ip = request()->ip();      // 访问IP
        //$ip = "39.186.183.10";
        $res = $this->checkIp($ip);
        if (session('ip') != md5(config('pass'))) {
            if ($res) {
                $this->redirect('Index/Error/index');
            }
        }
        $hot = Goods::hot();
        $this->assign('hot', $hot);
        // 写入访问日志
        Log::addLog(request()->url(), request()->ip(), time());
    }

    /**
     * 检查IP是否被禁用
     * @param $ip
     */
    public function checkIp($ip)
    {
        if (IpAddress::checkIpAddress($ip)) {
            return true;
        } else {
            return false;
        }
    }

    /*设置标题*/
    public function title($title)
    {
        $this->assign('title', $title);
    }
}
