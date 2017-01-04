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
 * @modified_time：2016/12/5 14:26
 * When I wrote this, only God and I understood what I was doing
 * Now, God only knows
 */

namespace app\index\controller;


use app\index\model\AuthGroup;
use app\index\model\AuthGroupUser;
use app\index\model\LogType;
use app\index\model\Message;
use think\Request;

class Log extends Base
{

    public function index()
    {


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
        $authGroupM = new  AuthGroup();
        $authGroupUserM = new AuthGroupUser();
        $auth_result = $authGroupUserM->where($user_data)->find();
        $auth_group = $auth_result['group_id'];
        //如果是超级管理员或者老板则不执行以下操作
        if ($auth_group == 1 || $auth_group == 2) {


        } else {

            $auth_result_data['id'] = $auth_result['group_id'];
            $auth_group_result = $authGroupM->where($auth_result_data)->find();

            $auth_group_all = $authGroupM->select();

            $number = count($auth_group_all);

            $number_result = $number - $auth_group_result['order'];


            $data_result1 = $auth_result['underling'];


            $auth_result['underling'] = explode(',', $auth_result['underling']);

            $data_result = $auth_result['underling'];
            $delete_data['id'] = $userInfo['id'];
            //去除与本次用户相同的id

            $key = array_search($data_result, $delete_data);
            array_splice($data_result, $key, 1);

            $data_fin = [];
            for ($k = 0; $k < $number_result; $k++) {

                foreach ($data_result as $i => $v) {
                    $map['user_id'] = $v;


                    $auth_result_fin = $authGroupUserM->where($map)->find();

                    $data_result1 = $data_result1 . "," . $auth_result_fin['underling'];


                    $data_fin[$i] = $data_result = $auth_result_fin['underling'];

                    $data_fin[$i] = explode(',', $data_fin[$i]);

                    if ($data_fin[$i] != null) {
                        $key = array_search($data_fin[$i], $map);
                        array_splice($data_fin[$i], $key, 1);


                    }

                    $data_fin[$i] = implode(',', $data_fin[$i]);


                }


                $data_fin = array_unique($data_fin);
                $data_fin = array_filter($data_fin);
                $data_result = $data_fin;


            }


            $data_result1 = explode(',', $data_result1);
            $data_result1 = array_unique($data_result1);
            $data_result1 = array_filter($data_result1);

            $data_result1 = implode(',', $data_result1);

            $auth_shaixuan['ucenter_id'] = array('in', $data_result1);
            $list1['ucenter_id'] = $auth_shaixuan['ucenter_id'];
        }




        $request = Request::instance();
        $list = $request->param();
        if (!isset($list['type_id']) || $list['type_id'] == null || $list['type_id'] == '') {

            $list['log_type_id'] = 1;

        }

        $this->assign('type_id', $list['type_id']);
        $logTypeM = new LogType();
        $type_result = $logTypeM->getAll();
        $this->assign('type_result', $type_result);
        if ($auth_group == 1 || $auth_group == 2) {

        }else{

            $list['ucenter_id'] = $list1['ucenter_id'];
        }
        $logM = new  \app\index\model\Log();
        $result = $logM->getAll($list);
        $this->assign('result',$result);

        return $this->fetch();
    }

    //新建日志
    public function addLog()
    {
        $resuest = Request::instance();
        $list = $resuest->param();
        $userInfo = session('user');
        $list['time']   =   strtotime($list['time']);
        $list['ucenter_id'] = $userInfo['id'];
        $logM = new \app\index\model\Log();
        $result = $logM->addLog($list);
        return $result;


    }

    public function editLog()
    {

        $request = new Request();
        $list = $request->param();

        $list['time']   =   strtotime($list['time']);


        $logM = new \app\index\model\Log();
        $result = $logM->editLog($list);
        return $result;
    }
    public  function zhoubao(){

        $userInfo = session('user');

        $user_data['user_id'] = $userInfo['id'];
        $authGroupM = new  AuthGroup();
        $authGroupUserM = new AuthGroupUser();
        $auth_result = $authGroupUserM->where($user_data)->find();
        $auth_group = $auth_result['group_id'];
        //如果是超级管理员或者老板则不执行以下操作
        if ($auth_group == 1 || $auth_group == 2) {


        } else {

            $auth_result_data['id'] = $auth_result['group_id'];
            $auth_group_result = $authGroupM->where($auth_result_data)->find();

            $auth_group_all = $authGroupM->select();

            $number = count($auth_group_all);

            $number_result = $number - $auth_group_result['order'];


            $data_result1 = $auth_result['underling'];


            $auth_result['underling'] = explode(',', $auth_result['underling']);

            $data_result = $auth_result['underling'];
            $delete_data['id'] = $userInfo['id'];
            //去除与本次用户相同的id

            $key = array_search($data_result, $delete_data);
            array_splice($data_result, $key, 1);

            $data_fin = [];
            for ($k = 0; $k < $number_result; $k++) {

                foreach ($data_result as $i => $v) {
                    $map['user_id'] = $v;


                    $auth_result_fin = $authGroupUserM->where($map)->find();

                    $data_result1 = $data_result1 . "," . $auth_result_fin['underling'];


                    $data_fin[$i] = $data_result = $auth_result_fin['underling'];

                    $data_fin[$i] = explode(',', $data_fin[$i]);

                    if ($data_fin[$i] != null) {
                        $key = array_search($data_fin[$i], $map);
                        array_splice($data_fin[$i], $key, 1);


                    }

                    $data_fin[$i] = implode(',', $data_fin[$i]);


                }


                $data_fin = array_unique($data_fin);
                $data_fin = array_filter($data_fin);
                $data_result = $data_fin;


            }


            $data_result1 = explode(',', $data_result1);
            $data_result1 = array_unique($data_result1);
            $data_result1 = array_filter($data_result1);

            $data_result1 = implode(',', $data_result1);

            $auth_shaixuan['ucenter_id'] = array('in', $data_result1);
            $list1['ucenter_id'] = $auth_shaixuan['ucenter_id'];


        }


        $request = Request::instance();
        $list = $request->param();
        if (!isset($list['type_id']) || $list['type_id'] == null || $list['type_id'] == '') {

            $list['log_type_id'] = 2;

        }

        $this->assign('type_id', $list['type_id']);
        $logTypeM = new LogType();
        $type_result = $logTypeM->getAll();
        $this->assign('type_result', $type_result);
        $logM = new  \app\index\model\Log();

        if ($auth_group == 1 || $auth_group == 2) {

        }else{

            $list['ucenter_id'] = $list1['ucenter_id'];
        }
        $result = $logM->getAll($list);

        $this->assign('result',$result);

        return $this->fetch();


    }
}