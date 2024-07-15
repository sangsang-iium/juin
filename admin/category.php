<?php
include_once("./_common.php");
include_once(BV_ADMIN_PATH."/admin_access.php");
include_once(BV_ADMIN_PATH."/admin_head.php");

$pg_title = ADMIN_MENU4;
$pg_num = 4;
$snb_icon = "<i class=\"fa fa-sitemap\"></i>";

if($member['grade'] != '1' && !$member['auth_'.$pg_num]) {
	alert("접근권한이 없습니다.");
}

if($code == "list") $pg_title2 = ADMIN_MENU4_01;
if($code == "view") $pg_title2 = ADMIN_MENU4_02;
if($code == "main") $pg_title2 = ADMIN_MENU4_03;
if($code == "used") $pg_title2 = ADMIN_MENU4_04;
if($code == "food") $pg_title2 = ADMIN_MENU4_05;
if($code == "singo") $pg_title2 = ADMIN_MENU4_06;

include_once(BV_ADMIN_PATH."/admin_topmenu.php");
?>

<div class="s_wrap">
	<h4 class="htag_title"><?php echo $pg_title2; ?></h4>
    <p class="gap50"></p>
	<?php
	include_once(BV_ADMIN_PATH."/category/category_{$code}.php");
	?>
</div>

<?php
include_once(BV_ADMIN_PATH."/admin_tail.php");
?>