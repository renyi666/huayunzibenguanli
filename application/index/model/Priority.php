<?php
/**
 * Created by 高远
 * Date: 2016/10/25
 * Time: 9:11
 */

namespace app\index\model;




use think\Model;

class Priority extends  Model
{
public  function  getAll(){

    return $this->select();
}
}