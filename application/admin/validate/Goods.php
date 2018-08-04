<?php

namespace app\admin\validate;

use think\Validate;

class Goods extends Validate
{
    /**
     * 验证规则
     */
    protected $rule = [
        'first'  => 'require',
    ];
    /**
     * 提示消息
     */
    protected $message = [
        'first.require'  => '所属分类不能为空',
    ];
    /**
     * 验证场景
     */
    protected $scene = [
        'add'  => ['first'],
        'edit' => [],
    ];
    
}
