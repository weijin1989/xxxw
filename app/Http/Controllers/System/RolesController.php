<?php
/**
 * Created by PhpStorm.
 * User: 13174
 * Date: 2018/4/1
 * Time: 15:07
 */

namespace App\Http\Controllers\System;

use App\Models\PrivilegeRoles;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\RolesManagement;
use App\Models\Authority;
use App\Models\RoleAuthotiry;
use App\Models\Menus;

use DB,Input;
use App\Http\Controllers\Common\AddLogsController;

class RolesController extends Controller
{
    //进入角色管理界面
    public function index()
    {
        $Role = new RolesManagement();
        $list = $Role -> findListAll();
        return view('system.roles.index')->with('list', $list)->with('sub_menu','roles');
    }

    //进入新增界面
    public function add()
    {
        //  $Role = new RolesManagement();
        // $list = $Role -> findListAll();
        return view('system.roles.add')->with('sub_menu','roles');
    }

    //进入新增的保存动作
    public function addSave(Request $request)
    {
        $RoleAdd = new RolesManagement();
        $name = $request->input('name');
        $status = $request->input('status');
        $time = date('Y-m-d H:i:s',time());
        $inset_data=array(
            'name'=>$name,
            'status'=>$status,
            'created_at'=>$time,
            'updated_at'=>$time,
        );
//        print_r($inset_data);exit;

        $RoleAdd-> newSave($inset_data);
        //添加日志
        $content="roles表添加新角色:".$name;
        $logs= new AddLogsController();
        $logs->addLogs($content);
        return redirect('/roles/');
    }

    /*
     * 启用/禁用
     */
    public function chageRolesStatus(Request $request){
        $id=$request->input('id');
        $status=$request->input('status');//1为启用；0为禁用
//        print_r($id);exit;
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
        $changeStatus = new RolesManagement();
        $changeStatus->change($id,$type);
        //添加日志
        $content="修改角色表(roles)id为：".$id."的状态。";
        $logs= new AddLogsController();
        $logs->addLogs($content);
        echo json_encode($return_data);
        return;
    }

    /*
     * 角色删除操作
     */
//    public function deleteRole(Request $request){
//        $id = $request->input('id');
////        $id = $request->input('name');
//        $deleteRole = new RolesManagement();
//        $r = $deleteRole->deleteTheOneRole($id);
//        $return_data =  $this->ajax_result;
//        if(!$r) {
//            $return_data['code'] = -2;
//            $return_data['msg'] = '删除失败！';
//        } else{
//            $return_data['msg'] = '删除成功';
//            //添加日志
//            $content="删除角色表(roles)id为：".$id."的角色信息。";
//            $logs= new AddLogsController();
//            $logs->addLogs($content);
//        }
//        return json_encode($return_data);
//    }

    /*
     * 跳转角色权限设置
     */
    public function roleAuthority($id){
        $newRoles = new RolesManagement();
        $roleAuthority = $newRoles->findAllRoleAuthority($id);
        foreach ($roleAuthority as &$value){
            $p=DB::select('select catname from system_menu where id =  '.$value->roleAuthority_pid);
            foreach ($p as &$v) {
                $value->roleAuthority_pid = $v->catname;
            }
        }
//                        echo '<pre>';
//        print_r($roleAuthority);exit;
//        $newAuthority = new Authority();
//        $authorityInfo = $newAuthority->findAllAuthority();
        $p_menus = Menus::p_menus();

        return view('system.roles.roleAuthority')
            ->with('authorityInfo',$p_menus)
            ->with('id', $id)
            ->with('roleAuthority', $roleAuthority)
            ->with('sub_menu','roles')
            ;
    }

