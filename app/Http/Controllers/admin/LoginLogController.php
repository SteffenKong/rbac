<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\model\LoginLog;
use Tools\Loader;

/**
 * Class LoginLogController
 * @package App\Http\Controllers\admin
 * 登录日志
 */
class LoginLogController extends BaseController
{
    /*　@var LoginLog $loginLogModel */
    protected $loginLogModel;

    public function __construct()
    {
        parent::__construct();
        $this->loginLogModel = Loader::sigltion(LoginLog::class);
    }

    public function index() {
        //TODO
    }
}
