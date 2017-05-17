<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\HomeController;
use App\Models\Channel;
use App\Models\ChannelNo;
use App\Models\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ChannelRegController extends HomeController
{
    public function getList(Request $request){
        $admin_user=session('admin_user');
        $channel=$admin_user->name;
        $data=ChannelNo::leftjoin('channel_no_pro','channel_no.id','=','channel_no_pro.proportion')
            ->where('no',$channel)
            ->first();

        $users=new User();
        //条件筛选
        $start_time=$request->start_time;
        $end_time=$request->end_time;
        if($start_time!=''){
            $users=$users->where('create_time','>=',$start_time);
        }
        if($end_time!=''){
            $end=date('Y-m-d',strtotime($end_time)+3600*24);
            $users=$users->where('create_time','<=',$end);
        }
        //注册数量
        $num=$users->where('channel',$channel)->count();
        $data['count']=$data->proportion/100*$num;

        if($data->lv1!=0){
            $data->lv1=Channel::find($data->lv1)['name'];
        }else{
            $data->lv1='';
        }

        if($data->lv2!=0){
            $data->lv2=Channel::find($data->lv2)['name'];
        }else{
            $data->lv2='';
        }

        if($data->lv3!=0){
            $data->lv3=Channel::find($data->lv3)['name'];
        }else{
            $data->lv3='';
        }

        if($data->lv4!=0){
            $data->lv4=Channel::find($data->lv4)['name'];
        }else{
            $data->lv4='';
        }

        if($data->lv5!=0){
            $data->lv5=Channel::find($data->lv5)['name'];
        }else{
            $data->lv5='';
        }

        return view('admin.channelreg.list',compact('data','start_time','end_time'));
    }

}
