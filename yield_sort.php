<?php
/**
 * @Author: lock
 * @Date:   2017-01-16 14:48:29
 * @Last Modified by:   lock
 * @Last Modified time: 2017-01-16 15:32:21
 */

function sort_arr($a,$b){
	while (1) {
		if(count($a)==0){
			foreach ($b as $key => $value) {
				yield $value;
			}
			break;
		}
		if(count($b)==0){
			foreach ($a as $key => $value) {
				yield $value;
			}
			break;
		}
		if($a[0]>$b[0]){
			yield array_shift($b);
		}else{
			yield array_shift($a);
		}
	}
}

$a=[1,3,5,7,9,18,19,20];
$b=[2,4,6,8,22];
foreach (sort_arr($a,$b) as $key => $value) {
 	echo $value.'--->';
 }