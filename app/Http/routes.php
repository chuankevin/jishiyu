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
	Route::controller('admin/message', 'MessageController');
	Route::controller('admin/feedback', 'FeedBackController');
	Route::controller('admin/bank', 'BankController');
	Route::controller('admin/banner', 'BannerController');
	Route::controller('admin/pushlog', 'PushLogController');
	Route::controller('admin/product', 'ProductController');
	Route::controller('admin/share', 'ShareController');
	Route::controller('admin/bootpage', 'BootPageController');
	Route::controller('admin/appupdate', 'AppUpdateController');
});

Route::group(['namespace' => 'Api', 'middleware' => ['web']], function () {
	Route::controller('api/alipay', 'AlipayController');
	Route::controller('api/cashbus', 'CashbusController');
	Route::controller('api/toutiao', 'TouTiaoController');
	Route::controller('api/message', 'MessageController');
	Route::controller('api/jpush', 'JPushController');
	Route::controller('api/feedback', 'FeedBackController');
	Route::controller('api/bank', 'BankController');
	Route::controller('api/banner', 'BannerController');
	Route::controller('api/userinfo', 'UserInfoController');
	Route::controller('api/product', 'ProductController');

});
