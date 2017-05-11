<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Maatwebsite\Excel\Facades\Excel;

class HomeController extends Controller
{
    //
    public function __construct()
    {
        $admin_user=session('admin_user');
        if(!$admin_user){
            echo "<script> location.href='/admin/login' </script>";
        }
        view()->share(compact('admin_user'));
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
        return response()->json(['url'=>'http://'.$_SERVER['SERVER_NAME'].'/excel/exports/'.$ret['file']]);

    }
}
