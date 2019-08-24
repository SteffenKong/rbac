<?php

namespace App\model;

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


    public function add($account,$password,$nickName,$email,$phone,$status,$roleId) {

    }

    public function edit($id,$account,$password,$nickName,$email,$phone,$status,$roleId) {

    }

    public function delData() {

    }

    public function getOne() {

    }

    public function getColumnValIsExists($columnName,$value) {

    }

    public function getColumnValIsExistsById($id,$columnName,$value) {

    }

    public function changeStatus($id) {

    }

    public function changePassword($id,$password) {

    }
}
