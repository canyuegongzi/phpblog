<?php
/**
 * Created by PhpStorm.
 * User: Marvin
 * Date: 2018/8/31
 * Time: 9:33
 */

namespace app\common\validate;


use think\Validate;

class Comment extends Validate
{
    protected $rule = [
        'content|评论内容' => 'require'
    ];
}