<?php
namespace app\admin\model;

use think\Model;

class AuthGroup extends Model{
  public function authGroupAccess(){
    return $this->hasMany('authGruopAccess','group_id');
  }
}