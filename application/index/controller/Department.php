<?php
/**
 * Created by 高远
 * Date: 2016/11/4
 * Time: 16:48
 */

namespace app\index\controller;


use app\index\model\Category;
use app\index\model\Message;
use app\index\model\Organization;
use app\index\model\Project;
use app\index\model\ProjectStage;
use think\Request;

class Department extends  Base
{


    public  function index(){

       $rules_result    =   session('rules_result');
        $rules_result   =   explode(',',$rules_result);


        $userInfo   =   session('user');

        $message_action['to'] =  $userInfo['id'];


        $message_action['stage_id'] =  array('neq', 0);

        $messageM   =  new  Message();

        $message_stage_result  =   $messageM->getlist($message_action);

        unset($message_action['stage_id']);
        $message_action['stage_id'] =  array('eq', 0);
        $message_project_result  =   $messageM->getlist1($message_action);



        $this->assign('messagestageLog',$message_stage_result);
        $this->assign('messageproLog',$message_project_result);
        $this->getProjectStage();


        $this->assign('userInfo',$userInfo);

        return $this->fetch();
    }



    public  function  getProjectStage(){
        $projectStage   =   new        ProjectStage();
        $project        =   new        Project();

        $project_stage_data =   $projectStage->getAll();
        foreach ($project_stage_data  as $key => $value){
            $project_stage_data[$key]['number']    =   count($project->where("stage_id=".($value['id']))->where("status=1")->select());


        }


        $this->assign('projectStage',$project_stage_data);

    }
    //修改机构名称

    public  function  deitOrganization(){

        $organzitionM   =   new Organization();

        $request    =     Request::instance();
        $list   =   $request->param();

        $result =   $organzitionM->editName($list);
        return $result;

    }
    //新建行业分类
    public  function newCategory(){


        $categoryM  =   new Category();
        $request    =   Request::instance();
        $list   =   $request->param();
        $result =   $categoryM->newCategory($list);
        return $result;


    }
    //删除行业分类
    public  function  deleteCategory(){
        $categoryM  =   new Category();
        $request    = Request::instance();
        $list       =$request->param();
        $result =   $categoryM->deleteCategory($list);
        return $result;


    }
    //编辑行业
    public  function  editCategory(){
        $categoryM  =   new Category();
        $request   =Request::instance();
        $list   =   $request->param();
        $result =   $categoryM->editCategory($list);
        return $result;



    }
}