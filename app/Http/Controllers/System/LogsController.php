<?php
namespace App\Http\Controllers\System;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB,Input,Auth;

class LogsController extends Controller
{
    public function index()
    {
        return view('system.logs');

    }
    public function logsList()
    {
        $all       = Input::all();
        $where = ' 1=1 ';
        extract($all);
        if(isset($starttime)&& $starttime!='' && isset($endtime)&& $endtime!=''){
            $where .= ' and `created_at` between  "'.$starttime.'" and "'.$endtime.'"';
        }
        $where .= isset($username) && $username!=''? ' and `username` like "%'.$username.'%"' : '';
        $where .= isset($contentID) && $contentID!=''? ' and `content` like "%'.$contentID.'%"' : '';

        $offset    = Input::get('offset');
        $limit     = Input::get('limit');

        $count = Logs::logs_count($where);
        foreach($count  as $k=>$v){
            $dataArr = (array)$v;
            $count=  $dataArr['total'];
        }
        if ($count == $offset && $count != 0) $offset = $offset - $limit;
        $rs=Logs::selectLogs($where,$limit,$offset);
        $rst= array();
        if($rs){
            foreach($rs as $k=>$v){
                $v=(array)$v;
                $rst[$k]=$v;
            }
        }
        $result['rows']=$rst;
        $result['total']=$count;
        return response()->json($result);
    }

}