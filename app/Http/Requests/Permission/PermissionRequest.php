<?php

namespace App\Http\Requests\Permission;

use App\Http\Requests\CommonRequest;


/**
 * Class PermissionRequest
 * @package App\Http\Requests\Permission
 * 权限参数校验器
 */
class PermissionRequest extends CommonRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'permissionName'=>'required',
            'pid'=>'numeric',
        ];
    }


    /**
     * @return array
     * 展示错误信息
     */
    public function messages()
    {
        return [
            'permissionName.required'=>'请填写权限名称',
            'pid.numeric'=>'父级id类型必须为数字'
        ];
    }
}
