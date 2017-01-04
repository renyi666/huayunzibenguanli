<?php
/**
 * Created by 高远
 * Date: 2016/11/2
 * Time: 13:07
 */

namespace app\index\controller;


use app\index\model\AuthGroup;
use app\index\model\AuthGroupUser;
use app\index\model\Project;
use think\Controller;
use think\Request;

class Return1 extends  Controller
{

    //根据跟进人选择
    public  function  index(){

        $userInfo   =   session('user');

        $user_data['user_id']    =   $userInfo['id'];
        $authGroupM =   new  AuthGroup();
        $authGroupUserM =   new AuthGroupUser();
        $auth_result    =   $authGroupUserM->where($user_data)->find();
        $auth_group=$auth_result['group_id'];

        $auth_result_data['id'] =   $auth_result['group_id'];
        $auth_group_result  =   $authGroupM->where($auth_result_data)->find();

        $auth_group_all =   $authGroupM->select();

        $number =   count($auth_group_all);

        $number_result  =   $number-$auth_group_result['order'];


        $data_result1= $auth_result['underling'] ;



        $auth_result['underling']   =   explode(',',$auth_result['underling']);

        $data_result= $auth_result['underling'] ;
        $delete_data['id']  =   $userInfo['id'];
        //去除与本次用户相同的id

        $key=array_search($data_result ,$delete_data);
        array_splice($data_result,$key,1);

        $data_fin=[];
        for($k=0;$k<$number_result;$k++){

            foreach ( $data_result as $i=>$v){
                $map['user_id'] =   $v;


                $auth_result_fin   =   $authGroupUserM->where($map)->find();

                $data_result1=$data_result1.",".$auth_result_fin['underling'];


                $data_fin[$i]=  $data_result =  $auth_result_fin['underling'];

                $data_fin[$i]   =explode(',', $data_fin[$i] );

                if($data_fin[$i]!=null){
                    $key=array_search($data_fin[$i]  ,$map);
                    array_splice($data_fin[$i],$key,1);


                }

                $data_fin[$i]   =implode(',', $data_fin[$i] );




            }


            $data_fin=array_unique( $data_fin);
            $data_fin=array_filter($data_fin);
            $data_result=$data_fin;


        }






        $data_result1=explode(',',$data_result1);
        $data_result1=array_unique( $data_result1);
        $data_result1=array_filter($data_result1);

        $data_result1=implode(',',$data_result1);

        $auth_shaixuan['p.ucenter_id']  =   array('in',$data_result1);


        $project    =   new Project();
        $list['category']   =   input('category');
        $list['investment']  =  input('investment');
        $list['province']   =   input('province');
        $list['stage_id']   =  input('stage_id');
        $list['priority_id']   =  input('priority_id');
        $list['charge_id']   = input('charge_id');


        if($list['category']!=0){
            $where4['p.category_id']    =   $where['category_id']   =   $list['category'];
        }

        if($list['investment']!=0){
            $where4['p.investment_stage']   =   $where['investment_stage'] =  $list['investment'];
        }
        if($list['province']!=0){
            $where4['p.province_id']    =   $where['province_id']   =  $list['province'];
        }
        if($list['stage_id']!=0){
            $where4['p.stage_id']   =   $data['stage_id']   =   $where['stage_id']  =  $list['stage_id'];
        }else{
            $where4['p.stage_id']   =  $data['stage_id']    =    $where['stage_id'] =   1;

        }
        if($list['priority_id']!=0){
            $where4['p.priority_id']    =   $where['priority_id']   =   $list['priority_id'];
        }

        if($list['charge_id']!=0){
            $where4['p.charge_id']    =   $where['charge_id']   =   $list['charge_id'];
        }

        if ($list['category'] == 0 && $list['investment'] == 0 && $list['province'] == 0&&  $list['priority_id'] ==0) {
           if($list['charge_id']==0){

               if($auth_group==1||$auth_group==2){
dump("aa");
                   $result=$project
                       ->alias('p')
                       ->where("p.stage_id=".$data['stage_id'])
                       ->where("p.status=1")
                       ->field('p.id,p.name,p.brief,p.category_name,p.company_name,p.ucenter_id,u.user_name ename,p.update_time,p.investment_stage,i.investment_name,pr.id pid,pr.name stage_name')

                       ->join('investment i', 'p.investment_stage=i.id')
                       ->join('project_stage pr', 'pr.id=p.stage_id')
                       ->join('ucenter u', 'u.id=p.ucenter_id')

                       ->paginate(6);

               }else{

                   $result=$project
                       ->alias('p')
                       ->where("p.stage_id=".$data['stage_id'])
                       ->where("p.status=1")

                       ->where($auth_shaixuan)
                       ->field('p.id,p.name,p.brief,p.category_name,p.company_name,p.ucenter_id,u.user_name ename,p.update_time,p.investment_stage,i.investment_name,pr.id pid,pr.name stage_name')
                       ->join('investment i', 'p.investment_stage=i.id')
                       ->join('project_stage pr', 'pr.id=p.stage_id')
                       ->join('ucenter u', 'u.id=p.ucenter_id')
                       ->paginate(6);

               }


//
//               $result=$project
//                   ->alias('p')
//                   ->where("p.stage_id=".$data['stage_id'])
//                   ->where("p.status=1")
//                   ->field('p.id,p.name,p.brief,p.category_name,p.company_name,p.ucenter_id,u.user_name ename,p.update_time,p.investment_stage,i.investment_name,pr.id pid,pr.name stage_name')
//
//                   ->join('investment i', 'p.investment_stage=i.id')
//                   ->join('project_stage pr', 'pr.id=p.stage_id')
//
//                   ->join('ucenter u', 'u.id=p.ucenter_id')
//
//                   ->paginate(4);

           }else{

//               $result=$project
//                   ->alias('p')
//                   ->where("p.stage_id=".$data['stage_id'])
//                   ->where("p.status=1")
//                   ->where("p.ucenter_id=".$list['charge_id'])
//                   ->field('p.id,p.name,p.brief,p.category_name,p.company_name,p.ucenter_id,u.user_name ename,p.update_time,p.investment_stage,i.investment_name,pr.id pid,pr.name stage_name')
//
//                   ->join('investment i', 'p.investment_stage=i.id')
//                   ->join('project_stage pr', 'pr.id=p.stage_id')
//
//                   ->join('ucenter u', 'u.id=p.ucenter_id')
//
//                   ->paginate(4);
               if($auth_group==1||$auth_group==2){

                   $result=$project
                       ->alias('p')
                       ->where("p.stage_id=".$data['stage_id'])
                       ->where("p.status=1")
                       ->where("p.ucenter_id=".$list['charge_id'])
                       ->field('p.id,p.name,p.brief,p.category_name,p.company_name,p.ucenter_id,u.user_name ename,p.update_time,p.investment_stage,i.investment_name,pr.id pid,pr.name stage_name')
                       ->join('investment i', 'p.investment_stage=i.id')
                       ->join('project_stage pr', 'pr.id=p.stage_id')
                       ->join('ucenter u', 'u.id=p.ucenter_id')
                       ->paginate(6);

               }else{

                   $result=$project
                       ->alias('p')
                       ->where("p.stage_id=".$data['stage_id'])
                       ->where("p.status=1")
                       ->where($auth_shaixuan)
                       ->field('p.id,p.name,p.brief,p.category_name,p.company_name,p.ucenter_id,u.user_name ename,p.update_time,p.investment_stage,i.investment_name,pr.id pid,pr.name stage_name')
                       ->join('investment i', 'p.investment_stage=i.id')
                       ->join('project_stage pr', 'pr.id=p.stage_id')
                       ->join('ucenter u', 'u.id=p.ucenter_id')
                       ->paginate(6);

               }
           }

        }else{

            if($list['charge_id']==0){
//                $result=$project
//                    ->alias('p')
//                    ->where($where4)
//                    ->where("p.status=1")
//                    ->field('p.id,p.name,p.brief,p.category_name,p.company_name,p.ucenter_id,u.user_name ename,p.update_time,p.investment_stage,i.investment_name,pr.id pid,pr.name stage_name')
//
//                    ->join('investment i', 'p.investment_stage=i.id')
//                    ->join('project_stage pr', 'pr.id=p.stage_id')
//
//                    ->join('ucenter u', 'u.id=p.ucenter_id')
//
//                    ->paginate(4);

                if($auth_group==1||$auth_group==2){

                    $result=$project
                        ->alias('p')
                        ->where("p.stage_id=".$data['stage_id'])
                        ->where("p.status=1")
                        ->where("p.ucenter_id=".$list['charge_id'])
                        ->field('p.id,p.name,p.brief,p.category_name,p.company_name,p.ucenter_id,u.user_name ename,p.update_time,p.investment_stage,i.investment_name,pr.id pid,pr.name stage_name')

                        ->join('investment i', 'p.investment_stage=i.id')
                        ->join('project_stage pr', 'pr.id=p.stage_id')
                        ->join('ucenter u', 'u.id=p.ucenter_id')

                        ->paginate(6);

                }else{

                    $result=$project
                        ->alias('p')
                        ->where("p.stage_id=".$data['stage_id'])
                        ->where("p.status=1")
                        ->where("p.ucenter_id=".$list['charge_id'])
                        ->where($auth_shaixuan)
                        ->field('p.id,p.name,p.brief,p.category_name,p.company_name,p.ucenter_id,u.user_name ename,p.update_time,p.investment_stage,i.investment_name,pr.id pid,pr.name stage_name')
                        ->join('investment i', 'p.investment_stage=i.id')
                        ->join('project_stage pr', 'pr.id=p.stage_id')
                        ->join('ucenter u', 'u.id=p.ucenter_id')
                        ->paginate(6);

                }
            }else{

//                $result=$project
//                    ->alias('p')
//                    ->where($where4)
//                    ->where("p.status=1")
//                    ->where("p.ucenter_id=".$list['charge_id'])
//                    ->field('p.id,p.name,p.brief,p.category_name,p.company_name,p.ucenter_id,u.user_name ename,p.update_time,p.investment_stage,i.investment_name,pr.id pid,pr.name stage_name')
//
//                    ->join('investment i', 'p.investment_stage=i.id')
//                    ->join('project_stage pr', 'pr.id=p.stage_id')
//
//                    ->join('ucenter u', 'u.id=p.ucenter_id')
//
//                    ->paginate(4);
                if($auth_group==1||$auth_group==2){

                    $result=$project
                        ->alias('p')
                        ->where("p.stage_id=".$data['stage_id'])
                        ->where("p.status=1")
                        ->where("p.ucenter_id=".$list['charge_id'])
                        ->field('p.id,p.name,p.brief,p.category_name,p.company_name,p.ucenter_id,u.user_name ename,p.update_time,p.investment_stage,i.investment_name,pr.id pid,pr.name stage_name')

                        ->join('investment i', 'p.investment_stage=i.id')
                        ->join('project_stage pr', 'pr.id=p.stage_id')
                        ->join('ucenter u', 'u.id=p.ucenter_id')

                        ->paginate(6);

                }else{

                    $result=$project
                        ->alias('p')
                        ->where("p.stage_id=".$data['stage_id'])
                        ->where("p.status=1")
                        ->where($auth_shaixuan)
                        ->where("p.ucenter_id=".$list['charge_id'])
                        ->field('p.id,p.name,p.brief,p.category_name,p.company_name,p.ucenter_id,u.user_name ename,p.update_time,p.investment_stage,i.investment_name,pr.id pid,pr.name stage_name')
                        ->join('investment i', 'p.investment_stage=i.id')
                        ->join('project_stage pr', 'pr.id=p.stage_id')
                        ->join('ucenter u', 'u.id=p.ucenter_id')
                        ->paginate(6);

                }

            }



        }

        foreach ($result as $key =>$value){

            $result[$key]['update_time']  =   date('Y-m-d H:i:s',$value['update_time']);

        }
return $result;

//        $this->assign('result',$result);
//        return $this->fetch();
    }


}