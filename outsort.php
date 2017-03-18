<?php
/**
 * @Author: lock
 * @Date:   2017-03-18 18:28:43
 * @Last Modified by:   lock
 * @Last Modified time: 2017-03-18 19:53:30
 */

$a = [1,5,7,11,25,78,90,102];
$b = [2,6,8,11,34,42,89,100,120,140];
$c = [4,9,13,27,55,72,92,102,111];
$d = [3,13,19,21,66,85,99,108,138];


function sort_arr($a,$b,$c,$d){
	$t1 = array_shift($a);
	$t2 = array_shift($b);
	$t3 = array_shift($c);
	$t4 = array_shift($d);
	$mix_arr = [];
	array_push($mix_arr, $t1);
	array_push($mix_arr, $t2);
	array_push($mix_arr, $t3);
	array_push($mix_arr, $t4);
	list($f1,$f2,$f3,$f4)=[false,false,false,false];
	while (1) {
		sort($mix_arr);
		$out = $mix_arr[0];
		if($out==$t1){
			$t1 = array_shift($a);
			array_push($mix_arr,$t1);
			if(count($a)==0){
				$f1 = true;
				$t1=-1;
			}
		}elseif($out==$t2){
			$t2 = array_shift($b);
			array_push($mix_arr,$t2);
			if(count($b)==0){
				$f2 = true;
				$t2=-1;
			}
		}elseif ($out==$t3) {
			$t3 = array_shift($c);
			array_push($mix_arr,$t3);
			if(count($c)==0){
				$f3 = true;
				$t3=-1;
			}
		}elseif($out==$t4){
			$t4 = array_shift($d);
			array_push($mix_arr,$t4);
			if(count($d)==0){
				$f4 = true;
				$t4=-1;
			}
		}
		unset($mix_arr[0]);
		$save_arr[]=$out;
		if($f1==true && $f2==true && $f3==true && $f4==true){
			if (count($mix_arr)>0) {
				foreach ($mix_arr as $value) {
					$save_arr[] = $value;
				}
			}
			break;
		}
	}

	return $save_arr;
}


$v = sort_arr($a,$b,$c,$d);
var_export($v);
