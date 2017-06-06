<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Models\FeedBack;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class FeedBackController extends ApiController
{
    public function postAdd(Request $request){
        $user_id=$request->user_id;
        if(!$user_id){
            return $this->msg('0001','用户id不存在');
        }
        $problem=$request->problem;
        if(!$problem){
            return $this->msg('0002','问题参数不存在');
        }

        $data=new FeedBack();
        $data->user_id=$user_id;
        $data->problem=$problem;

        $path='./upload/';
        $upFilePath = md5(date('ymdhis').rand(100000,999999)).".jpg";
        $ret=move_uploaded_file($_FILES['photo']['tmp_name'],$path.$upFilePath);
        if($ret){
            $data->img='/upload/'.$upFilePath;
        }
        //$data->img=json_encode($_FILES);
        $data->mobile=$request->mobile;
        $data->email=$request->email;
        if($data->save()){
            return $this->msg('0000','成功');
        }
    }

}
