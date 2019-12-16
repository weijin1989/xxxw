<?php
/**
 * Created by PhpStorm.
 * User: 13174
 * 角色管理
 * Date: 2016/5/20
 * Time: 9:11
 */
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use DB;

class RolesManagement extends Model {

    protected $table = 'roles';
    protected $table1 = 'authority_roles';

    /*
     * 数据展示
     */
    public function findListAll() {
        $table = $this->table;

        return DB::table($table)
            ->get();
    }

    /*
     * 新增的保存
     */
    public function newSave($data_arr) {
        $table = $this->table;

        DB::table($table)->insert($data_arr);
    }

    /*
     * 启用/禁用/编辑
     */
    public function change($id,$status) {
        $table = $this->table;

        DB::table($table)->where('id',$id)->update($status);
    }


    /*
     * 删除选中的一个角色
     */
    public function deleteTheOneRole($id)
    {
        $table = $this->table;
        return DB::table($table)->where('id', $id)->delete();
    }


    /**
     * 根据id获取详情
     * @param $id
     * @return mixed
     */
    public static function findOne($id)
    {
        return RolesManagement::where("id", $id)->first();
    }

    /*
     * 查询所有的角色权限列表信息
     */
    public function findAllRoleAuthority($id)
    {
        $table = $this->table;
        return DB::select('SELECT authority_roles.id as roleAuthority_id,authority_roles.menu_pid as roleAuthority_pid,roles.name as roleName,system_menu.catname as authorityName,url,authority_roles.created_at,authority_roles.updated_at
                        from authority_roles
                        LEFT JOIN roles ON authority_roles.role_id = roles.id
                        LEFT JOIN system_menu ON authority_roles.menu_id = system_menu.id
                        where roles.id = '.$id.'');
    }


}