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
    public $app_key = 'fa0d81922f79360b1f440714';
    public $master_secret = '0b232f731af2bfaf59acdc80';

    public function create_push($title,$msg,$user){
        //初始化
        $client=new JPush($this->app_key,$this->master_secret,null);
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
            $ret=$this->create_push('还款提醒','您有'.$value->amount.'元欠款需要处理！',$value->mobile);
            if($ret){
                $data=new PushLog();
                $data->push_mobile=$value->mobile;
                $data->push_title='还款提醒';
                $data->push_content='您有'.$value->amount.'元欠款需要处理！';
                $data->save();
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
                $data=new PushLog();
                $data->push_mobile=$value->mobile;
                $data->push_title='还款提醒';
                $data->push_content='您有'.$value->amount.'元欠款需要处理！';
                $data->save();
            }
        }
    }
}
