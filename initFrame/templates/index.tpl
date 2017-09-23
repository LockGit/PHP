<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title><!--webname--></title>
</head>
<body>
	<p>index.tpl文件</p>
	<div class="main">
		<ul>
			<li>首页</li>
			<li>音乐</li>
			<li>歌曲</li>
			<li>舞蹈</li>
			<li>hello</li>
		</ul>
	</div>
	<p>由系统变量设置的分页:<!--pagesize--></p>
	$name的值：{$name}
	<div class="if">
		<p>设置if语句</p>
		{if $num}
			Yes
		{else}
			No
		{/if}
	</div>
	<div class="foreach">
		<p>设置Foreach语句</p>
		{foreach $arr(key,value)}
			{@key} => {@value} <br />
		{/foreach}
	</div>
	<p>文件引入:{include file="test.php"}</p>
	{#}我是PHP中的注释，在静态中是看不到的，只有在PHP源代码才可以看到{#}
</body>
</html>