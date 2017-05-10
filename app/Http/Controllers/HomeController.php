<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

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
}
