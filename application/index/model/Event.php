<?php
/**
 * Created by 高远
 * Date: 2016/11/4
 * Time: 15:24
 */

namespace app\index\model;


use think\Model;

class Event extends  Model
{


        //新建事件
        public  function newEvent($list){


            $parm['title']  =   "新建事件";

            $parm['project_id'] =   $list['project_id'];
            $parm['from'] =   $list['ucenter_id'];
            $messageM   = new Message();
            $result =$messageM->addMessage($parm);
            return $this->save($list);
        }


        //搜索所有事件
    public  function  getAll($list){

        $where['project_id']    =   $list['id'];
        $where['status']        =1;
        $result =$this->where($where)->paginate(5);
        return $result;
    }
    //删除事件
    public  function deleteEvent($where){
        $list['status'] =  0;
        return $this->where($where)->update($list);

    }
    //编辑数据
    public  function editEvent($list){

        return $this->update($list);

    }
}