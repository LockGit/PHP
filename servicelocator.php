<?php

/**
 * Created by PhpStorm.
 * User: lock
 * Date: 2017/8/14
 * Time: 16:53
 * 服务定位模式
 * 实现服务使用者和服务的解耦，无需改变代码而只是通过简单配置更服服务实现。
 */


/**
 * 服务实例化实现
 * Class Creator
 */
class Creator {
    public static function createObject($obj) {

    }
}

class ServiceLocator {

    /**
     * 服务实例索引
     */
    private $_services = array();

    /**
     * 服务定义索引
     */
    private $_definitions = [];

    /**
     * 是否全局服务共享（单例模式）
     */
    private $_shared = [];

    public function has($id) {
        return isset($this->_services[$id]) || isset($this->_definitions[$id]);
    }

    public function __get($id) {
        if ($this->has($this->id)) {
            $this->get($id);
        }

        // another implement
    }

    public function get($id) {
        if (isset($this->_services[$id]) && $this->_shared[$id]) {
            return $this->_services[$id];
        }

        if (isset($this->_definitions[$id])) {
            // 实例化
            $definition = $this->_definitions[$id];
            $object = Creator::createObject($definition);//省略服务实例化实现
            if ($this->_shared[$id]) {
                $this->_services[$id] = $object;
            }

            return $object;
        }

        throw new Exception("无法定位服务{$id}");
    }

    public function set($id, $definition, $share = false) {
        if ($definition === null) {
            unset($this->_services[$id], $this->_definitions[$id]);
            return;
        }

        unset($this->_services[$id]);
        $this->_shared[$id] = $share;
        if (is_string($definition)) {
            return $this->_definitions[$id] = $definition;
        }
        if (is_object($definition) || is_callable($definition, true)) {
            return $this->_definitions[$id] = $definition;
        }

        if (is_array($definition)) {
            if (isset($definition['class'])) {
                return $this->_definitions[$id] = $definition;
            }
        }

        throw new Exception("服务添加失败");
    }
}
