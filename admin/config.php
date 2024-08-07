<?php
include_once("./_common.php");
include_once(BV_ADMIN_PATH."/admin_access.php");
include_once(BV_ADMIN_PATH."/admin_head.php");

$pg_title = ADMIN_MENU10;
$pg_num = 10;
$snb_icon = "<i class=\"fa fa-cogs\"></i>";

if($member['grade'] != '1' && !$member['auth_'.$pg_num]) {
	alert("접근권한이 없습니다.");
}

if($code == "default")			                $pg_title2 = ADMIN_MENU10_01;
if($code == "meta")				                  $pg_title2 = ADMIN_MENU10_02;
if($code == "sns")				                  $pg_title2 = ADMIN_MENU10_03;
if($code == "register")			                $pg_title2 = ADMIN_MENU10_04;
if($code == "sendmail_test")                $pg_title2 = ADMIN_MENU10_05;
if($code == "sms")			  	                $pg_title2 = ADMIN_MENU10_06;
if($code == "supply")			                  $pg_title2 = ADMIN_MENU10_07;
if($code == "super")			                  $pg_title2 = ADMIN_MENU10_08;
if($code == "managerinfo")                  $pg_title2 = ADMIN_MENU10_22;
if($code == "pg")				                    $pg_title2 = ADMIN_MENU10_09;
if($code == "kakaopay")			                $pg_title2 = ADMIN_MENU10_10;
if($code == "naverpay")			                $pg_title2 = ADMIN_MENU10_11;
if($code == "baesong")			                $pg_title2 = ADMIN_MENU10_12;
if($code == "islandlist")		                $pg_title2 = ADMIN_MENU10_13;
if($code == "nicecheck")		                $pg_title2 = ADMIN_MENU10_14;
if($code == "ipaccess")			                $pg_title2 = ADMIN_MENU10_15;
if($code == "board_group_list")	            $pg_title2 = ADMIN_MENU10_16;
if($code == "board_group_form")	            $pg_title2 = ADMIN_MENU10_16;
if($code == "board_list")		                $pg_title2 = ADMIN_MENU10_17;
if($code == "board_form")		                $pg_title2 = ADMIN_MENU10_17;
if($code == "branch")		                    $pg_title2 = ADMIN_MENU10_18;
if($code == "branch_register_form")         $pg_title2 = ADMIN_MENU10_18;
if($code == "chapter")		                  $pg_title2 = ADMIN_MENU10_19;
if($code == "chapter_register_form")        $pg_title2 = ADMIN_MENU10_19;
if($code == "manager_list")		              $pg_title2 = ADMIN_MENU10_20;
if($code == "manager_register_form")	      $pg_title2 = ADMIN_MENU10_20;
if($code == "authorization_list")         	$pg_title2 = ADMIN_MENU10_21;
if($code == "authorization_register_form")	$pg_title2 = ADMIN_MENU10_21;

include_once(BV_ADMIN_PATH."/admin_topmenu.php");
?>

<div class="s_wrap">
	<h4 class="htag_title"><?php echo $pg_title2; ?></h4>
    <p class="gap50"></p>
	<?php
	include_once(BV_ADMIN_PATH."/config/{$code}.php");
	?>
</div>

<?php
include_once(BV_ADMIN_PATH."/admin_tail.php");
?>