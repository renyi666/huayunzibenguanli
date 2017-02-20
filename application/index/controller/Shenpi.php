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
 * @created_time：2017/1/16 10:54
 * When I wrote this, only God and I understood what I was doing
 * Now, God only knows
 */

namespace app\index\controller;


use app\index\model\Message;
use app\index\model\Ucenter;
use think\Log;
use think\Request;

class Shenpi extends Base
{

    public function index()
    {
        $ucenterM = new  Ucenter();
        $messageM = new  Message();
        $shenpiM = new  \app\index\model\Shenpi();
        $userInfo = session('user');
        $message_action['to'] = $userInfo['id'];
        $message_action['stage_id'] = array('neq', 0);
        $message_stage_result = $messageM->getlist($message_action);
        unset($message_action['stage_id']);
        $message_action['stage_id'] = array('eq', 0);
        $message_project_result = $messageM->getlist1($message_action);
        $ucenterData = $ucenterM->getAll();
        $shenpiList = $shenpiM->getAll();
        $this->assign('ucentaeData', $ucenterData);
        $this->assign('shenpiList', $shenpiList);
        $this->assign('messagestageLog', $message_stage_result);
        $this->assign('messageproLog', $message_project_result);
        return $this->fetch();
    }

    /**新建审批
     * @return false|int
     */
    public function addNew()
    {
        $userInfo = session('user');
        $shenpiM = new  \app\index\model\Shenpi();
        $ucenterM = new  Ucenter();
        $list = Request::instance();
        $data = $list->param();
        $data['name'] = input('name');
        $data['content'] = input('content');
        $data['to'] = input('to');
        $data['relation'] = input('relation');
        $data['type'] = input('type');
        $data['user_id'] = $userInfo['id'];
        $data['user_name'] = $userInfo['user_name'];
        $where = $data["to"];
        $data['to_name'] = $ucenterM->getName($where);
        unset($where);
        $where = $data['relation'];
        $data['relation_name'] = $ucenterM->getName($where);
        $result = $shenpiM->addShenpi($data);
        return $result;
    }

    /**编辑审批
     * @return int|string
     */
    public function editShenpi()
    {
        $request = Request::instance();
        $list = $request->param();
        $ucenterM = new  Ucenter();
        $shenpiM = new \app\index\model\Shenpi();
        $where = $list["to"];
        $list['to_name'] = $ucenterM->getName($where);
        unset($where);
        $where = $list['relation'];
        $list['relation_name'] = $ucenterM->getName($where);
        $result = $shenpiM->editShenpi($list);
        return $result;
    }

    /**关闭审批 删除
     * @return int
     */
    public  function deleteShenpi(){
        $shenpM = new  \app\index\model\Shenpi();
        $where['id']    =   input('id');
        return $shenpM->deleteShenpi($where);
    }

    /**
     * 拒绝审批
     */
    public  function refuseShenpi(){

        $where['id']    =   input('id');
        $where['status']    =   input('status');
        $shenpiM = new  \app\index\model\Shenpi();
        return $shenpiM->refuseShenpi($where);
    }

}