<?php

namespace App\model;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Permission
 * @package App\model
 * 权限模型器
 */
class Permission extends Model
{

    protected $guarded = [];
    protected $primaryKey = 'id';
    protected $table = 'permissions';


    /**
     * @param $where
     * @return array
     * 获取权限列表
     */
    public function getList() {
        $query = Permission::orderBy('id','desc');
        $list = $query->get();
        $data = [];
        foreach ($list ?? [] as $key=>$value) {
            $data[] = [
                'id'=>$value->id,
                'permissionName'=>$value->permission_name,
                'url'=>$value->url,
                'pid'=>$value->pid,
                'createdAt'=>$value->created_at,
                'updatedAt'=>$value->updated_at
            ];
        }

        $total = $query->count();

        $treeData = getTree($data);

        return [$treeData,$total];
    }


    /**
     * @return array
     * 获取所有权限
     */
    public function getAll() {
        $list = Permission::all();
        $data = [];
        foreach ($list ?? [] as $key=>$value) {
            $data[] = [
                'id'=>$value->id,
                'permissionName'=>$value->permission_name,
                'url'=>$value->url,
                'pid'=>$value->pid,
                'createdAt'=>$value->created_at,
                'updatedAt'=>$value->updated_at
            ];
        }
        $treeData = getTree($data);
        return $treeData;
    }


    /**
     * @param $permissionName
     * @param $url
     * @param $pid
     * @return mixed
     * 添加权限
     */
    public function add($permissionName,$url,$pid) {
        return Permission::create([
            'permission_name'=>$permissionName,
            'url'=>$url,
            'pid'=>$pid,
            'created_at'=>Carbon::now()->toDateTimeString(),
            'updated_at'=>Carbon::now()->toDateTimeString()
        ]);
    }


    /**
     * @param $id
     * @param $permissionName
     * @param $url
     * @param $pid
     * @return mixed
     * 修改权限
     */
    public function edit($id,$permissionName,$url,$pid) {
        return Permission::where('id',$id)->update([
            'permission_name'=>$permissionName,
            'url'=>$url,
            'pid'=>$pid,
            'updated_at'=>Carbon::now()->toDateTimeString()
        ]);
    }


    /**
     * @param $permissionName
     * @return bool
     * 检测权限名称是否存在
     */
    public function checkPermissionNameIsExists($permissionName) {
        $count = Permission::where('permission_name',$permissionName)->count();
        return (bool)$count;
    }


    /**
     * @param $id
     * @param $permissionName
     * @return bool
     * 检测权限名称是否存在,除了不是自身之外
     */
    public function checkPermissionNameIsExistsById($id,$permissionName) {
        $count = Permission::where('permission_name',$permissionName)->where('id','!=',$id)->count();
        return (bool)$count;
    }


    /**
     * @param $url
     * @return bool
     * 检测url路由是否存在
     */
    public function checkUrlIsExists($url) {
        $count = Permission::where('url',$url)->count();
        return (bool)$count;
    }


    /**
     * @param $id
     * @param $url
     * @return bool
     * 检测url路由是否存在,除了不是自身之外
     */
    public function checkUrlIsExistsById($id,$url) {
        $count = Permission::where('url',$url)->where('id','<>',$id)->where('url','<>',null)->count();
        return (bool)$count;
    }


    /**
     * @param $id
     * @return mixed
     * 删除数据
     */
    public function delData($id) {
        return Permission::where('id',$id)->delete();
    }


    /**
     * @param $id
     * @return mixed
     * 获取单条权限数据
     */
    public function getOne($id) {
        return Permission::where('id',$id)->first();
    }


    /**
     * @param $id
     * 查找当前id是否有子级id
     */
    public function getSubsIds($id) {
        $list = Permission::all(['pid','id']);
        $data = [];
        foreach ($list ?? [] as $key=>$value) {
            $data[] = [
                'id'=>$value->id,
                'pid'=>$value->pid,
            ];
        }
        $ids = [];
        $ids = $this->getIdsByDeeping($data,$id);
        return $ids;
    }


    /**
     * @param $data
     * @param int $pid
     * @return array
     * 无限级获取子级id
     */
    public function getIdsByDeeping($data,$pid = 0) {
        $ids = [];
        foreach ($data ?? [] as $key=>$value) {
            if ($value['pid'] == $pid) {
                $ids[] = [
                    'id'=>$value['id']
                ];
                $ids = $ids + $this->getIdsByDeeping($data,$value['id']);
            }
        }
        if(!empty($ids)) {
            $ids = array_column($ids,'id');
        }
        return $ids;
    }


    /**
     * @param $roleId
     * @return array
     * 获取当前角色的所有权限
     */
    public function getPermissionsByRoleId($roleId) {
        $ids = PermissionRole::where('role_id',$roleId)->get(['permission_id']);
        $permissionIds = [];
        foreach ($ids ?? [] as $value) {
            array_push($permissionIds,$value->permission_id);
        }

        $permissions = Permission::whereIn('id',$permissionIds)->get();
        $data = [];
        foreach ($permissions ?? [] as $permission) {
            $data[] = [
                'id'=>$permission->id,
                'permissionName'=>$permission->permission_name,
                'route'=>$permission->url,
                'pid'=>$permission->pid
            ];
        }
        return $data;
    }


    /**
     * @return array
     * 获取超级管理员的所有权限
     */
    public function getPermissionByAdmin() {
        $permissions = Permission::all();
        $data = [];
        foreach ($permissions ?? [] as $permission) {
            $data[] = [
                'id'=>$permission->id,
                'permissionName'=>$permission->permission_name,
                'route'=>$permission->url,
                'pid'=>$permission->pid
            ];
        }
        return $data;
    }
}
