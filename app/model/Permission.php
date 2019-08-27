<?php

namespace App\model;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{

    protected $guarded = [];
    protected $primaryKey = 'id';
    protected $table = 'permissions';

    public function getList($where) {
        $list = Role::orderBy('id','desc')
            ->when(isset($where['roleName']) && !empty($where['roleName']),function($query) use ($where) {
                return $query->where('roleName','like',$where['roleName']);
            })
            ->get();

        $data = [];
        foreach ($list ?? [] as $key=>$value) {
            $data[] = [
                'id'=>$value->id,
                'permissionName'=>$value->permission_name,
                'url'=>$value->url,
                'createdAt'=>$value->created_at,
                'updatedAt'=>$value->updated_at
            ];
        }

        $total = $list->total();

        return [$data,$total];
    }
}
