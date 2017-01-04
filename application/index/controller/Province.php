<?php
/**
 * Created by 高远
 * Date: 2016/10/25
 * Time: 14:14
 */

namespace app\index\controller;


use think\Controller;

class Province extends  Base
{

            public  function  getById($id){

                $province   =   new \app\index\model\Province();
                $where['pid']   =   $id;
                $result =   $province->getById($where);

                if(isset($result)&&$result!=null){

                    return  $result;

                }
            }



}