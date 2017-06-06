<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Models\Banner;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class BannerController extends ApiController
{
    public function postList(Request $request){
        $data=new Banner();
        $data=$data->get();
        return $this->msg('0000','成功',['data'=>$data]);
    }
}
