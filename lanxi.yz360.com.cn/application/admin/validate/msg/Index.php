<?php

namespace app\admin\validate\msg;

use think\Validate;

class Index extends Validate
{
    /**
     * 验证规则
     */
    protected $rule = [
        ["title","require|max:20","不能为空|标题不能超过20个字符"],
        ["des","require|max:50","不能为空|简介不能超过50个字符"],
    ];
    /**
     * 提示消息
     */
    protected $message = [
    ];
    /**
     * 验证场景
     */
    protected $scene = [
        'add'  => [],
        'edit' => [],
    ];
    
}
