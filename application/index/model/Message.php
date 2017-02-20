<?php
/**
 * Created by 高远
 * Date: 2016/10/20
 * Time: 14:24
 */

namespace app\index\model;


use think\Model;

class Message extends  Model
{
    protected $autoWriteTimestamp = true;

    /**
     * @param新建消息
     * @return false|int
     */
    public  function addMessage($parm){
        $list   =   session('supresult');
        $userInfo = session('user');
        $where['user_id'] = $userInfo['id'];
        $groupUserM =new AuthGroupUser();
        $result =   $groupUserM->getOneUser($where);
        if($result['group_id']==1||$result['group_id']==2){

            return 1;
        }
        foreach ($list as $key=>$value){

            $parm['to'] =   $value;
            $this->insert($parm);
            unset($parm['to']);
        }

        return 1;
    }

    //根据项目分类筛选数据
    public  function getlist($parm){
        $parm['status']=1;
        return $this->field('id,stage_id,project_id,to,status,count(stage_id) stagenum,count(project_id) pronum')->where($parm)->group('stage_id')->select();

    }
    //根据项目筛选数据
    public  function getlist1($parm){
        $parm['status']=1;
        if($parm==null||$parm==""){

            return $this->field('id,stage_id,project_id,to,status,count(stage_id) stagenum,count(project_id) pronum')->group('project_id')->select();

        }else{

            return $this->field('id,stage_id,project_id,to,status,count(stage_id) stagenum,count(project_id) pronum')->where($parm)->group('project_id')->select();

        }
    }

    //吧数据标记为一点击
    public  function clickAlerday($parm){

        $list['status'] =2;
        return $this->where($parm)->update($list);

    }
}