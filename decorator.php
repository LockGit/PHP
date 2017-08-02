<?php
/**
 * Created by PhpStorm.
 * User: lock
 * Date: 2017/7/25
 * Time: 01:18
 * 装饰器模式
 * 装饰器模式能够从一个对象的外部动态地给对象添加功能。
 */

interface render{
    public function rendData();
}

class webService implements render{

    protected $data;
    public function __construct($data) {
        $this->data = $data;
    }

    public function rendData() {
        return $this->data;
    }
}


abstract class decorator implements render {
    protected $wrapped;

    public function __construct(render $wrappable) {
        $this->wrapped = $wrappable;
    }
}


class rendXml extends decorator{
    public function rendData() {
        $output = $this->wrapped->rendData();
        foreach ($output as $val){
            //
        }
        echo 'save xml';
    }
}

class rendJson extends decorator{
    public function rendData() {
        $output = $this->wrapped->rendData();
        echo json_encode($output);
    }
}

$server = new webService(['name'=>'lock']);

$xmlServer = new rendXml($server);
echo $xmlServer->rendData();

$jsonServer = new rendJson($server);
echo $jsonServer->rendData();