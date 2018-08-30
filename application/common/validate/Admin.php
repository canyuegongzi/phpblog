<?php
/**
 * Created by PhpStorm.
 * User: Marvin
 * Date: 2018/8/29
 * Time: 18:53
 */
namespace app\common\validate;
use think\Validate;
class Admin extends Validate
{
    protected $rule = [
        'username|管理员账户' => 'require',
        'password|密码' => 'require',
        'conpass|确认密码' => 'require|confirm:password',
        'oldpass|原密码' => 'require',
        'newpass|新密码' => 'require',
        'nickname|昵称' => 'require',
        'email|邮箱' => 'require|email|unique:admin',
        'code|验证码' => 'require'
    ];
    //登录场景验证
    public function sceneLogin(){
        return $this->only(['username', 'password']);
    }
    //注册场景验证
    public function sceneRegister(){
        return $this->only(['username', 'password', 'conpass', 'nickname', 'email'])
            ->append('username', 'unique:admin');
    }
}