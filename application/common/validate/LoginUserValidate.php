<?php

namespace app\common\validate;

class LoginUserValidate extends BaseValidate
{
    protected $rule = [
        'username' => 'require|min:5|max:12',
        'password' => 'require|min:5',
    ];
}