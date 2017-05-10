<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\HomeController;
use App\Models\AppActivate;
use App\Models\Channel;
use App\Models\ChannelNo;
use App\Models\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ChannelController extends HomeController
{

    /**
     * @param Request $request
     * @return mixed
     * 基础渠道列表
     */
    public function getList(Request $request){
        $data=new Channel();
        //条件筛选
        $keywords=$request->keywords;
        if($keywords!=''){
            $data=$data->where('name','like','%'.$keywords.'%');
        }

        //渠道信息
        $data=$data
            ->orderBy('create_at','desc')
            ->select('id','name','lv','create_at','is_delete')
            ->paginate(10);

        return view('admin.channel.list',compact('data','keywords'));
    }

    /**
     * @param Request $request
     * @return mixed
     * 添加渠道
     */
    public function anyAdd(Request $request){
        if($request->isMethod('post')){

            $channel=new Channel();
            $channel->name=$request->name;
            $channel->lv=$request->lv;
            $channel->pid=$request->pid ? $request->pid : 0;
            $channel->is_delete=0;
            $channel->create_at=date('Y-m-d H:i:s');
            $channel->update_at=date('Y-m-d H:i:s');
            $channel->remark=isset($request->remark) ? $request->remark : '';
            if($channel->save()){
                //一级渠道
                $channel1=Channel::where(['is_delete'=>0,'lv'=>1])
                    ->orderBy('create_at','desc')
                    ->get();
                return view('admin.channel.add',compact('channel1'))->with('msg','添加渠道成功');
            }


        }else{
            //一级渠道
            $channel1=Channel::where(['is_delete'=>0,'lv'=>1])
                ->orderBy('create_at','desc')
                ->get();
            return view('admin.channel.add',compact('channel1'));
        }
    }


    /**
     * @param Request $request
     * @return mixed
     * 获取下级渠道
     */
    public function postLv(Request $request){
        $pid=$request->pid;
        $channels=Channel::where(['pid'=>$pid,'is_delete'=>0])
            ->orderBy('create_at','desc')
            ->get();
        return response()->json($channels);
    }

    /**
     * @param Request $request
     * @return mixed
     * @throws Exception
     * 生成渠道号
     */
    public function anyAddno(Request $request){
        if($request->isMethod('post')){
           //dd($request->all());

            DB::beginTransaction();
            try {
                $data=new ChannelNo();
                $data->lv1=$request->lv1;
                $data->lv2=$request->lv2;
                $data->lv3=$request->lv3;
                $data->lv4=$request->lv4;
                $data->lv5=$request->lv5;
                $data->is_delete=0;
                $data->create_at=date('Y-m-d H:i:s');
                $data->update_at=date('Y-m-d H:i:s');
                $data->save();

                $data->no="QD".str_pad($data->id,4,"0",STR_PAD_LEFT );
                $data->save();
                DB::commit();

                $channel1=Channel::where(['is_delete'=>0,'lv'=>1])
                    ->orderBy('create_at','desc')
                    ->get();
                return view('admin.channel.addno',compact('channel1'))->with('msg','生成渠道号成功');

            } catch (Exception $e){
                DB::rollback();
                throw $e;
            }


        }else{
            //一级渠道
            $channel1=Channel::where(['is_delete'=>0,'lv'=>1])
                ->orderBy('create_at','desc')
                ->get();
            return view('admin.channel.addno',compact('channel1'));
        }
    }

    /**
     * @param Request $request
     * @return mixed
     * 渠道号列表
     */
    public function getNolist(Request $request){
        $data=new ChannelNo();

        //dd($users->where('channel','QD0007')->count());
        $keywords=$request->keywords;
        if($keywords!=''){
            $data=$data->where('no','like','%'.$keywords.'%');
        }

        //渠道信息
        $data=$data
            ->orderBy('create_at','desc')
            ->select('id','no','lv1','lv2','lv3','lv4','lv5','create_at','is_delete')
            ->paginate(10);

        foreach($data as $k=>$v){
            $users=new User();
            //条件筛选
            $start_time=$request->start_time;
            $end_time=$request->end_time;
            if($start_time!=''){
                $users=$users->where('create_time','>=',$start_time);
            }
            if($end_time!=''){
                $end=date('Y-m-d',strtotime($end_time)+3600*24);
                $users=$users->where('create_time','<=',$end);
            }
            //注册数量
            $num=$users->where('channel',$v->no)->count();
            $data[$k]['count']=$num;
            //激活量
            $activate=new AppActivate();
            if($start_time!=''){
                $activate=$activate->where('created_at','>=',$start_time);
            }
            if($end_time!=''){
                $end=date('Y-m-d',strtotime($end_time)+3600*24);
                $activate=$activate->where('updated_at','<=',$end);
            }
            $activate=$activate->where('channel',$v->no)->count();
            $data[$k]['activate_count']=$activate;
            if($v['lv1']!=0){
                $data[$k]['lv1']=Channel::find($v['lv1'])['name'];
            }else{
                $data[$k]['lv1']='';
            }
            if($v['lv2']!=0){
                $data[$k]['lv2']=Channel::find($v['lv2'])['name'];
            }else{
                $data[$k]['lv2']='';
            }
            if($v['lv3']!=0){
                $data[$k]['lv3']=Channel::find($v['lv3'])['name'];
            }else{
                $data[$k]['lv3']='';
            }
            if($v['lv4']!=0){
                $data[$k]['lv4']=Channel::find($v['lv4'])['name'];
            }else{
                $data[$k]['lv4']='';
            }
            if($v['lv5']!=0){
                $data[$k]['lv5']=Channel::find($v['lv5'])['name'];
            }else{
                $data[$k]['lv5']='';
            }
        }

        return view('admin.channel.nolist',compact('data','keywords','start_time','end_time'));
    }

    /**
     * @param Request $request
     * @return mixed
     * 删除渠道号
     */
    public function getDelete(Request $request){
        $id=$request->id;
        $channelNo=ChannelNo::find($id);
        if($channelNo->delete()){
            return response()->json(['msg'=>'删除成功']);
        }else{
            return response()->json(['msg'=>'删除失败']);
        }

    }

    /**
     * @param Request $request
     * @return mixed
     * 禁用或启用渠道
     */
    public function postUpdate(Request $request){
        $id=$request->id;
        $is_delete=$request->is_delete;
        $channel=Channel::find($id);
        if($is_delete==0){
            //正常
            $channel->is_delete=1;
            if($channel->save()){
                return response()->json(['code'=>1,'msg'=>'禁用成功']);
            }else{
                return response()->json(['code'=>0,'msg'=>'禁用失败']);
            }
        }elseif ($is_delete==1){
            //禁用
            $channel->is_delete=0;
            if($channel->save()){
                return response()->json(['code'=>1,'msg'=>'启用成功']);
            }else{
                return response()->json(['code'=>0,'msg'=>'启用失败']);
            }
        }
    }
}
