<?php

namespace App\Http\Controllers\System;

use App\Models\Privilege;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB,Input,Auth,Config;
use App\Models\Menus;
use App\Http\Controllers\Common\AddLogsController;

class PrivilegeController extends Controller
{
    /*
     * 首页
     */
    public function index(Request $request)
    {
        $menu_id=$request->input('menu_id');

        $menu_info=Menus::findOne($menu_id);
        $data=array();
        if($menu_id){
            $data['menu_id']=$menu_id;
        }
        $list=Privilege::get_select_list($data);
        return view('system.privilege.index')
            ->with('list',$list)
            ->with('menu_info',$menu_info)
            ->with('menu_id',$menu_id);
    }
    /*
     * 增加
     */
    public function add(Request $request)
    {
        $menu_id=$request->input('menu_id');
        $menu_info=Menus::findOne($menu_id);
        return view('system.privilege.add')
            ->with('menu_info',$menu_info);
    }

    /*
     * 增加 保存
     */
    public function add_save(Request $request)
    {
        $menu_id = $request->input('menu_id');
        $privilege_name = $request->input('privilege_name');
        $path=$request->input('path');
        $status=$request->input('status');

        $inset_data=array(
            'menu_id'=>$menu_id,
            'privilege_name'=>$privilege_name,
            'path'=>$path,
            'status'=>$status,
            'created_at'=>date('Y-m-d H:i:s'),
        );
        $id=Privilege::add_res_id($inset_data);
        $menu_info=Menus::findOne($menu_id);
        //添加日志
        $content="【".$menu_info->catname."URL权限】：增加 id=".$id;
        $logs= new AddLogsController();
        $logs->addLogs($content);
        return redirect('/system/privilege?menu_id='.$menu_id)->with('is_pop', '1');
    }


    /*
     * 编辑
     */
    public function edit($id)
    {
        $menus_list = Menus::p_menus();
        $info=Privilege::findOne($id);
        return view('system.privilege.edit')
            ->with('info',$info)
            ->with('menus_list',$menus_list);
    }

    /*
     * 编辑保存
     */
    public function edit_save(Request $request)
    {
        $id = $request->input('id');
        $privilege_name = $request->input('privilege_name');
        $path=$request->input('path');
        $status=$request->input('status');

        $update_data=array(
            'privilege_name'=>$privilege_name,
            'path'=>$path,
            'status'=>$status,
            'updated_at'=>date('Y-m-d H:i:s'),
        );
        $info=Privilege::findOne($id);
        Privilege::edit($id,$update_data);
        //添加日志
        $content="【".$info->menus->catname."URL权限】修改id为".$id."的信息。";
        $logs= new AddLogsController();
        $logs->addLogs($content);
        return redirect('/system/privilege?menu_id='.$info->menus->id)->with('is_pop', '1');
    }

    //根据栏目id获取权限节点
    public function findPrivilegeListByMenuId(Request $request){
        $menu_id=$request->input('menu_id');
        $roles_id=$request->input('roles_id');
        $return_data =  $this->ajax_result;
        $list=array();
        $p_list=Privilege::get_select_all(array('menu_id'=>$menu_id));
        $selected_list=PrivilegeRoles::get_select_all(array('roles_id'=>$roles_id));
        if($p_list){
            if($selected_list){
                $selected_list_demo=array();
                foreach($selected_list as $v){
                    $selected_list_demo[$v->privilege_id]=$v->privilege_id;
                }
                foreach($p_list as $k=>$pl){
                    $list[$k]=$pl;
                    $list[$k]['is_select']=0;
                    if(isset($selected_list_demo[$pl->id])){
                        $list[$k]['is_select']=1;
                    }
                }
            }else{
                $list=$p_list;
            }
        }
        $return_data['data']=$list;
        echo json_encode($return_data);
        return;
    }

    //根据栏目pid获二级栏目
    public function findMenuListByPid(Request $request){
        $menu_pid=$request->input('pid');
        $return_data =  $this->ajax_result;
        $p_list=Menus::sub_menus($menu_pid)->toArray();
        $return_data['data']=$p_list;
        echo json_encode($return_data);
        return;
    }

    //修改车辆类别的状态
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

        Privilege::edit($id,$type);
        $info=Privilege::findOne($id);
        //添加日志
        $content="【".$info->menus->catname."URL权限】修改状态id为".$id."；status=".$status."的状态";
        $logs= new AddLogsController();
        $logs->addLogs($content);
        echo json_encode($return_data);
        return;
    }

    /*
     * 权限路径是否存在
     * */
    public function chagePath(Request $request){
        $key=$request->input("path");
        $id=intval($request->input("id"));
        $return_data =  $this->ajax_result;
        if(!$key){
            $return_data['code']=-1;
            $return_data['msg']='参数错误';
            echo json_encode($return_data);
            return;
        }
        $rs=Privilege::getPath($key,$id);
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