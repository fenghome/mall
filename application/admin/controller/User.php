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

  public function adminStop(Request $request){
    $status = 0;
    $message = "停用失败";

    $user_id = $request->param('id');

    $res = UserModel::where('id','=',$user_id)->update(['status'=>0]);
    if($res>0){
      $status = 1;
      $message = "停用成功";
    }

    return json(['status'=>$status,'message'=>$message]);
  }

  public function adminStart(Request $request){
    $status = 0;
    $message = "启用失败";

    $user_id = $request->param('id');

    $res = UserModel::where('id','=',$user_id)->update(['status'=>1]);
    if($res>0){
      $status = 1;
      $message = "启用成功";
    }

    return json(['status'=>$status,'message'=>$message]);
  }

  public function showAdminEdit(Request $request){
    $user_id = $request->param('id');
    $user = UserModel::get($user_id);
    $authGroup = AuthGroup::all();
    $this->assign('authGroup',$authGroup);
    $this->assign('user',$user);
    return $this->fetch('user/admin_edit');
  }

  public function editUser(Request $request){
    $status = 0;
    $message = "更新用户失败";

    $data = $request->param();
    $res = UserModel::where("id","<>",$data['id'])->where("adminName","=",$data['adminName'])->select();  
    if(count($res)>0){
      $message = "用户名存在";
      return ["status"=>$status,"message"=>$message];
    }
    $user = UserModel::get($data['id']);
    $user->adminName=$data['adminName'];
    $user->authGroupAccess->group_id = 3; 

    $res = $user->together('authGroupAccess')->save();
    if($res){
      $status = 1;
      $message = "更新用户成功";
    }

    return ["status"=>$status,"message"=>$message];
  }


  
}
