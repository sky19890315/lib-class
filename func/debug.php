<?php
/**
 * Created by PhpStorm.
 * User: sunkeyi
 * Date: 2017/5/22
 * Time: 上午12:38
 */
function debug($var = null,$dump = true, $exit = true)
{
	if ($var === null){
		echo "必要参数不能为空";
		if ($exit){
			exit;
		}
	}else {

		if (is_array($var)) {
			print_r($var);
			if ($exit) {
				exit;
			}
		} else {

			if ($dump) {
				echo "输出结果为：";
				echo "<hr/>";
				var_dump($var);
				echo "<hr/>";
				echo "<br/>";
				echo "输出结束！";
			}
			if ($exit) {
				echo "程序退出";
				exit;
			}

		}
	}
}