<?php
/**
 *
 */
class test {
	function getArg() {
		$args = func_get_args();
		foreach ($args as $key => $value) {
			echo "参数" . ($key + 1) . ":$value\n";
		}
	}
	function getGlob($fileName) {
		$files = glob($fileName);
		print_r($files);
	}

}

$oTest = new test;
echo uniqid();