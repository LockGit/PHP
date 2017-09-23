<?php
/**
 * Created by PhpStorm.
 * User: lock
 * Date: 2017/2/26
 * Time: 12:56
 */
class TestAction extends Action{
    public function __construct(&$tpl){
        parent::__construct($tpl);
    }
    //action
    public function _action() {
       $this->test();
    }

    private function test(){
        $test = 'hello world';
        $this->_tpl->assign('test',$test);
    }

}