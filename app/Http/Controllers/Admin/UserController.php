<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\HomeController;
use App\Models\ChannelNo;
use App\Models\User;
use App\Models\UserHits;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

class UserController extends HomeController{

    /**
     * @param Request $request
     * @return mixed
     * 用户列表
     */
    public function getList(Request $request){
        $data=new User();
        //时间筛选
        $start_time=$request->start_time;
        $end_time=$request->end_time;
        if($start_time!=''){
            $data=$data->where('create_time','>=',$start_time);
        }
        if($end_time!=''){
            $end=date('Y-m-d',strtotime($end_time)+3600*24);
            $data=$data->where('create_time','<=',$end);
        }
        //渠道筛选
        $channel=$request->channel;
        if(!empty($channel)){
            $channelNo=ChannelNo::find($channel)->no;
            $data=$data->where('channel',$channelNo);
        }
        //手机号筛选
        $mobile=$request->mobile;
        if(!empty($mobile)){
            $data=$data->where('mobile',$mobile);
        }
        //用户信息
        $data=$data/*->where('user_status',1)*/
            //->leftjoin('channel_no','users.channel','=','channel_no.no')
            ->orderBy('create_time','desc')
            ->select('users.id','users.reg_from','users.channel','users.user_login','users.user_nicename','users.avatar','users.user_email','users.mobile','users.create_time','users.last_login_time','users.last_login_ip','users.user_status','users.hits','users.stay_time')
            ->paginate(10);
         foreach($data as $key=>$value){
             $channelno=ChannelNo::where('no',$value->channel)->first();
             if($channelno){
                 $data[$key]['name']=$channelno->name;
             }

         }

        //渠道信息
        $channels=ChannelNo::where('is_delete',0)
            ->select('id','no','name')
            ->get();
        return view('admin.user.list',compact('data','channels','channel','mobile','start_time','end_time'));
    }

    /**
     * @param Request $request
     * @return mixed
     * 禁用或启用
     */
    public function postDelete(Request $request){
        $id=$request->id;
        $status=$request->status;
        $user=User::find($id);
        if($status==1){
            //正常
            $user->user_status=0;
            if($user->save()){
                return response()->json(['code'=>1,'msg'=>'禁用成功']);
            }else{
                return response()->json(['code'=>0,'msg'=>'禁用失败']);
            }
        }elseif ($status==0){
            //禁用
            $user->user_status=1;
            if($user->save()){
                return response()->json(['code'=>1,'msg'=>'启用成功']);
            }else{
                return response()->json(['code'=>0,'msg'=>'启用失败']);
            }
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * 导出表格
     */
    public function postExport(Request $request){
        ini_set("memory_limit","256M");
        set_time_limit(600);
        $data=new User();
        //时间筛选
        $start_time=$request->start_time;
        $end_time=$request->end_time;
        if($start_time!=''){
            $data=$data->where('create_time','>=',$start_time);
        }
        if($end_time!=''){
            $end=date('Y-m-d',strtotime($end_time)+3600*24);
            $data=$data->where('create_time','<=',$end);
        }
        //渠道筛选
        $channel=$request->channel;
        if(!empty($channel)){
            $channelNo=ChannelNo::find($channel)->no;
            $data=$data->where('channel',$channelNo);
        }
        //手机号筛选
        $mobile=$request->mobile;
        if(!empty($mobile)){
            $data=$data->where('mobile','like','%'.$mobile.'%');
        }
        $head=[['ID','来源','渠道编号','用户名','昵称','手机','注册时间','最后登录时间','最后登录IP','点击','停留（秒）']];
        //用户信息
        $data=$data
            ->leftjoin('channel_no','users.channel','=','channel_no.no')
            ->where('user_status',1)
            ->orderBy('create_time','desc')
            ->select('users.id','reg_from','channel_no.name','user_login','user_nicename','mobile','create_time','last_login_time','last_login_ip','hits','stay_time')
            ->get()
            ->toArray();
        foreach($data as $key=>$value){
            $data[$key]['stay_time']=ceil($value['stay_time']/1000);
            $data[$key]['create_time']=date('Y-m-d',strtotime($value['create_time']));
        }
        $data=array_merge($head,$data);

        return $this->export('user_'.date('Ymdis'),'用户表',$data);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 用户点击统计
     */
    public function getUserhits(Request $request){
        $data=new UserHits();
        //手机号筛选
        $keywords=$request->keywords;
        if($keywords!=''){
            $data=$data->where('mobile','like','%'.$keywords.'%');
        }
        //渠道筛选
        $channel=$request->channel;
        if($channel!=''){
            $data=$data->where('user_hits.channel','like','%'.$channel.'%')
                ->orWhere('channel_no.name','like','%'.$channel.'%');
        }
        //时间筛选
        $start_time=$request->start_time;
        if($start_time==''){
            $start_time=date('Y-m-d');
        }
        $data=$data
            ->leftjoin('users','user_hits.uid','=','users.id')
            ->leftjoin('channel_no','user_hits.channel','=','channel_no.no')
            ->select('user_hits.id','uid','mobile','user_hits.channel','channel_no.name')
            ->orderBy('id','desc')
            ->groupBy('uid')
            ->paginate(15);
        foreach($data as $key=>$value){
            //今日点击
            $today=UserHits::where('created_at',$start_time)
                ->where('uid',$value->uid)
                ->sum('app_hits');
            $value->today=$today;
            //昨日点击
            $yesterday=UserHits::where('created_at',date('Y-m-d',strtotime($start_time)-3600*24))
                ->where('uid',$value->uid)
                ->sum('app_hits');
            $value->yesterday=$yesterday;
            //一周点击
            $week=UserHits::whereBetween('created_at',[date('Y-m-d',strtotime($start_time)-3600*24*7),$start_time])
                ->where('uid',$value->uid)
                ->sum('app_hits');
            $value->week=$week;
            //本月点击
            $month=UserHits::whereBetween('created_at',[date('Y-m'),date('Y-m-d')])
                ->where('uid',$value->uid)
                ->sum('app_hits');
            $value->month=$month;
        }
        return view('admin.user.userhits',compact('data','keywords','channel','start_time'));
    }
}
