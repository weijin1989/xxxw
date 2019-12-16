<?php
namespace App\Http\Controllers\News;

use App\Models\Company;
use App\Models\Media;
use App\Models\News;
use App\Models\Users;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB,Input,Auth,Image,Excel;


class PresentationController extends Controller
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
        $search=$request->input('search');
        $list=News::where('n_type',4)->wherein('status',[1,3,4])->orderBy('created_at','desc');
//        if($status){
//            $list=$list->where('status',$status);
//        }
        if($starttime){
            $list=$list->where('addtime','>=', $starttime);
        }
        if($endtime){
            $list=$list->where('addtime','<=', $endtime);
        }
        if($search){
            $list=$list->where('interview_situation','like', "%".$search.'%');
        }
        $users=Users::pluck('name','id');
        $medias=Media::pluck('media_name','id');
        $list=$list->paginate(10);
        if($request->input('export')==1){
            $this->export_csv($list);
        }
        $url = $request->fullUrl();
        return view('news.presentation.index',compact('list','url','status','users','medias','starttime','endtime','search'));
    }

    //增加保存
    public function addSave(Request $request){
        $m=new News();
        $m->n_type=4;
        $m->addtime=$request->input('addtime');
        $m->provider_company=$request->input('provider_company');
        $m->interview_situation=$request->input('interview_situation');
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
        $m->provider_company=$request->input('provider_company');
        $m->interview_situation=$request->input('interview_situation');
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
        return view('news.presentation.info',compact('url','info','medias','users'));
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
    public function export_csv($list,$export_name='采访报告-报告登记'){
        ini_set("max_execution_time", "3600");
        Excel::create($export_name,function($excel) use ($list,$export_name){
            $export_data=array();
            array_push($export_data, array(
                '报告日期','报告单位','采访情况'
            ));
            foreach($list as $k=>$l) {
                array_push($export_data, array(
                    $l->addtime,$l->provider_company,$l->interview_situation
                ));
            }
            $excel->sheet($export_name, function($sheet) use ($export_data){
                $sheet->setFontSize(10);//设置字体大小
                $sheet->setWidth(array('A' => 20,'B' => 20,'C' =>80));
                $sheet->rows($export_data);
                $sheet->cells('A1:C1', function($cells) {
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
                $sheet->getStyle('A1:C'.count($export_data))->applyFromArray($style_array);
            });
        })->export('xls');
    }
}