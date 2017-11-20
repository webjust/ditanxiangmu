<?php
namespace app\Common\model;

use think\Model;

class BaseModel extends Model
{
    public function add($data)
    {
        $ret = $this->allowField(true)->save($data);
        return $ret;
    }
}