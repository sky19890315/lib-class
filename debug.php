<?php
/**
 * Created by PhpStorm.
 * User: sunkeyi
 * Date: 2017/6/19
 * Time: 下午11:01
 */
/**
 * @param      $val
 */
function debug($val){
	$debugResult = "第".__LINE__."行--调试结果如下：<br/>";
	//初始化
	ini_set('display_errors','on');

	if ($val == null) {
		echo "关键参数缺失";
		return false;
	}

	//数组
	if (is_array($val)){
			echo "数组--".$debugResult;
			print_r($val);
	}
	//字符串
	if (is_string($val)){

			echo "字符串--".$debugResult;
			var_dump($val);
	}
	//对象
	if (is_object($val)){
		echo "对象--".$debugResult;
		var_dump($val);
	}//其他
	//资源
	if (is_resource($val)){
		echo "资源--".$debugResult;
		var_dump($val);
	}
	else{
		echo "其他类型--".$debugResult;
		var_dump($val);
	}
	echo "<hr/>";
	debug_zval_dump($val);
	echo "<hr/>";
	debug_print_backtrace();
	exit;



}
$dir ='./index.php';

debug($dir);