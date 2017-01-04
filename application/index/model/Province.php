<?php
/**
 * Created by 高远
 * Date: 2016/10/21
 * Time: 9:59
 */

namespace app\index\model;


use think\Model;

class Province extends  Model
{
        public function getAll(){

            return $this->where('pid=0')->select();
        }
        public  function getById($id){

            return $this->where($id)->select();

        }
}