<?php
/**
 * Created by PhpStorm.
 * User: lock
 * Date: 2017/2/26
 * Time: 12:44
 */

// 业务流程控制基类
class Action {
    // 较为常用的两个对象封装到业务流程的基类中
    protected $_tpl;
    protected $_model;

    protected function __construct(&$_tpl,&$_model=null){
        $this->_tpl=$_tpl;
        $this->_model=$_model;
    }
//     分页
//    protected function page($_total,$pagesize=PAGE_SIZE){
//        $_page =  new Page($_total,$pagesize);
//        $this->_model->limit = $_page->limit;
//        $this->_tpl->assign('page',$_page->pageshow());
//        // 添加顺序编号
//        $this->_tpl->assign('now_num',($_page->page-1)*$pagesize);
//    }
}
