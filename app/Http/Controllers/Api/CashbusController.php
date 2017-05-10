<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class CashbusController extends ApiController
{
    public function postUrl(Request $request){
        //检查参数
        $mobile=$request->mobile;
        if(!$mobile){
            return $this->msg('0001','参数不正确');
        }
        $amount=$request->amount;
        if(!$amount){
            return $this->msg('0001','参数不正确');
        }
        $loanDays=$request->loandays;
        if(!$loanDays){
            return $this->msg('0001','参数不正确');
        }

        $params = array();
        $params['channel'] = 'jsy001';
        $params['phone'] = $mobile;
        $params['showSteps'] = 1;
        $params['amount'] = $amount;
        $params['loanDays'] = $loanDays;
        $params['ticket'] = 'V3UyQ3myelB0iwjEsQNj4TCCVV2HYOrX';
        $sign=$this->getSignature($params);
        unset($params['ticket']);
        $params['signature']=$sign;
        $str = http_build_query($params);

        $url="https://weixin.cashbus.com/promotion.html#/?".$str;

        return $this->msg('0000','成功',['url'=>$url]);
    }

    private function getSignature($params) {
        //先将参数以其参数名的字典序升序进行排序
        ksort($params);
        //数组转url格式
        $str = http_build_query($params);
        //通过md5算法为签名字符串生成一个md5签名，该签名就是我们要追加的sign参数值
        return sha1($str);
    }
}
