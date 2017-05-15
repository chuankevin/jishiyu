<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

require  '/zmxy-sdk/zmop/RSAUtil.php';

class AlipayController extends ApiController
{
    /**
     * @param Request $request
     * 芝麻信用授权回调
     */
    public function anyAuthorize(Request $request){
        //dd($request->all());
    }

    public function postEncrypt(Request $request){
        $identity_type=$request->identity_type;
        if(!$identity_type){
            return $this->msg('0001','参数不正确');
        }
        $identity_param=$request->identity_param;
        if(!$identity_param){
            return $this->msg('0001','参数不正确');
        }
        $str="identity_type=".urlencode($identity_type)."&identity_param=".urlencode($identity_param);

        $params=urlencode(base64_encode(\RSAUtil::rsaEncrypt($str,"d:\Projects\jishiyu\public\zmxy-sdk\public_key.pem")));
        return $this->msg('0000','成功',['params'=>$params]);

    }
}
