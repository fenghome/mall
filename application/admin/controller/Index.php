<?php
namespace app\admin\controller;

use app\admin\controller\Base;
use app\admin\model\GoodsType;
use think\auth\Auth;
use app\admin\model\User as UserModel;
use app\admin\model\AuthGroupAccess;


class Index extends Base{
  public function index(){
    return $this->fetch('index');
  }

  public function test(){
    $user = new UserModel();
    $user->adminName = '111232143';
    $user->password = "sdf";
    $auth = new AuthGroupAccess(['group_id'=>2]);
    $user->authGroupAccess = $auth;
    $user->together('authGroupAccess')->save();
    
  }
} 