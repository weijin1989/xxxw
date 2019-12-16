<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use DB;

class Menus extends Model
{
    /**
     * 表名
     * @var string
     */
    protected $table = 'system_menu';

    //栏目列表
    public static function menus_list(){
        return Menus::select()->orderBy('sort','asc')->get();
    }
    //左侧栏目列表
    public static function menus_list_left(){
        return Menus::select()->where('status','1')->orderBy('sort','asc')->get();
    }
    //父级栏目列表
    public static function p_menus(){
        return Menus::select()->where('pid','0')->orderBy('sort','asc')->get();
    }
    //父级栏目列表
    public static function sub_menus($pid){
        return Menus::select()->where('pid',$pid)->where('status',1)->orderBy('id','asc')->get();
    }

    //栏目添加
    public static function add_menus_save($add_data){
        return Menus::insert($add_data);
    }

    //修改查找
    public static function findOne($id)
    {
        return Menus::where("id", $id)->first();
    }

    //修改
    public static function edit($id,$data_arr){
        return Menus::where('id',$id)->update($data_arr);
    }
    //判断名称是否存在
    public static function getMenus($name,$id)
    {
        return Menus::where("catname", $name)->where("id",'!=', $id)->first();
    }
    //删除
    public static function deleteMenus($id){
        return Menus::where('id',$id)->delete();
    }
    //通过Pid查找下一级栏目
    public static function findMenusListByPid($id){
        return Menus::where('pid',$id)->get();
    }

}