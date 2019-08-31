<?php

namespace App\Http\Controllers\admin;

use App\model\Permission;
use App\Http\Controllers\Controller;
use Tools\Loader;
use View;

/**
 * Class AdminController
 * @package App\Http\Controllers\admin
 * 基础控制器
 */
class BaseController extends Controller
{
    /**
     * BaseController constructor.
     * 在构造方法执行的时候web中间件还未执行因此无法使用session
     * 但我们可以在构造方法内通过定义中间件来使用session
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->getMenu();
            return $next($request);
        });
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 展示左侧栏
     */
    public function getMenu() {
        $admin = session('admin');
        /* @var Permission $permissionModel */
        $permissionModel = Loader::sigltion(Permission::class);
        $menus = [];
        if($admin['roleId'] != 0)
        {
            //获取普通管理员的权限工具栏
            $menusData = $permissionModel->getPermissionsByRoleId($admin['roleId']);
            //只取前两级数据
            $tmpTree = getTree($menusData);
            $data = [];
            foreach ($tmpTree ?? [] as $key=>$value) {
                if($value['level'] > 1) continue;
                $data[] = [
                    'id'=>$value['id'],
                    'permissionName'=>$value['permissionName'],
                    'route'=>$value['route'],
                    'pid'=>$value['pid']
                ];
            }
            $menus = getTreeList($data);
        }else {
            //获取超级管理员的权限工具栏
            $adminMenusData = $permissionModel->getPermissionByAdmin();
            //只取前两级数据
            $tmpTree = getTree($adminMenusData);
            $data = [];
            foreach ($tmpTree ?? [] as $key=>$value) {
                if($value['level'] > 1) continue;
                $data[] = [
                    'id'=>$value['id'],
                    'permissionName'=>$value['permissionName'],
                    'route'=>$value['route'],
                    'pid'=>$value['pid']
                ];
            }
            $menus = getTreeList($data);
        }

        //全局模板共享这个变量
        View::share('menus',$menus);
    }
}