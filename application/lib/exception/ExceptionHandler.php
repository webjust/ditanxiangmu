<?php

namespace app\lib\exception;

use think\Exception;
use think\exception\Handle;
use think\Request;

class ExceptionHandler extends Handle
{
    private $code;
    private $msg;
    private $errorCode;

    public function render(\Exception $ex)
    {
        // 自定义异常类
        if ($ex instanceof BaseException) {
            $this->code = $ex->code;
            $this->msg = $ex->msg;
            $this->errorCode = $ex->errorCode;
        } else {
            // 服务器异常类
            $this->code = 500;
            $this->msg = "服务器内部的异常";
            $this->errorCode = 999;
        }
        $request = Request::instance();
        $result = array(
            'msg' => $this->msg,
            'errorCode' => $this->errorCode,
            'request_url' => $request->url()
        );
        return json($result, $this->code);
    }
}