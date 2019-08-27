<?php
/**
 * Created by PhpStorm.
 * User: konghy
 * Date: 19-8-27
 * Time: 19-8-27
 */

/**
 * Class Tree
 * 无限级算法工具
 */
class Tree {

    /**
     * @var string
     */
    protected $idName = 'id';

    /**
     * @var string
     */
    protected $pidName = 'pid';

    /**
     * @var string
     */
    protected $titleName = 'title';

    /**
     * @var string
     */
    protected $childName = 'children';

    public function __construct($config)
    {
        $this->setConfig($config);
    }


    /**
     * @param $config
     * @return bool
     * 设置配置
     */
    private function setConfig($config) {
        if(!is_array($config) && empty($config)) {
            return false;
        }
        foreach ($config as $key=>$var) {
            $this->$key = $var;
        }
    }


    /**
     * @param $data
     * @param int $pid
     * @param int $level
     * @return array
     * 递归生成树状结构
     */
    public function deepFormatTree($data,$pid = 0,$level = 0) {
        $list = [];
        foreach ($data ?? [] as $key=>$value) {
            if($value[$this->pidName] == $pid) {
                $value['level'] = $level;
                $list[] = $value;
                $list = $list+$this->deepFormatTree($data,$value[$this->idName],$level+1);
            }
        }
        return $list;
    }
}