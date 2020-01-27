<?php
namespace app\admin\model;

use think\Model;

class User extends Model{

  protected $insert = ['status'=>1];
  public function setPasswordAttr($value){
    return md5($value);
  }

  public function authGroupAccess(){
    return $this->hasOne('AuthGroupAccess','uid');
  }
}