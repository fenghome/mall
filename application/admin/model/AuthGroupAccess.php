<?php
namespace app\admin\model;

use think\Model;

class AuthGroupAccess extends Model{
  public function user(){
    return $this->belognsTo('User');
  }
}