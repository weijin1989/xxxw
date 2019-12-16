<?php
namespace App\Http\Controllers\News;

use App\Models\Company;
use App\Models\Media;
use App\Models\News;
use App\Models\Users;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB,Input,Auth,Image,Excel;


class ClueController extends Controller
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
        $list=News::where('n_type',3)->wherein('status',[1,3,4])->orderBy('created_at','desc');
        if($status){
            $list=$list->where('status',$status);
        }
        if($starttime){
            $list=$list->where('addtime','>=', $starttime);
        }
        if($endtime){
            $list=$list->where('addtime','<=', $endtime);
        }
        if(Auth::user()->role!=0){//非管理员只能看到自己的
            $list=$list->where('at_id',Auth::user()->id);
        }
        $users=Users::pluck('name','id');
        $medias=Media::pluck('media_name','id');
        $list=$list->paginate(10);
        if($request->input('export')==1){
            $this->export_csv($list);
        }
        $url = $request->fullUrl();
        return view('news.clue.index',compact('list','url','status','users','medias','starttime','endtime'));
    }

    //增加视图
    public function add(Request $request){
        $url = $request->input('url');
        $medias=Media::get();
        return view('news.clue.add',compact('url','medias'));
    }


    //增加保存
    public function addSave(Request $request){
        $m=new News();
        $m->n_type=3;
        $m->addtime=$request->input('addtime');
        $m->region=$request->input('region');
        $m->provider=$request->input('provider');
        $m->provider_company=$request->input('provider_company');
        $m->content=$request->input('content');
        $m->at_id=Auth::user()->id;
        $m->save();
        $return_data =  $this->ajax_result;
        echo json_encode($return_data);
        return;
    }

    //修改保存
    public function editSave(Request $request,$id){
        $m=News::find($id);
        $m->addtime=$request->input('addtime');
        $m->region=$request->input('region');
        $m->provider=$request->input('provider');
        $m->provider_company=$request->input('provider_company');
        $m->content=$request->input('content');
        $m->status=$request->input('status');
        $m->confirmation=$request->input('confirmation');
//        $m->at_id=Auth::user()->id;
        $m->save();
        $return_data =  $this->ajax_result;
        echo json_encode($return_data);
        return;
    }

    //预览
    public function look($id)
    {
        $info=News::find($id);
        $users=Users::pluck('name','id');
        $medias=Media::pluck('media_name','id');
        return view('news.clue.info',compact('url','info','medias','users'));
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
        $changeStatus =News::find($id);
        $changeStatus->status=$status;
        $changeStatus->save();
        echo json_encode($return_data);
        return;
    }
    //导出 記者上稿
    public function export_csv($list,$export_name='新闻线索-新闻上报'){
        ini_set("max_execution_time", "3600");
        $users=Users::pluck('name','id');
        $medias=Media::pluck('media_name','id');
        Excel::create($export_name,function($excel) use ($list,$export_name,$medias,$users){
            $export_data=array();
            array_push($export_data, array(
                '线索日期','区域','提供者','提供者单位','内容','线索状态'
            ));
            foreach($list as $k=>$l) {
                array_push($export_data, array(
                    $l->addtime,$l->region,$l->provider,$l->provider_company,
                    $l->content,config('configure.status2')[$l->status]
                ));
            }
            $excel->sheet($export_name, function($sheet) use ($export_data){
                $sheet->setFontSize(10);//设置字体大小
                $sheet->setWidth(array('A' => 20,'B' => 20,'C' => 30,'D' => 20,'E' => 50,'F' => 17));
                $sheet->rows($export_data);
                $sheet->cells('A1:F1', function($cells) {
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
                $sheet->getStyle('A1:F'.count($export_data))->applyFromArray($style_array);
            });
        })->export('xls');
    }
    //线索管理 列表
    public function manage(Request $request){
        $status=$request->input('status',1);
        $endtime=$request->input('endtime');
        $starttime=$request->input('starttime');
        $list=News::where('n_type',3)->whereIn('status',[1,3,4])->orderBy('created_at','desc');
        if($status){
            $list=$list->where('status',$status);
        }
        if($starttime){
            $list=$list->where('addtime','>=', $starttime);
        }
        if($endtime){
            $list=$list->where('addtime','<=', $endtime);
        }
        $users=Users::pluck('name','id');
        $medias=Media::pluck('media_name','id');
        $list=$list->paginate(10);
        if($request->input('export')==1){
            $this->export_csv1($list);
        }
        $url = $request->fullUrl();
        return view('news.clue.manage',compact('list','url','status','users','medias','starttime','endtime'));
    }
    //导出 上稿确认
    public function export_csv1($list,$export_name='新闻线索-新闻上报'){
        ini_set("max_execution_time", "3600");
        $users=Users::pluck('name','id');
        $medias=Media::pluck('media_name','id');
        Excel::create($export_name,function($excel) use ($list,$export_name,$medias,$users){
            $export_data=array();
            array_push($export_data, array(
                '区域','提供者','提供者单位','内容','线索日期','线索状态','处置情况'
            ));
            foreach($list as $k=>$l) {
                array_push($export_data, array(
                    $l->region,$l->provider,$l->provider_company,
                    $l->content,$l->addtime,config('configure.status2')[$l->status],$l->confirmation
                ));
            }
            $excel->sheet($export_name, function($sheet) use ($export_data){
                $sheet->setFontSize(10);//设置字体大小
                $sheet->setWidth(array('A' => 20,'B' => 20,'C' => 30,'D' => 20,'E' => 50,'F' => 17,'G' => 30));
                $sheet->rows($export_data);
                $sheet->cells('A1:G1', function($cells) {
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
                $sheet->getStyle('A1:G'.count($export_data))->applyFromArray($style_array);
            });
        })->export('xls');
    }
}