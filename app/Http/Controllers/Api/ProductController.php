<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Models\ProductData;
use App\Models\Products;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ProductController extends ApiController
{
    public function postList(Request $request){
        $data=new Products();
        $data1=$data
            ->where(['type'=>1,'status'=>1])
            ->orderBy('order','asc')
            ->get();

        foreach($data1 as $key=>$value){
            $product_data=ProductData::whereIn('id',$value->data_id)->get();
            $data_name=array();
            foreach($product_data as $k=>$v){
                $data_name[]=$v->data_name;
            }
            $value['data_name']=$data_name;
        }


        $data2=$data
            ->where(['type'=>2,'status'=>1])
            ->orderBy('order','asc')
            ->get();

        foreach($data1 as $key=>$value){
            $product_data=ProductData::whereIn('id',$value->data_id)->get();
            $data_name=array();
            foreach($product_data as $k=>$v){
                $data_name[]=$v->data_name;
            }
            $value['data_name']=$data_name;
        }

        return $this->msg('0000','成功',['recommend'=>$data1,'quick'=>$data2]);
    }
}
