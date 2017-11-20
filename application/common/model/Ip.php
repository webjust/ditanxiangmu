<?php

namespace app\common\model;

use think\Model;

class Ip extends Model
{
    public function add($data)
    {
        $data['ip_type'] = 0;   // ip类型 0：网段 1：固定IP
        $data['status'] = 0;    // 禁用
        $this->allowField(true)->save($data);
        return $this->ip_id;
    }
}