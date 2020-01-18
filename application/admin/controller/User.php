<?php
namespace app\admin\controller;

use app\admin\controller\Base;
use think\Request;
use app\admin\model\User as UserModel;
use app\admin\model\AuthGroupAccess;

class User extends Base{
  public function adminList(){
    return $this->fetch('user/admin_list');
  }

  public function showAdminAdd(){
    return $this->fetch('user/admin_add');
  }

  public function addUser(Request $request){
    $status = 0;
    $message = "添加失败";
    
    $data = $request->param();
    $user = new UserModel($data);
    $user->authGroupAccess = new AuthGroupAccess(['group_id'=>$data['group_id']]);
    $res = $user->allowField(true)->together('authGroupAccess')->save();
    
    if($res){
      $status = 1;
      $message = "添加成功";
    }
    return json(['status'=>$status,'message'=>$message]);
  }
  
}
