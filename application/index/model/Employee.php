<?php
/**
 * Created by 高远
 * Date: 2016/10/20
 * Time: 14:08
 */

namespace app\index\model;


use think\Model;

class Employee extends  Model
{
    protected $autoWriteTimestamp = true;

    public  function getName($list){

        $where['id']    =   $list;
        $result= $this->where($where)->find();
        return $result['name'];
    }
}