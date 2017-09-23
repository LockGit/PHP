<?php
/**
 * @Author: Lock
 * @Date:   2014-11-26 00:06:08
 * @Last Modified by:   Lock
 * @Last Modified time: 2014-11-26 00:14:24
 */

class Template{
    // 创建一个数组动态创建变量$name,$content
    private $_vars=array();
    // 设置一个数组保存系统变量
    private $_config=array();

    public function __construct(){
        // 首先检查定义的常量的那几个目录是否存在
        if(!is_dir(CACHE)||!is_dir(TPL_DIR)||!is_dir(TPL_C_DIR)||!is_dir(INC_DIR)){
        	exit('模板文件，或者模板编译文件，或者includes，或者缓存文件夹不存在,请手工创建!');
        }

        // 自动解析xml文件
        $xml=simplexml_load_file(CONFIG_FILE);
        $tagli=$xml->xpath('/root/taglib');
        foreach($tagli as $v){
            $key=$v->name;
            $this->_config["$key"]=$v->value;
        }
        
    }

    // 注入变量
    public function assign($var,$value){
        if(isset($var)&&!empty($var)){
            //$this->_vars['name']='Lock';
            $this->_vars[$var]=$value;
        }else{
            exit('Error:请赋值模板变量！');
        }
    }


    //display方法用于显示模板
    public function display($tpl){
    	// 首先判断模板文件是否存在
    	$tplfile=TPL_DIR.$tpl;
        //判断传过来的模板文件是否存在
        if(!file_exists($tplfile)){
            exit($tplfile.'模板文件不存在！');
        }

    	// 定义编译文件和缓存文件名称
    	$compilefile=TPL_C_DIR.md5($tpl).$tpl.'.php';
    	$cachefile=CACHE.md5($tpl).$tpl.'.html';

        //当第二次运行相同文件的时候，直接载入缓存文件，避开编译
        if(IS_CACHE){
            // 缓存文件与编译文件都要存在
            if(file_exists($cachefile)&&file_exists($compilefile)){
                //判断缓存与编译文件是否修改过
                if(filemtime($compilefile)>=filemtime($tplfile)&&filemtime($cachefile)>=filemtime($compilefile)){
                    // 载入缓存文件
                    include $cachefile;
                    // 执行到这里就终止
                    return;
                }
            }
        }

    	// 当编译文件不存在或者模板文件修改过，则生成编译文件
    	if(!file_exists($compilefile)||filemtime($compilefile)<filemtime($tplfile)){
    		//引入模板分析类
    		require INC_DIR.'Parse.class.php';
    		$parse=new Parse($tplfile);
            // 将会生成编译文件
    		$parse->compile($compilefile);
    	}
        // 引入编译文件输出至浏览器
        include $compilefile;

        // 判断是否开启了缓冲区,会清除浏览器输出的内容，使用缓存的静态html文件
        if(IS_CACHE){
            // 如果开启了缓冲区，就创建缓存文件
            file_put_contents($cachefile, ob_get_contents());
            //清除缓冲区(清除了编译文件加载的内容)
            ob_end_clean();
            //引入静态缓存文件
            include $cachefile;
        }

    }



    
}

?>