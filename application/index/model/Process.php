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
 * @created_time：2017/1/11 15:07
 * When I wrote this, only God and I understood what I was doing
 * Now, God only knows
 */

namespace app\index\model;


use think\Model;

class Process extends Model
{

    /**获得suoyou
     * @return mixed
     */
    public function getAll()
    {

        return $this->select();
    }

    public function editProcess($parm)
    {

        $parm['update_time'] = time();
        $where['id'] = $parm['id'];
        unset($parm['id']);

        return $this->where($where)->update($parm);


    }

}