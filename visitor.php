<?php

/**
 * Created by PhpStorm.
 * User: lock
 * Date: 2017/8/14
 * Time: 16:10
 * 访问者模式
 * 访问者模式表示一个作用于某对象结构中的各元素的操作。
 * 它使你可以在不改变各元素类的前提下定义作用于这些元素的新操作。
 */

/**
 * Class Customer
 * 客户抽象接口
 */
abstract class Customer {
    protected $customerId;
    protected $customerName;

    /**
     *接受访问者的访问
     *
     * @param $visitor ServiceRequestVisitor
     */
    abstract public function accept(ServiceRequestVisitor $visitor);
}

/**
 * 具体元素，企业客户
 * Class EnterpriseCustomer
 */
class EnterpriseCustomer extends Customer {
    /**
     *接受访问者
     *
     * @param $visitor Servicerequestvisitor
     */
    public function accept(ServiceRequestVisitor $visitor) {
        $visitor->visitEnerpriseCustomer($this);
    }
}

/**
 * 具体元素，个人客户
 * Class PersonalCustomer
 */
class PersonalCustomer extends Customer {
    /**
     * 接受访问者
     *
     * @param ServiceRequestVisitor $visitor
     */
    public function accept(ServiceRequestVisitor $visitor) {
        $visitor->visitPersonalCustomer($this);
    }
}

/**
 *访问者接口
 */
interface Visitor {

    /**
     * 访问企业用户
     *
     * @param EnterpriseCustomer $ec
     * @return mixed
     */
    public function visitEnerpriseCustomer(EnterpriseCustomer $ec);

    /**
     * 访问个人用户
     *
     * @param PersonalCustomer $pc
     * @return mixed
     */
    public function visitPersonalCustomer(PersonalCustomer $pc);
}

/**
 * 具体的访问者
 * 对服务提出请求
 * Class ServiceRequestVisitor
 */
class ServiceRequestVisitor implements Visitor {
    //访问企业客户
    public function visitEnerpriseCustomer(EnterpriseCustomer $ec) {
        echo $ec->name . '企业提出服务请求。' . PHP_EOL;
    }

    //访问个人用户
    public function visitPersonalCustomer(PersonalCustomer $pc) {
        echo '客户' . $pc->name . '提出请求。' . PHP_EOL;
    }
}

/**
 *对象结构
 *存储要访问的对象
 */
class ObjectStructure {
    /**
     *存储客户对象
     *
     * @var array
     */
    private $obj = array();

    public function addElement($ele) {
        array_push($this->obj, $ele);
    }

    /**
     *处理请求
     *
     * @param $visitor Visitor
     */
    public function handleRequest(Visitor $visitor) {
        //遍历对象结构中的元素，接受访问
        foreach ($this->obj as $ele) {
            $ele->accept($visitor);
        }
    }
}

//对象结构
$os = new ObjectStructure();

//添加元素
$ele1 = new EnterpriseCustomer();
$ele1->name = 'ABC集团';
$os->addElement($ele1);

$ele2 = new EnterpriseCustomer();
$ele2->name = 'DEF集团';
$os->addElement($ele2);

$ele3 = new PersonalCustomer();
$ele3->name = '张三';
$os->addElement($ele3);

$serviceVisitor = new ServiceRequestVisitor();
$os->handleRequest($serviceVisitor);