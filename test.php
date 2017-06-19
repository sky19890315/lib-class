<?php
/**
 * Created by PhpStorm.
 * User: sunkeyi
 * Date: 2017/6/15
 * Time: 下午10:32
 */
session_start();
//unset($_SESSION['name']);
$name = $_SESSION['name'];
echo "是否开启首页弹窗：".$name;