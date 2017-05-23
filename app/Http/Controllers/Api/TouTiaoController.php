<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Models\ToutiaoCallbackLog;
use App\Models\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class TouTiaoController extends ApiController
{
    /**
     * @param Request $request
     * 今日头条-计划D
     */
    public function postReceived(Request $request){
        $arr=json_decode($request->data,true);
        $mobile=$arr['data'][0]['value'];

        //$ret=User::where('mobile',$mobile)->first();

        //if(!$ret){
            $data=new User();
            $data->mobile=$mobile;
            $data->create_time=date('Y-m-d H:i:s');
            $data->last_login_time=date('Y-m-d H:i:s');
            $data->user_status = 1;
            $data->user_type=2;
            $data->channel='QD0047';
            $data->save();
        //}

    }

    /**
     * @param Request $request
     * 今日头条-计划a
     */
    public function postReceiveda(Request $request){
        $arr=json_decode($request->data,true);
        $mobile=$arr['data'][0]['value'];

        //$ret=User::where('mobile',$mobile)->first();

        //if(!$ret){
            $data=new User();
            $data->mobile=$mobile;
            $data->create_time=date('Y-m-d H:i:s');
            $data->last_login_time=date('Y-m-d H:i:s');
            $data->user_status = 1;
            $data->user_type=2;
            $data->channel='QD0007';
            $data->save();
        //}

    }
}
