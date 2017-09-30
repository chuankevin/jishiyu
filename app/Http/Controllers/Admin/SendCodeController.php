<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\HomeController;
use App\Models\SendCode;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class SendCodeController extends HomeController
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 列表
     */
    public function getList(Request $request){
        $data=new SendCode();
        //时间筛选
        $start_time=$request->start_time;
        $end_time=$request->end_time;
        if($start_time!=''){
            $data=$data->where('created_at','>=',$start_time);
        }
        if($end_time!=''){
            //$end=date('Y-m-d',strtotime($end_time)+3600*24);
            $data=$data->where('created_at','<=',$end_time);
        }
        //手机号筛选
        $mobile=$request->mobile;
        if($mobile!=''){
            $data=$data->where('send_code.mobile',$mobile);
        }

        $data=$data
            ->leftjoin('users','send_code.mobile','=','users.mobile')
            ->select('send_code.*','users.create_time')
            ->where('num',5)
            ->paginate(15);
        return view('admin.sendcode.list',compact('data','start_time','end_time','mobile'));
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * 导出表格
     */
    public function postExport(Request $request){
        ini_set("memory_limit","256M");
        set_time_limit(600);
        $data=new SendCode();
        //时间筛选
        $start_time=$request->start_time;
        $end_time=$request->end_time;
        if($start_time!=''){
            $data=$data->where('created_at','>=',$start_time);
        }
        if($end_time!=''){
            //$end=date('Y-m-d',strtotime($end_time)+3600*24);
            $data=$data->where('created_at','<=',$end_time);
        }
        //手机号筛选
        $mobile=$request->mobile;
        if($mobile!=''){
            $data=$data->where('mobile',$mobile);
        }

        $head=[['ID','手机号','注册时间','记录时间']];
        //用户信息
        $data=$data
            ->leftjoin('users','send_code.mobile','=','users.mobile')
            ->select('send_code.id','send_code.mobile','users.create_time','send_code.created_at')
            ->where('num',5)
            ->get()
            ->toArray();

        $data=array_merge($head,$data);

        return $this->export('user_'.date('Ymdis'),'恶意用户表',$data);
    }
}
