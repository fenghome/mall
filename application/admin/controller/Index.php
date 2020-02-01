<?php
namespace app\admin\controller;

use app\admin\controller\Base;
use app\admin\model\GoodsType;
use think\auth\Auth;
use app\admin\model\User as UserModel;
use app\admin\model\AuthGroupAccess;
use app\admin\model\AuthRule;
use app\admin\model\AuthGroup;


class Index extends Base{
  public function index(){
    return $this->fetch('index');
  }

  public function test(){
    dump(strpos('1111222',strval(1))!==false);


  }

  public function test1(){
    $this->success('新增成功', 'index/index');
  }
} 