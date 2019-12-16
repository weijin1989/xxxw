<?php
/**
 * Created by PhpStorm.
 * User: wj
 * 角色管理
 * Date: 2018/4/2
 * Time: 9:11
 */
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use DB;

class System extends Model {

    protected $table = 'users';
    protected $table1 = 'roles';
    protected $table2 = 'region';
    protected $table3 = 'user_region';
    protected $table4 = 'users_agents';

    /*
     * users数据展示
     */
    public function findAllUsers($pagesize = 10) {
//        $table = $this->table;
//
//        return DB::table($table)
//            ->get();
        return System::select()->paginate($pagesize);
    }
    //user 业务员，业务经理角色展示
    public function findBusinessUsers($pagesize = 10) {
        $table = $this->table;
        $rs = DB::table($table)
            ->where('role', 'like', '%,2,%')
            ->orWhere('role', 'like', '%,3,%')
            ->orWhere('role', 'like', '%,20,%')
            ->paginate($pagesize);
        return $rs;
    }
    /**
     * 与角色表进行关联
     */
    public function roles()
    {
        return $this->belongsTo('App\Model\RolesManagement', 'role', 'id');
    }

    //转入角色id 返回角色名称
    public function rolesname($rolesid){
        $rid = trim($rolesid,',');
        $roles = DB::select('select * from roles where id in ('.$rid.')');
        $rname='';
        foreach($roles as $k=>$v){
            $rname .= $v->name."、";
        }
        return rtrim($rname,"、");
    }
    /*
     * 获取角色列表
     */
    public function findAllRoles() {
        $table = $this->table1;


        return DB::table($table)
            ->where('status', 1)
            ->get();
    }

    /*
    * 查询已经注册的数量数量
    */
    public function findRolesNumber($data) {
        $table = $this->table;

        return DB::table($table)
            ->where('email', $data)
            ->count();
    }

    /*
     * 新增的保存
     */
    public function newSaveCreate($data_arr) {
        $table = $this->table;

        DB::table($table)->insert($data_arr);
    }

    /*
     * 启用/禁用/编辑
     */
    public function dochage($id,$status) {
        $table = $this->table;

        return DB::table($table)->where('id',$id)->update($status);
    }

    /*
     * 查询一条
     */
    public function findOne($id)
    {
        return System::where("id", $id)->first();
    }

    /*
     * 删除选中的一条数据
     */
    public function deleteTheOne($id)
    {
        return System::where("id", $id)->delete();
    }

    /*
     *查询省
     */
    public function province()
    {
        $table = $this->table2;
        return   DB::table($table)
            ->where("type","1")
            ->orderBy('id', 'asc')
            ->get();
    }

    /*
     * 查询市
     */
    public function city($data)
    {
        $table = $this->table2;
        return   DB::table($table)
            ->where("type","2")
            ->where("pid",$data)
            ->orderBy('id', 'asc')
            ->get();
    }

    /*
     * 查询区/县
     */
    public function country($data)
    {
        $table = $this->table2;
        return   DB::table($table)
            ->where("type","3")
            ->where("pid",$data)
            ->orderBy('id', 'asc')
            ->get();
    }

    /*
     * 查询所有的关联数据
     */
    public function findAllUserRegion($id)
    {
//        return DB::select('select *,CONCAT(r2.name,r1.name) as newname,users.name as username,user_region.id as user_region_id  from user_region,users,region as r1, region as r2
//                  where r1.pid = r2.id and r1.path = user_region.region and users.id = user_region.uid and user_region.uid ='.$id);
        return DB::select('SELECT *   FROM
                                (
                                    (select user_region.id as user_region_id,users.name as username,CONCAT(r1.name,r2.name,r3.name) as newname,user_region.created_at,user_region.updated_at from
                                    user_region
                                    LEFT JOIN users ON users.id = user_region.uid
                                    inner  JOIN region as r3 ON r3.path = user_region.region
                                    inner  JOIN region as r2 ON r3.pid = r2.id
                                    inner  JOIN region as r1 ON r2.pid = r1.id
                                    where user_region.uid = '.$id.' and r1.type = 1 and r1.isactived = 1 and r2.isactived = 1 and r3.isactived = 1)
                                    union
                                    (select user_region.id as user_region_id,users.name as username,CONCAT(r1.name,r2.name) as newname,user_region.created_at,user_region.updated_at from
                                    user_region
                                    LEFT JOIN users ON users.id = user_region.uid
                                    inner  JOIN region as r2 ON r2.path = user_region.region
                                    inner  JOIN region as r1 ON r2.pid = r1.id
                                    where user_region.uid = '.$id.' and r1.type = 1 and r1.isactived = 1 and r2.isactived = 1)
                                    union
                                    (select user_region.id as user_region_id,users.name as username,r1.name as newname,user_region.created_at,user_region.updated_at from
                                    user_region
                                    LEFT JOIN users ON users.id = user_region.uid
                                    inner  JOIN region as r1 ON r1.path = user_region.region
                                    where user_region.uid = '.$id.' and r1.type = 1 and r1.isactived = 1)
                                )temp
                         order by created_at desc');
    }

    /*
     * /新增用户区域
     */
    public function addNewArea($data)
    {
        $table = $this->table3;
        return DB::table($table)->insert($data);
    }

    /*
     * 新增用户区域查重
     */
    public function getAreaCount($id,$region)
    {
        $table = $this->table3;
        return DB::table($table)
            ->where("uid", $id)
            ->where("region", $region)
            ->count();
    }

    /*
     * 删除一条
     */
    public function deleteOneArea($id)
    {
        $table = $this->table3;
        DB::table($table)->where("id", $id)->delete();
    }

    /*
     * 删除一条用户
     */
    public function deleteUser($id)
    {
        $table = $this->table;
        return DB::table($table)->where("id", $id)->delete();
    }

}