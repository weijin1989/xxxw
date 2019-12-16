<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB,Log;

class Logs extends Model
{
    protected $table="logs";

    public static function addLogs($add_data){
        return Logs::insert($add_data);
    }
    public static function logs_count($where){
        $sql = "select count(*) as total from logs where ".$where;
        return DB::select($sql);
    }

    public static function selectLogs($where,$limit=10,$offset=0){
        $sql = "select * from logs where ".$where." order by `created_at` desc limit ".$limit." offset ".$offset;
        return DB::select($sql);
    }
}
