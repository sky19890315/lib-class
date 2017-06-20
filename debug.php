<?php
/**
 * Created by PhpStorm.
 * User: sunkeyi
 * Date: 2017/6/19
 * Time: 下午11:01
 */

/**
 * @param $val
 * @param $onDebug
 * @return bool
 */
function debug($val, $onDebug = 1){
	//初始化
	if ($onDebug == 1) {
		ini_set('error_reporting', ' E_ALL & ~E_NOTICE');
		ini_set('display_errors', 'on');
	}else {
		echo "已<b>关闭</b>debug模式，如果需要开启，请将第二个参数设置为<b>1</b>，
不设置将<b>默认开启</b>debug模式;<br/>";
	}
	//固定变量
	$debugResult = "第".__LINE__."行--调试结果如下：<br/>";
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

class Test{
	public function getNum(){
		echo "hello";
	}
}

$ob = new Test();
debug($ob);