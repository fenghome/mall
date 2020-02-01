<?php
namespace app\admin\controller;
use app\admin\controller\Base;
use app\admin\model\AuthGroup;
use app\admin\model\AuthGroupAccess;
use app\admin\model\AuthRule;
use think\Request;

class Role extends Base{

  //显示角色管理页面
  public function adminRole(){
    $authGroupList = AuthGroup::all();
    foreach($authGroupList as $authGroup){
      if(strlen($authGroup->rules)===0){
        $ruleIds = [];
      }else{
        $ruleIds = explode(',',$authGroup->rules);
      }
      
      $ruleTitles = [];
      for($i=0;$i<count($ruleIds);$i++){
        $ruleTitles[$i] = AuthRule::get($ruleIds[$i])->title;
      }
      $authGroup->rules = $ruleTitles;
    }
    $this->assign('authGroupList',$authGroupList);
    return $this->fetch('role/admin_role');
  }

  //显示增加角色页面
  public function showRoleAdd(){
    $rules = AuthRule::all();
    $this->assign('rules',$rules);
    return $this->fetch('role/admin_role_add');
  }

  //增加角色
  public function AddRole(Request $request){
    $data = $request->param();
    //判断角色名称是否存在
    $hasTitle = AuthGroup::get(['title'=>$data['title']]);
    if(!is_null($hasTitle)){
      $status = 0;
      $message = '角色名称存在';
      return ['status'=>$status,'message'=>$message];
    }
    //将rules合并成数据库所需字符串:1,2,3
    if(array_key_exists('rules',$data)){
      $data['rules'] = implode(',',$data['rules']);
    }

    $authGroup = new AuthGroup($data);
    $res = $authGroup->allowField(true)->save();
  
    if($res>0){
      $status = 1;
      $message = "添加成功";
      return ['status'=>$status,'message'=>$message];
    }

    $status =0;
    $message = "添加失败";
    return ['status'=>$status,'message'=>$message];
  }

  //显示编辑角色页面
  public function showRoleEdit(Request $request){
    $authGroup_id = $request->param('id');
    $authGroup = AuthGroup::get($authGroup_id);
    if(!is_null($authGroup)){
      $this->assign('authGroup',$authGroup);
    }
    $rules = AuthRule::all();
    $this->assign('rules',$rules);
    return $this->fetch('role/admin_role_edit');
  }

  //编辑角色
  public function editRole(Request $request){
    $data = $request->param();
    //检查角色名是否存在
    $hasTitle = AuthGroup::get(['title'=>$data['title']]);
    if(!is_null($hasTitle) && $hasTitle->id != $data['id']){
      $status = 0;
      $message = "角色名存在";
      return ['status'=>$status,'message'=>$message];
    }

    //将rules合并成数据库需要的字符串:1,2,3
    if(array_key_exists('rules',$data)){
      $data['rules'] = implode(',',$data['rules']);
    }else{
      $data['rules']="";
    }
    $res = AuthGroup::where('id','=',$data['id'])->update([
      'title'=>$data['title'],
      'rules'=>$data['rules']
    ]);
    if($res>0){
      $status = 1;
      $message = "更新成功";
    }
    else{
      $status = 0;
      $message = "更新失败";
    }
    return ['status'=>$status,'message'=>$message];

  }

  //删除角色
  public function delRole(Request $request){
    $group_id = $request->param('id');
    //判断当前角色下是否有用户
    $hasUser = AuthGroupAccess::get(['group_id'=>$group_id]);
    if(!is_null($hasUser)){
      $status = 0;
      $message = "当前角色下有用户，无法删除";
      return ['status'=>$status,'message'=>$message];
    }
    //删除角色
    $res = AuthGroup::destroy(['id'=>$group_id]);
    if($res==0){
      $status = 0;
      $message = "删除失败";
      return ['status'=>$status,'message'=>$message];
    }

    $status = 1;
    $message = "删除成功";
    return ['status'=>$status,'message'=>$message];

  }

}