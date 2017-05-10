<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\HomeController;
use App\Models\AppLog;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class AppLogController extends HomeController
{
    public function getList(Request $request){
        $data=new AppLog();
        //条件筛选
        $start_time=$request->start_time;
        $end_time=$request->end_time;
        if($start_time!=''){
            $data=$data->where('created_at','>=',$start_time);
        }
        if($end_time!=''){
            $data=$data->where('created_at','<=',$end_time);
        }
        $channel=$request->channel;
        if($channel!=''){
            $data=$data->where('channel','like','%'.$channel.'%');
        }
        $mobile=$request->mobile;
        if($mobile!=''){
            $data=$data->where('mobile',$mobile);
        }

        $data=$data->leftjoin('users','app_log.user_id','=','users.id')
            ->select('app_log.*','users.mobile','users.channel',DB::raw('SUM(hits) as hits'),DB::raw('SUM(open) as open'))
            ->groupBy('user_id')
            ->paginate(10);
        //dd($data);
        return view('admin.applog.list',compact('data','start_time','end_time','channel','mobile'));
    }
}
