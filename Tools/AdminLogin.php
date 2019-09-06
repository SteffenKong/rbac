<?php
/**
 * Created by PhpStorm.
 * User: konghy
 * Date: 19-9-6
 * Time: 19-9-6
 */
namespace Tools;

use Illuminate\Support\Facades\Redis;

/**
 * Trait login
 * 登录性状
 */
trait AdminLogin {

    /**
     * @param $userId
     * 登入记录redis标识
     */
    public function setLoginStatus($userId) {
        //记录进入redis
        $key = config('miss.ssoKey').$userId;
        return Redis::setnx($key,$userId);
    }


    /**
     * @param $userId
     * 登出销毁redis标识
     */
    public function logoutStatus($userId) {
        //销毁redis标识
        $key = config('miss.ssoKey').$userId;
        return Redis::del($key);
    }



    /**
     * @param $userId
     * @return mixed
     * 获取是否登录
     */
    public function checkIsLoginExists($userId) {
        //记录进入redis
        $key = config('miss.ssoKey').$userId;
        return Redis::exists($key);
    }
}