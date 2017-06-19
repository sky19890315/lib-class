<?php
/**
 * Created by PhpStorm.
 * User: sunkeyi
 * Date: 2017/5/22
 * Time: 下午11:16
 */

require_once 'debug.php';
// ini_set('allow_call_time_pass_reference',true);

$a = 1;

$b = &$a;

debug($b);