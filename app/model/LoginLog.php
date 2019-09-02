<?php

namespace App\model;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LoginLog
 * @package App\model
 * 登录日志模型器
 */
class LoginLog extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'login_log';
    protected $guarded = [];



    /**
     * @param $pageSize
     * @param array $where
     * @return mixed
     * 日志列表
     */
    public function getList($pageSize,$where = []) {
        return LoginLog::paginate($pageSize);
    }


    /**
     * @param $account
     * @param $params
     * @param $ip
     * @return mixed
     * 添加日志数据
     */
    public function addLogs($account,$params,$ip) {
        return LoginLog::create([
            'account'=>$account,
            'params'=>$params,
            'ip'=>$ip,
            'login_time'=>Carbon::now()->toDateTimeString(),
            'created_at'=>Carbon::now()->toDateTimeString(),
            'updated_at'=>Carbon::now()->toDateTimeString()
        ]);
    }
}
