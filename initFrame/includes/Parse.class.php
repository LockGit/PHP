<?php
class Parse{
	// 一个保留字段模板内容的字段
	private $tpl_data;
	public function __construct($tplfile){
		//保存到$tpl_data中
		if(!$this->tpl_data=file_get_contents($tplfile)){
			// $this->compile($tplfile);
			exit('ERROR:Paser类读取编译文件失败！');
		}
	}

	// 解析普通变量
	private function parVar(){
		// $name替换成php代码
		$pattern='/\{\$([\w]+)\}/';
		if(preg_match($pattern, $this->tpl_data)){
			// 如果查找到了，则替换
			$this->tpl_data=preg_replace($pattern, "<?php echo \$this->_vars['$1']; ?>", $this->tpl_data);
		}
	}
	// 解析系统变量
	private function parConfig(){
		$pattern='/<!\-\-([\w]+)\-\->/';
		if(preg_match($pattern, $this->tpl_data)){
			// 如果查找到了设置了系统变量
			$this->tpl_data=preg_replace($pattern, "<?php echo \$this->_config['$1']; ?>", $this->tpl_data);
		}
	}
	// 解析if语句
	private function parIf(){
		$pattern='/\{if\s+\$([\w]+)\}/';
		$patternEndif='/\{\/if\}/';
		$patternElse='/\{else\}/';
		// 匹配时if必须要有结束语句
		if(preg_match($pattern, $this->tpl_data) && preg_match($patternEndif, $this->tpl_data)){
			// 替换开始的if
			$this->tpl_data=preg_replace($pattern, "<?php if(\$this->_vars['$1']){ ?>", $this->tpl_data);
			// 替换结尾的if
			$this->tpl_data=preg_replace($patternEndif, "<?php } ?>", $this->tpl_data);
			// 如果匹配到了else
			if(preg_match($patternElse, $this->tpl_data)){
				$this->tpl_data=preg_replace($patternElse, "<?php }else{ ?>", $this->tpl_data);
			}
		}
	}
	// 解析foreach语句
	private function parForeach(){
		$pattern='/\{foreach\s\$([\w]+)\(([\w]+),([\w]+)\)\}/';
		$patternEndforeach='/\{\/foreach\}/';
		$patternContent='/\{@([\w]+)\}/';
		if(preg_match($pattern, $this->tpl_data) && preg_match($patternEndforeach,$this->tpl_data)){
			// 替换开始处的foreach
			$this->tpl_data=preg_replace($pattern, "<?php foreach(\$this->_vars['$1'] as \$$2=>\$$3){ ?>", $this->tpl_data);
			// 替换结尾处的foreach
			$this->tpl_data=preg_replace($patternEndforeach, "<?php } ?>", $this->tpl_data);
			// 替换foreach循环中的内容
			$this->tpl_data=preg_replace($patternContent, "<?php echo $$1; ?>", $this->tpl_data);
		}
	}
	// 解析include语句
	private function parInclude(){
		$pattern='/\{include\s+file=\"([\w\.\-]+)\"\}/';
		if(preg_match($pattern, $this->tpl_data,$match)){
			// 如果匹配到了，检查引入的文件是否存在，并且是否为空
			if(!file_exists($match[1])||empty($match)){
				exit('ERROR:引入文件不存在！');
			}
			// 替换为php代码
			$this->tpl_data=preg_replace($pattern, "<?php include '$1'; ?>", $this->tpl_data);
		}
	}
	// 解析PHP代码注释
	private function parPHP(){
		$pattern='/\{#\}(.*)\{#\}/';
		if(preg_match($pattern, $this->tpl_data)){
			// 解析PHP的注释代码，缓存文件中不会存在，只会存在编译.php文件中
			$this->tpl_data=preg_replace($pattern, "<?php /* $1 */ ?>", $this->tpl_data);
		}
	}

	//有一个公共方法用于调用
	public function compile($filename){
		// 生成编译文件之前替换{$name}为PHP代码
		$this->parVar();
		$this->parConfig();
		$this->parIf();
		$this->parForeach();
		$this->parInclude();
		$this->parPHP();
		// 生成编译文件
		if(!file_put_contents($filename,$this->tpl_data)){
			exit($filename.'编译模板文件时出错');
		}

	}


}

?>