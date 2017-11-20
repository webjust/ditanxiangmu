<?php

namespace app\lib\exception;

class BannerException extends BaseException
{
    public $code = 404;
    public $msg = 'Banner找不到';
    public $errorCode = 20000;
}