<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\HomeController;
use App\Models\Order;
use App\Models\ScoreProduct;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ScoreProductController extends HomeController
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 商品列表
     */
    public function getList(Request $request){
        $data=new ScoreProduct();

        $data=$data->paginate(15);

        return view('admin.scoreproduct.list',compact('data'));
    }

    /**
     * @param Request $request
     * @return $this|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 新增商品
     */
    public function anyAdd(Request $request){
        if($request->isMethod('post')){
            $data=new ScoreProduct();
            $data->sku_name=$request->sku_name;
            $data->price=$request->price;
            $data->img=$request->img_path;
            if($data->save()){
                return view('admin.scoreproduct.add')->with('msg','新增商品成功');
            }
        }else{
            return view('admin.scoreproduct.add');
        }
    }

    /**
     * @param Request $request
     * @return $this|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 编辑商品
     */
    public function anyEdit(Request $request){
        $data=ScoreProduct::find($request->id);
        if($request->isMethod('post')){
            $data->sku_name=$request->sku_name;
            $data->price=$request->price;
            $data->img=$request->img_path;
            if($data->save()){
                return view('admin.scoreproduct.add')->with('msg','编辑商品成功');
            }
        }else{

            return view('admin.scoreproduct.edit',compact('data'));
        }
    }

    /**
     * @param Request $request
     * @return mixed
     * 删除商品
     */
    public function postDelete(Request $request){
        $id=$request->id;
        $data=ScoreProduct::find($id);
        if($data->delete()){
            return response()->json(['msg'=>'删除成功']);
        }else{
            return response()->json(['msg'=>'删除失败']);
        }
    }


    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 兑换记录
     */
    public function getOrderlist(Request $request){
        $data=new Order();
        //时间筛选
        $start_time=$request->start_time;
        $end_time=$request->end_time;
        if($start_time!=''){
            $data=$data->where('order.created_at','>=',$start_time);
        }
        if($end_time!=''){
            $end=date('Y-m-d',strtotime($end_time)+3600*24);
            $data=$data->where('order.created_at','<',$end);
        }
        //订单号筛选
        $order_code=$request->order_code;
        if($order_code!=''){
            $data=$data->where('order_code','like','%'.$order_code.'%');
        }
        //手机号筛选
        $mobile=$request->mobile;
        if($mobile!=''){
            $data=$data->where('mobile',$mobile);
        }
        //状态筛选
        $status=$request->status;
        if($status!=''){
            $data=$data->where('order.status',$status);
        }

        $data=$data
            ->leftjoin('score_product','order.sku_id','=','score_product.id')
            ->select('order.*','score_product.sku_name')
            ->paginate(15);
        return view('admin.scoreproduct.orderlist',compact('data','start_time','end_time','order_code','mobile','status'));
    }

    public function postGrant(Request $request){
        $id=$request->id;
        $data=Order::find($id);
        $data->status=2;
        if($data->save()){
            return response()->json(['code'=>0000,'msg'=>'状态更新成功']);
        }
    }


}
