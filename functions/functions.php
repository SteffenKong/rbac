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
                $list = array_merge($list,getTree($data,$value['id'],$level+1));
            }
        }
        return $list;
    }
}


/**
 * 生成树状辅助函数
 */
if(!function_exists('getTreeList')) {
    /**
     * @param $data
     * @param int $pid
     * @return array
     */
    function getTreeList($data,$pid = 0) {
        $tree = [];
        $newTree = [];
        foreach ($data ?? [] as $key=>$value) {
            $newTree[$value['id']] = $value;
        }

        foreach ($newTree ?? [] as $key=>$value) {
            if($value['pid'] == $pid) {
                $tree[] = &$newTree[$value['id']];
            }elseif(isset($newTree[$value['id']])) {
                $newTree[$value['pid']]['items'][] = &$newTree[$value['id']];
            }
        }
        return $tree;
    }
}