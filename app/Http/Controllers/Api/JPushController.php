<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Models\Message;
use App\Models\PushLog;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use JPush\Client as JPush;

class JPushController extends ApiController
{
    public $app=array(
        '1'=>[
            'app_key'=>'fa0d81922f79360b1f440714',
            'master_secrte'=>'0b232f731af2bfaf59acdc80'
        ],
        '2'=>[
            'app_key'=>'90f347350b8253c1d5edd026',
            'master_secrte'=>'38df49226dcb25018f969d34'
        ],
        '3'=>[
            'app_key'=>'22cad97195dbc8ca77e227ed',
            'master_secrte'=>'83473188d7f0f84ab7efb9f4'
        ]
    );

    public function create_push($title,$msg,$user,$app_id){
        //初始化
        $client=new JPush($this->app[$app_id]['app_key'],$this->app[$app_id]['master_secrte'],null);
        $push=$client->push();

        $platform = array('ios');
        $alert = $title;
        $alias = array($user);

        //$regId = array('rid1', 'rid2');
        $ios_notification = array(
            'sound' => 'hello jpush',
            'badge' => '+1',
            'content-available' => true,
            'category' => 'jiguang',
            'extras' => array(
                'content' => $msg,
            ),
        );
        $content = $msg;
        $message = array(
            'title' => $title,
            'content_type' => 'text',
            'extras' => array(
                'content' => $msg,
            ),
        );

        $response = $push->setPlatform($platform)
            ->addAlias($alias)
            ->iosNotification($alert, $ios_notification)
            ->message($content, $message);

        try {
            $ret=$response->send();
            return $ret;
        } catch (\JPush\Exceptions\JPushException $e) {
            // try something else here
            print $e;
        }

    }

    public function push(){
        $data=new Message();
        $start_time=date('Y-m-d H:i:s',strtotime(date('Y-m-d H:i')));
        $end_time=date('Y-m-d H:i:s',strtotime(date('Y-m-d H:i'))+59);
        $data=$data
            ->leftjoin('users','message.user_id','=','users.id')
            ->whereBetween('push_time',[$start_time,$end_time])
            ->select('message.*','users.mobile')
            ->get();
        foreach($data as $key=>$value){
            if($value->app_id==''){
                $data[$key]['app_id']=2;
            }
            $ret=$this->create_push('还款提醒','您有'.$value->amount.'元欠款需要处理！',$value->mobile,$value->app_id);
            if($ret){
                $push_log=new PushLog();
                $push_log->push_mobile=$value->mobile;
                $push_log->push_title='还款提醒';
                $push_log->push_content='您有'.$value->amount.'元欠款需要处理！';
                $push_log->save();

                //循环周期
                $message=Message::find($value->id);
                switch ($value->rep_id){
                    case 2:
                        $message->push_time=date('Y-m-d H:i:s',strtotime($message->push_time)+3600*24*7);
                        break;
                    case 9:
                        $message->push_time=date('Y-m-d H:i:s',strtotime($message->push_time)+1800);
                        break;
                    case 3:
                        $message->push_time=date('Y-m-d H:i:s',strtotime($message->push_time)+3600*24*7*2);
                        break;
                    case 4:
                        $message->push_time=date('Y-m-d H:i:s',strtotime("+1 months",strtotime($message->push_time)));
                        break;
                    case 5:
                        $message->push_time=date('Y-m-d H:i:s',strtotime("+2 months",strtotime($message->push_time)));
                        break;
                    case 7:
                        $message->push_time=date('Y-m-d H:i:s',strtotime("+3 months",strtotime($message->push_time)));
                        break;
                    case 8:
                        $message->push_time=date('Y-m-d H:i:s',strtotime("+6 months",strtotime($message->push_time)));
                        break;
                }
                $message->save();

            }
        }
    }


    public function postPush(){
        $data=new Message();
        $start_time=date('Y-m-d H:i:s',strtotime(date('Y-m-d H:i')));
        $end_time=date('Y-m-d H:i:s',strtotime(date('Y-m-d H:i'))+59);
        $data=$data
            ->leftjoin('users','message.user_id','=','users.id')
            ->whereBetween('push_time',[$start_time,$end_time])
            ->select('message.*','users.mobile')
            ->get();
        foreach($data as $key=>$value){
            $ret=$this->create_push('还款提醒','您有'.$value->amount.'元欠款需要处理！',$value->mobile);
            if($ret){
                $push_log=new PushLog();
                $push_log->push_mobile=$value->mobile;
                $push_log->push_title='还款提醒';
                $push_log->push_content='您有'.$value->amount.'元欠款需要处理！';
                $push_log->save();

                //循环周期
                $message=Message::find($value->id);
                switch ($value->rep_id){
                    case 2:
                        $message->push_time=date('Y-m-d H:i:s',strtotime($message->push_time)+3600*24*7);
                        break;
                    case 9:
                        $message->push_time=date('Y-m-d H:i:s',strtotime($message->push_time)+1800);
                        break;
                    case 3:
                        $message->push_time=date('Y-m-d H:i:s',strtotime($message->push_time)+3600*24*7*2);
                        break;
                    case 4:
                        $message->push_time=date('Y-m-d H:i:s',strtotime("+1 months",strtotime($message->push_time)));
                        break;
                    case 5:
                        $message->push_time=date('Y-m-d H:i:s',strtotime("+2 months",strtotime($message->push_time)));
                        break;
                    case 7:
                        $message->push_time=date('Y-m-d H:i:s',strtotime("+3 months",strtotime($message->push_time)));
                        break;
                    case 8:
                        $message->push_time=date('Y-m-d H:i:s',strtotime("+6 months",strtotime($message->push_time)));
                        break;
                }
                $message->save();

            }
        }
    }
}
