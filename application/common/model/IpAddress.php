<?php

namespace app\common\model;

use think\Model;

class IpAddress extends Model
{
    public static function checkIpAddress($ip_address)
    {
        $where = array();
        $ip = explode('.', $ip_address);
        $where['ip1'] = $ip[0];
        $where['ip2'] = $ip[1];
        $where['ip3'] = $ip[2];
        $ret = self::where($where)->find();
        return $ret;
    }
}