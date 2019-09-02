<?php

namespace App\Http\Requests\Role;

use App\Http\Requests\CommonRequest;

/**
 * Class RoleRequest
 * @package App\Http\Requests\Role
 * 角色添加校验器
 */
class RoleRequest extends CommonRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'roleName'=>'required',
            'description'=>'required|max:200'
        ];
    }

    public function  messages()
    {
        return [
            'roleName.required'=>'请填写角色名称',
            'description.required'=>'请填写角色描述',
            'description.max'=>'角色描述不能超过199个字符s'
        ];
    }
}