    //通过Pid查找下一级栏目
    public function findMenusListByPid() {
        $pid = $_REQUEST["pid"];
        $id = $_REQUEST["id"];
       // $result = Menus::findMenusListByPid($pid);
        $result = DB::select('select * from `system_menu` where pid = '.$pid);
        //已有栏目
        $res = DB::select('select * from `authority_roles` where role_id = '.$id.' and menu_pid = '.$pid);

        if(!empty($result)){
            $ajax_result = $this->ajax_result;
            $data=array(
                'menus_list'=>$result,
                'checked' => $res
            );
            $ajax_result['data']=$data;
        }else{
            $ajax_result['code']=-1;
        }
        return response()->json($ajax_result);
    }
    /*
     * 新增角色权限
     */
    public function addRoleAuthority($role_id,$authority_id){
        $time = date('Y-m-d H:i:s',time());
        $inset_data=array(
            'role_id'=>$role_id,
            'authority_id'=>$authority_id,
            'updated_at'=>$time,
            'created_at'=>$time,
        );
        $newRoleAuthotiry = new RoleAuthotiry();
        $rs=$newRoleAuthotiry->addNew($inset_data);
        $code=1;
        if(!$rs){
            $code=-1;
        }else{
            //添加日志
            $content="给角色为：".$role_id."，添加了新栏目权限".$authority_id;
            $logs= new AddLogsController();
            $logs->addLogs($content);
        }
        return $code;
    }

    /*
     * 用户权限查重；若重复删除，然后新增
     */
    public function checkRoleAuthority(){
        $role_id = $_REQUEST["id"];
        $pmemu_id = $_REQUEST["pmemu_id"];
        $smenu_id = $_REQUEST["smenu_id"];
        $time = date('Y-m-d H:i:s');

        RoleAuthotiry::delold($role_id,$pmemu_id);//删除以前
        $inset_data=array();
        foreach($smenu_id as $k =>$v){
            $inset_data[$k]['role_id']=$role_id;
            $inset_data[$k]['menu_pid']=$pmemu_id;
            $inset_data[$k]['menu_id']=$v;
            $inset_data[$k]['status']='1';
            $inset_data[$k]['updated_at']=$time;
            $inset_data[$k]['created_at']=$time;
        }
        $newRoleAuthotiry = new RoleAuthotiry();
        $newRoleAuthotiry->addNew($inset_data);

        $content="给角色为：".$role_id."，添加了新栏目权限id=".implode(',',$smenu_id);
        $logs= new AddLogsController();
        $logs->addLogs($content);
        return redirect('/roles/roleAuthority/'.$role_id);

    }

    /*
     * 删除用户区域
     */
    public function deleteRoleAuthority(Request $request){
        $id=$request->input('roleAuthority_id');
        $return_data =  $this->ajax_result;
        if($id == ""){
            $return_data['code']=-1;
            $return_data['msg']='参数错误';
            echo json_encode($return_data);
            return;
        }
        $newRoleAuthotiry = new RoleAuthotiry();
        $newRoleAuthotiry->deleteOneAuthotiry($id);
        //添加日志
        $content="删除角色权限表(authority_roles)id为：".$id."的信息";
        $logs= new AddLogsController();
        $logs->addLogs($content);
        return response()->json($return_data);
    }

    /*
     * 给角色加Url权限列表
     * */
    public function privilegeRoles($role_id){
        $Role = new RolesManagement();
        $role_info = $Role -> findOne($role_id);
        $list=PrivilegeRoles::get_select_all(array('roles_id'=>$role_id));
        $menus_list = Menus::sub_menus();
//        echo '<pre/>';
//        print_r($list->toArray());exit;
        return view('system.roles.rolePrivilege')
            ->with('role_info',$role_info)
            ->with('menus_list',$menus_list)
            ->with('list', $list);

    }
    /*
     * 给角色加Url权限保存
     * */
    public function saveRolePrivilege(Request $request){
        $role_id=$request->input('role_id');
        $menu_id=$request->input('menu_id');
        $privilege_id=$request->input('privilege_id');
        if($privilege_id) {
            PrivilegeRoles::del($menu_id, $role_id);//删除该栏目下以前所有的权限;
            $add_data=array();
            foreach($privilege_id as $k=>$l){
                $add_data[$k]['privilege_id']=$l;
                $add_data[$k]['roles_id']=$role_id;
                $add_data[$k]['menu_id']=$menu_id;
                $add_data[$k]['updated_at']=date('Y-m-d H:i:s');
                $add_data[$k]['created_at']=date('Y-m-d H:i:s');
            }
            PrivilegeRoles::add($add_data);
        }

        return redirect("/roles/privilegeRoles/".$role_id)->with('is_pop', '1');
    }


}