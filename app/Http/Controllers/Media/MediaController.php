<?php
namespace App\Http\Controllers\Media;

use App\Models\Media;
use App\Models\Users;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB,Input,Auth,Image;


class MediaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission');
    }

    //列表
    public function index(Request $request){
        $media_type=$request->input('media_type');
        $list=Media::orderBy('is_past','asc')->orderBy('created_at','desc');
        if($media_type){
            $list=$list->where('media_level',$media_type);
        }
        $list=$list->paginate(10);
        $url = $request->fullUrl();
        return view('media.index',compact('list','url','media_type'));
    }

    //增加视图
    public function add(Request $request){
        $url = $request->input('url');
        return view('media.add',compact('url'));
    }


    /*
     * 查询编号是否存在
     */
    public function ajax_check_mediaName(Request $request){
        $id=$request->input('id');
        $media_name=$request->input('media_name');
        $media_type=$request->input('media_type');
        $media_level=$request->input('media_level');
        $return_data =  $this->ajax_result;
        $info=Media::where('media_name',trim($media_name))->where('id','<>',$id)
            ->where('media_type',$media_type)
            ->where('media_level',$media_level)
            ->first();
        if($info){
            $return_data['code']=-1;
        }
        echo json_encode($return_data);
        return;
    }

    //增加保存
    public function addSave(Request $request){
        $m=new Media();
        $m->media_name=$request->input('media_name');
        $m->media_type=$request->input('media_type');
        $m->media_level=$request->input('media_level');
        $m->media_info=$request->input('media_info');
        $m->save();
        return redirect(base64_decode($request->input('url')))->with('is_pop', '1');
    }


    //修改视图
    public function edit(Request $request,$id){
        $info=Media::find($id);
        $url = $request->input('url');
        return view('media.edit',compact('url','info'));
    }
    //修改保存
    public function editSave(Request $request,$id){
        $m=Media::find($id);
        $m->media_name=$request->input('media_name');
        $m->media_type=$request->input('media_type');
        $m->media_level=$request->input('media_level');
        $m->media_info=$request->input('media_info');
        $m->save();
        return redirect(base64_decode($request->input('url')))->with('is_pop', '1');
    }

    //修改状态
    public function chageStatus(Request $request){
        $id=$request->input('id');
        $status=$request->input('status');
        $return_data =  $this->ajax_result;
        if($id == ""){
            $return_data['code']=-1;
            $return_data['msg']='参数错误';
            echo json_encode($return_data);
            return;
        }
        if($status==9){
//            Media::where('id',$id)->delete();
            $changeStatus = Media::find($id);
            $changeStatus->is_past = 1;
            $changeStatus->save();
        }else {
            $changeStatus = Media::find($id);
            $changeStatus->status = $status;
            $changeStatus->save();
        }
        echo json_encode($return_data);
        return;
    }
}