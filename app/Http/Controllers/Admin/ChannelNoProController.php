<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\HomeController;
use App\Models\ChannelNo;
use App\Models\ChannelNoPro;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

class ChannelNoProController extends HomeController
{

    public function getList(Request $request){

        $data=new ChannelNoPro();
        $keywords=$request->keywords;
        if($keywords!=''){
            $data=$data->where('channel_no.name','like','%'.$keywords.'%');
        }
        $data=$data
            ->leftjoin('channel_no','channel_no_pro.channel_no_id','=','channel_no.id')
            ->select('channel_no_pro.*','channel_no.name')
            ->orderBy('created_at','desc')
            ->paginate(15);

        return view('admin.channelnopro.list',compact('data','keywords'));
    }


    public function anyEdit(Request $request){
        $data=ChannelNoPro::find($request->id);
        if($request->isMethod('post')){
            $data->proportion=$request->proportion;
            if($data->save()){
                return Redirect::to('admin/channelnopro/list');
            }
        }else{
            //渠道数据
            $channels=ChannelNo::get();
            return view('admin.channelnopro.edit',compact('data','channels'));
        }
    }
}
