<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class AlipayController extends ApiController
{
    /**
     * @param Request $request
     * 芝麻信用授权回调
     */
    public function anyAuthorize(Request $request){
        //dd($request->all());
    }
}
