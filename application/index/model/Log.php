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
 * @modified_time：2016/12/5 14:39
 * When I wrote this, only God and I understood what I was doing
 * Now, God only knows
 */

namespace app\index\model;




use think\Model;

class Log extends Model
{
    protected $autoWriteTimestamp = true;

    public  function addLog($parm){

        return $this->save($parm);

    }
    public  function getAll($parm){

        $where['type_id'] =   $parm['type_id'];
        if(isset($parm['ucenter_id'])){

            $where['ucenter_id'] =   $parm['ucenter_id'];
        }
        $result=$this
            ->alias('l')
            ->where($where)
            ->order('l.update_time desc')
            ->field('l.id,l.name,l.ucenter_id,l.create_time,l.morning_content,l.finish_work,l.finish_remark,l.nofinish_work,l.nofinish_remark,l.next_plan,l.morning_remark,l.afternoon_content,l.afternoon_remark,l.time,l.type_id,u.user_name,l.update_time')
            ->join('ucenter u','u.id=l.ucenter_id')
            ->paginate(15);

        return $result;

    }
    public  function editLog($parm){

        $result     =   $this->update($parm);
        return $result;
    }




}