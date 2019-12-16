<?php
/**
 * Created by PhpStorm.
 * User: weijin
 * Date: 2016/5/20
 * Time: 10:11
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Privilege extends Model
{
    /**
     * 表名
     * @var string
     */
    protected $table = 'privilege';

    /*添加*/
    public static function add($data_arr){
//        return Privilege::insert($data_arr);
        return Privilege::insertGetId($data_arr);
    }

    /*添加*/
    public static function add_res_id($data_arr){
        return Privilege::insert($data_arr);
    }

    /*修改*/
    public static function edit($id,$data_arr){
        return Privilege::where('id',$id)->update($data_arr);
    }

    /*删除*/
    public static function del($car_type_key){
        return Privilege::where('car_type_key',$car_type_key)->delete();
    }


    /**
     * 根据id获取详情
     * @param $id
     * @return mixed
     */
    public static function findOne($id)
    {
        return Privilege::with("menus")->where("id", $id)->first();
    }

    /*查询全部列表*/
    public static function get_select_list($select_data=array(),$pagesize=10)
    {
        return Privilege::with("menus")->where($select_data)->orderBy('id','asc')->paginate($pagesize);
    }

    /*查询全部列表*/
    public static function get_select_all($select_data=array())
    {
        return Privilege::where($select_data)->orderBy('id','desc')->get();
    }

    /*查询全部列表*/
    public static function get_select_all_in($select_data=array())
    {
        return Privilege::select('path')->whereIn('menu_id',$select_data)->orderBy('id','desc')->get();
    }

    /**
     * 根据key是否存在
     */
    public static function getPath($key,$id)
    {
        return Privilege::where("path", $key)->where("id",'!=', $id)->first();
    }

    /**
     * 关联栏目表
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function menus()
    {
        return $this->belongsTo('App\Models\Menus', 'menu_id', 'id');
    }
}