<?php
/**
 * 用户表
 * @author coffee
 *
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB,Log;

class Member extends Model
{
    protected $table = 'member';
    protected $fillable = [];

    public function findListAll() {

    	$table = $this->table;

    	$list = DB::table($table)
		    	->orderBy('id', 'asc')
		    	->get();

    	if (empty($list)) {
    		return $list;
    	}

    	foreach ($list as $k => $v) {
    		$list[$k] = self::msgInit($v);
    	}

    	return $list;
    }

    /**
     * 初始化msg
     * @param unknown $msg
     * @return void|unknown
     */
    public function msgInit($msg) {
    	if (empty($msg)) {
			return ;
    	}
    	$msg->app_path = substr($msg->path, 1, strlen($msg->path)-2);
    	return $msg;
    }

    public function decrementIntegralById($id_str, $num = 1) {
    	$table = $this->table;

    	if (empty($id_str)) {
    		return ;
    	}

    	$id_arr = explode(",", $id_str);

    	DB::table($table)
		    	->whereIn('id', $id_arr)
		    	->decrement('intergral', $num);
    }

    public function incrementIntegralById($id_str, $num = 1) {
    	$table = $this->table;

    	if (empty($id_str)) {
    		return ;
    	}

    	$id_arr = explode(",", $id_str);

    	DB::table($table)
		    	->whereIn('id', $id_arr)
		    	->increment('intergral', $num);
    }

    /**
     * 影响人数
     * @param unknown $id
     */
    public function findCountAncestorById($id) {

    	$table = $this->table;

    	return DB::table($table)
    					->where('ismember',1)
				    	->where('path', 'like', '%,'.$id.',%')
				    	->where('id', '!=', $id)
				    	->count();
    }

    /**
     * 面子数量
     * @param unknown $pid
     */
    public function findCountByPid($pid) {

    	$table = $this->table;

    	return DB::table($table)
				    	->where('pid', $pid)
						->where('ismember',1)
				    	->count();
    }

    /**
     * 会员列表
     * @param unknown $id
     * @return unknown|Ambigous <void, \App\Model\unknown, unknown>
     */
    public function findListById($id) {
    	$table = $this->table;

    	$id_arr = explode(",", $id);
    	$list = DB::table($table)
				    	->whereIn('id', $id_arr)
				    	->orderBy('id', 'desc')
				    	->get();

    	if (empty($list)) {
    		return $list;
    	}

    	foreach ($list as $k => $v) {
    		$list[$k] = self::msgInit($v);
    	}

    	return $list;
    }

    /**
     * 下级列表
     * @param unknown $pid
     */
    public function findListByPid($pid) {

    	$table = $this->table;

    	$list = DB::table($table)
				    	->where('pid', $pid)
				    	->where('ismember', 1)
				    	->orderBy('id', 'desc')
						->get();

    	if (empty($list)) {
    		return $list;
    	}

    	foreach ($list as $k => $v) {
    		$list[$k] = self::msgInit($v);
    	}

    	return $list;
    }
	public function findListByPid1($pid) {
		$table = $this->table;

		$list=DB::table($table)
			->join('member_star', 'member.id', '=', 'member_star.mid')
			->select('member.*', 'member_star.star', 'member_star.circle_num', 'member_star.influence_num')
			->where('member.pid', $pid)
			->where('member.ismember', 1)
			->orderBy('member_star.star', 'desc')
			->orderBy('member_star.influence_num', 'desc')
			->get();

		if (empty($list)) {
			return $list;
		}

		foreach ($list as $k => $v) {
			$list[$k] = self::msgInit($v);
		}

		return $list;
	}
    /**
     * 会员个人基本信息
     * @param unknown $openid
     */
    public function findMsgByOpenid($openid) {

    	$table = $this->table;

    	$msg = DB::table($table)
				    	->where('openid', $openid)
				    	->first();

    	$msg = self::msgInit($msg);
    	return $msg;
    }


    /**
     * 会员个人基本信息
     * @param unknown $openid
     */
    public function findMsgById($id) {

    	$table = $this->table;

    	$msg = DB::table($table)
			    		->where('id', $id)
			    		->first();

    	$msg = self::msgInit($msg);
    	return $msg;
    }

    /**
     * 会员个人基本信息
     * @param unknown $openid
     */
    public function findMsgByShare($share) {

    	$table = $this->table;

    	$msg = DB::table($table)
			    		->where('share', $share)
			    		->first();

    	$msg = self::msgInit($msg);
    	return $msg;
    }

    /**
     * 会员个人基本信息
     * @param unknown $openid
     */
    public function findMsgByTel($tel) {

    	$table = $this->table;

    	$msg = DB::table($table)
			    		->where('tel', $tel)
			    		->first();

    	$msg = self::msgInit($msg);
    	return $msg;
    }

    /**
     * 添加
     * @param unknown $data
     */
    public function addDo($data_arr) {

    	$table = $this->table;

    	$date_time = date("Y-m-d H:i:s");
    	$data_arr["created_at"] = $date_time;
    	$data_arr["updated_at"] = $date_time;

    	if (!empty($data_arr["intergral"])) {
			$data_arr["intergral"] 	= floor($data_arr["intergral"]);
		}

    	return DB::table($table)->insertGetId($data_arr);
    }

    /**
     * 保存
     * @param unknown $data_arr
     */
    public function saveDo($data_arr) {

    	$table = $this->table;

    	$data_arr["updated_at"] = date("Y-m-d H:i:s");

    	if (!empty($data_arr["intergral"])) {
    		$data_arr["intergral"] 	= floor($data_arr["intergral"]);
    	}

		if (!empty($data_arr["id"])) {

			$id = $data_arr["id"];
			unset($data_arr["id"]);

			DB::table($table)
	            	->where('id', $id)
	            	->update($data_arr);
	     	return ;
		}

		if (!empty($data_arr["openid"])) {

			$openid = $data_arr["openid"];
			unset($data_arr["openid"]);

			DB::table($table)
	            	->where('openid', $openid)
	            	->update($data_arr);
	  		return ;
		}

    }

	/**
	 * 后台查询会员个人基本信息5/22
	 */


	//树结构查询
	public function tree_select($value) {
		$table = $this->table;
		return DB::table($table)
//			->where('isactived' ,1)
			->where('wangwang','like %'. $value.'%')
			->orwhere('name','like %'. $value.'%')
			->get();
	}

	//会员资料二维码刷新
	public function doupdate($data_arr){
		$table = $this->table;
		$id = $data_arr["id"];
		unset($data_arr["id"]);
		return DB::table($table)
			->where('id',$id)
			->update($data_arr);
	}

	//面子、圈子统计
	public function faceRes($pid) {
		$table = $this->table;
		return DB::table($table)
			->select(DB::raw('count(id) as total'))
			->where('pid', $pid)
			->where('ismember',1)
			->get();
	}
	//影响力
	public function faceEff($pid) {
		$table = $this->table;
		return DB::table($table)
			->select(DB::raw('count(id) as total'))
			->where('path','like', '%,'.$pid.',%')
			->where('ismember',1)
			->get();
	}

	//修改积分
	public static function edit($mid,$intergral){
		$rs= Member::where('id',$mid)->increment('intergral',$intergral);//累加跟下面的效果相同
		if($rs){
//			Log::info('intergral修改成功---对表操作---mid==' . $mid);
			$rs= Member::where('id',$mid)->increment('profit_intergral',$intergral);
		}
//		Log::info('intergral---对表操作---rs==' . $rs);
		return $rs;
//		return DB::select('update member set intergral=intergral+'.$intergral.',profit_intergral=profit_intergral+'.$intergral.' where id='.$mid);
	}

	//修改积分
	public static function edit_jf_jb($mid,$intergral,$gold){
	    $m_info=Member::find($mid);
        $m_info->intergral=$m_info->intergral+$intergral;
        $m_info->profit_intergral=$m_info->profit_intergral+$intergral;
        $m_info->gold=$m_info->gold+$gold;
        $m_info->profit_gold=$m_info->profit_gold+$gold;
        $m_info->save();
//		$rs= Member::where('id',$mid)->increment('intergral',$intergral);//累加跟下面的效果相同
//		if($rs){
//			$rs= Member::where('id',$mid)->increment('profit_intergral',$intergral);
//			Member::where('id',$mid)->increment('gold',$gold);
//			Member::where('id',$mid)->increment('profit_gold',$gold);
//		}
		return 1;
	}

	//后台修改积分
	public static function backgroundEdit($mid,$intergral){
		return DB::table('member')->where('id',$mid)->increment('intergral',$intergral);//累加跟下面的效果相同
		//return DB::select('update member set intergral=intergral+'.$intergral.' where id='.$mid);
	}



	/*修改*/
	public static function edit_info($id,$data_arr){
		return Member::where('id',$id)->update($data_arr);
	}

	//查询单条
	public static function findOne($mid){
		return Member::where('id',$mid)->first();
	}

	//积分充值处按条件查询
	public function findMemberInfo($wxname,$tel) {
		$table = $this->table;
		$rs = DB::table($table);
		if($wxname != ""){
			$rs = $rs->where('wxname', $wxname);
		}
		if($tel != ""){
			$rs = $rs->where('tel', $tel);
		}
		return $rs->get();
	}
	//升降星级处按条件查询
	public function findMemberInfo2($wxname,$tel) {
		$table = $this->table;
		$rs = DB::table($table)
			->select('member.*','member_star.star')
			->leftJoin("member_star","member_star.mid","=","member.id");

		if($wxname != ""){
			$rs = $rs->where('wxname', $wxname);
		}
		if($tel != ""){
			$rs = $rs->where('tel', $tel);
		}
		return $rs->get();
	}

//	//按照id查询openid和当前积分
//	public function findById($id) {
//		$table = $this->table;
//	}
}
