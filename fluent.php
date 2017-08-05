<?php
/**
 * Created by PhpStorm.
 * User: lock
 * Date: 2017/8/6
 * Time: 01:16
 * 流接口模式
 * 流接口（Fluent Interface）是指实现一种面向对象的、能提高代码可读性的 API 的方法。
 * 其目的就是可以编写具有自然语言一样可读性的代码，我们对这种代码编写方式还有一个通俗的称呼 —— 方法链。
 * 比如Sql查询构建器
 */


Class SqlBuilder{
    protected $field = [];
    protected $from = [];
    protected $where = [];

    public function select(array $selectFiled=array()){
        $this->field=$selectFiled;
        return $this;
    }

    public function from($table,$alias){
        $this->from[]=$table .' as '.$alias;
        return $this;
    }

    public function where($condition){
        $this->where[]=$condition;
        return $this;
    }

    public function getQuery(){
        return 'select ' . implode(',', $this->field) . ' from ' . implode(',',
                $this->from) . ' where ' . implode(' and ', $this->where);
    }

}

$obj = new SqlBuilder();
$obj->select(['name','age'])->from('userTable','user')->where('id=1');
echo $obj->getQuery();