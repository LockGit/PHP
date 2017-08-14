<?php
/**
 * Created by PhpStorm.
 * User: lock
 * Date: 2017/8/14
 * Time: 15:03
 * 规格模式
 * 可以认为是组合模式的一种扩展。
 * 有时项目中某些条件决定了业务逻辑，这些条件就可以抽离出来以某种关系（与、或、非）进行组合，从而灵活地对业务逻辑进行定制。
 */

/**
 *  规格接口
 * Interface SpecificationInterface
 */
interface SpecificationInterface {
    // 该方法根据给定对象是否满足这个规格来返回true 或 false。
    public function isSatisfiedBy(Item $item);

    // 创建规格的AND 和逻辑
    public function plus(SpecificationInterface $spec);

    // 创建规格的OR 或逻辑
    public function either(SpecificationInterface $spec);

    // 创建规格的Not 非逻辑
    public function not();
}

/**
 * 规格抽象类
 * Class AbstractSpecification
 */
abstract class AbstractSpecification implements SpecificationInterface {
    // 检查给定的item是否满足所有条件
    abstract public function isSatisfiedBy(Item $item);

    public function plus(SpecificationInterface $spec) {
        return new Plus($this, $spec);
    }

    public function either(SpecificationInterface $spec) {
        return new Either($this, $spec);
    }

    public function not() {
        return new Not($this);
    }
}

/**
 * 操作对象类
 * Class Item
 */
class Item {
    protected $price;

    public function __construct($price) {
        $this->price = $price;
    }

    public function getPrice() {
        return $this->price;
    }
}

/**
 * Class Plus
 */
class Plus extends AbstractSpecification {
    protected $left;
    protected $right;

    // 创建两个规格的和逻辑
    public function __construct(
        SpecificationInterface $left,
        SpecificationInterface $right
    ) {
        $this->left = $left;
        $this->right = $right;
    }

    // 检查规格的组合AND逻辑是否通过
    public function isSatisfiedBy(Item $item) {
        return $this->left->isSatisfiedBy($item)
            && $this->right->isSatisfiedBy($item);
    }
}

/**
 * Class Either
 */
class Either extends AbstractSpecification {
    protected $left;
    protected $right;

    // 创建一个封装了两个规格组合的新规格
    public function __construct(
        SpecificationInterface $left,
        SpecificationInterface $right
    ) {
        $this->left = $left;
        $this->right = $right;
    }

    // 逻辑或是否成立
    public function isSatisfiedBy(Item $item) {
        return $this->left->isSatisfiedBy($item)
            || $this->right->isSatisfiedBy($item);
    }
}

/**
 * Class Not
 */
class Not extends AbstractSpecification {
    protected $spec;

    // 创建一个新的规格封装了另外一个规格
    public function __construct(SpecificationInterface $spec) {
        $this->spec = $spec;
    }

    // 返回封装规格的取反结果
    public function isSatisfiedBy(Item $item) {
        return !$this->spec->isSatisfiedBy($item);
    }
}

/**
 * 价格规格
 * Class PriceSpecification
 */
class PriceSpecification extends AbstractSpecification {
    protected $maxPrice;
    protected $minPrice;

    // 设置可选的最高价
    public function setMaxPrice($maxPrice) {
        $this->maxPrice = $maxPrice;
    }


    // 设置可选的最低价
    public function setMinPrice($minPrice) {
        $this->minPrice = $minPrice;
    }

    // 检查价格是否在最大和最小之间
    public function isSatisfiedBy(Item $item) {
        if (!empty($this->maxPrice) && $item->getPrice() > $this->maxPrice) {
            return false;
        }
        if (!empty($this->minPrice) && $item->getPrice() < $this->minPrice) {
            return false;
        }

        return true;
    }
}


// 客户端调用示例

//创建两个价格规格
$spec1 = new PriceSpecification();
$spec2 = new PriceSpecification();

//进行或的条件组合
$either = $spec1->either($spec2); //抽象规格类中定义了either方法，返回组合后的规格

$price = 100;
$item = new Item($price);
echo $either->isSatisfiedBy($item);