<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use DB;

class RoleAuthotiry extends Model
{
    protected $table = 'authority_roles';
    /**
     * 根据用户名获取用户信息
     * @param $username
     * @return mixed 用户信息记录
     */

    //静态方法
    //  public static function read($pid){
    //return Agent::where('pid', $pid)->orderBy('created_at','asc')->first();
    // }
//
//    public static function getUserAll($select_data){
//        return UserRegion::select('region','id')->where($select_data)->get();
//    }


    /*
    * 删除一条权限
    */
    public function deleteOneAuthotiry($id)
    {
        $table = $this->table;
        DB::table($table)->where("id", $id)->delete();
    }

    /*
    * 依据参数，查询数量
    */
    public function getCount($role_id,$authority_id)
    {
        $table = $this->table;
        return DB::table($table)->where("role_id", $role_id)->where("authority_id", $authority_id)->count();
    }

    /*
    * 新增
    */
    public function addNew($data)
    {
        $table = $this->table;
        return DB::table($table)->insert($data);
    }

    //删除之前的栏目权限
    public static function delold($roles_id,$pmenus_id){
        return RoleAuthotiry::where('role_id',$roles_id)->where('menu_pid',$pmenus_id)->delete();
    }

    //查询角色所有栏目
    public static function roles_menus($roles_id){
        return RoleAuthotiry::select('menu_pid','menu_id')->where('status',1)->whereIn('role_id',$roles_id)->get();
    }

    //查询角色所有栏目
    public static function roles_menus_all(){
        return RoleAuthotiry::select('menu_pid','menu_id')->where('status',1)->get();
    }

}
