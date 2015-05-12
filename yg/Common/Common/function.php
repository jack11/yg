<?php

/**
 * test dump
 */
function dumps($data){
	echo '<pre>';
	print_r($data);
	echo '</pre>';
	exit;
}

/**
 * 判断是否是不为空数组
 */
function empty_array($array){
	if(empty($array) || !is_array($array)){
		return TRUE;
	}
	return FALSE;
}
