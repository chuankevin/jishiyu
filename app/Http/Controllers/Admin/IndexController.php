<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\HomeController;
use App\Models\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class IndexController extends HomeController
{

    /**
     * @return mixed
     * 后台首页
     */
    public function getIndex(){

        //总用户量
        $sum=User::count();
        //今日新增
        $today_sum=User::where('create_time','>',date('Y-m-d'))->count();
        //昨日新增
        $yesterday=date('Y-m-d',strtotime(date('Y-m-d'))-3600*24);
        $yesterday_sum=User::whereBetween('create_time',[$yesterday,date('Y-m-d')])->count();
        //周新增
        $week=date('Y-m-d',strtotime(date('Y-m-d'))-3600*24*7);
        $week_sum=User::where('create_time','>',$week)->count();
        //月新增
        $month=date('Y-m-d',strtotime(date('Y-m-d'))-3600*24*30);
        $month_sum=User::where('create_time','>',$month)->count();

        return view('admin/index/index',compact('sum','today_sum','yesterday_sum','week_sum','month_sum'));
    }
}
