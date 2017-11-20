<?php

namespace app\common\validate;

use think\Exception;
use think\Request;
use think\Validate;

class BaseValidate extends Validate
{
    public function goCheck() {
        $request = Request::instance();
        $data = $request->param();
        $result = $this->check($data);
        if (!$result) {
            $error = $this->getError();
            throw new Exception();
        } else {
            return true;
        }
    }
}