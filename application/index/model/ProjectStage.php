<?php
/**
 * Created by 高远
 * Date: 2016/10/21
 * Time: 10:59
 */

namespace app\index\model;


use think\Db;
use think\Model;

class ProjectStage extends  Model
{

    protected $autoWriteTimestamp = false;
        public  function  getAll(){
            return $this->order('order_id asc')->select();

        }
    public  function  getName($id){

        return $this->field('name')->where($id)->find();
    }
    //新建项目库
    public  function  add($list){

        $parm['name']   =   $list['name'];
        $parm['order_id']  =   $list['order'];

        Db::startTrans();
        $all    =   $this->select();
        foreach ($all as $k =>$v){


            if($parm['order_id']<=$v['order_id']){
                $where['id']    =   $v['id'];


               $this->where($where)->setInc('order_id');


                }


            }


        $result =   $this->insertGetId($parm);
        if($result!=0){

            Db::commit();
        }else{

            Db::rollback();
        }



        return $result;

    }


        //删除项目库
    public  function  delete_stage($list){

        $result =   $this->where($list)->delete();
        return $result;

    }
    public  function  edit($list){

        $result =   $this->update($list);

        return $result;

    }
    public  function getMax(){

        $result =   $this->field('max(order_id) order_id')->find();
        $where['order_id']  =   $result['order_id'];

        $result1    =   $this->where($where)->find();
        return $result1['id'];
    }

}