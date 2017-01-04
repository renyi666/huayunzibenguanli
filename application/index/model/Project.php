<?php
namespace app\index\model;

use think\Model;

/**
 * Created by 高远
 * Date: 2016/10/20
 * Time: 10:08
 */
class Project extends Model
{
    protected $autoWriteTimestamp = true;

    //查看所有项目
    public function getAll()
    {

        return $this->select();


    }

    //根据某一项条件筛选项目
    public function getWhere($id)
    {
        $where['id'] = $id['id'];
        return $this->where($where)->find();

    }


    public function savaAll($list)
    {


        $data['status'] = $this->save($list);
        $data['id'] = $this->id;
        //把操作放到记录表里
        $parm['title']  =   "新建项目";
        $parm['stage_id']    =   $list['stage_id'];
        $parm['project_id'] =   $data['id'];
        $parm['from'] =   $list['ucenter_id'];
        $messageM   = new Message();
        $result =$messageM->addMessage($parm);

        return $data;

    }


    public function editProject($list)
    {
        $parm['title']  =   "编辑项目";
        $parm['project_id'] =   $list['id'];
        $parm['from'] =   $list['ucenter_id'];
        $messageM   = new Message();
        $result =$messageM->addMessage($parm);


        return $this->update($list);


    }

    public function deledtProject($list)
    {

        $data['status'] = 0;
        return $this->where($list)->update($data);


    }


}