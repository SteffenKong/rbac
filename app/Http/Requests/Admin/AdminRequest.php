<?php

namespace App\Http\Requests\Admin;
use App\Http\Requests\CommonRequest;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class AdminRequest
 * @package App\Http\Requests
 * 账号添加校验器
 */
class AdminRequest extends CommonRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'account'=>'required',
            'password'=>'required',
            'email'=>'required|email',
            'phone'=>'required|digits:11',
            'nickName'=>'required',
            'roleId'=>'numeric'
        ];
    }

    /**
     * @return array
     * 输出错误信息
     */
    public function messages()
    {
        return [
            'account.required' => '请填写账号',
            'password.required' => '请填写密码',
            'email.required' => '请填写电子邮箱',
            'email.email' => '邮箱格式错误',
            'phone.required' => '请填写手机号',
            'phone.digits' => '手机号必须为11位数字',
            'nickName.required'=>'请填写真实昵称',
            'status.in' => '状态取值异常',
            'roleId.numeric'=>'角色取值异常'
        ];
    }
}
