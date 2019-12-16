<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Common\AddLogsController;
use App\Models\Company;
use App\Models\User;
use App\Models\Users;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\System;
use DB,Input,Auth,Config,Excel,Util,Redirect;

class MainController extends Controller
{
    /*
     * 界面跳转到账户管理界面
     */
    public function index(Request $request) {
        $com_id=$request->input('com_id');
        $system = new System();
        $com_info=Company::where('id',$com_id)->first();
        $com_id_str[]=$com_info->id;
        if($com_info->pid==0){
            $com_list=Company::where('pid',$com_id)->get();
            foreach($com_list as $v){
                $com_id_str[]=$v->id;
            }
        }
        $usersInfo=System::whereIn('company_id',$com_id_str)->leftJoin('company','company.id','=','users.company_id')
            ->select('users.*','company.company_name')
            ->orderby('company_id')
            ->paginate(10);
        foreach($usersInfo as $k=>$v){
            $rolesid = trim($v->role,',');
            $usersInfo[$k]->rolesname = $system->rolesname($rolesid);
        }
        return view('system.index',compact('usersInfo','com_info'));
    }


    public function area(){
        $where['pid']=Input::get('pro');
        $arr=Region::Address($where);
        return response()->json($arr);

    }

    public function street(){
        $where['county']=Input::get('pro');
        $arr=Street::where($where)->get();
        return response()->json($arr);

    }

    public function cell(){
        $where['street_id']=Input::get('pro');
        $arr=Cell::where($where)->get();
        return response()->json($arr);

    }

    /*
     * 跳转到账户管理新增界面
     */
    public function add(Request $request){
        $system = new System();
        $company_id=$request->input('com_id');
        $company_info=Company::find($request->input('com_id'));
        $company_list=Company::get();
        $roleInfo=$system->findAllRoles();
        return view('system.create',compact('roleInfo','company_id','company_info','company_list'));
    }

    /*
     * 账户管理新增保存
     */
    public function doadd(Request $request)
    {
        $system = new System();
        $time = date('Y-m-d H:i:s',time());
        $roles = $request->input('role');

        $inset_data=array(
            'email'=>$request->input('email'),
            'name'=>$request->input('name'),
            'company_id'=>$request->input('company_id'),
            'password'=>bcrypt($request->input('password')),
            'role'=>$roles,
            'updated_at'=>$time,
            'status'=>1,
            'created_at'=>$time,
        );
        $system->newSaveCreate($inset_data);
//        $request->input('com_id')
        return redirect('/system?com_id='.$request->input('com_id'))->with('is_pop', '1');
    }

    /*
     * 检查账户新增内容
     */
    public function addCheck(Request $request){
        $email=$request->input("email");
        $return_data =  $this->ajax_result;
        if(!$email){
            $return_data['code']=-1;
            $return_data['msg']='参数错误';
            echo json_encode($return_data);
            return;
        }
        $system = new System();
        $result =  $system->findRolesNumber($email);
        if($result){
            $return_data['code']=1;
            $return_data['msg']='该邮箱已被使用';
            echo json_encode($return_data);
            return;
        }else{
            echo json_encode($return_data);
            return;
        }
    }

    /*
     * 用户启用/禁用执行动作
     */
    public function chageUsesStatus(Request $request){
        $id=$request->input('id');
        $status=$request->input('status');//1为启用；0为禁用
        $return_data =  $this->ajax_result;
        if($id == ""){
            $return_data['code']=-1;
            $return_data['msg']='参数错误';
            echo json_encode($return_data);
            return;
        }
        $type=array();
        if($status!=9) {
            if ($status == 0) {
                $type['status'] = 1;
            } else {
                $type['status'] = 0;
            }
            $system = new System();
            $system->dochage($id, $type);
        }else{
            User::where('id',$id)->delete();
        }
//        //添加日志
//        $content="修改用户表(users)id为：".$id."的状态。";
//        $logs= new AddLogsController();
//        $logs->addLogs($content);
        echo json_encode($return_data);
        return;
    }

