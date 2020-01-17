<?php
namespace app\admin\controller;

use app\admin\controller\Base;
use app\admin\model\GoodsType;
use think\auth\Auth;

class Index extends Base{
  public function index(){
    return $this->fetch('index');
  }

  public function test(){

    $user_id = 1;
    $auth = Auth::instance();

    if($auth->check('show_button',$user_id)){
      echo "{$user_id}号有show_button权限";
    }else{
      echo "{$user_id}号没有show_button权限";
    }
  }
} 