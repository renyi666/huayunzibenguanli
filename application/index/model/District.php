<?php
/**
 * Created by 高远
 * Date: 2016/10/25
 * Time: 14:04
 */

namespace app\index\model;


use think\Model;

class District extends Model
{


            public  function  getProvince(){
                return $this->where('pid=0')->select();

            }
}