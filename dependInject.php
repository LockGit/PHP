<?php

/**
 * Created by PhpStorm.
 * User: lock
 * Date: 2017/8/2
 * Time: 23:59
 * 依赖注入模式
 * 实现调用者与被调用者的解耦
 */
abstract class config {
    protected $storage;

    public function __construct($storage) {
        $this->storage = $storage;
    }
}

interface params {
    public function get($key);

    public function set($key,$val);
}


class OnlineConfig extends config implements params {

    /**
     * @param      $key
     * @param null $default
     * @return null
     */
    public function get($key, $default = null) {
        if (isset($this->storage[$key])) {
            return $this->storage[$key];
        }
        return $default;
    }

    /**
     * @param $key
     * @param $value
     */
    public function set($key, $value) {
        $this->storage[$key] = $value;
    }
}


class Connect{
    protected $config;
    protected $host;
    public function __construct(params $config) {
        $this->config = $config;
    }

    public function conn(){
        $host = $this->config->get('host');
        echo 'connect to host:'.$host.PHP_EOL;
        $port = $this->config->get('port');
        echo 'connect to port:'.$port;
        //if connn success
        $this->host = $host;
    }

    public function getHost(){
        $this->host;
    }
}

$configArr = ['host'=>'127.0.0.1'];
$onlineConfig = new OnlineConfig($configArr);
echo $onlineConfig->get('host').PHP_EOL;
$onlineConfig->set('port','3306');

$connObj = new Connect($onlineConfig);
$connObj->conn();
