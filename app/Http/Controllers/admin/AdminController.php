<?php

namespace App\Http\Controllers\admin;

use App\Http\Requests\AdminRequest;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\model\Admin;


/**
 * Class AdminController
 * @package App\Http\Controllers\admin
 * 账号控制器
 */
class AdminController extends Controller
{
    protected $adminModel;

    public function __construct()
    {
        $this->adminModel = new Admin();
    }


    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 账号列表
     */
    public function index(Request $request) {
        $pageSize = $request->get('pageSize',config('miss.pagesize'));
        $list = $this->adminModel->getList($pageSize);
        return view('admin/admin/index',compact('list'));
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 账号添加界面
     */
    public function addView() {
        return view('/admin/admin/add');
    }


    /**
     * @param LoginRequest $request
     * @return false|string
     * 添加账号
     */
    public function add(AdminRequest $request) {
        $data = $request->all();

        if($this->adminModel->getColumnValIsExists('account',$data['account'])) {
            return Json_print('001','账号已存在');
        }

        if($this->adminModel->getColumnValIsExists('email',$data['email'])) {
            return Json_print('001','邮箱已存在');
        }

        if($this->adminModel->getColumnValIsExists('phone',$data['phone'])) {
            return Json_print('001','手机已存在');
        }

        if($this->adminModel->getColumnValIsExists('nick_name',$data['nickName'])) {
            return Json_print('001','真实名称已存在');
        }

        $status = 1;
        if(isset($data['status'])) {
            $status = 0;
        }

        $roleId = 0;
        if(!empty($data['roleId'])) {
            $roleId = $data['roleId'];
        }

        $res = $this->adminModel->add($data['account'],$data['password'],$data['nickName'],$data['email'],$data['phone'],$status,$roleId);
        if(!$res) {
            return Json_print('001','录入失败');
        }
        return Json_print('000','录入成功');
    }


    /**
     * @param LoginRequest $request
     * @return false|string
     * 编辑账号
     */
    public function edit(LoginRequest $request) {
        $data = $request->all();

        if($this->adminModel->getColumnValIsExists('account',$data['account'])) {
            return Json_print('001','账号已存在');
        }

        if($this->adminModel->getColumnValIsExists('email',$data['email'])) {
            return Json_print('001','邮箱已存在');
        }

        if($this->adminModel->getColumnValIsExists('phone',$data['phone'])) {
            return Json_print('001','手机已存在');
        }

        if($this->adminModel->getColumnValIsExists('nickName',$data['nickName'])) {
            return Json_print('001','真实名称已存在');
        }

        $status = 1;
        if(isset($data['status'])) {
            $status = 0;
        }

        $roleId = 0;
        if(!empty($data['roleId'])) {
            $roleId = $data['roleId'];
        }


        $res = $this->adminModel->edit($data['id'],$data['account'],$data['password'],$data['nickName'],$data['email'],$data['phone'],$status,$roleId);

        if(!$res) {
            return Json_print('001','录入失败');
        }
        return Json_print('000','录入成功');
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 显示编辑界面
     */
    public function editView(int $id) {
        $admin = $this->adminModel->getOne(intval($id));
        return view('/admin/admin/edit',compact('admin'));
    }


    /**
     * @param int $id
     * @return false|string
     * 删除账号
     */
    public function delete(int $id) {
        $res = $this->adminModel->delData(intval($id));
        if(!$res) {
            return Json_print('001','删除失败');
        }
        return Json_print('000','删除成功');
    }
}