    /*
     * 跳转用户编辑界面
     */
    public function edit($id,Request $request){
        $system = new System();
        $com_id=$request->input('com_id');
        $company_info=Company::find($request->input('com_id'));
        $roleInfo=$system->findAllRoles();
        $usersOneInfo=$system->findOne($id);
        return view('system.edit',compact('com_id','roleInfo','usersOneInfo','company_info'));
    }

    /*
     * 用户编辑执行保存
     */
    public function doedit(Request $request){
        $id = $request->input('change_id');
        $time = date('Y-m-d H:i:s',time());
        $roles =$request->input('role');
        $password=$request->input('password');

        $new_data=array(
//            'email'=>$request->input('email'),
            'name'=>$request->input('name'),
            'role'=>$roles,
//            'auth'=>$request->input('auth'),
            'updated_at'=>$time,
            'status'=>$request->input('status'),
        );
        if($password){
            $new_data['password']=bcrypt($password);
        }

        $system = new System();
        $system->dochage($id,$new_data);
        return redirect('/system?com_id='.$request->input('com_id'))->with('is_pop', '1');
    }

    /*
     * 进行密码重置
     */
    public function reset(Request $request){
        $id = $request->input('id');
        $time = date('Y-m-d H:i:s',time());
        $new_data=array(
            'password'=>bcrypt(123456),
            'updated_at'=>$time,
        );
        $system = new System();
        $r = $system->dochage($id,$new_data);
        $return_data =  $this->ajax_result;
        if(!$r) {
            $return_data['code'] = -2;
            $return_data['msg'] = '重置失败！';
        } else{
            $return_data['msg'] = '重置成功，新密码：123456';
            //添加日志
            $content="重置了用户表(users)id为：".$id."的密码。";
            $logs= new AddLogsController();
            $logs->addLogs($content);
        }
        return json_encode($return_data);
    }

    /*
     * 跳转业务员区域设置
     */
    public function userRegionList(){
        $system = new System();
        $usersInfo=$system->findBusinessUsers();
//        echo "<pre>";
//        print_r($usersInfo);exit;

        foreach($usersInfo as $k=>$v){
            $rolesid = trim($v->role,',');
            $usersInfo[$k]->rolesname = $system->rolesname($rolesid);
        }

        return view('admin.system.userRegionList')->with('usersInfo', $usersInfo)->with('menu',$this->menu);
    }

    /*
     * 跳转用户区域设置
     */
    public function userRegion($id){
        $system = new System();
        $province = $system->Province();
        $userRegionList=UserRegion::getByUidList(['uid'=>$id]);
        $userRegion=array();
//        echo '<pre/>';
//        print_r($userRegionList->toArray());exit;
        if($userRegionList){
            foreach($userRegionList->toArray() as $k=>$v){
                $userRegion[$k]=$v;
                $reg=Region::getRegionName($v['region']);
                $userRegion[$k]['region']=$reg;
            }
        }
//        echo '<pre/>';
//        print_r($userRegion);exit;
        return view('admin.system.userRegion')
            ->with('province', $province)
            ->with('id', $id)
            ->with('userRegion', $userRegion)

            ->with('menu',$this->menu);
    }

    /*
     * 获取市
     */
    public function getCity(Request $request){
        $id=$request->input('id');
        $return_data =  $this->ajax_result;
        if($id == ""){
            $return_data['code']=-1;
            $return_data['msg']='参数错误';
            echo json_encode($return_data);
            return;
        }
//        print_r($id);exit;
        $system = new System();
        $city= $system->city($id);
        $return_data['data']=$city;
        return response()->json($return_data);
    }

    /*
     * 获取县
     */
    public function getCountry(Request $request){
        $id=$request->input('id');
        $return_data =  $this->ajax_result;
        if($id == ""){
            $return_data['code']=-1;
            $return_data['msg']='参数错误';
            echo json_encode($return_data);
            return;
        }
//        print_r($id);exit;
        $system = new System();
        $country= $system->country($id);
        $return_data['data']=$country;
        return response()->json($return_data);
    }

