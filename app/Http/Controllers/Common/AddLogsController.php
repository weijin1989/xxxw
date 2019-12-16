<?php
namespace App\Http\Controllers\Common;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB,Input,Auth;
use App\Models\Logs;


class AddLogsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission');
    }
    public function addLogs($content){
        $userid = Auth::user()->id ;
        $username = Auth::user()->name ;
        $time = date('Y-m-d H:i:s');
        $add_data = array(
            'userid'    =>$userid,
            'username'  =>$username,
            'content'   =>$content,
            'created_at'=>$time
        );
        Logs::addLogs($add_data);
    }
//use App\Http\Controllers\Common\AddLogsController;
//$content="操作内容";
//$logs= new AddLogsController();
//$logs->addLogs($content);

}