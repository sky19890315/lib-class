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
			echo $debugResult;
			print_r($val);
			echo "<hr/>";
		debug_zval_dump($val);
		echo "<hr/>";
		debug_print_backtrace();
		exit;
	}
	//字符串
	if (is_string($val)){

			echo $debugResult;
			var_dump($val);
		echo "<hr/>";
		debug_zval_dump($val);
		echo "<hr/>";
		debug_print_backtrace();
			exit;
	}


}

$str = 'abc';
debug($str);