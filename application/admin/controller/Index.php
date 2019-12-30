<?php
namespace app\admin\controller;

use app\admin\controller\Base;
use app\admin\model\GoodsType;

class Index extends Base{
  public function index(){
    return $this->fetch('index');
  }

  public function test(){
    return $this->fetch('test');
  }
} 