<?php
//函数库


/**
 *  通用化API接口输出
 */
if(!function_exists('Json_print')) {

    /**
     * @param $code
     * @param $message
     * @param array $data
     * @param array $extra
     * @param int $httpCode
     * @return false|string
     */
    function Json_print($code,$message,$data=[],$extra = [],$httpCode = 200) {
        $result = [
            'code'=>$code,
            'message'=>$message,
            'data'=>$data,
            'extra'=>$extra
        ];

        return json_encode($result);
    }
}