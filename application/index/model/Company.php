<?php
/**
 * Created by 高远
 * Date: 2016/10/20
 * Time: 10:40
 */

namespace app\index\model;


use think\helper\Time;
use think\Model;

class Company extends  Model
{
    // 新增的时候把create_time字段设置为当前时间
    protected $autoWriteTimestamp = true;
//    protected $updateTime = false;
//    protected  $auto    =   ['update_time','create_time'];
//    protected $update = ['update_time'=>'time()'];
        public  function  getNameById($id){
            return $this->field('name')->where($id)->find();

        }
        public  function  getPerson($id){
            return $this->field('corporate_person')->where($id)->find();


        }

        public  function  getByName($name){
            return $this->field('id')->where($name)->find();
        }





}