    /*
     * 新增用户区域
     */
    public function addArea($uid,$region){
        $time = date('Y-m-d H:i:s',time());
        $inset_data=array(
            'uid'=>$uid,
            'region'=>$region,
            'updated_at'=>$time,
            'created_at'=>$time,
        );
        $system = new System();
        $rs=$system->addNewArea($inset_data);
        $code=1;
        if(!$rs){
            $code=-1;
        }else{
            //添加日志
            $content="给用户为：".$uid."，添加了新地区".$region;
            $logs= new AddLogsController();
            $logs->addLogs($content);
        }
        return $code;
    }

    /*
     * 删除用户区域
     */
    public function deleteUserArea(Request $request){
        $id=$request->input('user_region_id');
        $return_data =  $this->ajax_result;
        if($id == ""){
            $return_data['code']=-1;
            $return_data['msg']='参数错误';
            echo json_encode($return_data);
            return;
        }
        $system = new System();
        $system->deleteOneArea($id);
        //添加日志
        $content="删除用户地区表(user_region)id为：".$id."的信息。";
        $logs= new AddLogsController();
        $logs->addLogs($content);
        return response()->json($return_data);
    }

    /*
     * 角色删除操作
     */
    public function deleteUser(Request $request){
        $id = $request->input('id');
        $system = new System();
        $r=$system->deleteUser($id);
        $return_data =  $this->ajax_result;
        if(!$r) {
            $return_data['code'] = -2;
            $return_data['msg'] = '删除失败！';
        } else{
            $return_data['msg'] = '删除成功';
            //添加日志
            $content="删除用户表(Users)id为：".$id."的信息。";
            $logs= new AddLogsController();
            $logs->addLogs($content);
        }
        return json_encode($return_data);
    }

    /*
     * 检查用户区域是否存在，同时，做执行新增
     */
    public function checkUserArea(Request $request){
        $id=$request->input('id');
        if($id == ""){
            $return_data['code']=-1;
            $return_data['msg']='参数错误';
            echo json_encode($return_data);
            return;
        }
        $province=$request->input('province');
        $city=$request->input('city');
        $country=$request->input('country');
        if($province != 0){
            $region = ",".$province.",";
        }
        if($city != 0){
            $region .= $city.",";
        }
        if($country != 0){
            $region .= $country.",";
        }
        $system = new System();
        $count = $system->getAreaCount($id,$region);
        $return_data =  $this->ajax_result;
        if($count == 0){
            $return_data['msg']='新增成功';
            $r=$this->addArea($id,$region);
            if(!$r){
                $return_data['code']=-2;
                $return_data['msg']='新增失败！';
            }
            return json_encode($return_data);;
        }else{
            $return_data['code']=-1;
            $return_data['msg']='该区域已存在，请重新选取';
            echo json_encode($return_data);
            return;
        }
    }



    /*
     * 检查微信客服信息是否存在
     */
    public function check_kf_account(Request $request){
        $key=$request->input("kf_account");
        $id=intval($request->input("id"));
        $nickname=$request->input("nickname");
        $return_data =  $this->ajax_result;
        if(!$key||!$nickname){
            $return_data['code']=-1;
            $return_data['msg']='参数错误';
            echo json_encode($return_data);
            return;
        }
        $rs=Users::chageKfAccount($key,$nickname,$id);
        if($rs){
            $return_data['code']=1;
            $return_data['msg']='该客服信息已经存在';
            echo json_encode($return_data);
            return;
        }else{
            echo json_encode($return_data);
            return;
        }
    }
	
	public function degradeMemberStar()
	{
		date_default_timezone_set('Asia/Shanghai');
    	$end = date('Y-m-d H:i:s'); 
		DB::table('member_star')
            ->where('star', '>', 0)
			->where('updated_at', '<=', $end)
            ->update(['star' => 0]);
	}
}