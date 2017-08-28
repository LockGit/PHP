<?php
/**
 * @Author: lock
 * @Date:   2017-08-25 00:49:38
 * @Last Modified by:   lock
 * @Last Modified time: 2017-08-26 23:14:07
 */
$arr = array(
	'1.1.1.1_4.1.1.8',
	'2.2.2.1_5.5.5.5',
	'110.3.1.1_194.2.168.1',
	'192.168.1.1_223.233.223.1',
	'192.165.1.2_193.2.2.1',
	'4.4.4.4_6.6.6.6',
	'8.8.8.1_10.1.1.1',
	'8.1.1.1_9.10.10.10',
	'18.1.1.1_19.2.2.2',
	'9.0.0.1_12.9.9.10',
	'195.0.0.1_225.0.0.1',
	'225.0.0.2_225.0.0.111',
	'255.0.0.112_255.0.0.220'
	);
$arr = [
	'1.1.1.1_8.8.8.8',
	'8.8.8.8_110.110.110.1',
	'7.7.7.7_8.1.1.1',
];


function setIpNum($ip){
	return bindec(decbin(ip2long($ip)));
}

function trans_to_num($arr){
	$ip_num_arr = [];
	foreach ($arr as $ip_segment) {
		list($startIp,$endIp) = explode('_', $ip_segment);
		$ip_num_arr[setIpNum($startIp)] = setIpNum($endIp);
	}
	ksort($ip_num_arr);
	return $ip_num_arr;
}



function merge_ip($arr){
	$merge_arr = [];
	foreach ($arr as $key => $value) {
		$merge_arr[]=['start'=>$key,'end'=>$value];
	}
	$finsh_arr = [];
	$tmp = array_shift($merge_arr);
	foreach ($merge_arr as $k=>$ip_arr) {
		if($ip_arr['start']<$tmp['end'] && $ip_arr['end']<$tmp['end']){
			continue;
		}elseif($ip_arr['start']<$tmp['end'] && $ip_arr['end']>$tmp['end']){
			$tmp['end'] = $ip_arr['end'];
		}else{
			$finsh_arr[]=$tmp;
			$tmp['start'] = $tmp['start'];
			if($ip_arr['start']>=$tmp['end']){
				$tmp['start'] = $ip_arr['start'];	
			}
			$tmp['end'] = max([$ip_arr['end'],$tmp['end']]);
		}
	}
	$finsh_arr[] = $tmp;
	$result = [];
	foreach ($finsh_arr as $ip_arr) {
		$result[]=long2ip($ip_arr['start']).'_'.long2ip($ip_arr['end']);
	}
	return implode(',',array_unique(array_filter($result)));
}

$d = trans_to_num($arr);
$m = merge_ip($d);

var_export($m);


