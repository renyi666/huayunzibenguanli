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
 * @created_time：2017/1/11 14:43
 * When I wrote this, only God and I understood what I was doing
 * Now, God only knows
 */

namespace app\index\controller;


use app\index\model\AuthGroup;
use app\index\model\AuthGroupUser;
use app\index\model\Message;
use think\Request;

class Process extends  Base
{

    public  function index(){
        $userInfo = session('user');
        $message_action['to'] =  $userInfo['id'];


        $message_action['stage_id'] =  array('neq', 0);

        $messageM   =  new  Message();

        $message_stage_result  =   $messageM->getlist($message_action);

        unset($message_action['stage_id']);
        $message_action['stage_id'] =  array('eq', 0);
        $message_project_result  =   $messageM->getlist1($message_action);



        $this->assign('messagestageLog',$message_stage_result);
        $this->assign('messageproLog',$message_project_result);

        $user_data['user_id'] = $userInfo['id'];
        $authGroupM = new AuthGroup();
        $authGroupUserM = new AuthGroupUser();
        $auth_result = $authGroupUserM->where($user_data)->find();
        $auth_group = $auth_result['group_id'];


        $processM  =new  \app\index\model\Process();
        $processResult  =   $processM->paginate(10);


$this->assign('processresult',$processResult);




        return $this->fetch();
    }

    public  function  addProcess(){

        $request     =  Request::instance();
        $list   =    $request->param();
        $userInfo   =   session('user');
        $list['faburen']    =   $userInfo['id'];
        $list['fabuname']    =   $userInfo['user_name'];

        $processM   = new  \app\index\model\Process();
        $result =   $processM->save($list);
        return $result;


    }

    public  function editProcess(){

        $request     =  Request::instance();
        $list   =    $request->param();

        $processM   = new  \app\index\model\Process();
        $result =   $processM->editProcess($list);
        return $result;
    }

}