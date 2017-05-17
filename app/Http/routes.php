<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
 */

Route::get('/', function () {
	return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
 */

Route::group(['namespace' => 'Admin', 'middleware' => ['web']], function () {
	Route::controller('admin/index', 'IndexController');
	Route::controller('admin/login', 'LoginController');
	Route::controller('admin/user', 'UserController');
	Route::controller('admin/channel', 'ChannelController');
	Route::controller('admin/channelreg', 'ChannelRegController');
	Route::controller('admin/channelnopro', 'ChannelNoProController');
	Route::controller('admin/business', 'BusinessController');
	Route::controller('admin/card', 'CardController');
	Route::controller('admin/slide', 'SlideController');
	Route::controller('admin/slidecat', 'SlideCatController');
	Route::controller('admin/role', 'RoleController');
	Route::controller('admin/adminuser', 'AdminUserController');
	Route::controller('admin/applog', 'AppLogController');
});

Route::group(['namespace' => 'Api', 'middleware' => ['web']], function () {
	Route::controller('api/alipay', 'AlipayController');
	Route::controller('api/cashbus', 'CashbusController');
	Route::controller('api/toutiao', 'TouTiaoController');

});
