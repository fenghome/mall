<?php

namespace app\admin\controller;

use app\admin\controller\Base;
use app\admin\model\GoodsType;
use app\admin\model\Goods;
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
    $goods = Goods::all();
    $this->assign('goods',$goods);
    return $this->fetch('product-list');
  }

  public function showProductAdd(){

    $category = GoodsType::where("id",">","1")->order('path')->select();
    foreach ($category as $k => $v) {
      $v['name'] = str_repeat("|------", $v['level'] - 1) . $v['name'];
    }
    $this->assign('category',$category);
    return $this->fetch('product-add');
  }

  public function productAdd(Request $request){
    $data = $request->param();
    $ids = explode("|",$data['ids']);
    $data['tid']=$ids[0];
    $data['tpid']=$ids[1]; 
    $data['text']=isset($data['editorValue'])?$data['editorValue'] : "";
    $goods = new Goods($data);
    $res = $goods->allowField(true)->save();
    if($res){
      $status = 1;
      $message = "添加成功";
    }else{
      $status = 0;
      $message = "添加失败";
    }
    return ["status"=>$status,"message"=>$message];
  }

  public function showProductEdit(Request $request){
    $id = $request->param('id');
    $goods = Goods::get($id);
    $this->assign('goods',$goods);
    $category = GoodsType::where("id",">","1")->order('path')->select();
    foreach ($category as $k => $v) {
      $v['name'] = str_repeat("|------", $v['level'] - 1) . $v['name'];
    }
    $this->assign('category',$category);
    return $this->fetch('product-edit');
  }

  public function productEdit(Request $request){
    $data = $request->param();
    $ids = explode("|",$data['ids']);
    $data['tid'] = $ids[0];
    $data['tpid'] = $ids[1];
    $data['text'] = isset($data['editorValue'])?$data['editorValue']:"";
    $goods = new Goods();
    $res = $goods->allowField(true)->save($data,['id'=>$data['id']]);
    if($res){
      $status = 1;
      $message = "更新成功";
    }else{
      $status  = 0;
      $message = "更新失败";
    }
    return ["status"=>$status,"message"=>$message];
  }


  public function addFile(Request $request){ 
    $err = [
      'error'=>'一个错误',

    ];
    return json($err);
    
      
  }
    // $file = $request->file('file');
    // echo json_decode('ddd');
    
    // if($file){
    //   $info = $file->move(ROOT_PATH.'public'.DS.'uploads');
    //   if($info){
    //     $status = 0;
    //     $message = "上传成功";
    //   }else{
    //     $status = 0;
    //     $message = "上传失败";
    //   }
    //   $res = ["status"=>$status,"message"=>$message];
    //   return json_encode($res);
    // }
  // }
}
