<?php

/**
 * Created by PhpStorm.
 * User: weijin
 * Date: 2016/5/20
 * Time: 10:11
 */
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use DB;

class Users extends Model {

    /**
     * 表名
     * @var string
     */
    protected $table = 'users';

	/*添加*/
	public static function add($data_arr){
		return Users::insert($data_arr);
	}

	/*修改*/
	public static function edit($id,$data_arr){
		return Users::where('id',$id)->update($data_arr);
	}

	/**
	 * 根据用户名获取用户信息
	 * @param $id
	 * @return mixed 用户信息记录
	 */
	public static function findOne($id)
	{
		return Users::where("id", $id)->first();
	}

    //列表
    public static function lists($where,$pagesize=10){
        $rs=Users::with('user_region')->orderBy('created_at','desc');
        if(isset($where['where'])){
            if(isset($where['where']['where_in'])){
                $rs=$rs->whereIn('role',$where['where']['where_in']);
                unset($where['where']['where_in']);
            }
            $rs=$rs->where($where['where']);
        }
//        if(isset($where['region'])){
//            $rs=$rs->where('region','like','%'.$where['region'].'%');
//        }
//        $rs=$rs->where('password1','>',0);
        return $rs->paginate($pagesize);
    }


    public function user_region()
    {
        return Users::hasMany('App\Model\UserRegion','uid','id');
    }


    public function roles()
    {
        return Users::hasMany('App\Model\RolesManagement','role','id');
    }

	/**
	 * 查询微信客服信息 是否存在
	 */
	public static function chageKfAccount($kf_account,$nickname,$id)
	{
		return Users::where("kf_account", $kf_account)->where("nickname", $nickname)->where("id",'!=', $id)->first();
	}

}