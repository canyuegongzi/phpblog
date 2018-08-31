<?php
/**
 * Created by PhpStorm.
 * User: Marvin
 * Date: 2018/8/30
 * Time: 15:25
 */

namespace app\common\model;

use think\Model;
use think\model\concern\SoftDelete;

class Admin extends Model
{
    //软删除
    use SoftDelete;

    //只读字段
    protected $readonly = ['email'];

    //登录校验
    public function login($data)
    {
        $validate = new \app\common\validate\Admin();
        if (!$validate->scene('login')->check($data)) {
            return $validate->getError();
        }
        $result = $this->where($data)->find();
        if ($result) {
            //判断用户是否可用
            if ($result['status'] != 1) {
                return '此账户被禁用！';
            }
            //1表示有这个用户，也就是用户名和密码正确了
            $sessionData = [
                'id' => $result['id'],
                'nickname' => $result['nickname'],
                'is_super' => $result['is_super']
            ];
            session('admin', $sessionData);
            return 1;
        }else {
            return '用户名或者密码错误！';
        }
    }

    //注册账户
    public function register($data)
    {
        $validate = new \app\common\validate\Admin();
        if (!$validate->scene('register')->check($data)) {
            return $validate->getError();
        }
        //只允许插入有的 字段
        $result = $this->allowField(true)->save($data);
        if ($result) {
            mailto($data['email'], '注册管理员账户成功！', '注册管理员账户成功！');
            return 1;
        }else {
            return '注册失败！';
        }
    }

    //重置密码
    public function reset($data) {
        $validate = new \app\common\validate\Admin();
        if (!$validate->scene('reset')->check($data)) {
            return $validate->getError();
        }
        if ($data['code'] != session('code')) {
            return "验证码不正确！";
        }
        //查询关键字email，值为$data['email']
        $adminInfo = $this->where('email', $data['email'])->find();
        $password = mt_rand(10000,99999);
        //查询到的数据重置password
        $adminInfo->password = $password;
        $result = $adminInfo->save();
        if ($result) {
            $content = '恭喜您，密码重置成功！<br>用户名：' . $adminInfo['username'] . '<br>新密码：'
                . $password;
            mailto($data['email'], '密码重置成功', $content);
            return 1;
        }else {
            return '重置密码失败！';
        }
    }

    //添加管理员
    public function add($data)
    {
        $validate = new \app\common\validate\Admin();
        if (!$validate->scene('add')->check($data)) {
            return $validate->getError();
        }
        $result = $this->allowField(true)->save($data);
        if ($result) {
            return 1;
        }else {
            return '管理员添加失败！';
        }
    }

    //编辑
    public function edit($data)
    {
        $validate = new \app\common\validate\Admin();
        if (!$validate->scene('edit')->check($data)) {
            return $validate->getError();
        }
        $adminInfo = $this->find($data['id']);
        if ($data['oldpass'] != $adminInfo['password']) {
            return '原密码不正确！';
        }
        $adminInfo->password = $data['newpass'];
        $adminInfo->nickname = $data['nickname'];
        $result = $adminInfo->save();
        if ($result) {
            return 1;
        }else {
            return '管理员修改失败！';
        }
    }
}