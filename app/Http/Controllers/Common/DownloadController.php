<?php
namespace App\Http\Controllers\Common;

use App\Models\Government;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB,Input,Auth;
use App\Models\Logs;


class DownloadController extends Controller
{
    public function __construct()
    {
    }
    public function download_enclosure(Request $request){
        $name=trim($request->input('name'));
        $go=Government::where('enclosure',$name)->first();
        if($go->enclosure) {
            $filedir1 = public_path('upload_file').'/government_enclosure/';
            $file = fopen($filedir1 . $go->enclosure, "rb");
            //告诉浏览器这是一个文件流格式的文件
            Header("Content-type: application/octet-stream");
            //请求范围的度量单位
            Header("Accept-Ranges: bytes");
            //Content-Length是指定包含于请求或响应中数据的字节长度
            Header("Accept-Length: " . filesize($filedir1 . $go->enclosure));
            //用来告诉浏览器，文件是可以当做附件被下载，下载后的文件名称为$file_name该变量的值。
            Header("Content-Disposition: attachment; filename=" .$go->enclosure_name.'_'.$go->enclosure);
            //读取文件内容并直接输出到浏览器
            echo fread($file, filesize($filedir1 . $go->enclosure));
            fclose($file);
            exit ();
        }
    }

}