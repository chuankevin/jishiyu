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

        if(date('Y-m-d')>=$data->start && date('Y-m-d')<=$data->end){
            $data['today']=ceil(($data->proportion2)/100*$today);
        }else{
            $data['today']=ceil(($data->proportion)/100*$today);
        }


        $day1=$users->where('channel',$channel)->whereBetween('create_time',[date('Y-m-d',time()-3600*24),date('Y-m-d')])->count();
        if(date('Y-m-d',time()-3600*24)>=$data->start && date('Y-m-d',time()-3600*24)<=$data->end){
            $data['day1']=ceil(($data->proportion2)/100*$day1);
        }else{
            $data['day1']=ceil(($data->proportion)/100*$day1);
        }


        $day2=$users->where('channel',$channel)->whereBetween('create_time',[date('Y-m-d',time()-3600*24*2),date('Y-m-d',time()-3600*24)])->count();
        if(date('Y-m-d',time()-3600*24*2)>=$data->start && date('Y-m-d',time()-3600*24*2)<=$data->end){
            $data['day2']=ceil(($data->proportion2)/100*$day2);
        }else{
            $data['day2']=ceil(($data->proportion)/100*$day2);
        }


        $day3=$users->where('channel',$channel)->whereBetween('create_time',[date('Y-m-d',time()-3600*24*3),date('Y-m-d',time()-3600*24*2)])->count();
        if(date('Y-m-d',time()-3600*24*3)>=$data->start && date('Y-m-d',time()-3600*24*3)<=$data->end){
            $data['day3']=ceil(($data->proportion2)/100*$day3);
        }else{
            $data['day3']=ceil(($data->proportion)/100*$day3);
        }


        $day4=$users->where('channel',$channel)->whereBetween('create_time',[date('Y-m-d',time()-3600*24*4),date('Y-m-d',time()-3600*24*3)])->count();
        if(date('Y-m-d',time()-3600*24*4)>=$data->start && date('Y-m-d',time()-3600*24*4)<=$data->end){
            $data['day4']=ceil(($data->proportion2)/100*$day4);
        }else{
            $data['day4']=ceil(($data->proportion)/100*$day4);
        }

        $day5=$users->where('channel',$channel)->whereBetween('create_time',[date('Y-m-d',time()-3600*24*5),date('Y-m-d',time()-3600*24*4)])->count();
        if(date('Y-m-d',time()-3600*24*5)>=$data->start && date('Y-m-d',time()-3600*24*5)<=$data->end){
            $data['day5']=ceil(($data->proportion2)/100*$day5);
        }else{
            $data['day5']=ceil(($data->proportion)/100*$day5);
        }

        $day6=$users->where('channel',$channel)->whereBetween('create_time',[date('Y-m-d',time()-3600*24*6),date('Y-m-d',time()-3600*24*5)])->count();
        if(date('Y-m-d',time()-3600*24*6)>=$data->start && date('Y-m-d',time()-3600*24*6)<=$data->end){
            $data['day6']=ceil(($data->proportion2)/100*$day6);
        }else{
            $data['day6']=ceil(($data->proportion)/100*$day6);
        }

        //条件筛选
        $start_time=$request->start_time;
        $end_time=$request->end_time;
        $users1=new User();
        if($start_time!=''){
            $users1=$users1->where('create_time','>=',$start_time);
        }
        if($end_time!=''){
            $end=date('Y-m-d',strtotime($end_time)+3600*24);
            $users1=$users1->where('create_time','<=',$end);
        }

        $users2=new User();
        if($start_time!=''){
            $users2=$users2->where('create_time','>=',$start_time);
        }
        if($end_time!=''){
            $end=date('Y-m-d',strtotime($end_time)+3600*24);
            $users2=$users2->where('create_time','<=',$end);
        }

        $users3=new User();
        if($start_time!=''){
            $users3=$users3->where('create_time','>=',$start_time);
        }
        if($end_time!=''){
            $end=date('Y-m-d',strtotime($end_time)+3600*24);
            $users3=$users3->where('create_time','<=',$end);
        }
        $users4=new User();
        if($start_time!=''){
            $users4=$users4->where('create_time','>=',$start_time);
        }
        if($end_time!=''){
            $end=date('Y-m-d',strtotime($end_time)+3600*24);
            $users4=$users4->where('create_time','<=',$end);
        }


        //注册数量
        if($data->proportion2){

            $num1=$users1
                ->where('channel',$channel)
                ->where('create_time','<',$data->start)
                ->count();
            $num2=$users2
                ->where('channel',$channel)
                ->whereBetween('create_time',[$data->start,date('Y-m-d',strtotime($data->end)+3600*24)])
                ->count();
            $num3=$users3
                ->where('channel',$channel)
                ->where('create_time','>',date('Y-m-d',strtotime($data->end)+3600*24))
                ->count();

            $num=ceil(($data->proportion)/100*$num1)+ceil(($data->proportion2)/100*$num2)+ceil(($data->proportion)/100*$num3);
            $data['count']=$num;

        }else{
            $num=$users4->where('channel',$channel)->count();
            $data['count']=ceil(($data->proportion)/100*$num);
        }



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
