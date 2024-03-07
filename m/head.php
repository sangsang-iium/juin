<?php
if(!defined("_BLUEVATION_")) exit; // 개별 페이지 접근 불가

include_once(BV_MPATH."/head.sub.php");

// include_once(BV_MTHEME_PATH.'/head.skin.php');
// include_once(BV_PATH.'/include/header.php');
// include_once(BV_PATH.'/include/dockBar.php');

$current_url = $_SERVER['PHP_SELF'];
$filename = str_replace('.php', '', basename($current_url));

switch ($filename) {
  case 'index':
  case 'list':
  case 'listtype':
  case 'plan':
  case 'timesale':
    include_once(BV_PATH.'/include/topMenu.php');
    break;
  default: 
    break;
}
?>

<div class="popDim"></div>