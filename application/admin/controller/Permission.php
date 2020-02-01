<?php
namespace app\admin\controller;

use app\admin\controller\Base;
use app\admin\model\AuthRule;
use app\admin\model\AuthGroup;
use think\Request;

class Permission extends Base
{
    public function adminPermission()
    {
        $rules = AuthRule::all();
        $this->assign('rules',$rules);
        return $this->fetch('permission/admin_permission');
    }

    public function showPermissionAdd()
    {
        return $this->fetch('permission/admin_permission_add');
    }

    public function addPermission(Request $request){


        $data = $request->param();
        $res = AuthRule::get(['title'=>$data['title']]);
        if(!is_null($res)){
            $status = 0;
            $message = "权限名称存在";
            return ['status'=>$status,'message'=>$message];
        }
        $res1 = AuthRule::create($data,true);
        if($res1->id>0){
            $status = 1;
            $message = "新增成功";
            return ['status'=>$status,'message'=>$message];
        }

        $status = 0;
        $message = "新增失败";
 
        return ['status'=>$status,'message'=>$message];
    }

    //显示编辑权限节点界面
    public function showPermissionEdit(Request $request){
        $rule_id = $request->param('id');
        $rule = AuthRule::get($rule_id);
        $this->assign('rule',$rule);
        return $this->fetch('permission/admin_permission_edit');
    }

    //编辑权限节点
    public function editPermission(Request $request){
        $status = 0;
        $message = "更新失败";
        $data = $request->param();
        $res = AuthRule::get(['title'=>$data['title']]);

        if(!is_null($res) && $res->id != $data['id']){
            $status = 0;
            $message = "权限名称存在";
            return ['message'=>$message,'status'=>$status];
        }
        $res = AuthRule::where('id','=',$data['id'])->update([
            'name'=>$data['name'],
            'title'=>$data['title']
        ]);
        if($res>0){
            $status = 1;
            $message = "权限节点更新成功";
        }

        return ['message'=>$message,'status'=>$status];
    }

    //删除权限节点
    public function delPermission(Request $request){
        
        $rule_id = $request->param('id');
        $res = AuthGroup::where('rules','like','%'.$rule_id.'%')->find();
        if(!is_null($res)){
            $status = 0;
            $message = "权限节点下有用户组，无法删除";
            return ['status'=>$status,'message'=>$message];
        }
        $delRes = AuthRule::destroy($rule_id);
        if($delRes>0){
            $status = 1;
            $message = "删除成功";
            return ['status'=>$status,'message'=>$message];
        }

        $status = 0;
        $message = "删除失败";
        return ['status'=>$status,'message'=>$message];
    }

    
}