# PHP
filter xss php class 

Usage: 
```
<?php
require('xsshtml.class.php');
$html = '<html code>';
$xss = new XssHtml($html);
$html = $xss->getHtml();
?>
```

PHP Version > 5.0
IE7+ or other browser
