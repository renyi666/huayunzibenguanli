<?php
/**
 *　　　　　　　　┏┓　　　┏┓+ +
 *　　　　　　　┏┛┻━━━┛┻┓ + +
 *　　　　　　　┃　　　　　　　┃ 　
 *　　　　　　　┃　　　━　　　┃ ++ + + +
 *　　　　　　 ████━████ ┃+
 *　　　　　　　┃　　　　　　　┃ +
 *　　　　　　　┃　　　┻　　　┃
 *　　　　　　　┃　　　　　　　┃ + +
 *　　　　　　　┗━┓　　　┏━┛
 *　　　　　　　　　┃　　　┃　　　　　　　　　　　
 *　　　　　　　　　┃　　　┃ + + + +
 *　　　　　　　　　┃　　　┃　　　　Code is far away from bug with the animal protecting　　　　　　　
 *　　　　　　　　　┃　　　┃ + 　　　　神兽保佑,代码无bug　　
 *　　　　　　　　　┃　　　┃
 *　　　　　　　　　┃　　　┃　　+　　　　　　　　　
 *　　　　　　　　　┃　 　　┗━━━┓ + +
 *　　　　　　　　　┃ 　　　　　　　┣┓
 *　　　　　　　　　┃ 　　　　　　　┏┛   Author:XiaoFei Zhai
 *　　　　　　　　　┗┓┓┏━┳┓┏┛ + + + +
 *　　　　　　　　　　┃┫┫　┃┫┫
 *　　　　　　　　　　┗┻┛　┗┻┛+ + + +
 */

namespace app\index\model;


use think\Model;

class Menu extends Model
{
    public function tree(){
        $where['pid']                               =   0;
        $tree                                       =   $this->where($where)->order('sort desc')->select();
        if($tree){
            foreach ($tree as $k =>$v){
                $children                           =   $this->data([])->getChildren($v->id);
                foreach ($children as $key => $val){
                    $a                              =   $this->getChildren($val->id);
                    $children[$key]->children       =      $a;
                }
                $tree[$k]->children                 =   $children ? $children : [];
            }
        }
        return $tree;
    }
    public function getMenu($ids){

        $where['pid']                               =   0;
        $where['id']                                =   ['in',$ids];
        $tree                                       =   $this->where($where)->order('id asc')->select();
        if($tree){
            foreach ($tree as $k =>$v){
                $children                           =   $this->getChildren($v->id,$ids);
                foreach ($children as $key => $val){
                    $a                              =   $this->getChildren($val->id,$ids);
                    $children[$key]->children       =      $a;
                }
                $tree[$k]->children                 =   $children ? $children : [];
            }
        }
        return $tree;
    }

    public function getChildren($pid,$ids=''){
        $where['pid']                               =   $pid;
        if(!empty($ids)){
            $where['id']                            =   ['in',$ids];
        }
        return $this->data([])->where($where)->order('sort desc')->select();
    }


}