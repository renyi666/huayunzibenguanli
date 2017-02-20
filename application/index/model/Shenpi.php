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
 * @created_time：2017/1/16 11:36
 * When I wrote this, only God and I understood what I was doing
 * Now, God only knows
 */

namespace app\index\model;


use think\Model;

class Shenpi extends Model
{

    protected $autoWriteTimestamp = true;

    //添加
    public function addShenpi($parm)
    {
        return $this->save($parm);


    }

    public function getAll()
    {
        $userInfo   =   session('user');
        $where['user_id|to']    =$userInfo['id'];
        return $this->where($where)->order('create_time desc')->paginate(15);
    }

    public function editShenpi($parm)
    {

        $where['id'] = $parm['id'];

        unset($parm['id']);
        return $this->where($where)->update($parm);

    }

    public function deleteShenpi($parm)
    {

        return $this->where($parm)->delete();

    }
    public function  refuseShenpi($parm){

        $parm['shenpi_time']    =   time();
        return $this->update($parm);
    }
}