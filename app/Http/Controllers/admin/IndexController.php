<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Session;

/**
 * Class IndexController
 * @package App\Http\Controllers\admin
 * 首页控制器
 */
class IndexController extends BaseController
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 首页界面
     */
    public function index() {
        return view('/admin/index/index');
    }


    /**
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * 注销
     */
    public function logout() {
        Session::forget('admin');
        return redirect(route('login'));
    }
}
