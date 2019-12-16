<?php

namespace App\Http\Controllers\System;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Users;
use DB,Input,Auth;
use App\Http\Controllers\Common\AddLogsController;

class UsersController extends Controller
{
    /*
     * 首页
     */
    public function index(Request $request)
    {
    }

    /*
     * 修改密码
     */
    public function modifyPassword(Request $request)
    {
        return view('system.modifyPassword');
    }

    /*
     * 修改密码 保存
     */
    public function modifyPassword_save(Request $request)
    {
        $n_password = trim($request->input('n_password'));
        $name = $request->input('name');
        $id   = Auth::user()->id;
        $inset_data=array();
        if($name!=''){
            $inset_data['name']=$name;
        }
        if($n_password!='') {
            $inset_data['password'] = bcrypt($n_password);
        }
        Users::edit($id,$inset_data);
        //添加日志
        $content="Users表修改了个人信息或者密码,修改人id=".$id;
        $logs= new AddLogsController();
        $logs->addLogs($content);
        if($n_password) {
            return redirect('/system/modifyPassword')->with('is_pop', '1');
        }else{
            return redirect('/system/modifyPassword')->with('is_pop', '1');
        }
    }

    /*
     * 检测原始密码是否正确
     * */
    public function ajax_check_pwd(Request $request){
        $password=$request->input("o_password");
        $id   = Auth::user()->id;
        $rs=Users::findOne($id);
        $return_data =  $this->ajax_result;
        if(!password_verify($password,$rs->password)){
            $return_data['code']=-1;
            $return_data['msg']='原始密码不正确';
        }
        echo json_encode($return_data);
        return;
    }

    public function online(Request $request){
        $line=$request->input('line');
        Users::findOne(Auth::user()->id);
        $data=array('is_online'=>0);
        if($line==1){//在线
            $data['is_online']=1;
        }
//        print_r($data);exit;
        Users::edit(Auth::user()->id,$data);
        //添加日志
        $content="【系统日志】- 用户 ".Auth::user()->name." 标记为下线：";
        $logs= new AddLogsController();
        $logs->addLogs($content);
        echo json_encode($this->ajax_result);
        return;
    }


}