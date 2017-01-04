<?php
/**
 *　　　　　　　　┏┓　　　┏┓+ +
 *　　　　　　　┏┛┻━━━┛┻┓ + +
 *　　　　　　　┃　　　　　　　┃ 　
 *　　　　　　　┃　　　━　　　┃ ++ + + +
 *　　　　　　 ████━████ ┃+
 *　　　　　　　┃　　　　　　　┃ +
 *　　　　　　　┃　　　┻　　　┃
 *　　　　　　　┃　　　　　　　┃ + +
 *　　　　　　　┗━┓　　　┏━┛
 *　　　　　　　　　┃　　　┃　　　　　　　　　　　
 *　　　　　　　　　┃　　　┃ + + + +
 *　　　　　　　　　┃　　　┃　　　　Code is far away from bug with the animal protecting　　　　　　　
 *　　　　　　　　　┃　　　┃ + 　　　　神兽保佑,代码无bug　　
 *　　　　　　　　　┃　　　┃
 *　　　　　　　　　┃　　　┃　　+　　　　　　　　　
 *　　　　　　　　　┃　 　　┗━━━┓ + +
 *　　　　　　　　　┃ 　　　　　　　┣┓
 *　　　　　　　　　┃ 　　　　　　　┏┛   Author:XiaoFei Zhai
 *　　　　　　　　　┗┓┓┏━┳┓┏┛ + + + +
 *　　　　　　　　　　┃┫┫　┃┫┫
 *　　　　　　　　　　┗┻┛　┗┻┛+ + + +
 */

namespace app\index\model;


use think\Model;

class AuthGroupUser extends Model
{
    /**
     * 获取分组id
     * @param $userId
     * @return mixed
     */
    public function getGroupId($userId)
    {
        $where['user_id'] = $userId;

        return $this->where($where)->value('group_id');
    }

    /**
     * 是否存在用户
     * @param $groupId
     * @param $userId
     * @return array|false|\PDOStatement|string|Model
     */
    public function haveUser($groupId, $userId)
    {
        $where['group_id'] = $groupId;
        $where['user_id'] = $userId;
        return $this->where($where)->find();
    }

    /**移除用户
     * @param $groupId
     * @param $userId
     * @return int
     */
    public function removeUser($groupId, $userId)
    {
        $where['group_id'] = $groupId;
        $where['user_id'] = $userId;
        return $this->where($where)->delete();
    }

    /**查询单个用户
     * @param $parm
     * @return array|false|\PDOStatement|string|Model
     */
    public function getOneUser($parm)
    {

        return $this->where($parm)->find();
    }

    /**根据group_id获得所有对应的用户
     * @param $pram
     * @return false|\PDOStatement|string|\think\Collection
     */
    public function getALLByGroupId($pram)
    {
        $where['group_id'] = array('in', $pram);

       $result  =    $this->field('user_id')->where($where)->select();
        foreach ($result as $key =>$value){

            $list[$key] =   $value['user_id'];
        }
        return $list;
    }

}