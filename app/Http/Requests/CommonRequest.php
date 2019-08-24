<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;


/**
 * Class CommonRequest
 * @package App\Http\Requests
 * 公共校验器
 */
class CommonRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;    //开放鉴定权限
    }



    /**
     * @param Validator $validator
     * 接口返回错误信息格式
     */
    public function failedValidation(Validator $validator)
    {
        exit(json_encode([
            'msg'=>'004',
            'message'=>'错误信息',
            'errors'=>$validator->getMessageBag()->toArray()
        ]));
    }
}
