<?php

namespace app\common\model;

use think\Exception;
use think\Model;

class AdminLog extends Model
{
    /*添加管理员登录信息*/
    public static function addAdminLog($id, $user, $ip)
    {
        if (!is_int($id)) {
            throw new Exception("用户ID非法");
        }
        if (!$id || !$ip || !$user) {
            throw new Exception("传递数据非法");
        }
        $data = [
            'admin_id' => $id,
            'admin_user' => $user,
            'log_ip' => $ip,
            'log_time' => time()
        ];
        return self::insert($data);
    }

    /*日志列表*/
    public static function getList($condition = array(), $size = 10, $order = "admin_log_id desc")
    {
        $list = self::where($condition)->limit($size)->order($order)->paginate($size);
        $page = $list->render();
        return [$list, $page];
    }
}