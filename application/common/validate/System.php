<?php
/**
 * Created by PhpStorm.
 * User: Marvin
 * Date: 2018/8/31
 * Time: 10:31
 */

namespace app\common\validate;


use think\Validate;

class System extends Validate
{
    protected $rule = [
        'webname|网站标题' => 'require',
        'copyright|版权信息' => 'require'
    ];
}