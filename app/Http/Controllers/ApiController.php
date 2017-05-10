<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class ApiController extends Controller
{

    protected function msg($code,$msg,$data=[]){
        $ret=['code'=>$code,'msg'=>$msg,'data'=>$data];
        return response()->json($ret);
    }
}
