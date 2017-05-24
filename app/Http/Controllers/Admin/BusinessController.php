<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\HomeController;
use App\Models\Business;
use App\Models\BusinessProperties;
use App\Models\BusinessPropertyName;
use App\Models\BusinessPropertyType;
use App\Models\BusinessTags;
use App\Models\HitsLog;
use App\Models\Tags;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class BusinessController extends HomeController
{
    /**
     * @param Request $request
     * @return mixed
     * 业务列表
     */
    public function getList(Request $request){
        $data=new Business();
        //条件筛选
        $keywords=$request->keywords;
        if($keywords!=''){
            $data=$data->where('post_title','like','%'.$keywords.'%');
        }
        $post_status=isset($request->post_status) ? $request->post_status : 1;
        if($post_status!=''){
            $data=$data->where('post_status',$post_status);
        }else{
            $data=$data->where('post_status',1);
        }
        //业务数据
        $data=$data
            //->where('post_status',1)
            ->orderBy('post_date','desc')
            ->select('id','post_title','post_hits','edufanwei','feilv','qixianfanwei','zuikuaifangkuan','smeta','post_date','link','post_status','listorder')
            ->paginate(10);

        return view('admin.business.list',compact('data','keywords','post_status'));
    }

    /**
     * @param Request $request
     * @return mixed
     * @throws Exception
     * 添加业务
     */
    public function anyAdd(Request $request){
        if($request->isMethod('post')){
//dd($request->all());
            DB::beginTransaction();
            try {
                //维护业务数据
                $data=new Business();
                $data->post_title=$request->post_title;
                $data->post_excerpt=$request->post_excerpt;
                $data->edufanwei=$request->edufanwei;
                $data->feilv=$request->feilv;
                $data->fv_unit=$request->fv_unit;
                $data->qixianfanwei=$request->qixianfanwei;
                $data->qx_unit=$request->qx_unit;
                $data->zuikuaifangkuan=$request->zuikuaifangkuan;
                $data->shenqingtiaojian=$request->shenqingtiaojian;
                $data->link=$request->link;
                $data->link_h5=$request->link_h5;
                $data->smeta=json_encode(['thumb'=>$request->img_path]);
                $data->post_date=date('Y-m-d H:i:s');
                $data->post_modified=date('Y-m-d H:i:s');
                $data->save();

                $arr=array();//存属性
                $properties=BusinessPropertyType::get();//属性数据
                foreach($properties as $property){
                    $value=$property->type_name_en;
                    $arr[]=$request->$value;
                }
                //维护属性数据
                $business_pro=new BusinessProperties();
                foreach($arr as $v){
                    foreach($v as $vv){
                        $business_pro->insert(['business_id'=>$data->id,'property_id'=>$vv]);
                      /*  $business_pro->business_id=$data->id;
                        $business_pro->property_id=$vv;
                        $business_pro->save();*/
                    }
                }
                //维护标签
                $tags=$request->tags;
                foreach ($tags as $tag){
                    BusinessTags::insert([
                        'business_id'=>$data->id,
                        'tag_id'=>$tag,
                        'created_at'=>date('Y-m-d H:i:s'),
                        'updated_at'=>date('Y-m-d H:i:s'),
                    ]);
                }

                DB::commit();

                $property_type=BusinessPropertyType::get();
                foreach($property_type as $value){
                    $value['data']=BusinessPropertyName::where('property_type',$value['type_id'])->get();
                }
                //标签
                $tags=Tags::get();
                return view('admin.business.add',compact('property_type','tags'))->with('msg','添加业务成功！');

            } catch (Exception $e){
                DB::rollback();
                throw $e;
            }

        }else{
            //属性
            $property_type=BusinessPropertyType::get();
            foreach($property_type as $value){
                $value['data']=BusinessPropertyName::where('property_type',$value['type_id'])->get();
            }
            //标签
            $tags=Tags::get();

            return view('admin.business.add',compact('property_type','tags'));
        }

    }

    /**
     * @param Request $request
     * @return mixed
     * @throws Exception
     * 编辑业务
     */
    public function anyEdit(Request $request){
        $id=$request->id;
        if($request->isMethod('post')){;
            DB::beginTransaction();
            try {
                //维护业务数据
                $data=Business::find($id);
                $data->post_title=$request->post_title;
                $data->post_excerpt=$request->post_excerpt;
                $data->edufanwei=$request->edufanwei;
                $data->feilv=$request->feilv;
                $data->fv_unit=$request->fv_unit;
                $data->qixianfanwei=$request->qixianfanwei;
                $data->qx_unit=$request->qx_unit;
                $data->zuikuaifangkuan=$request->zuikuaifangkuan;
                $data->shenqingtiaojian=$request->shenqingtiaojian;
                $data->link=$request->link;
                $data->link_h5=$request->link_h5;
                $data->smeta=json_encode(['thumb'=>$request->img_path]);
                $data->post_modified=date('Y-m-d H:i:s');
                $data->save();

                $arr=array();//存属性
                $properties=BusinessPropertyType::get();//属性数据
                foreach($properties as $property){
                    $value=$property->type_name_en;
                    $arr[]=$request->$value;
                }
                //维护属性数据
                BusinessProperties::where('business_id',$id)->delete();
                $business_pro=new BusinessProperties();
                foreach($arr as $v){
                    foreach($v as $vv){
                        $business_pro->insert(['business_id'=>$id,'property_id'=>$vv]);
                    }
                }
                //维护标签
                BusinessTags::where('business_id',$id)->delete();
                $tags=$request->tags;
                foreach ($tags as $tag){
                    BusinessTags::insert([
                        'business_id'=>$data->id,
                        'tag_id'=>$tag,
                        'created_at'=>date('Y-m-d H:i:s'),
                        'updated_at'=>date('Y-m-d H:i:s'),
                    ]);
                }

                DB::commit();

                return Redirect::to('admin/business/list');

            } catch (Exception $e){
                DB::rollback();
                throw $e;
            }

        }else{
            //回显业务数据
            $data=Business::find($id);
            $properties=BusinessProperties::where('business_id',$id)->get();
            $property_type=BusinessPropertyType::get();
            foreach($property_type as $value){
                $value['data']=BusinessPropertyName::where('property_type',$value['type_id'])->get();
            }
            //标签
            $tags=Tags::get();
            $business_tags=BusinessTags::where('business_id',$id)->get();
            return view('admin.business.edit',compact('property_type','data','properties','tags','business_tags'));
        }

    }

    /**
     * @param Request $request
     * @return mixed
     * 删除业务
     */
    public function getDelete(Request $request){
        $id=$request->id;
        $business=Business::find($id);
        if($business->delete()){
            return response()->json(['msg'=>'删除成功']);
        }else{
            return response()->json(['msg'=>'删除失败']);
        }

    }

    /**
     * @param Request $request
     * 排序
     */
    public function getOrder(Request $request){
        $id=$request->id;
        $order=$request->order;
        $business=Business::find($id);
        $business->listorder=$order;
        $business->save();

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * 产品上下架
     */
    public function getUpdate(Request $request){
        $id=$request->id;
        $status=$request->status;
        $business=Business::find($id);
        if($status==0){
            $business->post_status=1;
            if($business->save()){
                return response()->json(['msg'=>'上架成功']);
            }else{
                return response()->json(['msg'=>'上架失败']);
            }
        }elseif ($status==1){
            $business->post_status=0;
            if($business->save()){
                return response()->json(['msg'=>'下架成功']);
            }else{
                return response()->json(['msg'=>'下架失败']);
            }
        }
    }

    /**
     * @param Request $request
     * 上传图片
     */
    public function postImg(Request $request){
        $path='./upload/';
        $upFilePath = md5(date('ymdhis').rand(100000,999999)).".jpg";
        $ok=move_uploaded_file($_FILES['fileToUpload']['tmp_name'],$path.$upFilePath);

       if($ok === FALSE){
            echo json_encode(['msg'=>'0','file_url'=>'http://'.$_SERVER['SERVER_NAME'].':82'.'/upload/'.$upFilePath,'path'=>$upFilePath]);
        }else{
            echo json_encode(['msg'=>'1','file_url'=>'http://'.$_SERVER['SERVER_NAME'].':82'.'/upload/'.$upFilePath,'path'=>$upFilePath]);
        }
    }

    /**
     * @param Request $request
     * @return mixed
     * 业务点击量
     */
    public function getHitslist(Request $request){
        $data=new HitsLog();
        //条件筛选
       /* $keywords=$request->keywords;
        if($keywords!=''){
            $data=$data->where('post_title','like','%'.$keywords.'%');
        }*/
        $start_time=$request->start_time;
        $end_time=$request->end_time;
        if($start_time!=''){
            $data=$data->where('created_at','>=',$start_time);
        }
        if($end_time!=''){
            $end=date('Y-m-d',strtotime($end_time)+3600*24);
            $data=$data->where('created_at','<=',$end);
        }
        //业务数据
        $data=$data
            ->leftjoin('business','hits_log.business_id','=','business.id')
            ->where('business.post_status',1)
            ->select('hits_log.*','business.post_title',DB::raw('SUM(hits) as count'))
            ->groupBy('business_id')
            ->orderBy('hits_log.id')
            ->paginate(10);

        return view('admin.business.hitslist',compact('data','start_time','end_time'));
    }
}
