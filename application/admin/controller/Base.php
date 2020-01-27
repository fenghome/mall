<?php
  namespace app\admin\controller;
  use think\Controller;
  use think\Session;
  use think\auth\Auth;

  class Base extends Controller{
    public function _empty()
    {   
      $this->error('页面不存在', 'index/index');
    }

    protected $beforeActionList = [
      'isLogin' =>  ['except'=>'login,checklogin'],
      'alreadylogin'  =>  ['only'=>'login'],
    ];

    protected function isLogin(){
      if(!Session::has('user_id')){
        $this->error('请登录', 'user/login');
      }
    }

    protected function alreadylogin(){
      if(Session::has('user_id')){
        $this->success('已登录', 'index/index');
      }
    }
    
  }