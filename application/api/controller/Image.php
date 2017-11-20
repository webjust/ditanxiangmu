<?php

namespace app\api\controller;

use think\Controller;
use think\Request;

class Image extends Controller
{
    public function upload()
    {
        $file = Request::instance()->file('file');
        $info = $file->move('upload/m_img');
        if ($info && $info->getPathname()) {
            return ["code" => 1, "msg" => 'success', "data" => ['src' => '/' . str_replace('\\', '/', $info->getPathname())]];
        }
        return ["code" => 0, "msg" => 'upload error'];
    }
}