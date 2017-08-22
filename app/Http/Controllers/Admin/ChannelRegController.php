<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\HomeController;
use App\Models\Channel;
use App\Models\ChannelNo;
use App\Models\ChannelReg;
use App\Models\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ChannelRegController extends HomeController
{
    public function getList(Request $request){
        //刷新当天和前天数据
        $this->generate(date("Y-m-d",strtotime("-1 day")));
        $this->generate(date('Y-m-d'));
        //七天注册
        $admin_user=session('admin_user');
        $channel=$admin_user->name;
        $data=ChannelReg::where('channel',$channel)
            ->orderBy('created_at','desc')
            ->limit(7)
            ->get();
        //总注册
        $start_time=$request->start_time;
        $end_time=$request->end_time;

        $channel_reg=new ChannelReg();
        if($start_time!=''){
            $channel_reg=$channel_reg->where('created_at','>=',$start_time);
        }
        if($end_time!=''){
            $channel_reg=$channel_reg->where('created_at','<=',$end_time);
        }
        $total=$channel_reg
            ->where('channel',$channel)
            ->sum('reg_num');
        //渠道名称
        $channel_name=ChannelNo::where('no',$channel)->first();


        return view('admin.channelreg.list',compact('channel','channel_name','total','data','start_time','end_time'));
    }

    /**
     * 处理注册数据
     */
    public function generate($date){
        $admin_user=session('admin_user');
        $channel=$admin_user->name;
        //当前渠道的比例
        $data=ChannelNo::leftjoin('channel_no_pro','channel_no.id','=','channel_no_pro.channel_no_id')
            ->where('no',$channel)
            ->first();
        //当日注册量
        $users=new User();
        $rel_num=$users
            ->where('channel',$channel)
            ->where('create_time','>=',$date)
            ->where('create_time','<',date('Y-m-d',strtotime($date)+3600*24))
            ->count();
        //处理后数量
        if($date>=$data->start && $date<=$data->end){
            $reg_num=ceil($rel_num*($data->proportion2)/100);
        }else{
            $reg_num=ceil($rel_num*($data->proportion)/100);
        }
        //存入数据库
        $channel_reg=ChannelReg::where([
            'channel'=>$channel,
            'created_at'=>$date
        ])->first();

        if($channel_reg){
            ChannelReg::where([
                'channel'=>$channel,
                'created_at'=>$date
            ])->update([
                'rel_num'=>$rel_num,
                'reg_num'=>$reg_num
            ]);
        }else{
            ChannelReg::insert([
                'channel'=>$channel,
                'rel_num'=>$rel_num,
                'reg_num'=>$reg_num,
                'created_at'=>$date,
                'updated_at'=>$date,
            ]);
        }

    }

}
