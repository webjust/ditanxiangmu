<?php

namespace app\common\model;

use think\Exception;
use think\Model;

class Admin extends Model
{
    // 更新登录信息
    public function updateById($data, $id)
    {
        $data['last_login_time'] = time();
        $ret = $this->where('admin_id='.$id)->update($data);
        if (!$ret) {
            throw new Exception("记录登录信息失败");
        }
        return $ret;
    }
}