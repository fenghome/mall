<?php
namespace app\admin\controller;

use app\admin\controller\Base;
use think\Request;
use think\Session;
use think\captcha\Captcha;
use app\admin\model\User as UserModel;
use app\admin\model\AuthGroupAccess;
use app\admin\model\AuthGroup;


class User extends Base{

  public function login(){
    return $this->fetch('user/login');
  }

  public function checkLogin(Request $request){
    $status = 0;
    $message = "";
    $data = $request->param();
    if(!captcha_check($data['verityCode'])){
      $status = 0;
      $message = "验证码错误";
      return ['status'=>$status,'message'=>$message];
    };
    
    $password = md5($data['password']);
    $res = UserModel::get(['adminName'=>$data['adminName'],'password'=>$password]);
    if(is_null($res)){
      $status = 0;
      $message = "账户或密码错误";
      return ['status'=>$status,'message'=>$message];     
    }

    $status = 1;
    $message = "登录成功";

    Session::set('user_id',$res->id);
    Session::set('user_info',$res->getData());
    return ['status'=>$status,'message'=>$message];  
  }

  public function logout(){
    Session::delete('user_id');
    Session::delete('user_info');
    $this->success('退出成功', 'User/login');
  }

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
    
    if($user->adminName !== $data['adminName']){
      $user->adminName=$data['adminName'];
      $res = $user->save();
      if($res === 0){
        $status = 0;
        $message = "用户名更新失败";
        return ["status"=>$status,"message"=>$message];
      }
    }
    

    if($user->authGroupAccess->group_id != $data['group_id']){
      $res = AuthGroupAccess::where('uid','=',$data['id'])->update(['group_id'=>$data['group_id']]);
      if($res === 0){
        $status = 0;
        $message = "角色更新失败";
        return ["status"=>$status,"message"=>$message];
      }
    }
    
    $status = 1;
    $message = "更新用户成功";
    return ["status"=>$status,"message"=>$message];
  }


  public function delUser(Request $request){
    $status = 0;
    $message = "删除失败";
    $user_id = $request->param('id');
    $user = UserModel::get($user_id);
    $res = $user->together('authGroupAccess')->delete();
    if($res>0){
      $status = 1;
      $message = "删除成功";
    }

    return ['status'=>$status,'message'=>$message];
  }

  public function permission(){

    return $this->fetch('user/admin_permission');
  }

  public function showPermissionAdd(){
    return $this->fetch('user/admin_permission_add');                        
  }
  
}
