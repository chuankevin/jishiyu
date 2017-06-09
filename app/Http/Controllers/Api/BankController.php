<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Models\Bank;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class BankController extends ApiController
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * 银行列表
     */
    public function postList(Request $request){
        $data=new Bank();
        $data=$data
            ->get();
        return $this->msg('0000','成功',['data'=>$data]);
    }

}
