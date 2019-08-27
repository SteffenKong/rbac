<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Tools\Loader;

class PermissionController extends Controller
{
    protected $permissionModel;

    public function __construct()
    {
        $this->permissionModel = Loader::sigltion(Permission::class);
    }


    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 获取权限列表
     */
    public function getList(Request $request) {
        $where['permissionName'] = trim($request->get('permissionName',''));
        $where['url'] = trim($request->get('url',''));
        $list = $this->permissionModel->getList($where);
        return view('/admin/role/index',compact('list'));
    }
}
