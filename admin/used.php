<?php
include_once("./_common.php");
include_once(BV_ADMIN_PATH."/admin_access.php");
include_once(BV_ADMIN_PATH."/admin_head.php");

$pg_title = ADMIN_MENU11;
$pg_num = 11;
$snb_icon = "<i class=\"fa fa-sitemap\"></i>";

if($member['id'] != 'admin' && !$member['auth_'.$pg_num]) {
	alert("접근권한이 없습니다.");
}

if($code == "list"){
    $pg_title2 = ADMIN_MENU11_01;
    $pg_title3 = ADMIN_MENU11_01;
} else if($code == "form"){
    $pg_title2 = ADMIN_MENU11_01;
    $pg_title3 = ADMIN_MENU11_02;
} else if($code == "view"){
    $pg_title2 = ADMIN_MENU11_01;
    $pg_title3 = ADMIN_MENU11_03;
}

include_once(BV_ADMIN_PATH."/admin_topmenu.php");
?>

<div class="s_wrap">
	<h4 class="htag_title"><?php echo $pg_title3; ?></h4>
    <p class="gap50"></p>
	<?php
	include_once(BV_ADMIN_PATH."/used/used_{$code}.php");
	?>
</div>

<?php
include_once(BV_ADMIN_PATH."/admin_tail.php");
?>