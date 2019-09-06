<?php
namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\model\Admin;
use Tools\AdminLogin;
use Session;


/**
 * Class LoginController
 * @package App\Http\Controllers\admin
 * 登陆控制器
 */
class LoginController extends Controller
{

    use AdminLogin;

    protected $adminModel;

    public function __construct()
    {
        //防止重复登录
        if(Session::exists('admin')) {
            return redirect('/index');
        }
        $this->adminModel = new Admin();
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 登陆界面
     */
    public function login() {
       return view('/admin/login/login');
    }


    /**
     * @param LoginRequest $request
     * 登录动作
     */
    public function sign(LoginRequest $request) {
        $account = $request->post('account','addslashes');
        $password = $request->post('password','addslashes');
        $admin = $this->adminModel->login($account,$password);

        if(!$admin) {
            return Json_print('001','登陆失败');
        }
        $isDeny = $this->adminModel->getStatus($admin['id']);
        if(!$isDeny) {
            return Json_print('001','账号被禁用 - 请联系管理员SteffenKong');
        }

        Session::put('admin',$admin);

        //检测是否在登录
        if($this->checkIsLoginExists($admin['id'])) {
            //检测到已有人登录
            return Json_print('001','不能多点登录');
        }

        //记录redis
        $this->setLoginStatus($admin['id']);

        return Json_print('000','登陆成功');
    }
}
