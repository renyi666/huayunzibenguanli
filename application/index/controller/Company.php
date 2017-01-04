<?php
/**
 * Created by 高远
 * Date: 2016/10/20
 * Time: 10:54
 */

namespace app\index\controller;


use think\Controller;
use think\helper\Time;

class Company extends  Controller
{

    public  function index(){

        $company    =   new \app\index\model\Company();
       \app\index\model\Company::getLastSql();
        /*
         * 新增
         */
//        $company->data(['name'=>'aa']);
//        $company->save();

        /*
         * 更新
         */
//        $company->update(['id' => 19, 'name' => 'thinkphp']);
        $a  =   "aadhajksdhaksjasda";
        $b= "aadhajksdhaksjasda";
        dump(md5($b));
        dump(md5($a));

    }
        public  function  selectCompany($name){
            $company        =   new \app\index\model\Company();
            $where['name']  =   $name;
            $result =   $company->getByName($where);
            if(is_numeric($result['id'])){

                $data="ok";
            }else{}





        }

}