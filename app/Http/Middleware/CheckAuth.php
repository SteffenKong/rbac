<?php

namespace App\Http\Middleware;

use App\model\Permission;
use Closure;
use Session;
use Tools\Loader;

/**
 * Class CheckAuth
 * @package App\Http\Middleware
 * 鉴权中间件
 */
class CheckAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //定义白名单
       $white = [
           '/login',
           '/sign',
           '/index',
           '/logout'

       ];

       $domain = config('miss.domain');
       $url = $request->url();
       $domainIndex = strlen($domain)-1;
       $routeName = substr($url,$domainIndex);
        $admin = session('admin');
        if(strpos($routeName,'captcha') === false && strpos($routeName,'edit') === false) {
            if (!in_array($routeName, $white) && $admin['roleId'] != 0) {
                //取出当前用户的角色的拥有权限
                /* @var Permission $permissionModel */
                $permissionModel = Loader::sigltion(Permission::class);
                $curPermission = $permissionModel->getPermissionsByRoleId($admin['roleId']);
                if (!in_array($routeName, array_column($curPermission,'route'))) {
                    return redirect('/index');
                }
            }
        }
       return $next($request);
    }
}
