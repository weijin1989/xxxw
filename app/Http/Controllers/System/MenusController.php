<?php

namespace App\Http\Controllers\System;

use App\Models\Posts;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Menus;
use DB,Input,Excel;
use App\Http\Controllers\Common\AddLogsController;

class MenusController extends Controller
{

    public function index()
    {
//        $filePath='storage/wp_posts.xls';
//        $reader = Excel::load($filePath);
//        $reader=$reader->getSheet(0);
//        foreach($reader->toArray() as $k=>$v){
//            Posts::where('ID',$v[0])->update(['guid'=>$v[1]]);
//        }
////        dd($data);
//        echo '导入成功';exit;

        $list = Menus::Menus_list()->toArray();
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
        }

        return view('system.menus.index')->with('list',$p_arr);
    }
    /*
   * 跳转到添加页面
   * */
    public function add_menus()
    {
        $p_menus = Menus::p_menus();
        return view('system.menus.add_menus')->with('p_menus',$p_menus);
    }
    //添加保存
    public function add_menus_save()
    {
        $pid = (isset($_REQUEST["pid"]) && $_REQUEST["pid"] !='')?$_REQUEST["pid"]:'0';
        $catname = $_REQUEST["catname"];
        $icon = $_REQUEST["icon"];
        $url = $_REQUEST["url"];
        $sort = (isset($_REQUEST["sort"]) && $_REQUEST["sort"] !='')?$_REQUEST["sort"]:'50';
        $describe = $_REQUEST["describe"];
        $status = $_REQUEST["status"];
        $time = date('Y-m-d H:i:s');

        $add_data=array(
            'pid'=>$pid,
            'catname'=>$catname,
            'icon'=>$icon,
            'url'=>$url,
            'sort'=>$sort,
            'describe'=>$describe,
            'status'=>$status,
            'created_at'=>$time
        );
        Menus::add_menus_save($add_data);
        //添加日志
        $content="system_menu表添加新栏目:".$catname;
        $logs= new AddLogsController();
        $logs->addLogs($content);
        return redirect('/system/menusList/')->with('is_pop', '1');
    }
    //修改状态
    public function chageMenusStatus(Request $request){
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

        Menus::edit($id,$type);
        //添加日志
        $content="修改系统栏目表(system_menu)id为:".$id."的状态$status";
        $logs= new AddLogsController();
        $logs->addLogs($content);
        echo json_encode($return_data);
        return;
    }
    //删除栏目
    public function del_menus(Request $request)
    {
        $id= $request->input("id");
        $result = Menus::deleteMenus($id);
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
    public function edit_menus($id)
    {
        $info=Menus::findOne($id);
        $p_menus = Menus::p_menus();
        return view('system.menus.edit_menus')->with('p_menus',$p_menus)->with('info',$info);
    }
    public function edit_menus_save()
    {
        $id = $_REQUEST["id"];
        $pid = (isset($_REQUEST["pid"]) && $_REQUEST["pid"] !='')?$_REQUEST["pid"]:'0';
        $catname = $_REQUEST["catname"];
        $icon = $_REQUEST["icon"];
        $url = $_REQUEST["url"];
        $sort = (isset($_REQUEST["sort"]) && $_REQUEST["sort"] !='')?$_REQUEST["sort"]:'50';
        $describe = $_REQUEST["describe"];
        $status = $_REQUEST["status"];
        $time = date('Y-m-d H:i:s');
        $edit_data=array(
            'pid'=>$pid,
            'catname'=>$catname,
            'icon'=>$icon,
            'url'=>$url,
            'sort'=>$sort,
            'describe'=>$describe,
            'status'=>$status,
            'updated_at'=>$time
        );
        Menus::edit($id,$edit_data);
        //添加日志
        $content="修改系统栏目表(system_menu)id为:".$id."的信息";
        $logs= new AddLogsController();
        $logs->addLogs($content);
        return redirect('/system/menusList/')->with('is_pop', '1');
    }
    /*
    * 名称是否存在
    * */
    public function ajax_menus(Request $request){
        $name=$request->input("catname");
        $id=$request->input("id");
        $return_data =  $this->ajax_result;
        if(!$name){
            $return_data['code']=-1;
            $return_data['msg']='参数错误';
            echo json_encode($return_data);
            return;
        }
        $rs=Menus::getMenus($name,$id);
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

