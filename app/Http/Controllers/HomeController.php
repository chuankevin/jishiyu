<?php

namespace App\Http\Controllers;


use App\Models\RoleMenu;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use Maatwebsite\Excel\Facades\Excel;

class HomeController extends Controller
{
    public $port='80';

    public function __construct()
    {
        //登录判断
        $admin_user=session('admin_user');
        if(!$admin_user){
            echo "<script> location.href='/admin/login' </script>";
        }
        view()->share(compact('admin_user'));

        //访问权限控制
        $url=URL::current();
        $path=parse_url($url)['path'];
        $path=explode('/',$path);
        $controller=$path[2];
        //$action=$path[3];
        $menuList = RoleMenu::getMenuList($admin_user->id);

        if(!RoleMenu::hasMenuCategory($menuList,$controller,'controller')){
            $c=$menuList[0]->controller;
            echo "<script> location.href='/admin/".$c."/list' </script>";

        }
    }

    public function export($filename,$title,$data){
        //dd($data);
        $ret=Excel::create($filename, function($excel) use ($title,$data) {

            // Set the title
            $excel->setTitle($title);
            $excel->sheet('sheet1', function($sheet) use ($data){
                $sheet->rows($data);
            });

        })->store('xls','./excel/exports',true);
        return response()->json(['url'=>'http://'.$_SERVER['SERVER_NAME'].':'.$this->port.'/excel/exports/'.$ret['file']]);

    }


}
