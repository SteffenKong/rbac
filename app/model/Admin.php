<?php

namespace App\model;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Admin
 * @package App\model
 * 账号模型
 */
class Admin extends Model
{
    public $timestamps = true;
    protected $guarded = [];
    protected $primaryKey = 'id';
    protected $table = 'admin';


    /**
     * @param $account
     * @param $password
     * @return array|bool
     * 登陆
     */
    public function login($account,$password) {
        $admin = Admin::where('account',$account)->first();

        //用户不存在
        if(!$admin) {
            return false;
        }

        //校验密码的哈希
        if(!password_verify($password,$admin->password)) {
            return false;
        }

        return [
            'id'=>$admin->id,
            'account'=>$admin->account,
            'roleId'=>$admin->account,
            'nickName'=>$admin->nici_name,
            'email'=>$admin->email,
            'phone'=>$admin->phone,
            'status'=>$admin->status
        ];
    }


    /**
     * @param $id
     * @return bool
     * 检测管理员的状态
     */
    public function checkStatus($id) {
        $statusRes = Admin::where('id',$id)->first(['status']);
        if(!$statusRes->status) {
            return false;
        }
        return true;
    }


    /**
     * @param $pageSize
     * @return array
     * 分页获取数据
     */
    public function getList($pageSize) {
        $list =  Admin::orderBy('id','desc')->paginate($pageSize);
        $result = [];
        foreach ($list ?? [] as $key => $value) {
            $result[] = [
                'id'=>$value->id,
                'account'=>$value->account,
                'email'=>$value->email,
                'phone'=>$value->phone,
                'nickName'=>$value->nick_name,
                'status'=>$value->status,
                'roleId'=>$value->role_id,
                'createdAt'=>$value->created_at,
                'updatedAt'=>$value->updated_at
            ];
        }
        return [$list,$result];
    }



    /**
     * @param $account
     * @param $password
     * @param $nickName
     * @param $email
     * @param $phone
     * @param $status
     * @param $roleId
     * @return mixed
     * 添加账号
     */
    public function add($account,$password,$nickName,$email,$phone,$status,$roleId) {
        return Admin::create([
            'account'=>$account,
            'password'=>password_hash($password,PASSWORD_DEFAULT),
            'nick_name'=>$nickName,
            'email'=>$email,
            'phone'=>$phone,
            'status'=>$status,
            'role_id'=>$roleId,
            'created_at'=>Carbon::now()->toDateTimeString(),
            'updated_at'=>Carbon::now()->toDateTimeString()
        ]);
    }


    public function edit($id,$account,$password,$nickName,$email,$phone,$status,$roleId) {

    }


    /**
     * @param $id
     * @return mixed
     * 删除数据
     */
    public function delData($id) {
        return Admin::where('id',$id)->delete();
    }


    /**
     * @param $id
     * @return mixed
     * 获取单条数据
     */
    public function getOne($id) {
        return Admin::where('id',$id)->first();
    }


    /**
     * @param $columnName
     * @param $value
     * @return bool
     * 查找指定值是否存在
     */
    public function getColumnValIsExists($columnName,$value) {
        $bool = Admin::where($columnName,$value)->count();
        return (bool)$bool;
    }


    /**
     * @param $id
     * @param $columnName
     * @param $value
     * @return bool
     * 查找指定值是否存在,除去当前id
     */
    public function getColumnValIsExistsById($id,$columnName,$value) {
        $bool = Admin::where($columnName,$value)->where('id','!=',$id)->count();
        return (bool)$bool;
    }


    public function changeStatus($id) {

    }

    public function changePassword($id,$password) {

    }
}
