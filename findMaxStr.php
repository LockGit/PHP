<?php
/**
 * @Author: lock
 * @Date:   2017-06-30 00:42:34
 * @Last Modified by:   lock
 * @Last Modified time: 2017-06-30 10:02:02
 * 查找某个字符串中连续字符串首次出现次数最多的那个字符及个数
 */

$str = 'aabbbacdaadddeeedddmmdddfxxxxxxxxbxxxbxxgbbbbbbbbxxxxxxx';

$arr = str_split($str);

$tmp = [];
$max = ['str' => $arr[0], 'cnt' => 1];
for ($i = 1; $i < count($arr); $i++) {
    if (isset($tmp[$arr[$i]])) {
        if ($arr[$i] != $arr[$i - 1]) {
            $tmp[$arr[$i]] = 1;
            if ($tmp[$arr[$i - 1]] != $max['cnt']) {
                unset($tmp[$arr[$i - 1]]);
            }
        }
        $tmp[$arr[$i]] = $tmp[$arr[$i]] + 1;
        if ($tmp[$arr[$i]] > $max['cnt']) {
            $max['str'] = $arr[$i];
            $max['cnt'] = $tmp[$arr[$i]];
        }
    } else {
        $tmp[$arr[$i]] = 1;
    }
}

echo 'Max Str Info:'.PHP_EOL;
var_export($max);


