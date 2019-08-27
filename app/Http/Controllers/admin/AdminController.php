<?php

namespace App\Http\Controllers\admin;

use App\Http\Requests\Admin\AdminEditRequest;
use App\Http\Requests\Admin\AdminRequest;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\model\Admin;
use Tools\Loader;

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
//        $this->adminModel = new Admin();
        $this->adminModel = Loader::sigltion(Admin::class);
    }


    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 账号列表
     */
    public function index(Request $request) {
        $pageSize = $request->get('pageSize',config('miss.pagesize'));
        $where['account'] = trim($request->get('account',''));
        $list = $this->adminModel->getList($pageSize,$where);
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
    public function edit(AdminEditRequest $request) {
        $data = $request->all();

        if($this->adminModel->getColumnValIsExistsById($data['id'],'account',$data['account'])) {
            return Json_print('001','账号已存在');
        }

        if($this->adminModel->getColumnValIsExistsById($data['id'],'email',$data['email'])) {
            return Json_print('001','邮箱已存在');
        }

        if($this->adminModel->getColumnValIsExistsById($data['id'],'phone',$data['phone'])) {
            return Json_print('001','手机已存在');
        }

        if($this->adminModel->getColumnValIsExistsById($data['id'],'nick_name',$data['nickName'])) {
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

        $password = '';
        if(empty($data['password'])) {
            $password = $this->adminModel->getOldPass($data['id']);
        }else {
            $password = password_hash($data['password'],PASSWORD_DEFAULT);
        }


        $res = $this->adminModel->edit($data['id'],$data['account'],$password ,$data['nickName'],$data['email'],$data['phone'],$status,$roleId);

        if(!$res) {
            return Json_print('001','编辑失败');
        }
        return Json_print('000','编辑成功');
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
    public function delete(Request $request) {
        $id = $request->all('id');
        if(empty($id['id'])) {
            return Json_print('001','id非法');
        }

        $isSuper = $this->adminModel->isSuperAdmin(intval($id['id']));
        if($isSuper) {
            return Json_print('001','超级管理员不能删除');
        }

        $res = $this->adminModel->delData(intval($id['id']));
        if(!$res) {
            return Json_print('001','删除失败');
        }
        return Json_print('000','删除成功');
    }


    /**
     * @param int $id
     * @return false|string
     * 修改帐号状态
     */
    public function changeStatus(Request $request) {
        $id = $request->post('id');
        if(empty($id)) {
            return Json_print('001','id非法');
        }
        $res = $this->adminModel->changeStatus(intval($id));
        if(!$res) {
            return Json_print('001','修改状态失败');
        }
        return Json_print('000','修改状态成功');
    }


    /**
     * @param int $id
     * @return false|string
     * 修改密码
     */
    public function changePass(Request $request) {
        $id = $request->post('id');
        $password = $request->get('password');
        if(empty($id)) {
            return Json_print('001','id非法');
        }

        if(empty($password)) {
            return Json_print('001','密码不能为空');
        }


        $res = $this->adminModel->changePassword(intval($id),$password);
        if(!$res) {
            return Json_print('001','密码修改失败');
        }
        return Json_print('000','密码修改成功');
    }
}
