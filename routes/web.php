<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::group(['namespace'=>'admin'],function() {

    //登录
    Route::get('login','LoginController@login')->name('login');
    Route::post('sign','LoginController@sign');


    //检测是否登录的中间件
    Route::group(['middleware'=>['CheckLogin']],function() {

        //首页
        Route::get('index','IndexController@index');
        //注销
        Route::get('logout','IndexController@logout')->name('logout');

        //前缀为admin的路由
        Route::group(['prefix'=>'admin'],function() {

            /*************************** 帐号管理 *****************************/

            //账号列表
            Route::get('index','AdminController@index');

            //账号添加界面
            Route::get('add','AdminController@addView');
            Route::post('add','AdminController@add');

            //编辑
            Route::get('edit/{id}','AdminController@editView')->where(['\d+']);
            Route::put('edit','AdminController@edit');
            Route::post('changeStatus','AdminController@changeStatus');
            Route::post('changePass','AdminController@changePass');

            //删除帐号
            Route::delete('delete','AdminController@delete');


            /***************************角色管理*****************************/



            /***************************权限管理*****************************/
        });
    });
});




Route::get('md5',function() {
    echo password_hash('123456',PASSWORD_DEFAULT);
});