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


/**
 * 无限级分类辅助函数
 */
if(!function_exists('getTree')) {
    /**
     * @param $data
     * @param int $pid
     * @param int $level
     * @return array
     */
    function getTree($data,$pid = 0,$level = 0) {
        $list = [];
        foreach ($data ?? [] as $key=>$value) {
            if($value['pid'] == $pid) {
                $value['level'] = $level;
                $list[] = $value;
                $list = $list+$this->deepFormatTree($data,$value['id'],$level+1);
            }
        }
        return $list;
    }
}