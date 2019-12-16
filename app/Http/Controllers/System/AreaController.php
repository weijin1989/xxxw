<?php

namespace App\Http\Controllers\System;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Area;
use DB,Input,Excel;
use App\Http\Controllers\Common\AddLogsController;

class AreaController extends Controller
{

    public function index()
    {
        $list = Area::orderBy('status',1)->get()->toArray();
        $p_arr=array();
        foreach($list  as $k=>$v){
            if($v['pid']==0){
                $p_arr[$v['id']]=$v;
                $p_arr[$v['id']]['two']=array();
            }
        }
        foreach($list as $k=>$v){
            if (isset($p_arr[$v['pid']])) {
                $p_arr[$v['pid']]['two'][$k] = $v;
            }
        };

        return view('system.area.index',compact('p_arr'));
    }
    /*
   * 跳转到添加页面
   * */
    public function add()
    {
        $p_list = Area::where('pid',0)->pluck('area','id');
        return view('system.area.add',compact('p_list'));
    }
    //添加保存
    public function add_save(Request $request)
    {
        $a=new Area();
        $a->pid=$request->input('pid');
        $a->area=$request->input('area');
        $a->status=$request->input('status');
        $a->save();
        return redirect('/system/area')->with('is_pop', '1');
    }
    //修改状态
    public function chageStatus(Request $request){
        $id=$request->input('id');
        $status=$request->input('status');//1为禁用；0为启用
        $return_data =  $this->ajax_result;
        if(!$id){
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
        $a=Area::find($id);
        $a->status=$type['status'];
        $a->save();
        echo json_encode($return_data);
        return;
    }
    //删除栏目
    public function del_Area(Request $request)
    {
        $id= $request->input("id");
        $result = Area::deleteArea($id);
        $return_data =  $this->ajax_result;
        if($result) {
            $return_data['msg'] = '删除成功';
            //添加日志
            $content="删除系统栏目表(system_menu)id为:".$id."的信息";
            $logs= new AddLogsController();
            $logs->addLogs($content);
        } else{
            $return_data['code'] = -2;
            $return_data['msg'] = '删除失败！';
        }
        echo json_encode($return_data);exit;
    }
    /*
    * 跳转到修改页面
    * */
    public function edit($id)
    {
        $info=Area::find($id);
        $p_Area = Area::where('pid',0)->pluck('area','id');;
        return view('system.area.edit')->with('p_list',$p_Area)->with('info',$info);
    }
    public function edit_save($id,Request $request)
    {
        $a=Area::find($id);
        $a->pid=$request->input('pid');
        $a->area=$request->input('area');
        $a->status=$request->input('status');
        $a->save();

        return redirect('/system/area')->with('is_pop', '1');
    }
    /*
    * 名称是否存在
    * */
    public function ajaxArea(Request $request){
        $name=$request->input("area");
        $id=$request->input("id");
        $return_data =  $this->ajax_result;
        if(!$name){
            $return_data['code']=-1;
            $return_data['msg']='参数错误';
            echo json_encode($return_data);
            return;
        }
        $rs=Area::where('area',$name)->where('id','<>',$id)->frist();
        if($rs){
            $return_data['code']=1;
            $return_data['msg']='已经存在';
            echo json_encode($return_data);
            return;
        }else{
            echo json_encode($return_data);
            return;
        }
    }

}

