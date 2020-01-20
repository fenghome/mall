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
    $name = 1;
    echo $name;
  }
} 