<?php
namespace app\admin\model;

use think\Model;

class User extends Model{
  public function authGroupAccess(){
    return $this->hasOne('AuthGroupAccess','uid');
  }
}