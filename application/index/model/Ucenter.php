<?php
/**
 * Created by 高远
 * Date: 2016/10/20
 * Time: 14:26
 */

namespace app\index\model;


use think\Db;
use think\Model;
use think\Request;



class Ucenter extends  Model
{
    protected $autoWriteTimestamp = true;

        public  function  login($list){


           $result  =    $this->check($list);

            return $result;
        }
        public  function  logout(){

            Session::clear();


        }
        public  function  getAll(){
            $where['u.status']="1";
            $result=$this
                ->alias('u')

                ->field('u.user_name,u.id,u.mobile,u.update_time,u.create_time,u.user_no,u.remark,u.status,u1.user_name remark_name')
                ->join('ucenter  u1', 'u1.id=u.remark','LEFT')
                ->paginate(150);
            return $result;

        }



        public  function register($list){

            //获取到直属上级的id
            $group_id1=$group_id['user_id']   =   $list['remark'];

            //如果直属上级为空，就是老板级别，则相对于老板来说，直属上级是超级管理员
        if($list['remark']==null||$list['remark']==''||$list['remark']=="null"){
            $group_id1=$group_id['user_id'] =1;


        }





            $where1['mobile']   =   $list['mobile'];

            $list['password']   =   md5($list['password']);

            //查看用户表中是否有注册手机号

            $result1    =   $this->where($where1)->find();





            if($result1!=null){

                $data=array(
                    'status'  =>   -1,
                    'info' =>"请确认工号和账号没有注册过2"
                );

                return $data;

            }



            //用户表里添加完数据返回的id
            Db::startTrans();
            $res['user_id'] =$this->insertGetId($list);


            if($res['user_id']==0){
                Db::rollback();
                $data=array(
                    'status'  =>   -1,
                    'info' =>"请确认工号和账号没有注册过"
                );
                return $data;

            }





            $authGroupUserM =   new AuthGroupUser();
            $authGroupM =   new AuthGroup();
            //根据传递过来的直属上级id获得上级所属于的管理组




            $user_group_id1['id']=$user_group_id['id']   = $authGroupUserM->getGroupId($group_id1);

            if($user_group_id['id']==false){
                Db::rollback();
                $data=array(
                    'status'  =>   -1,
                    'info' =>"失败"
                );
                return $data;
            }

            $auth_order['order'] =$authGroupM->getOrder($user_group_id1);

            if($auth_order['order']==false){
                Db::rollback();
                $data=array(
                    'status'  =>   -1,
                    'info' =>"失败"
                );
                return $data;
            }

            $level  =  new Level();
            $map['user_id'] =   $res['user_id'];
            $map['pid']     =    $group_id1;
            $level_return   =   $level->insertGetId($map);

            if($level_return==0){

                Db::rollback();
                $data=array(
                    'status'  =>   -1,
                    'info' =>"添加失败"
                );
                return $data;

            }

            unset($map);

            $auth_order['order']    = $auth_order['order']+1;

            $auth_order_res =   $authGroupM->getByOrder($auth_order);

            //如果数据库存在，就直接取
            if($auth_order_res!=null&&$auth_order_res!=''){


                $auth_resurn_res['id']   =   $auth_order_res['id'];
            }else{//如果不存在，新建一个管理层
                $map['title']   =   "新建";
                $map['rules']   ="1,4,7,8";
                $map['order']   =    $auth_order['order'];

                //返回添加的id
                $auth_resurn_res['id']=$authGroupM->insertGetId($map);
                if( $auth_resurn_res['id']==0){

                    Db::rollback();
                    $data=array(
                        'status'  =>   -1,
                        'info' =>"添加失败"
                    );
                    return $data;

                }

            }

            unset($map);

            //如果新建老板账号，则直接添加数据即可
            if( $group_id['user_id'] ==1){

                $map['user_id'] =    $res['user_id'] ;
                $map['group_id']   =    2;
                $map['underling']   =     $res['user_id'];

                $auth_group_result  =$authGroupUserM->insertGetId($map);
                if( $auth_group_result==0){

                    Db::rollback();
                    $data=array(
                        'status'  =>   -1,
                        'info' =>"添加失败"
                    );
                    return $data;

                }
            }else{

                $map['user_id'] =    $res['user_id'] ;
                $map['group_id']   =    $auth_resurn_res['id'];
                $map['underling']   =   $res['user_id'] ;

                $auth_user_result   =$authGroupUserM->insertGetId($map);
                if( $auth_user_result==0){

                    Db::rollback();
                    $data=array(
                        'status'  =>   -1,
                        'info' =>"添加失败"
                    );
                    return $data;

                }

                if($auth_order['order'] ==2){



                }else{

                    $update_auth_data   =   $authGroupUserM->where($group_id)->find();


                    $where2['id']   =   $update_auth_data['id'];
                    $update_auth_data1['underling']=   $update_auth_data['underling'].",".$res['user_id'] ;


                     $auth_user_update   = $authGroupUserM->where($where2)->update($update_auth_data1);
                    if( $auth_user_update==0){

                        Db::rollback();
                        $data=array(
                            'status'  =>   -1,
                            'info' =>"添加失败"
                        );
                        return $data;

                    }

                }



            }





            Db::commit();
            return 1;


        }
        public function check($list){

            $where['mobile']    =   $list['mobile'];

            $result =   $this->where($where)->find();
            $list['password']   =   md5($list['password']);

            if($result!=null){
                if($result['status']==1){
                    if($result['password']==$list['password']){
                        $data=array(
                            'status'    => 1,
                            'info'      =>"密码正确，登录成功"
                        );
                        unset($result['password']);
                        session('user',$result);
                        return $data;
                    }else{
                        $data=array(
                            'status'    => 2,
                            'info'      =>"密码不正确"
                        );
                        return $data;
                    }
                }else{
                    $data=array(
                        'status'    => 3,
                        'info'      =>"该账号已被禁用"
                    );
                    return $data;
                }
            }else{
                    $data=array(
                    'status'    => 4,
                    'info'      =>"该用户不存在"
                );
                return $data;
            }

        }

        public  function changePw($list){

            $where['mobile']    =   $list['mobile'];
            $data    =   session('user');
            $uid    =   $data['id'];

            $result =   $this->where($where)->find();
            if($result==null){

                $data   =  array (

                    'status'    =>4,
                    'info'      =>"该用户不存在"
                );
                return  $data;
            }
            if($result['id']!=$uid){

                $data   =  array (

                    'status'    =>5,
                    'info'      =>"该用户不是您自己的账户"
                );
                return  $data;

            }

            $oldPassword['password']    =   md5($list['user_old_password']);
            if($result['password']!=$oldPassword['password']){

                $data   =  array (

                    'status'    =>55,
                    'info'      =>"您的原密码不正确"
                );
                return  $data;

            }
            $record['password'] =   md5($list['password']);

            $up_result  =   $this->where($where)->update($record);
            if($up_result==1){
                $data   =  array (

                    'status'    =>1,
                    'info'      =>"修改成功"
                );
                return  $data;

            }else{
                $data   =  array (

                    'status'    =>2,
                    'info'      =>"修改失败,请确保和原密码不重复"
                );
                return  $data;

            }





        }
    public  function getName($list){
        $where['id']    =   $list;

        $result= $this->where($where)->find();
        return $result['user_name'];


    }
}