<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class LoginLog extends Model
{
    protected $table = 'login_log';
    protected $guarded = [];
    protected $primaryKey = 'id';


    public function getList($pageSize,$where = []) {
        //TODO
    }

    public function addLogs() {
        //TODO
    }
}
