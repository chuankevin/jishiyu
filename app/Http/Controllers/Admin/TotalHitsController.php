<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\HomeController;
use App\Models\HitsLog;
use App\Models\ProductHitsLog;
use App\Models\TotalHits;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class TotalHitsController extends HomeController
{
    public function getList(Request $request){

        $start_time=$request->start_time;
        $end_time=$request->end_time;

        $list_order=$request->list_order ? $request->list_order : 'desc';

        //*********************新产品点击数据************************
        $product_hits=new ProductHitsLog();
        //时间筛选
        if($start_time!=''){
            $product_hits=$product_hits->where('product_hits_log.created_at','>=',$start_time);
        }
        if($end_time!=''){
            $end=date('Y-m-d',strtotime($end_time)+3600*24);
            $product_hits=$product_hits->where('product_hits_log.created_at','<=',$end);
        }
        //最终数据
        $product_hits=$product_hits
            ->select('product_hits_log.created_at','products.pro_name as pname',DB::raw('SUM(cmf_product_hits_log.hits) as hits'))
            ->leftjoin('products','products.id','=','business_id')
            ->groupBy('business_id')
            ->orderBy('hits',$list_order)
            //->paginate(15);
            ->get();
        $product_hits_total=$product_hits->sum('hits');

        //*********************老产品点击数据**************************
        $business_hits=new HitsLog();
        //时间筛选
        if($start_time!=''){
            $business_hits=$business_hits->where('hits_log.created_at','>=',$start_time);
        }
        if($end_time!=''){
            $end=date('Y-m-d',strtotime($end_time)+3600*24);
            $business_hits=$business_hits->where('hits_log.created_at','<=',$end);
        }
        //最终数据
        $business_hits=$business_hits
            ->select('hits_log.created_at','business.post_title as pname',DB::raw('SUM(cmf_hits_log.hits) as hits'))
            ->leftjoin('business','business.id','=','business_id')
            ->groupBy('business_id')
            ->orderBy('hits',$list_order)
            //->paginate(15);
            ->get();
        $business_hits_total=$business_hits->sum('hits');

        //**********************H5点击数据******************************
        $h5_hits=new HitsLog();
        //时间筛选
        if($start_time!=''){
            $h5_hits=$h5_hits->where('hits_log.created_at','>=',$start_time);
        }
        if($end_time!=''){
            $end=date('Y-m-d',strtotime($end_time)+3600*24);
            $h5_hits=$h5_hits->where('hits_log.created_at','<=',$end);
        }
        //最终数据
        $h5_hits=$h5_hits
            ->select('hits_log.created_at','business.post_title as pname',DB::raw('SUM(cmf_hits_log.h5_hits) as hits'))
            ->leftjoin('business','business.id','=','business_id')
            ->groupBy('business_id')
            ->orderBy('hits',$list_order)
            //->paginate(15);
            ->get();
        $h5_hits_total=$h5_hits->sum('hits');

        return view('admin.totalhits.list',compact('product_hits','business_hits','h5_hits','start_time','end_time','product_hits_total','business_hits_total','h5_hits_total','list_order'));
    }
}
