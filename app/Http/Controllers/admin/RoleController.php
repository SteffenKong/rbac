<?php

namespace App\Http\Controllers\admin;

use App\model\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Role\RoleRequest;
use App\model\Role;
use Tools\Loader;

/**
 * Class RoleController
 * @package App\Http\Controllers\admin
 * 角色控制器
 */
class RoleController extends BaseController
{
    /* @var Role $roleModel */
    protected $roleModel;

    /* @var Permission $roleModel */
    protected $permissionModel;

    public function __construct()
    {
        parent::__construct();
        $this->roleModel = Loader::sigltion(Role::class);
        $this->permissionModel = Loader::sigltion(Permission::class);
    }


    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 获取角色列表
     */
    public function index(Request $request) {
        $pageSize = $request->get('pageSize',config('miss.pagesize'));
        $where['roleName'] = trim($request->get('roleName',''));
        $list = $this->roleModel->getList($pageSize,$where);
        return view('/admin/role/index',compact('list'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 展示角色添加界面
     */
    public function addView() {
        return view('/admin/role/add');
    }


    /**
     * @param RoleRequest $request
     * @return false|string
     * 添加角色
     */
    public function add(RoleRequest $request) {
        $data = $request->post();
        $status = 1;
        if(!isset($data['status'])) {
            $status = 0;
        }
        $isExists = $this->roleModel->checkRoleNameIsExists($data['roleName']);
        if($isExists) {
            return Json_print('001','角色名称已存在');
        }

        $res = $this->roleModel->add($data['roleName'],$data['description'],$status);
        if(!$res) {
            return Json_print('001','录入失败');
        }
        return Json_print('000','录入成功');
    }


    /**
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 展示角色编辑界面
     */
    public function editView(int $id) {
        if(empty($id)) {
            return Json_print('001','ID非法');
        }
        $data = $this->roleModel->getOne(intval($id));
        return view('/admin/role/edit',compact('data','permissions'));
    }


    /**
     * @param RoleRequest $request
     * @return false|string
     * 编辑角色
     */
    public function edit(RoleRequest $request) {
        $data = $request->all();
        $status = 1;
        if(!isset($data['status'])) {
            $status = 0;
        }
        $isExists = $this->roleModel->checkRoleNameIsExistsById($data['id'],$data['roleName']);
        if($isExists) {
            return Json_print('001','角色名称已存在');
        }

        $res = $this->roleModel->edit($data['id'],$data['roleName'],$data['description'],$status);
        if(!$res) {
            return Json_print('001','编辑失败');
        }
        return Json_print('000','编辑成功');
    }


    /**
     * @param Request $request
     * @return false|string
     * 删除角色数据
     */
    public function delete(Request $request) {
        $id = $request->all('id');
        if(empty($id['id'])) {
            return Json_print('001','角色id非法');
        }

        $adminCount = $this->roleModel->getAdminCountByRoleId($id['id']);
        if ($adminCount) {
            return Json_print('001','角色正在被使用,禁止删除');
        }

        $res = $this->roleModel->delData($id['id']);
        if(!$res) {
            return Json_print('001','删除失败');
        }
        return Json_print('000','删除成功');
    }


    /**
     * @param Request $request
     * @return false|string
     * 更换角色状态
     */
    public function changeStatus(Request $request) {
        $id = $request->post('id');
        if(empty($id)) {
            return Json_print('001','ID不能为空');
        }
        $res = $this->roleModel->changeStatus($id);
        if(!$res) {
            return Json_print('001','编辑失败');
        }
        return Json_print('000','编辑成功');
    }


    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 展示分配权限的界面
     */
    public function dirbutePermissionView(Request $request) {
        $roleId = $request->get('id');
        if(empty($roleId)) {
            return Json_print('001','ID不能为空');
        }

        //获取当前角色的所有权限
        $oldPermissionIds = $this->roleModel->getOldPermissions($roleId);
        $permissions = $this->permissionModel->getAll();
        return view('/admin/role/dirbute',compact('permissions','oldPermissionIds','roleId'));
    }



    public function dirbutePermission(Request $request) {
        $permissonIds = $request->post('permissionIds');
        $id = $request->post('id');
        if(empty($id)) {
            return Json_print('001','ID不能为空');
        }
        $permissions = [];
        if(!empty($permissonIds)) {
            $permissions = $permissonIds;
        }
        $res = $this->roleModel->dirbute($id,$permissions);
        if(!$res) {
            return Json_print('001','分配失败');
        }
        return Json_print('000','分配成功');
    }
}
