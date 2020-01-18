<?php
namespace app\admin\controller;

use app\admin\controller\Base;
use app\admin\model\GoodsType;
use think\auth\Auth;



class Index extends Base{
  public function index(){
    return $this->fetch('index');
  }

  public function testAAA(){

    $controller = request()->action();
    echo $controller;
  }
} 