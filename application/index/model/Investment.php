<?php
/**
 * Created by 高远
 * Date: 2016/10/21
 * Time: 10:44
 */

namespace app\index\model;


use think\Model;

class Investment extends  Model
{
        public  function  getAll(){

            return $this->select();
        }
 public  function  getName($id){

     return $this->field('investment_name')->where($id)->find();
 }


}