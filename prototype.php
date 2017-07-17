<?php
/**
 * Created by PhpStorm.
 * User: lock
 * Date: 2017/7/17
 * Time: 11:42
 * 原型模式
 * 原型模式是先创建好一个原型对象，然后通过clone原型对象来创建新的对象。
 * 适用于大对象的创建，因为创建一个大对象需要很大的开销，如果每次new就会消耗很大，原型模式仅需内存拷贝即可。
 */

interface prototype{
    public function copy();
}

class text implements prototype{

    public $font;
    public $size;
    public $color;
    public function __construct($font,$size,$color) {
        $this->font = $font;
        $this->size = $size;
        $this->color = $color;
    }

    public function echoInfo(){
        printf("%s,%s,%s",$this->font,$this->size,$this->color);
    }

    public function copy() {
        return clone $this;
    }
}


$md = new text('微软雅黑','12px','黑色');
$md->echoInfo();

$md2 = $md->copy();
echo $md2->font;
$md2->echoInfo();