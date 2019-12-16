<?php
namespace App\Http\Controllers\News;

use App\Models\Company;
use App\Models\Media;
use App\Models\News;
use App\Models\Users;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB,Input,Auth,Image,Excel;


class NewsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission');
    }

    //列表
    public function index(Request $request){
        $status=$request->input('status',1);
        $order_by=$request->input('order_by','created_at');
        $order_by_select=$request->input('order_by_select','desc');
        $list=News::where('n_type',1)->whereIn('status',[1,2,3,4]);
        if($status){
            $list=$list->where('status',$status);
        }
        $users=Users::pluck('name','id');
        $medias=Media::pluck('media_name','id');
        if(Auth::user()->role!=0){//非管理员只能看到自己的
            $list=$list->where('at_id',Auth::user()->id);
        }
        $list=$list->orderBy($order_by,$order_by_select)->paginate(10);
        if($request->input('export')==1){
            $this->export_csv($list);
        }
        $url = $request->fullUrl();
        return view('news.draft.index',compact('list','url','status','users','medias','order_by_select','order_by'));
    }

    //增加视图
    public function add(Request $request){
        $url = $request->input('url');
        $medias=Media::get();
        return view('news.draft.add',compact('url','medias'));
    }


    //增加保存
    public function addSave(Request $request){
        $m=new News();
        $m->title=$request->input('title');
        $m->catid=1;
        $m->n_type=1;
        $m->media_id=$request->input('media_id');
        $m->text_size=intval($request->input('text_size'));
        $m->cat_page=$request->input('cat_page');
        $m->content=$request->input('content');
        $m->addtime=$request->input('addtime');
        $m->at_id=Auth::user()->id;
        $m->save();
        return redirect(base64_decode($request->input('url')))->with('is_pop', '1');
    }


    //修改视图
    public function edit(Request $request,$id){
        $info=News::find($id);
        $medias=Media::get();
        $url = $request->input('url');
        $media_type=Media::where('id',$info->media_id)->first();
        $media_type=$media_type->media_level;
        return view('news.draft.edit',compact('url','info','medias','media_type'));
    }
    //修改保存
    public function editSave(Request $request,$id){
        $m=News::find($id);
        $m->title=$request->input('title');
        $m->media_id=$request->input('media_id');
        $m->text_size=intval($request->input('text_size'));
        $m->cat_page=$request->input('cat_page');
        $m->content=$request->input('content');
        $m->addtime=$request->input('addtime');
//        $m->at_id=Auth::user()->id;
        $m->save();
        return redirect(base64_decode($request->input('url')))->with('is_pop', '1');
    }

    //预览
    public function look($id)
    {
        $info=News::find($id);
        $users=Users::pluck('name','id');
        $medias=Media::pluck('media_name','id');
        return view('news.draft.info',compact('url','info','medias','users'));
    }

    /*
     * 查询文章标题是否存在
     */
    public function ajax_check_title(Request $request){
        $id=$request->input('id');
        $title=$request->input('title');
        $return_data =  $this->ajax_result;
        $info=News::where('title',trim($title))->where('n_type',1)->where('id','<>',$id)->first();
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
        $changeStatus =News::find($id);
        $changeStatus->status=$status;
        $changeStatus->save();
        echo json_encode($return_data);
        return;
    }
    //导出 記者上稿
    public function export_csv($list,$export_name='新闻上稿'){
        ini_set("max_execution_time", "3600");
        $users=Users::pluck('name','id');
        $medias=Media::pluck('media_name','id');
        Excel::create($export_name,function($excel) use ($list,$export_name,$medias,$users){
            $export_data=array();
            array_push($export_data, array(
                '新闻标题','作者','刊播时间','媒体名称','栏目版面','字数','稿件状态','上稿时间'
            ));
            foreach($list as $k=>$l) {
                array_push($export_data, array(
                    $l->title,$users[$l->at_id],$l->addtime,$medias[$l->media_id],$l->cat_page,$l->text_size,config('configure.status')[$l->status],
                    $l->created_at
                ));
            }
            $excel->sheet($export_name, function($sheet) use ($export_data){
                $sheet->setFontSize(10);//设置字体大小
                $sheet->setWidth(array('A' => 50,'B' => 20,'C' => 30,'D' => 20,'E' => 20,'F' => 17,'G' => 15,'H' => 35));
                $sheet->rows($export_data);
                $sheet->cells('A1:H1', function($cells) {
                    $cells->setFontWeight('bold');
                    $cells->setAlignment('center');
                });
                $style_array = array(
                    'borders' => array(
                        'allborders' => array(
                            'style' => \PHPExcel_Style_Border::BORDER_THIN
                        )
                    )
                );
                $sheet->getStyle('A1:H'.count($export_data))->applyFromArray($style_array);
            });
        })->export('xls');
    }
    //上稿确认 列表
    public function confirm(Request $request){
        $status=$request->input('status',2);
        $endtime=$request->input('endtime');
        $starttime=$request->input('starttime');
        $search=$request->input('search');
        $order_by=$request->input('order_by');
        $order_by_select=$request->input('order_by_select');
        $list=News::where('n_type',1)->whereIn('status',[2,3,4]);
        if($status){
            $list=$list->where('status',$status);
        }
        if($starttime){
            $list=$list->where('addtime','>=', $starttime);
        }
        if($endtime){
            $list=$list->where('addtime','<=', $endtime);
        }
        if($search){
            $list=$list->where('title','like',"%".$search.'%');
        }
        $users=Users::pluck('name','id');
        $medias=Media::pluck('media_name','id');
        if($order_by){
            $list=$list->orderBy($order_by,$order_by_select);
        }else{
            $list=$list->orderBy('created_at','desc');
        }
        $list=$list->paginate(10);
        if($request->input('export')==1){
            $this->export_csv1($list);
        }
        $url = $request->fullUrl();
        return view('news.draft.confirm',compact('list','url','status','users','medias','starttime','endtime','search','order_by','order_by_select'));
    }
    //上稿确认  确认页面
    public function edit_confirm($id,Request $request){

        $info=News::find($id);
        $medias=Media::orderby('is_past','asc')->orderby('media_level','asc')->get();
        $url = $request->input('url');
        $user=Users::leftJoin('company','company.id','=','users.company_id')->select('users.id','users.name','users.company_id','company.company_name')->get();
        $coms=[];
        $users=[];
        foreach($user as $v){
            $users[$v->id]=$v->name;
            $coms[$v->id]=$v->company_name;
        }
        return view('news.draft.edit_confirm',compact('url','info','medias','users','coms'));
    }
    //修改保存
    public function editConfirmSave(Request $request,$id){
        $m=News::find($id);
        $m->title=$request->input('title');
        $m->media_id=$request->input('media_id');
        $m->text_size=intval($request->input('text_size'));
        $m->cat_page=$request->input('cat_page');
        $m->content=$request->input('content');
        $m->addtime=$request->input('addtime');
        $m->status=$request->input('status');
        $m->confirmation=$request->input('confirmation');
//        $m->at_id=Auth::user()->id;
        $m->save();
        return redirect(base64_decode($request->input('url')))->with('is_pop', '1');
    }
    //导出 上稿确认
    public function export_csv1($list,$export_name='新闻上稿'){
        ini_set("max_execution_time", "3600");
        $users=Users::pluck('name','id');
        $medias=Media::pluck('media_name','id');
        Excel::create($export_name,function($excel) use ($list,$export_name,$medias,$users){
            $export_data=array();
            array_push($export_data, array(
                '新闻标题','媒体名称','栏目版面','刊播时间','字数','获奖情况','稿件状态','上稿时间','确认意见'
            ));
            foreach($list as $k=>$l) {
                array_push($export_data, array(
                    $l->title,$medias[$l->media_id],$l->cat_page,$l->addtime,$l->text_size,$l->prize_money,
                    config('configure.status')[$l->status],$l->created_at,$l->confirmation
                ));
            }
            $excel->sheet($export_name, function($sheet) use ($export_data){
                $sheet->setFontSize(10);//设置字体大小
                $sheet->setWidth(array('A' => 50,'B' => 20,'C' => 30,'D' => 25,'E' => 20,'F' => 17,'G' => 15,'H' => 35,'I' => 50));
                $sheet->rows($export_data);
                $sheet->cells('A1:I1', function($cells) {
                    $cells->setFontWeight('bold');
                    $cells->setAlignment('center');
                });
                $style_array = array(
                    'borders' => array(
                        'allborders' => array(
                            'style' => \PHPExcel_Style_Border::BORDER_THIN
                        )
                    )
                );
                $sheet->getStyle('A1:I'.count($export_data))->applyFromArray($style_array);
            });
        })->export('xls');
    }

    //根据媒体类别获取媒体 7-22号修改  根据媒体级别获取媒体
    public function getTypeByMedia(Request $request){
        $media_type=$request->input('media_type');
        $return_data =  $this->ajax_result;
        if($media_type==='') {
            $return_data['code'] = -1;
            $return_data['msg'] = '参数错误';
            return response()->json($return_data);
        }
        $list=Media::where('media_level',$media_type)->where('status',1)->orderby('is_past','asc')->orderby('media_level','asc')->select('id','media_level','media_name','is_past')->get();
        foreach($list as $k=>$v){
            $list[$k]['media_level_name']=config('configure.media_level')[$v->media_level];
        }
        $return_data['data']=$list;
        return response()->json($return_data);
    }
    //上稿统计 列表
    public function statistics(Request $request){
        $endtime=$request->input('endtime');
        $starttime=$request->input('starttime');
        $search=$request->input('search');
        $media_id=$request->input('media_id');
        $cat_page=$request->input('cat_page');
        $order_by=$request->input('order_by');
        $order_by_select=$request->input('order_by_select');
        $c=$request->input('c',1);
        $list=News::where('n_type',1)->where('status',3);
        if($starttime){
            $list=$list->where('addtime','>=', $starttime);
        }
        if($endtime){
            $list=$list->where('addtime','<=', $endtime);
        }
        if($search){
            $list=$list->where('title','like','%'.$search.'%');
        }
        if($media_id){
            $list=$list->where('media_id',$media_id);
        }
        if($cat_page){
            $list=$list->where('cat_page','like','%'.$cat_page.'%');
        }
        if($order_by){
            $list=$list->orderBy($order_by,$order_by_select);
        }else{
            $list=$list->orderBy('media_id','asc')->orderBy('addtime','desc');
        }
        $users=Users::pluck('name','id');
        $medias=Media::pluck('media_name','id');
        $medias1=Media::orderby('is_past','asc')->orderby('media_level')->get();
        $list=$list->paginate(10);
        if($request->input('export')==1){
            $this->export_csv2($list);
        }
        $url = $request->fullUrl();

        $data=[];
        foreach($list as $k=>$v){
            $data[$v->media_id][] =$v->toArray();
        }
//        dd($table);
        return view('news.draft.statistics',compact('list','c','cat_page','media_id','url','users','medias','medias1','starttime','endtime','search','order_by','order_by_select','data'));
    }
    //省级上稿统计 列表
    public function statistics1(Request $request){
        $endtime=$request->input('endtime');
        $starttime=$request->input('starttime');
        $search=$request->input('search');
        $media_id=$request->input('media_id');
        $media_level=$request->input('media_level');
        $cat_page=$request->input('cat_page');
        $order_by=$request->input('order_by');
        $is_past=$request->input('is_past');
        $order_by_select=$request->input('order_by_select');
        $c=$request->input('c',2);
        $list=News::leftJoin('media','media.id','=','news.media_id')
            ->select('news.*')
            ->where('n_type',1)->where('news.status',3);
        if($starttime){
            $list=$list->where('news.addtime','>=', $starttime);
        }
        if($endtime){
            $list=$list->where('addtime','<=', $endtime);
        }
        if($media_level){
            $list=$list->where('media.media_level', $media_level);
        }
        if(isset($is_past)){
            $list=$list->where('media.is_past', $is_past);
        }
        if($search){
            $list=$list->where('title','like','%'.$search.'%');
        }
        if($media_id){
            $list=$list->where('media_id',$media_id);
        }
        if($cat_page){
            $list=$list->where('cat_page','like','%'.$cat_page.'%');
        }
        if($order_by){
            $list=$list->orderBy($order_by,$order_by_select);
        }else{
            $list=$list->orderBy('media_id','asc')->orderBy('addtime','desc');
        }
        $users=Users::pluck('name','id');
        $medias=Media::pluck('media_name','id');
        $medias1=Media::orderby('is_past','asc')->orderby('media_level')->get();
        $list=$list->paginate(10);
        if($request->input('export')==1){
            $this->export_csv2($list);
        }
        $url = $request->fullUrl();

        $data=[];
        foreach($list as $k=>$v){
            $data[$v->media_id][] =$v->toArray();
        }
//        dd($table);
        return view('news.draft.statistics1',compact('list','c','media_level','is_past','cat_page','media_id','url','users','medias','medias1','starttime','endtime','search','order_by','order_by_select','data'));
    }
    //获奖录入
    public function sub_prize(Request $request){
        $id=$request->input('id');
        $prize_money=$request->input('prize_money');
        $return_data =  $this->ajax_result;
        if($id == ""){
            $return_data['code']=-1;
            $return_data['msg']='参数错误';
            echo json_encode($return_data);
            return;
        }
        $changeStatus =News::find($id);
        $changeStatus->prize_money=$prize_money;
        $changeStatus->save();
        echo json_encode($return_data);
        return;
    }
    //导出 上稿确认
    public function export_csv2($list,$export_name='新闻上稿'){
        ini_set("max_execution_time", "3600");
        $users=Users::pluck('name','id');
        $medias=Media::pluck('media_name','id');
        Excel::create($export_name,function($excel) use ($list,$export_name,$medias,$users){
            $export_data=array();
            array_push($export_data, array(
                '媒体名称','刊播时间','栏目版面','新闻标题','作者','字数','获奖情况','确认意见'
            ));
            foreach($list as $k=>$l) {
                array_push($export_data, array(
                    $medias[$l->media_id],$l->addtime,$l->cat_page,$l->title,$users[$l->at_id],
                    $l->text_size,$l->prize_money,$l->confirmation
                ));
            }
            $excel->sheet($export_name, function($sheet) use ($export_data){
                $sheet->setFontSize(10);//设置字体大小
                $sheet->setWidth(array('A' => 20,'B' => 20,'C' => 30,'D' => 50,'E' => 20,'F' => 17,'G' => 15,'H' => 50));
                $sheet->rows($export_data);
                $sheet->cells('A1:H1', function($cells) {
                    $cells->setFontWeight('bold');
                    $cells->setAlignment('center');
                });
                $style_array = array(
                    'borders' => array(
                        'allborders' => array(
                            'style' => \PHPExcel_Style_Border::BORDER_THIN
                        )
                    )
                );
                $sheet->getStyle('A1:H'.count($export_data))->applyFromArray($style_array);
            });
        })->export('xls');
    }

    //模糊查询标题
    public function getTypeByTitle(Request $request){
        $type=$request->input('type',1);
        $title=$request->input('title');
        $return_data =  $this->ajax_result;
        if($title == ""){
            $return_data['code']=-1;
            $return_data['msg']='参数错误';
            echo json_encode($return_data);
            return;
        }
        $list =News::select('title')->where('n_type',$type)->where('title','like','%'.$title.'%')->get();
        $return_data['data']=$list;
        echo json_encode($return_data);
        return;
    }
}