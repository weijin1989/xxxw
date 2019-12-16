<?php
/**
 * Created by PhpStorm.
 * User: weijin
 * Date: 2018/3/27
 * Time: 9:58
 */

namespace App\Http\Middleware;

use App\Models\Menus;
use App\Models\Privilege;
use App\Models\RoleAuthotiry;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Redirect;

class ServerPermissions
{
    public function handle($request, Closure $next)
    {
		$menu_pid= $request->input('menu_pid');
		$menu_lid=$request->input('menu_lid');
		if(!$menu_pid) {
			$menu_pid=Session::get('menu_pid');
		}
		if(!$menu_lid) {
			$menu_lid=Session::get('menu_lid');
		}
		Session::put('menu_pid', $menu_pid);
		Session::put('menu_lid', $menu_lid);
		//star栏目权限
//		$roles_id = Auth::user()->role;
		$roles_id = explode(',',Auth::user()->role);
		foreach($roles_id as $v){
			if($v!=''){
				$rid[]=$v;
			}
		}
		$roles_menu = RoleAuthotiry::roles_menus($rid)->toArray();//所有该角色下的栏目权限

        if(in_array("0", $rid)){//超级管理员
            $roles_menu = RoleAuthotiry::roles_menus_all()->toArray();//所有该角色下的栏目权限
        }

		$rols_arr=array();
		foreach($roles_menu as $v){
			$rols_arr[$v['menu_pid']]=$v['menu_pid'];
			$rols_arr[$v['menu_id']]=$v['menu_id'];
		}
		$list = Menus::menus_list_left()->toArray();
		$menu=array();
		foreach($list as $l){
            if(!in_array("0", $rid)){
                if(isset($rols_arr[$l['id']])) {
                    $menu[] = $l;
                }
            }else{//如果是超管权限所有菜单显示
                $menu[] = $l;
            }
		}
		$p_arr=array();
        foreach($menu  as $k=>$v){
            if($v['pid']==0){
                $p_arr[$v['id']]=$v;
                $p_arr[$v['id']]['two']=array();
            }
        }
        foreach($menu as $k=>$v){
            if (isset($p_arr[$v['pid']])) {
                $p_arr[$v['pid']]['two'][$k] = $v;
            }
        }
		//echo "<pre>";print_r($p_arr);exit;
		view()->share('system_menu',$p_arr);
		view()->share('menu_pid',$menu_pid);
		view()->share('menu_lid',$menu_lid);
		//end栏目权限
		$url='/'.$request->path();
		$url=preg_replace("[\d+]", '*', $url);//把所有数字替换成*
		$is_role=1;

		$p_role_list_demo=array();
		$p_role_list = Privilege::get_select_all_in(array_values($rols_arr));//栏目下所有url权限
		if($p_role_list) {
			foreach ($p_role_list as $v) {
				array_push($p_role_list_demo,trim($v->path));
			}
		}
		if (!in_array($url, $p_role_list_demo,TRUE)) {//判断该url是否跟角色权限匹配
			$is_role=0;
		}
		if($url=='//'){
			$is_role=1;
		}
		if($request->isMethod('post')||$request->ajax()){
			$is_role=1;
		}
        if(in_array("0", $rid)){//超级管理员
            return $next($request);
        }
		if(!$is_role){
            abort(400);
			return view('errors.error')->with("errorMsg",'你没有权限访问该页面')->with("errorCode",'400');//跳转错误页面
		}
		return $next($request);
    }
}