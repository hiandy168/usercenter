<?php
/**
 * Tree 树型类(无限分类)
 */
class Tree {
    private $result;
    private $tmp;
    private $arr;
    private $already = array();
    /**
     * @param array $result 树型数据表结果集
     * @param array $fields 树型数据表字段，array(分类id,父id)
     * @param integer $root 顶级分类的父id
     */
    public function __construct($result, $fields = array('id', 'fid'), $root = 0) {
        $this->result = $result;
        $this->fields = $fields;
        $this->root = $root;
        $this->fix = '&nbsp;&nbsp;&nbsp;';
        $this->handler();
    }
    /**
     * 树型数据表结果集处理
     */
    private function handler() {
        foreach ($this->result as $rk=>$node) {
            $tmp[$node[$this->fields[1]]][$rk] = $node;
        }
        krsort($tmp);
        for ($i = count($tmp); $i > 0; $i--) {
            foreach ($tmp as $k => $v) {
                if (!in_array($k, $this->already)) {
                    if (!$this->tmp) {
                        $this->tmp = array($k, $v);
                        $this->already[] = $k;
                        continue;
                    } else {
                        foreach ($v as $key => $value) {
                            if ($value[$this->fields[0]] == $this->tmp[0]) {
                                $tmp[$k][$key]['child'] = $this->tmp[1];
                                $this->tmp = array($k, $tmp[$k]);
                            }
                        }
                    }
                }
            }
            $this->tmp = null;
        }
        $this->tmp = $tmp;
    }
    /**
     * 反向递归
     */
    private function recur_n($arr, $id) {
        foreach ($arr as $k=>$v) {
            if ($v[$this->fields[0]] == $id) {
                $this->arr[$k] = $v;
                if ($v[$this->fields[1]] != $this->root) $this->recur_n($arr, $v[$this->fields[1]]);
            }
        }
    }
    /**
     * 正向递归
     */
    private function recur_p($arr,$fix='') {
        foreach ($arr as $k=>$v) {
            $tmp_v =array();
            $v['fix'] = $fix;
            $tmp_v =$v;
            unset($tmp_v['child']);
            $this->arr[$k] = $tmp_v;
            if (isset($v['child'])&& $v['child']){
                $newfix = $this->fix.' '.$fix;
                $this->recur_p($v['child'],$newfix);
            }
        }
    }
    /**
     * 菜单 多维数组
     *
     * @param integer $id 分类id
     * @return array 返回分支，默认返回整个树
     */
    public function tree($id = null) {
        $id = ($id == null) ? $this->root : $id;
        if(isset($this->tmp[$id])){
            return $this->tmp[$id];
        }
    }
    
    /**
     * 散落 一维数组
     *
     * @param integer $id 分类id
     * @return array 返回leaf下所有分类id
     */
    public function tree2($id) {
        $this->arr = null;
        $this->recur_p($this->tree($id));
        return $this->arr;
    }
    
    /**
     * 导航 一维数组
     *
     * @param integer $id 分类id
     * @return array 返回单线分类直到顶级分类
     */
    public function get_parent($id) {
        $this->arr = null;
        $this->recur_n($this->result, $id);
        krsort($this->arr);
        return $this->arr;
    }

}

//$tree= new Tree($result);
//$arr = $tree->tree(0);
//$nav = $tree->tree2(0);
//var_dump($arr);

?>


