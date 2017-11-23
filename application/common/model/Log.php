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

    /*日志列表*/
    public static function getList($condition = array(), $size = 10, $order = "log_id desc")
    {
        $list = self::where($condition)->limit($size)->order($order)->paginate($size);
        $page = $list->render();
        return [$list, $page];
    }

    /*访问量统计*/
    public static function viewPageCount($day = 1)
    {
        $condition = [];
        if (is_int($day)) {
            $end = strtotime('yesterday') + 60 * 60 * 24;
            $begin = $end - ($day) * 60 * 60 * 24;
            $condition['create_time'] = [['>', $begin], ['<', $end], 'and'];
        }
        if ($day == 'week') {
            // 上周周一
            $last_week_begin = strtotime(date('Y-m-d', strtotime('last week')));
            // 上周周日
            $last_week_end = strtotime(date('Y-m-d', strtotime('last week'))) + 3600 * 24 * 7;
            $condition['create_time'] = [['>', $last_week_begin], ['<', $last_week_end], 'and'];
        }
        if ($day == 'month') {
            // 过去一个月
            $last_month_begin = strtotime('last month');
            $last_month_end = $last_month_begin + 3600 * 24 * 30;
            $condition['create_time'] = [['>', $last_month_begin], ['<', $last_month_end], 'and'];
        }
/*        self::where($condition)->count();
        echo self::getLastSql();
        echo '<br>';
        echo date('Y-m-d H:i:s', strtotime('last month'));*/
        return self::where($condition)->count();
    }
}