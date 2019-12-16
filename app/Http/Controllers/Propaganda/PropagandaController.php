<?php
namespace App\Http\Controllers\Propaganda;


use App\Models\Area;
use App\Models\News;
use App\Models\Propaganda;
use App\Models\Users;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB,Input,Auth,Image,Excel;


class PropagandaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission');
    }

    //列表
    public function index(Request $request){
        $status=$request->input('status');
        $starttime=$request->input('starttime');
        $endtime=$request->input('endtime');
        $p_id=$request->input('p_id');
        $area_id=$request->input('area_id');
        $types=$request->input('types');
        $category=$request->input('category');
        $cur_type=$request->input('cur_type');
        $order_by=$request->input('order_by');
        $order_by_select=$request->input('order_by_select');

        $search=trim($request->input('search'));
        $list=Propaganda::where('status','<>',9);
        if($search){
            $list=$list->where('name','like','%'.$search.'%');
        }
        if($p_id){
            $list=$list->where('p_id',$p_id);
        }
        if($area_id){
            $list=$list->where('area_id',$area_id);
        }
        if($types){
            $list=$list->where('types',$types);
        }
        if($category){
            $list=$list->where('category',$category);
        }
        if($cur_type){
            $list=$list->where('cur_type',$cur_type);
        }

        if($order_by){
            $list=$list->orderBy($order_by,$order_by_select);
        }else{
            $list=$list->orderBy('created_at','desc');
        }
        $users=Users::pluck('name','id');
        $area=Area::pluck('area','id');
        $p_area=Area::where('pid','<>',0)->pluck('area','id');
        $list=$list->paginate(10);
//        if($request->input('export')==1){
//            $this->export_csv($list);
//        }
        $url = $request->fullUrl();
        return view('propaganda.index',compact('list','url','status','category','types','cur_type',
            'users','area','starttime','endtime','search','p_area','p_id','area_id','order_by','order_by_select'));
    }

    //增加视图
    public function add(Request $request){
        $url = $request->input('url');
        $p_area=Area::where('pid',0)->pluck('area','id');
        return view('propaganda.add',compact('url','p_area'));
    }


    //增加保存
    public function addSave(Request $request){
        $m=new Propaganda();
        $m->name=$request->input('name');
        $m->types=$request->input('types');
        $m->category=$request->input('category');
        $m->cur_type=$request->input('cur_type');
        $m->p_id=$request->input('p_id');
        $m->area_id=$request->input('area_id');
        $m->situation=$request->input('situation');
        $m->report=$request->input('report');
        $m->datas=$request->input('datas');
        $m->at_id=Auth::user()->id;
        $m->save();

        return redirect(base64_decode($request->input('url')))->with('is_pop', '1');
//        $return_data =  $this->ajax_result;
//        echo json_encode($return_data);
//        return;
    }


    //修改视图
    public function edit(Request $request,$id){
        $url = $request->input('url');
        $info=Propaganda::find($id);
        $p_area=Area::where('pid',0)->pluck('area','id');
        $area_info=Area::find($info->area_id);
        return view('propaganda.edit',compact('url','p_area','info','area_info'));
    }

    //修改保存
    public function editSave(Request $request,$id){
        $m=Propaganda::find($id);
        $m->name=$request->input('name');
        $m->types=$request->input('types');
        $m->category=$request->input('category');
        $m->cur_type=$request->input('cur_type');
        $m->p_id=$request->input('p_id');
        $m->area_id=$request->input('area_id');
        $m->situation=$request->input('situation');
        $m->report=$request->input('report');
        $m->datas=$request->input('datas');
//        $m->at_id=Auth::user()->id;
        $m->save();
        return redirect(base64_decode($request->input('url')))->with('is_pop', '1');
//        $return_data =  $this->ajax_result;
//        echo json_encode($return_data);
//        return;
    }

    //预览
    public function look($id)
    {
        $info=Propaganda::find($id);
        $area=Area::pluck('area','id');
        return view('propaganda.info',compact('info','area'));
    }

    /*
     * 查询文章标题是否存在
     */
    public function ajax_check_title(Request $request){
        $id=$request->input('id');
        $title=$request->input('title');
        $return_data =  $this->ajax_result;
        $info=News::where('title',trim($title))->where('n_type',2)->where('id','<>',$id)->first();
        if($info){
            $return_data['code']=-1;
        }
        echo json_encode($return_data);
        return;
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
        $changeStatus =Propaganda::find($id);
        $changeStatus->status=$status;
        $changeStatus->save();
        echo json_encode($return_data);
        return;
    }
    //根据父类id获取列表
    public function getIdByList(Request $request){
        $p_id=$request->input('p_id');
        $return_data =  $this->ajax_result;
        if($p_id==='') {
            $return_data['code'] = -1;
            $return_data['msg'] = '参数错误';
            return response()->json($return_data);
        }
        $list=Area::where('pid',$p_id)->where('status',1)->select('id','area')->get();
        $return_data['data']=$list;
        return response()->json($return_data);
    }
}