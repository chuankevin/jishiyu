<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use JPush\Client as JPush;

class JPushController extends ApiController
{
    public static $app_key = 'fa0d81922f79360b1f440714';
    public static $master_secret = '0b232f731af2bfaf59acdc80';

    public static function create_push(Request $request){
        //初始化
        $client=new JPush(self::$app_key,self::$master_secret,null);
        $push=$client->push();

        $platform = array('ios');
        $alert = 'Hello JPush';
        $alias = array('13691458151');

        //$regId = array('rid1', 'rid2');
        $ios_notification = array(
            'sound' => 'hello jpush',
            'badge' => +1,
            'content-available' => true,
            'category' => 'jiguang',
            'extras' => array(
                'key' => 'value',
                'jiguang'
            ),
        );
        $content = 'Hello World';
        $message = array(
            'title' => 'hello jpush',
            'content_type' => 'text',
            'extras' => array(
                'key' => 'value',
                'jiguang'
            ),
        );
        $options = array(
            'sendno' => 100,
            'time_to_live' => 100,
            'override_msg_id' => 100,
            'big_push_duration' => 100
        );
        $response = $push->setPlatform($platform)
            ->addAlias($alias)
            //->addRegistrationId($regId)
            ->iosNotification($alert, $ios_notification)
            ->message($content, $message);
            //->options($options)

        try {
            $response->send();
        } catch (\JPush\Exceptions\JPushException $e) {
            // try something else here
            print $e;
        }

    }

    public static  function push(){
        self::create_push();
    }
}
