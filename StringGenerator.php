<?php

/**
 * Created by PhpStorm.
 * User: sunkeyi
 * Date: 2017/5/16
 * Time: 下午4:28
 */
class StringGenerator
{
	/**
	 * @param int $len
	 * @return StringGenerator
	 */
	public function generator($len = 8)
	{
		//取范围数组
		$arrA = range('a', 'z');
		$arrB = range('A','Z');
		$arrC = range(0,9);

		//合并数组
		$arr = array_merge($arrA, $arrB, $arrC);

		//反转键值对
		$arrR = array_flip($arr);

		//从数组中取出指定长度对键
		$keys = array_rand($arrR, $len);

		//转换为字符串
		$str = implode('' ,$keys);
		$str = str_shuffle($str);
		//返回字符串
		return $str;

	}
}