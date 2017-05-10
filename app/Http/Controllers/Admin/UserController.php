<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\HomeController;
use App\Models\ChannelNo;
use App\Models\User;
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
        //条件筛选
        $channel=$request->channel;
        if(!empty($channel)){
            $channelNo=ChannelNo::find($channel)->no;
            $data=$data->where('channel',$channelNo);
        }
        $mobile=$request->mobile;
        if(!empty($mobile)){
            $data=$data->where('mobile','like','%'.$mobile.'%');
        }
        //用户信息
        $data=$data/*->where('user_status',1)*/
            ->orderBy('create_time','desc')
            ->select('id','reg_from','channel','user_login','user_nicename','avatar','user_email','mobile','create_time','last_login_time','last_login_ip','user_status')
            ->paginate(10);
        //渠道信息
        $channels=ChannelNo::where('is_delete',0)
            ->select('id','no')
            ->get();
        return view('admin.user.list',compact('data','channels','channel','mobile'));
    }

    /**
     * @param Request $request
     * @return mixed
     * 禁用或启用渠道
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
}
