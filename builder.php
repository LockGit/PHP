<?php
/**
 * Created by PhpStorm.
 * User: lock
 * Date: 2017/7/15
 * Time: 23:44
 * 建造者模式也称生成器模式
 * 以docker举例
 */

class leader{
    /**
     * leader 并不知道具体实现细节
     * @param BuilderInterface $builder
     * @return mixed
     */
    public function build(BuilderInterface $builder){
        $builder->pullDockerImage();
        $builder->createContainer();
        $builder->runContainer();
        return $builder->getContainer();
    }
}


interface BuilderInterface{
    /**
     * 拉取镜像
     * @return mixed
     */
    public function pullDockerImage();

    /**
     * 创建容器
     * @return mixed
     */
    public function createContainer();

    /**
     * 运行容器
     * @return mixed
     */
    public function runContainer();

    /**
     * 获得这个容器
     * @return mixed
     */
    public function getContainer();
}


class buildCentOsContainer implements BuilderInterface{
    public function pullDockerImage() {
        echo 'start pull docker image'.PHP_EOL;
    }

    public function createContainer() {
        echo 'start create container'.PHP_EOL;
    }

    public function runContainer() {
        echo 'run container'.PHP_EOL;
    }

    public function getContainer() {
        echo 'get container'.PHP_EOL;
    }
}


$leader = new leader();
$leader->build(new buildCentOsContainer());