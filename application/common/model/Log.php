<?php

namespace app\common\model;

use function Sodium\add;
use think\Exception;
use think\Model;

class Log extends Model
{
    /*添加访问日志*/
    public static function addLog($url, $ip, $time)
    {
        if ($url && $ip && $time) {
            $data = ['path' => $url, 'ip' => $ip, 'create_time' => $time];
            (new Log())->save($data);
        }
    }

    public static function getList($condition = array(), $size = 10, $order = "log_id desc")
    {
        $list = self::where($condition)->limit($size)->order($order)->paginate($size);
        $page = $list->render();
        return [$list, $page];
    }
}