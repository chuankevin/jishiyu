<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Models\Products;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ProductController extends ApiController
{
    public function postList(Request $request){
        $data=new Products();
        $data1=$data
            ->where('type',1)
            ->orderBy('order','asc')
            ->get();
        $data2=$data
            ->where('type',2)
            ->orderBy('order','asc')
            ->get();

        return $this->msg('0000','成功',['recommend'=>$data1,'quick'=>$data2]);
    }
}
