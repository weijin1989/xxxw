<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Common\AddLogsController;
use App\Models\Company;
use App\Models\Users;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\System;
use DB,Input,Auth,Config,Excel,Util,Redirect;

class CompanyController extends Controller
{
    /*
     * 界面
     */
    public function index() {
        $p_list=Company::where('pid',0)->orderby('sort','asc')->get();
        $sub_list=Company::where('pid','<>',0)->orderby('sort','asc')->get();
        $sub_list_demo=[];
        foreach($sub_list as $k=>$v){
            $sub_list_demo[$v->pid][$k]=$v;
        }
        $list=[];
        foreach($p_list as $k=>$v){
            $p_list[$k]['sub']=[];
            if(isset($sub_list_demo[$v->id])){
                $p_list[$k]['sub']=$sub_list_demo[$v->id];
            }
        }
        return view('system.company.index',compact('p_list'));
    }
    /*
     * 新增界面
     */
    public function add(){
        $p_list=Company::where('pid',0)->get();
        return view('system.company.add',compact('p_list'));
    }
    /*
     * 新增界面
     */
    public function add_save(Request $request){
        $com=new Company();
        $com->pid=$request->input('pid');
        $com->company_no=$request->input('company_no');
        $com->company_name=$request->input('company_name');
        $com->company_type=$request->input('company_type');
        $com->status=$request->input('status');
        $com->sort=$request->input('sort');
        $com->save();
        return redirect('/system/company')->with('is_pop', '1');
    }

    /*
     * 修改
     */
    public function edit($id) {
        $info=Company::where('id',$id) ->first();
        $p_list=Company::where('pid',0)->get();
        return view('system.company.edit',compact('info','p_list'));
    }
    /*
     * 编辑服务人员保存
     */
    public function edit_save($id,Request $request){
        $com=Company::find($id);
        $com->pid=$request->input('pid');
        $com->company_no=$request->input('company_no');
        $com->company_name=$request->input('company_name');
        $com->company_type=$request->input('company_type');
        $com->status=$request->input('status');
        $com->sort=$request->input('sort');
        $com->save();
        return redirect('/system/company')->with('is_pop', '1');
    }

    /*
     * 禁用执行动作
     */
    public function chageStatus(Request $request){
        $id=$request->input('id');
        $status=$request->input('status');//1为启用；0为禁用
        $return_data =  $this->ajax_result;
        if($id == ""){
            $return_data['code']=-1;
            $return_data['msg']='参数错误';
            echo json_encode($return_data);
            return;
        }
        $type=array();
        if($status==0){
            $type['status']=1;
        }else{
            $type['status']=0;
        }
        $system = new System();
        $system->dochage($id,$type);
        echo json_encode($return_data);
        return;
    }

    /*
     * 查询编号是否存在
     */
    public function ajax_check_no(Request $request){
        $id=$request->input('id');
        $company_no=$request->input('company_no');
        $return_data =  $this->ajax_result;
        $info=Company::where('company_no',trim($company_no))->where('id','<>',$id)->first();
        if($info){
            $return_data['code']=-1;
        }
        echo json_encode($return_data);
        return;
    }

    /*
     * 查询名称是否存在
     */
    public function ajax_check_name(Request $request){
        $id=$request->input('id');
        $company_name=$request->input('company_name');
        $return_data =  $this->ajax_result;
        $info=Company::where('company_name',trim($company_name))->where('id','<>',$id)->first();
        if($info){
            $return_data['code']=-1;
        }
        echo json_encode($return_data);
        return;
    }


    //删除单位并且删除下面的账号
    public function del(Request $request){
        $id=$request->input('id');
        $return_data =  $this->ajax_result;
        if($id == ""){
            $return_data['code']=-1;
            $return_data['msg']='参数错误';
            echo json_encode($return_data);
            return;
        }
        Company::where('id',$id)->delete();
        Users::where('company_id',$id)->delete();
        echo json_encode($return_data);
        return;
    }
}