<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Models\UserInfo;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class UserInfoController extends ApiController
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * 完善个人信息
     */
    public function postAdd(Request $request){
        $uid=$request->uid;
        if(!$uid){
            return $this->msg('0001','用户id参数缺失');
        }
        $realname=$request->realname;
        if(!$realname){
            return $this->msg('0002','姓名参数缺失');
        }
        $idcard=$request->idcard;
        if(!$idcard){
            return $this->msg('0003','身份证参数缺失');
        }

        $data=new UserInfo();
        $data->uid=$uid;
        $data->realname=$realname;
        $data->idcard=$idcard;
        if($data->save()){
            return $this->msg('0000','成功');
        }

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * 拉取用户信息
     */
    public function postDetail(Request $request){
        $uid=$request->uid;
        if(!$uid){
            return $this->msg('0001','用户id参数缺失');
        }
        $data=UserInfo::where('uid',$uid)->first();
        if($data){
            return $this->msg('0000','成功',['data'=>$data]);
        }else{
            return $this->msg('0002','此用户不存在');
        }
    }
}
