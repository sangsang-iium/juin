<?php
include_once("./_common.php");
include_once(BV_ADMIN_PATH."/admin_access.php");
include_once(BV_ADMIN_PATH."/admin_head.php");

$pg_title = ADMIN_MENU8;
$pg_num = 8;
$snb_icon = "<i class=\"fa fa-comments-o\"></i>";

if($member['id'] != 'admin' && !$member['auth_'.$pg_num]) {
	alert("���ٱ����� �����ϴ�.");
}

if($code == "qa")			$pg_title2 = ADMIN_MENU8_01;
if($code == "qa_form")		$pg_title2 = ADMIN_MENU8_01;
// if($code == "leave")		$pg_title2 = ADMIN_MENU8_02;
if($code == "faq_group")	$pg_title2 = ADMIN_MENU8_03;
if($code == "faq")			$pg_title2 = ADMIN_MENU8_04;
if($code == "faq_from")		$pg_title2 = ADMIN_MENU8_04;
if($code == "singo")		$pg_title2 = ADMIN_MENU8_05;
if($code == "singod")		$pg_title2 = ADMIN_MENU8_05;

include_once(BV_ADMIN_PATH."/admin_topmenu.php");
?>

<div class="s_wrap">
	<h4 class="htag_title"><?php echo $pg_title2; ?></h4>
    <p class="gap50"></p>
	<?php 
	include_once(BV_ADMIN_PATH."/help/help_{$code}.php"); 
	?>
</div>

<?php
include_once(BV_ADMIN_PATH."/admin_tail.php");
?>