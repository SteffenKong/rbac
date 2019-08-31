<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;
use DB;
use Carbon\Carbon;


/**
 * Class Role
 * @package App\model
 * 角色模型
 */
class Role extends Model
{

    protected $guarded = [];
    protected $table = 'roles';
    protected $primaryKey = 'id';


    /**
     * @param $pageSize
     * @param array $where
     * @return array
     * 获取角色列表
     */
    public function getList($pageSize,$where = []) {
        $list = Role::orderBy('id','desc')
            ->when(isset($where['roleName']) && !empty($where['roleName']),function($query) use ($where) {
                return $query->where('role_name','like',$where['roleName']);
            })
            ->paginate($pageSize);

        $return = [];
        foreach ($list->items() ?? [] as $key=>$value) {
            $return[] = [
                'id'=>$value->id,
                'roleName'=>$value->role_name,
                'description'=>$value->description,
                'status'=>$value->status,
                'createdAt'=>$value->created_at,
                'updatedAt'=>$value->updated_at
            ];
        }
        return [$list,$return];
    }


    /**
     * @param $roleName
     * @param $description
     * @param $status
     * @return mixed
     * 添加数据
     */
    public function add($roleName,$description,$status) {
        return Role::create([
            'role_name'=>$roleName,
            'description'=>$description,
            'status'=>$status,
            'created_at'=>Carbon::now()->toDateTimeString(),
            'updated_at'=>Carbon::now()->toDateTimeString()
        ]);
    }


    /**
     * @param $roleName
     * @return bool
     * 检测角色名称是否存在
     */
    public function checkRoleNameIsExists($roleName) {
        $bool = Role::where('role_name',$roleName)->count();
        return (bool)$bool;
    }


    /**
     * @param $id
     * @param $roleName
     * @return bool
     * 检测除了自身id,名字是否和其他数据有冲突
     */
    public function checkRoleNameIsExistsById($id,$roleName) {
        $bool = Role::where('role_name',$roleName)->where('id','!=',$id)->count();
        return (bool)$bool;
    }


    /**
     * @param $id
     * @return bool
     * 检测角色是否真在被使用
     */
    public function getAdminCountByRoleId($roleId) {
        $count = Admin::where('role_id',$roleId)->count();
        return (bool)$count;
    }


    /**
     * @param $id
     * @return array
     * 获取单条数据
     */
    public function getOne($id) {
        $data = Role::where('id',$id)->first();
        $return = [];
        if($data){
            $return = [
                'id'=>$data->id,
                'roleName'=>$data->role_name,
                'description'=>$data->description,
                'status'=>$data->status,
                'createdAt'=>$data->created_at,
                'updatedAt'=>$data->updated_at
            ];
        }
        return $return;
    }


    /**
     * @param $id
     * @param $roleName
     * @param $description
     * @param $status
     * @return mixed
     * 编辑数据
     */
    public function edit($id,$roleName,$description,$status) {
        return Role::where('id',$id)->update([
            'role_name'=>$roleName,
            'description'=>$description,
            'status'=>$status,
            'updated_at'=>Carbon::now()->toDateTimeString()
        ]);
    }


    /**
     * @param $id
     * @return mixed
     * 删除数据
     */
    public function delData($id) {
        return Role::where('id',$id)->delete();
    }


    /**
     * @param $id
     * @return mixed
     * 修改状态
     */
    public function changeStatus($id) {
        $statusRes = Role::where('id',$id)->value('status');
        $status = 1;
        if($statusRes == 1) {
            $status = 0;
        }
        return Role::where('id',$id)->update(['status'=>$status,'updated_at'=>Carbon::now()->toDateTimeString()]);
    }


    /**
     * @param $roleId
     * @return bool
     * 判断当前角色是否被使用
     */
    public function getRoleCountByRoleId($roleId) {
        $count = Role::where('role_id',$roleId)->count();
        return (bool)$count;
    }


    /**
     * @return array
     * 取出所有有效的角色
     */
    public function getAllRoles() {
        $roles = Role::where('status',1)->get(['id','role_name']);
        $return = [];
        foreach ($roles ?? [] as $key=>$value) {
            $return[] = [
                'id'=>$value->id,
                'roleName'=>$value->role_name,
            ];
        }
        return $return;
    }


    /**
     * @param $roleId
     * @param $permissionIds
     * @return bool
     * 分配权限
     */
    public function dirbute($roleId,$permissionIds) {
        try {
            DB::beginTransaction();
            $res1 = $this->async($roleId);
            $data = [];
            foreach ($permissionIds ?? [] as $key=>$value) {
                $data[] = [
                    'role_id'=>$roleId,
                    'permission_id'=>$value,
                    'created_at'=>Carbon::now()->toDateTimeString(),
                    'updated_at'=>Carbon::now()->toDateTimeString()
                ];
            }
            $res2 = DB::table('permission_role')->insert($data);
            if($res1===false || !$res2) {
                DB::rollBack();
                return false;
            }
            DB::commit();
            return true;
        }catch (\Exception $e) {
            return false;
        }
    }


    /**
     * @param $roleId
     * @return mixed
     * 异步清楚
     */
    public function async($roleId = []) {
        return PermissionRole::where('role_id',$roleId)->delete();
    }


    /**
     * @param $roleId
     * @return array
     * 获取当前的data
     */
    public function getOldPermissions($roleId) {
        $permissionIds = PermissionRole::where('role_id',$roleId)->get(['permission_id']);
        $ids = [];
        foreach ($permissionIds ?? [] as $permissionId) {
            array_push($ids,$permissionId['permission_id']);
        }

        return $ids;
    }
}