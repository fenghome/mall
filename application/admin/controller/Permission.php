<?php
namespace app\admin\controller;

use app\admin\controller\Base;
use app\admin\model\AuthRule;
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
        $status = 0;
        $message = "新增失败";
        $data = $request->param();
        $res = AuthRule::create($data,true);
        if($res->id>0){
            $status = 1;
            $message = "新增成功";
        }
        return ['status'=>$status,'message'=>$message];
    }
}