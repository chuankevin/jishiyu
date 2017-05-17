<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Models\ToutiaoCallbackLog;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class TouTiaoController extends ApiController
{
    public function postReceived(Request $request){
        $data=new ToutiaoCallbackLog();
        $data->info=json_encode($request->all());
        $data->save();
    }
}
