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

class AuthGroup extends Model
{
    public function getRules($groupId)
    {
        $where['id'] = $groupId;
        return $this->where($where)->value('rules');
    }

    public function setRules($groupId, $rules)
    {
        if (is_array($rules)) {
            $rules = implode(',', $rules);
        }
        return $this->save(['rules' => $rules], ['id' => $groupId]);
    }

    public function getOrder($res)
    {
        return $this->where($res)->value('order');


    }

    public function getByOrder($list)
    {

        return $this->where($list)->find();

    }

    /**通过order帅选所有比自己等级高的
     * @param $list
     * @return string
     */
    public function getAllUserByOrder($list)
    {

        $where['order'] = array('lt', $list['order']);
        $result = $this->field('id')->where($where)->select();
        if($result!=null&&$result!=""){
            unset($list);
            foreach ($result as $k => $v) {

                $list[$k] = $v['id'];
            }

            $list = implode(',', $list);
            return $list;

        }
        return 0;



    }

}