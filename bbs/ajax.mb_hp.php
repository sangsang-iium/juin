<?php
define('_PURENESS_', true);
include_once('./_common.php');
include_once(BV_LIB_PATH.'/register.lib.php');

$mb_hp   = trim($_POST['reg_mb_hp']);
$mb_id   = trim($_POST['reg_mb_id']);

if($msg = valid_mb_hp($mb_hp)) die($msg);
//if($msg = exist_mb_hp($mb_hp, $mb_id)) die($msg);
?>