<?php
namespace app\admin\controller;

use app\admin\controller\Base;
use think\Request;
use app\admin\model\User as UserModel;
use app\admin\model\AuthGroupAccess;
use app\admin\model\AuthGroup;
class User extends Base{
  public function adminList(){
    $userList = UserModel::all();
    $this->assign('userList',$userList);
    return $this->fetch('user/admin_list');
  }

  public function showAdminAdd(){
    return $this->fetch('user/admin_add');
  }

  public function addUser(Request $request){
    $status = 0;
    $message = "添加失败"; 

    $data = $request->param();    
    $res = UserModel::get(['adminName'=>$data['adminName']]);
    if(!is_null($res)){
      $status = 0;
      $message = "用户名存在";
      return json(['status'=>$status,'message'=>$message]);
    }
    
    $user = new UserModel();    
    $user->data($data,true);
    $user->authGroupAccess = new AuthGroupAccess(['group_id'=>$data['group_id']]);    
    $res = $user->allowField(true)->together('authGroupAccess')->save();    
    
    if($res){
      $status = 1;
      $message = "添加成功";
    }
    return json(['status'=>$status,'message'=>$message]);
  }


  
}
