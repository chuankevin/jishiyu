<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Models\Message;
use App\Models\MessageRem;
use App\Models\MessageRep;
use App\Models\MessageType;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class MessageController extends ApiController
{

    public $api_secret='wTCzqpY30jF9DHd8saT3E2tQU0q7aUhK';

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * 提醒列表接口
     */
    public function postList(Request $request){
        $user_id=$request->user_id;
        if(!$user_id){
            return $this->msg('0001','用户id不存在');
        }
        $data=Message::leftjoin('message_type','message.type_id','=','message_type.id')
            ->leftjoin('message_rep','message.rep_id','=','message_rep.id')
            ->leftjoin('message_rem','message.rem_id','=','message_rem.id')
            ->where('user_id',$user_id)
            ->select('message.id as msg_id','message.name','message_type.name as type_name','message_type.icon','amount','repayment_date','message_rep.name as rep_name','message_rem.name as rem_name','remark')
            ->orderBy('message.created_at','desc')
            ->get();

        return $this->msg('0000','成功',['data'=>$data]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * 提醒类型
     */
    public function postTypelist(Request $request){
        $data=MessageType::select('id as type_id','name','icon')
            ->where('is_defind',0)
            ->get();
        return $this->msg('0000','成功',['data'=>$data]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * 提醒重复
     */
    public function postReplist(Request $request){
        $data=MessageRep::select('id as rep_id','name')
            ->get();
        return $this->msg('0000','成功',['data'=>$data]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * 提醒时间
     */
    public function postRemlist(Request $request){
        $data=MessageRem::select('id as rem_id','name')
            ->get();
        return $this->msg('0000','成功',['data'=>$data]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * 新增提醒
     */
    public function postAdd(Request $request){
        //判断用户id
        $user_id=$request->user_id;
        if(!$user_id){
            return $this->msg('0001','用户id不存在');
        }
        //提醒类型
        $type_id=$request->type_id;
        if(!$type_id){
            return $this->msg('0002','提醒类型不存在');
        }else{
            if($type_id==6){
                $msg_name=$request->msg_name;
                if(!$msg_name){
                    return $this->msg('0007','自定义名称不存在');
                }else{
                    $message_type=new MessageType();
                    $message_type->name=$msg_name;
                    $message_type->icon='/img/jishiyu/zidingyi.png';
                    $message_type->is_defind=1;
                    $message_type->save();
                    $type_id=$message_type->id;
                }
            }
        }
        //姓名
        $name=$request->name;
        if(!$name){
            return $this->msg('0003','姓名不存在');
        }
        //金额
        $amount=$request->amount;
        if(!$amount){
            return $this->msg('0004','金额不存在');
        }
        //还款日
        $date=$request->date;
        if(!$date){
            return $this->msg('0005','还款日不存在');
        }
        //重复方式
        $rep_id=$request->rep_id;
        if(!$rep_id){
            return $this->msg('0006','重复方式不存在');
        }
        //提醒时间
        $rem_id=$request->rem_id;
        if(!$rem_id){
            return $this->msg('0006','重复方式不存在');
        }
        //维护数据
        $data=new Message();
        $data->user_id=$user_id;
        $data->type_id=$type_id;
        $data->name=$name;
        $data->amount=$amount;
        $data->repayment_date=$date;
        $data->rep_id=$rep_id;
        $data->rem_id=$rem_id;
        $data->remark=$request->remark;
        if($data->save()){
            return $this->msg('0000','成功');
        }

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * 删除提醒
     */
    public function postDelete(Request $request){
        $id=$request->id;
        if(!$id){
            return $this->msg('0001','id不存在');
        }

        $data=Message::find($id);
        if($data->delete()){
            return $this->msg('0000','成功');
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * 生成签名
     */
    public function postSignature(Request $request){
        if(empty($request->all())){
            return $this->msg('0001','参数不存在');
        }
        //先将参数以其参数名的字典序升序进行排序
        $params=$request->all();
        ksort($params);
        //数组转url格式
        $str = http_build_query($params).$this->api_secret;
        //sha1加密
        $sign=sha1($str);
        return $this->msg('0000','成功',["sign"=>$sign]);

    }

    public function postAuthinfo(Request $request){
        $authinfo=$request->authinfo;
        if(!$authinfo){
            return $this->msg('0001','authinfo参数不存在');
        }
        $str=$authinfo.$this->api_secret;
        $sign=sha1($str);
        return $this->msg('0000','成功',["sign"=>$sign]);
    }


}
