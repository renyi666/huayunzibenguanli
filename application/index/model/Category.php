<?php
/**
 * Created by 高远
 * Date: 2016/10/21
 * Time: 10:53
 */

namespace app\index\model;


use think\Model;

class Category extends  Model
{
        public  function  getAll(){

            return $this->select();
        }
        public  function  getName($id){

            return $this->field('name')->where($id)->find();

        }
        public  function newCategory($parm){

            return $this->insert($parm);

        }
        public  function deleteCategory($parm){

            return $this->where($parm)->delete();


        }
        //编辑行业
    public  function editCategory($parm){


        return $this->update($parm);
    }

}