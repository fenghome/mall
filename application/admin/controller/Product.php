<?php

namespace app\admin\controller;

use app\admin\controller\Base;
use app\admin\model\GoodsType;
use think\Request;

class Product extends Base
{
  public function categoryList()
  {
    $res = GoodsType::all();
    return $this->fetch('category-list');
  }

  public function categoryAddForm()
  {
    $goodsType = GoodsType::where('1=1')->order('path')->select();
    foreach ($goodsType as $k => $v) {
      $v['name'] = str_repeat("|------", $v['level'] - 1) . $v['name'];
    }
    $this->assign('goodsType', $goodsType);
    return $this->fetch('category-add');
  }

  public function categoryAdd(Request $request)
  {
    $data = $request->param();
    $name = $data['name'];
    $pid = $data['pid'];
    $fdata = GoodsType::get($pid);
    $fpath = $fdata['path'];
    $level = $fdata['level'] + 1;
    $goods = GoodsType::create(["name" => $name, "pid" => $pid, "level" => $level]);
    if ($goods == true) {
      $id = $goods['id'];
      $path = $fpath . ',' . $id;
      $res = GoodsType::update(["path" => $path], ['id' => $id]);
      if ($res == true) {
        $status = 1;
        $message = '类别添加成功!';
      } else {
        $status = 0;
        $message = '类别添加失败！';
      }
    } else {
      $status = 0;
      $message = '类别添加失败！';
    }

    return ["status" => $status, "message" => $message];
  }

  public function categoryDelete(Request $request){
    $id = $request->param('id');
    $res = GoodsType::destroy($id);
    if($res > 0){
      $message = "删除成功";
      $status = 1;
    }else{
      $message = "删除失败";
      $status = 0;
    }
    return ["status"=>$status,"message"=>$message];
    
  }

  public function getCategory(){
    $result = GoodsType::where("id",">","1")->field('id,pid,name')->select();
    return $result;
  }

  public function productList(){
    return $this->fetch('product-list');
  }

  public function showProductAdd(){

    $category = GoodsType::where('1=1')->order('path')->select();
    foreach ($category as $k => $v) {
      $v['name'] = str_repeat("|------", $v['level'] - 1) . $v['name'];
    }
    $this->assign('category',$category);
    return $this->fetch('product-add');
  }
}
