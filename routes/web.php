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
    Route::group(['middleware'=>['CheckLogin','CheckAuth']],function() {

        //首页
        Route::get('index','IndexController@index');
        //注销
        Route::get('logout','IndexController@logout')->name('logout');


        /*************************** 帐号管理 *****************************/
        Route::group(['prefix'=>'admin'],function() {



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
        });


        /***************************角色管理*****************************/
        Route::group(['prefix'=>'role'],function() {
            Route::get('index','RoleController@index');
            Route::get('add','RoleController@addView');
            Route::post('add','RoleController@add');
            Route::get('edit/{id}','RoleController@editView')->where(['\d+']);
            Route::put('edit','RoleController@edit');
            Route::post('changeStatus','RoleController@changeStatus');
                Route::get('dirbutePermissionView','RoleController@dirbutePermissionView');
            Route::post('dirbutePermission','RoleController@dirbutePermission');
            //删除角色
            Route::delete('delete','RoleController@delete');
        });



        /***************************权限管理*****************************/
        Route::group(['prefix'=>'permission'],function() {
            Route::get('index','PermissionController@index');
            Route::get('add','PermissionController@addView');
            Route::post('add','PermissionController@add');
            Route::get('edit/{id}','PermissionController@editView')->where(['\d+']);
            Route::put('edit','PermissionController@edit');
            //删除权限
            Route::delete('delete','permissionController@delete');

        });
    });
});




Route::get('md5',function() {
    echo password_hash('123456',PASSWORD_DEFAULT);
});