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
    /* @var LoginLog $loginLogModel */
    protected $loginLogModel;

    public function __construct()
    {
        parent::__construct();
        $this->loginLogModel = Loader::sigltion(LoginLog::class);
    }


    /**
     * @param Request $request
     * @return false|string
     * 登录日志列表
     */
    public function index(Request $request) {
        $pageSize = $request->get('pageSize',config('app.pageSize'));
        $where = [];
        $data = $this->loginLogModel->getList($pageSize,$where);
    }
}
