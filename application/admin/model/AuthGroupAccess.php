<?php
namespace app\admin\model;

use think\Model;

class AuthGroupAccess extends Model{
  public function user(){
    return $this->belongsTo('User');
  }
  public function authGroup(){
    return $this->belongsTo('AuthGroup','group_id');
  }
}