<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\HomeController;
use App\Models\ProductHitsLog;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ProductHitsLogController extends HomeController
{
    /**
     * @param Request $request
     * @return mixed
     * 业务点击量
     */
    public function getList(Request $request){
        $data=new ProductHitsLog();
        //条件筛选
        $start_time=$request->start_time;
        $end_time=$request->end_time;
        if($start_time!=''){
            $data=$data->where('product_hits_log.created_at','>=',$start_time);
        }
        if($end_time!=''){
            $end=date('Y-m-d',strtotime($end_time)+3600*24);
            $data=$data->where('product_hits_log.created_at','<',$end);
        }
        //业务数据
        $data=$data
            ->leftjoin('products','product_hits_log.business_id','=','products.id')
            ->where('products.status',1)
            ->select('product_hits_log.*','products.pro_name',DB::raw('SUM(cmf_product_hits_log.hits) as count'))
            ->groupBy('business_id')
            ->orderBy('product_hits_log.id')
            ->paginate(15);

        //业务点击数据汇总
        $hit_log=new ProductHitsLog();
        if($start_time!=''){
            $hit_log=$hit_log->where('created_at','>=',$start_time);
        }
        if($end_time!=''){
            $end=date('Y-m-d',strtotime($end_time)+3600*24);
            $hit_log=$hit_log->where('created_at','<',$end);
        }
        $app_sum=$hit_log->sum('product_hits_log.hits');



        return view('admin.producthitslog.list',compact('data','start_time','end_time','app_sum'));
        
    }
}
