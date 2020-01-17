<?php
namespace app\admin\controller;

use app\admin\controller\Base;

class User extends Base{
  public function adminList(){
    return $this->fetch('user/admin_list');
  }

  public function showAdminAdd(){
    return $this->fetch('user/admin_add');
  }

  
}
