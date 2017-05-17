<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Models\ZmxyCallbackLog;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

//require  public_path().'/zmxy-sdk/zmop/RSAUtil.php';
require  public_path().'/zmxy-sdk/zmop/ZmopClient.php';
require  public_path().'/zmxy-sdk/zmop/request/ZhimaAuthInfoAuthorizeRequest.php';
require  public_path().'/zmxy-sdk/zmop/request/ZhimaCreditScoreGetRequest.php';

class AlipayController extends ApiController
{
    /**
     * @param Request $request
     * 芝麻信用授权回调,加密加签
     */

    //芝麻公钥文件
    //public $public_key="d:\Projects\jishiyu\public\zmxy-sdk\public_key.pem";
    //商户私钥文件
    //public $private_key="d:\Projects\jishiyu\public\zmxy-sdk\private_key.pem";

    public $public_key="./zmxy-sdk/public_key.pem";
    public $private_key="./zmxy-sdk/private_key.pem";

    //芝麻信用网关地址
    public $gatewayUrl = "https://zmopenapi.zmxy.com.cn/openapi.do";
    //数据编码格式
    public $charset = "UTF-8";
    //芝麻分配给商户的 appId
    public $appId = "1002755";


    /**
     * @param Request $request
     * 解密解签
     */
    public function anyAuthorize(Request $request){
        //从回调URL中获取params参数，此处为示例值
        $params = $request->params;
        //从回调URL中获取sign参数，此处为示例值
        $sign = $request->sign;

        // 判断串中是否有%，有则需要decode
        $params = strstr ( $params, '%' ) ? urldecode ( $params ) : $params;
        $sign = strstr ( $sign, '%' ) ? urldecode ( $sign ) : $sign;

        $client = new \ZmopClient ( $this->gatewayUrl, $this->appId, $this->charset, $this->private_key, $this->public_key );
        $result = $client->decryptAndVerifySign ( $params, $sign );
        //echo $result;
       /* $data=new ZmxyCallbackLog();
        $data->info=$result;
        $data->save();*/
        parse_str($result,$data);

        return $this->testZhimaCreditScoreGet($data['open_id']);


    }

    public function testZhimaCreditScoreGet($open_id){

        $str=date('YmdHis').str_pad(floor(microtime()*1000),3,'0',STR_PAD_RIGHT).mt_rand(1000000000000,'9999999999999');

        $client = new \ZmopClient($this->gatewayUrl,$this->appId,$this->charset,$this->private_key,$this->public_key);
        $request = new \ZhimaCreditScoreGetRequest();
        $request->setChannel("apppc");
        $request->setPlatform("zmop");
        $request->setTransactionId($str);// 必要参数
        $request->setProductCode("w1010100100000000001");// 必要参数
        $request->setOpenId($open_id);// 必要参数
        $response = $client->execute($request);
        echo json_encode($response);
    }

    /**
     * @param Request $req
     * @return \Illuminate\Http\JsonResponse
     * 芝麻加密加签，返回授权地址
     */
    public function postEncrypt(Request $req){

        $identity_type=$req->identity_type;
        if(!$identity_type){
            return $this->msg('0001','参数不正确');
        }
        $identity_param=$req->identity_param;
        if(!$identity_param){
            return $this->msg('0001','参数不正确');
        }

        $client = new \ZmopClient($this->gatewayUrl,$this->appId,$this->charset,$this->private_key,$this->public_key);
        $request = new \ZhimaAuthInfoAuthorizeRequest();
        $request->setChannel("apppc");
        $request->setPlatform("zmop");
        $request->setIdentityType($identity_type);// 必要参数
        $request->setIdentityParam($identity_param);// 必要参数
        $request->setBizParams("{'auth_code':'M_H5','channelType':'app','state':'商户自定义'}");
        $url = $client->generatePageRedirectInvokeUrl($request);
        return $this->msg('0000','成功',['url'=>$url]);
       /*
        $str="identity_type=".urlencode($identity_type)."&identity_param=".urlencode($identity_param);

        //$params=urlencode(base64_encode(\RSAUtil::rsaEncrypt($str,"d:\Projects\jishiyu\public\zmxy-sdk\public_key.pem")));
        $params=urlencode(\RSAUtil::rsaEncrypt($str,$this->public_key));
        //$sign=base64_encode(\RSAUtil::sign($str,"d:\Projects\jishiyu\public\zmxy-sdk\private_key.pem"));
        $sign=\RSAUtil::sign($str,$this->private_key);
        */

    }
}
