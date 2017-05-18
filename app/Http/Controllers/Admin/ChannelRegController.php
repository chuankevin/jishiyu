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
        $data=ChannelNo::leftjoin('channel_no_pro','channel_no.id','=','channel_no_pro.channel_no_id')
            ->where('no',$channel)
            ->first();

        $users=new User();

        //七天注册量
        $today=$users->where('channel',$channel)->where('create_time','>=',date('Y-m-d'))->count();
        $data['today']=ceil(($data->proportion)/100*$today);

        $day1=$users->where('channel',$channel)->whereBetween('create_time',[date('Y-m-d',time()-3600*24),date('Y-m-d')])->count();
        $data['day1']=ceil(($data->proportion)/100*$day1);

        $day2=$users->where('channel',$channel)->whereBetween('create_time',[date('Y-m-d',time()-3600*24*2),date('Y-m-d',time()-3600*24)])->count();
        $data['day2']=ceil(($data->proportion)/100*$day2);

        $day3=$users->where('channel',$channel)->whereBetween('create_time',[date('Y-m-d',time()-3600*24*3),date('Y-m-d',time()-3600*24*2)])->count();
        $data['day3']=ceil(($data->proportion)/100*$day3);

        $day4=$users->where('channel',$channel)->whereBetween('create_time',[date('Y-m-d',time()-3600*24*4),date('Y-m-d',time()-3600*24*3)])->count();
        $data['day4']=ceil(($data->proportion)/100*$day4);

        $day5=$users->where('channel',$channel)->whereBetween('create_time',[date('Y-m-d',time()-3600*24*5),date('Y-m-d',time()-3600*24*4)])->count();
        $data['day5']=ceil(($data->proportion)/100*$day5);

        $day6=$users->where('channel',$channel)->whereBetween('create_time',[date('Y-m-d',time()-3600*24*6),date('Y-m-d',time()-3600*24*5)])->count();
        $data['day6']=ceil(($data->proportion)/100*$day6);

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
        $data['count']=ceil(($data->proportion)/100*$num);


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

        //近七天注册



        return view('admin.channelreg.list',compact('data','start_time','end_time'));
    }

}
