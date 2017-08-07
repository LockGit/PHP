<?php

/**
 * Created by PhpStorm.
 * User: lock
 * Date: 2017/8/8
 * Time: 00:20
 * 迭代器模式
 * 提供一种方法访问一个容器（Container）对象中各个元素，而又不需暴露该对象的内部细节。
 * PHP标准库（SPL）中提供了迭代器接口 Iterator，要实现迭代器模式，实现该接口即可。
 * 参考:http://www.cnblogs.com/chenssy/p/3250409.html
 */

class SomeCollection implements Iterator {

    protected $data;

    protected $posIndex;

    public function __construct($data) {
        $this->data = $data;
        $this->posIndex = 0;
    }


    public function current() {
        $row = $this->data[$this->posIndex];
        $row['ip'] = gethostbyname($row['url']);
        return $row;
    }

    public function next() {
        $this->posIndex++;
    }

    public function valid() {
        return $this->posIndex >= 0 && $this->posIndex < count($this->data);
    }

    public function key() {
        return $this->posIndex;

    }

    public function rewind() {
        $this->posIndex = 0;
    }

}


$array = array(
    array('url' => 'www.baidu.com'),
    array('url' => 'www.sina.com.cn'),
    array('url' => 'www.google.com'),
    array('url' => 'www.qq.com'),
);


$coll = new SomeCollection($array);

foreach ($coll as $row) {
    echo $row['url'], ' ', $row['ip'], PHP_EOL;
}