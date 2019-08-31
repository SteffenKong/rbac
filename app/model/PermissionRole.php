<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PermissionRole extends Model
{
    protected $table = 'permission_role';
    protected $primaryKey = 'id';
    protected $guarded = [];
}
