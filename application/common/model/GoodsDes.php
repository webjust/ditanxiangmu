<?php

namespace app\common\model;

class GoodsDes extends BaseModel
{
    public function add($data)
    {
        $this->allowField(true)->save($data);
        return $this->g_des_id;
    }
}