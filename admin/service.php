<?php
include_once("./_common.php");
include_once(BV_ADMIN_PATH."/admin_access.php");
include_once(BV_ADMIN_PATH."/admin_head.php");

$pg_title = ADMIN_MENU12;
$pg_num = 12;
$snb_icon = "<i class=\"fa fa-sitemap\"></i>";

if($member['id'] != 'admin' && !$member['auth_'.$pg_num]) {
	alert("접근권한이 없습니다.");
}

if($code == "list"){
    $pg_title2 = ADMIN_MENU12_01;
    $pg_title3 = ADMIN_MENU12_01;
} else if($code == "view"){
    if($b_type == 1){
        $pg_title2 = ADMIN_MENU12_01;
        $pg_title3 = "신한신용";
    } else if($b_type == 2){
        $pg_title2 = ADMIN_MENU12_01;
        $pg_title3 = "신한체크";
    } else if($b_type == 3){
        $pg_title2 = ADMIN_MENU12_01;
        $pg_title3 = "노무";
    } else if($b_type == 4){
        $pg_title2 = ADMIN_MENU12_01;
        $pg_title3 = "상조";
    }
}

include_once(BV_ADMIN_PATH."/admin_topmenu.php");
?>

<div class="s_wrap">
	<h4 class="htag_title"><?php echo $pg_title3; ?></h4>
    <p class="gap50"></p>
	<?php
    if($code == 'view'){
        include_once(BV_ADMIN_PATH."/service/service_{$code}{$b_type}.php");
    } else {
        include_once(BV_ADMIN_PATH."/service/service_{$code}.php");
    }
	?>
</div>

<?php
include_once(BV_ADMIN_PATH."/admin_tail.php");
?>