<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Admin\ChannelRegController;
use App\Http\Controllers\ApiController;
use App\Models\AdminUser;
use App\Models\ChannelNo;
use App\Models\ChannelReg;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;

class FlushController extends ApiController
{
    /**
     *
     * 定时执行刷新前一天数据
     */
    public function getCrond(){
        $admin_user=AdminUser::get();
        foreach ($admin_user as $key=>$value) {
            $this->generate(date("Y-m-d",strtotime("-1 day")),$value->name);
        }
    }

    public function generate($date,$channel){
        if(!strstr($channel,'QD')){
            return;
        }
        //当前渠道的比例
        $data=ChannelNo::leftjoin('channel_no_pro','channel_no.id','=','channel_no_pro.channel_no_id')
            ->where('no',$channel)
            ->first();
        if(!$data){
            return;
        }
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
