<?php
include_once("./_common.php");
include_once(BV_ADMIN_PATH."/admin_access.php");
include_once(BV_ADMIN_PATH."/admin_head.php");

$pg_title = ADMIN_MENU1;
$pg_num = 1;
$snb_icon = "<i class=\"ionicons ion-ios-people fs40\"></i>";

if($member['grade'] != '1' && !$member['auth_'.$pg_num]) {
	alert("접근권한이 없습니다.");
}

if($code == "list")					$pg_title2 = ADMIN_MENU1_01;
if($code == "level_form")			$pg_title2 = ADMIN_MENU1_02;
if($code == "register_form")		$pg_title2 = ADMIN_MENU1_03;
if($code == "xls")					$pg_title2 = ADMIN_MENU1_04;
if($code == "xls_update")			$pg_title2 = ADMIN_MENU1_04;
// if($code == "month")				$pg_title2 = ADMIN_MENU1_05;
// if($code == "day")					$pg_title2 = ADMIN_MENU1_06;
if($code == "point")				$pg_title2 = ADMIN_MENU1_07;
if($code == "pointxls")				$pg_title2 = ADMIN_MENU1_08;
if($code == "pointxls_update")		$pg_title2 = ADMIN_MENU1_08;
if($code == "point_select_form")	$pg_title2 = ADMIN_MENU1_09;
if($code == "point_select_list")	$pg_title2 = ADMIN_MENU1_09;
if($code == "mail_list")			$pg_title2 = ADMIN_MENU1_10;
if($code == "mail_form")			$pg_title2 = ADMIN_MENU1_10;
if($code == "mail_select_form")		$pg_title2 = ADMIN_MENU1_10;
if($code == "mail_select_list")		$pg_title2 = ADMIN_MENU1_10;
if($code == "mail_select_update")	$pg_title2 = ADMIN_MENU1_10;
if($code == "mail_select_update")	$pg_title2 = ADMIN_MENU1_10;
// 탈퇴 추가 _20240604_SY
if($code == "leave")		$pg_title2 = ADMIN_MENU8_02;
// push관리추가_20240719_ONE
if($code == "push")		$pg_title2 = ADMIN_MENU1_11;
if($code == "push_form")		$pg_title2 = ADMIN_MENU1_12;

include_once(BV_ADMIN_PATH."/admin_topmenu.php");
?>

<div class="s_wrap">
	<h4 class="htag_title"><?php echo $pg_title2; ?></h4>
    <p class="gap50"></p>
	<?php
	include_once(BV_ADMIN_PATH."/member/member_{$code}.php");
	?>
</div>

<?php
include_once(BV_ADMIN_PATH."/admin_tail.php");
?>