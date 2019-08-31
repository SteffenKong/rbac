<?php

namespace App\Http\Controllers\admin;

use App\Http\Requests\Permission\PermissionRequest;
use App\model\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Tools\Loader;

/**
 * Class PermissionController
 * @package App\Http\Controllers\admin
 * 权限控制器
 */
class PermissionController extends BaseController
{

    /* @var Permission $permissionModel */
    protected $permissionModel;

    public function __construct()
    {
        parent::__construct();
        $this->permissionModel = Loader::sigltion(Permission::class);
    }


    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 获取权限列表
     */
    public function index(Request $request) {
        $list = $this->permissionModel->getList();
        return view('/admin/permission/index',compact('list'));
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 展示权限添加界面
     */
    public function addView() {
        $permissions = $this->permissionModel->getAll();
        return view('/admin/permission/add',compact('permissions'));
    }


    /**
     * @param PermissionRequest $request
     * @return false|string
     * 添加权限
     */
    public function add(PermissionRequest $request) {
        $data = $request->post();

        if($this->permissionModel->checkPermissionNameIsExists($data['permissionName'])) {
            return Json_print('001','权限名称已存在');
        }

        if($this->permissionModel->checkUrlIsExists($data['url']) && !empty($data['url'])) {
            return Json_print('001','url路由名称已存在');
        }

        $res = $this->permissionModel->add($data['permissionName'],$data['url'],$data['pid']);
        if(!$res) {
            return Json_print('001','添加失败');
        }

        return Json_print('000','添加成功');
    }



    /**
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 展示编辑界面
     */
    public function editView(int $id) {
        $permissions = $this->permissionModel->getAll();
        $oldPermission = $this->permissionModel->getOne($id);
        return view('/admin/permission/edit',compact('permissions','oldPermission'));
    }


    /**
     * @param PermissionRequest $request
     * @return false|string
     * 编辑权限
     */
    public function edit(PermissionRequest $request) {
        $data = $request->all();

        if($this->permissionModel->checkPermissionNameIsExistsById($data['id'],$data['permissionName'])) {
            return Json_print('001','权限名称已存在');
        }

        if($this->permissionModel->checkUrlIsExistsById($data['id'],$data['url'])) {
            return Json_print('001','url路由名称已存在');
        }

        $res = $this->permissionModel->edit($data['id'],$data['permissionName'],$data['url'],$data['pid']);
        if(!$res) {
            return Json_print('001','编辑失败');
        }

        return Json_print('000','编辑成功');
    }


    /**
     * @param Request $request
     * @return false|string
     * 删除权限
     */
    public function delete(Request $request) {
        $id = $request->get('id');
        if(empty($id)) {
            return Json_print('001','id非法');
        }
        $subIds = $this->permissionModel->getSubsIds($id);
        if(!empty($subIds)) {
            return Json_print('001','包含子节点禁止删除');
        }

        $res = $this->permissionModel->delData($id);
        if(!$res) {
            return Json_print('001','删除失败');
        }

        return Json_print('000','删除成功');
    }
}
