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


use think\helper\Time;
use think\Model;

class FileShare extends Model
{
    protected $auto                     =   [];
    protected $insert                   =   [];
    protected $update                   =   [];

    protected $updateTime               =   '';

    public function upload(){

    }

    public function uploadImage(){
        //echo json_encode($_FILES);exit();
        $file                           =   request()->file('image');
        if($file){
            $md5                            =   $file->md5();

            $fileInfo                       =   $this->fileExist($md5);
            if($fileInfo){
                return $fileInfo;
            }
            // 移动到框架应用根目录/public/uploads/ 目录下
            $info = $file->rule('uniqid')->move(ROOT_PATH . 'public' . DS . 'uploads'. DS . 'image');
            if($info){
                $data['name']               =   $info->getInfo('name');
                $data['mime']               =   $info->getInfo('type');
                $data['size']               =   $info->getInfo('size');
                $data['ext']                =   $info->getExtension();
                $data['save_name']          =   $info->getFilename();
                $data['save_path']          =   $info->getRealPath();
                $path                       =    dirname(dirname(dirname(dirname(__FILE__)))).'/public';;
                $path                       =   str_replace('\\','/',$path);
                $data['save_path']          =   str_replace($path,'',$data['save_path']);
                $data['save_path']          =   str_replace('\\','/',$data['save_path']);
                $data['sha1']               =   $info->sha1();
                $data['md5']                =   $info->md5();
                $data['create_time']                =  time();
                $row                        =   $this->allowField(true)->save($data);
                if($row){
                    return $this->info($this->id);
                }else{
                    return false;
                }

            }else{
                // 上传失败获取错误信息
                $this->error                =   $file->getError();
                return false;
            }
        }else{
            $this->error                    =   -70001;
            return false;
        }

    }
    /**
     * 检测当前上传的文件是否已经存在
     * @param  array   $md5 文件上传数组
     * @return boolean       文件信息， false - 不存在该文件
     */
    public function fileExist($md5){
        /* 查找文件 */
        $map                    =   array('md5' => $md5);
        return $this->field(true)->where($map)->find();
    }

    public function info($id,$field=true){
        return $this->field($field)->find($id);
    }
    public  function sava_file($list){


        return $this->save($list);
    }


//查询所有文件
    public  function  getAll($list){

        $where['project_id']    =   $list['id'];



            $result=$this
            ->alias('f')
                ->where('folder_id','=',0)
                ->where($where)
            ->field('f.id,f.name,f.save_path,f.ext,f.project_id,f.type_number,u.user_name,f.create_time,f.ucenter_id')

            ->join('ucenter u','u.id=f.ucenter_id')

            ->paginate(20);
        return $result;


    }
    //删除文件
    public  function  deleteFolder($list){
       
        $result =   $this->where($list)->delete();

        return $result;

    }
    //查询文件夹下的文件
    public  function  getFolder($list){

        $where['folder_id'] =   $list['id'];
        $result=$this
            ->alias('f')
            ->where($where)

            ->field('f.id,f.name,f.save_path,f.ext,f.project_id,f.type_number,u.user_name,f.create_time,f.ucenter_id')

            ->join('ucenter u','u.id=f.ucenter_id')

            ->paginate(6);

        return $result;

    }
    //新建文件夹
    public  function  addFolder($list){

        $data['project_id'] =   $list['id'];
        $data['name']               =   $list['title'];
        $data['mime']               =   '';
        $data['size']               =   '';
        $data['ext']                =   '';
        $data['save_name']          =   "新建文件夹";
        $data['save_path']          =   '';

        $data['save_path']          =  '';
        $data['save_path']          =  '';
        $data['sha1']               =  '';
        $data['md5']                =  '';
        $data['create_time']                =  time();
        $userInfo   =session('user');
        $data['ucenter_id']     =   $userInfo['id'];
        $data['type_number'] =  "0";//默认为零
        $data['folder_id'] =  $list['folder_id'];
        $row                        =   $this->allowField(true)->save($data);
        return $row;

    }

    //重命名
    public  function  reName($list){

        $data['id'] =   $list['id'];
        $data['name']   =   $list['title'];

        $result = $this->update($data);


        return $result;
    }
    public function getALL1(){
        $where['folder_id'] =0;
        $result=$this
            ->alias('f')
        ->where($where)
            ->field('f.id,f.name,f.save_path,f.ext,f.project_id,f.type_number,u.user_name,f.create_time,f.ucenter_id')

            ->join('ucenter u','u.id=f.ucenter_id')

            ->paginate(6);

        return $result;

    }
    public function getFolder1($parm){

        $where['folder_id'] =   $parm['id'];
        $result=$this
            ->alias('f')
            ->where($where)
            ->field('f.id,f.name,f.save_path,f.ext,f.project_id,f.type_number,u.user_name,f.create_time,f.ucenter_id')

            ->join('ucenter u','u.id=f.ucenter_id')

            ->paginate(6);

        return $result;
    }
}