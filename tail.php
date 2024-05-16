<?php
if(!defined('_BLUEVATION_')) exit;

include_once(BV_THEME_PATH.'/tail.skin.php'); // 하단

// BODY 내부 메시지
if($config['tail_script']) {
	echo $config['tail_script'].PHP_EOL;
}

include_once(BV_PATH."/tail.sub.php");
?>