<?php
/***
 *
 *                        ,%%%%%%%%,
 *                      ,%%/\%%%%/\%%
 *                     ,%%%\c "" J/%%%
 *            %.       %%%%/ o  o \%%%
 *            `%%.     %%%%    _  |%%%
 *             `%%     `%%%%(__Y__)%%'
 *             //       ;%%%%`\-/%%%'
 *            ((       /  `%%%%%%%'
 *             \\    .'          |
 *              \\  /       \  | |
 *               \\/         ) | |
 *                \         /_ | |__
 *                (___________))))))) 攻城狮
 *
 * @author：gaoyuan
 * @created_time：2016/12/29 8:50
 * When I wrote this, only God and I understood what I was doing
 * Now, God only knows
 */

namespace app\index\model;


use think\Model;

class ActionLog extends Model
{


    //添加数据
    public  function  addnew($parm){

        return $this->save($parm);


    }
    //根据项目分类筛选数据
    public  function getlist($parm){

        return $this->field('id,category_id,project_id,ucenter_id,status,count(category_id) canum,count(project_id) pronum')->where($parm)->group('category_id')->select();

    }
    //根据项目筛选数据
    public  function getlist1($parm){

        if($parm==null||$parm==""){

            return $this->field('id,category_id,project_id,ucenter_id,status,count(category_id) canum,count(project_id) pronum')->group('project_id')->select();

        }else{

            return $this->field('id,category_id,project_id,ucenter_id,status,count(category_id) canum,count(project_id) pronum')->where($parm)->group('project_id')->select();

        }

    }
}