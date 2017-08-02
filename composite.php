<?php

/**
 * Created by PhpStorm.
 * User: lock
 * Date: 2017/7/23
 * Time: 23:43
 * 组合模式
 * 必须存在不可分割的基本元素；
 * 组合后的物体任然可以被组合。
 */
abstract class companyBase {
    //node name
    protected $name;

    public function __construct($name) {
        $this->name = $name;
    }

    public function getName() {
        return $this->name;
    }

    abstract public function add(companyBase $c);

    abstract public function remove(companyBase $c);

    abstract public function show();

    abstract public function work();
}

class company extends companyBase {
    protected $items = [];

    public function add(companyBase $c) {
        $nodeName = $c->getName();
        if (!isset($this->items[$nodeName])) {
            $this->items[$nodeName] = $c;
        } else {
            throw new Exception('node exits!');
        }
    }

    public function remove(companyBase $c) {
        $nodeName = $c->getName();
        if (isset($this->items[$nodeName])) {
            unset($this->items[$nodeName]);
        } else {
            throw new Exception('node not exits!');
        }
    }

    public function show($deep = 0) {
        echo str_repeat('-', $deep) . '['.$this->name.']' . PHP_EOL;
        foreach ($this->items as $item) {
            echo $item->show($deep + 2);
        }
    }

    public function work($deep = 0) {
        foreach ($this->items as $item) {
            echo str_repeat("\t", $deep) . $this->name . PHP_EOL;
            $item->work($deep + 1);
        }
    }
}


class hr extends companyBase {
    public function add(companyBase $c) {
        exit('no add');
    }

    public function remove(companyBase $c) {
        exit('no remove');
    }

    public function show($deep = 0) {
        echo str_repeat('-', $deep) . $this->name . PHP_EOL;
    }

    public function work($deep = 0) {
        echo str_repeat("\t", $deep) . "人力资源部门的工作是为公司招聘人才" . PHP_EOL;
    }

}

class it extends companyBase{
    public function add(companyBase $c) {
        exit('no add');
    }

    public function remove(companyBase $c) {
        exit('no remove');
    }

    public function show($deep = 0) {
        echo str_repeat('-', $deep) . $this->name . PHP_EOL;
    }

    public function work($deep = 0) {
        echo str_repeat("\t", $deep) . "it技术部门的工作是为公司解决it问题" . PHP_EOL;
    }
}

$company = new company('北京某科技开发公司');
$hr = new hr("人力资源部");
$it = new it("it技术部");
$company->add($hr);
$company->add($it);

//武汉分公司
$c2 = new Company("武汉分公司");
$c2->add($hr);
$c2->add($it);
$company->add($c2);

$company->show();
$company->work();