<?php
namespace app\index\controller;

use think\auth\Auth;

class Index
{
    public function index()
    {
        $user_id = 1;
        // 获取auth实例
        $auth = Auth::instance();
        // 检测权限
        if ($auth->check('show_button', $user_id)) {// 第一个参数是规则名称,第二个参数是用户UID
            echo "{$user_id}号用户有显示操作按钮的权限";
        } else {
            echo "{$user_id}号用户没有显示操作按钮的权限";
        }
        echo '<br/>';
        $user_id = 2;
        // 检测权限
        if ($auth->check('show_button', $user_id)) {// 第一个参数是规则名称,第二个参数是用户UID
            echo "{$user_id}号用户有显示操作按钮的权限";
        } else {
            echo "{$user_id}号用户没有显示操作按钮的权限";
        }
    }
}
