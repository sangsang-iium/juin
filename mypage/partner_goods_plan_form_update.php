<?php
include_once("./_common.php");

check_demo();

check_admin_token();

$upl_dir = BV_DATA_PATH."/plan";
$upl = new upload_files($upl_dir);

unset($value);
if($_POST['pl_limg_del']) {
	$upl->del($_POST['pl_limg_del']);
	$value['pl_limg'] = '';
}
if($_POST['pl_bimg_del']) {
	$upl->del($_POST['pl_bimg_del']);
	$value['pl_bimg'] = '';
}
if($_FILES['pl_limg']['name']) {
	$value['pl_limg'] = $upl->upload($_FILES['pl_limg']);
}
if($_FILES['pl_bimg']['name']) {
	$value['pl_bimg'] = $upl->upload($_FILES['pl_bimg']);
}

$value['mb_id']	     = $member['id'];
$value['pl_name']	 = $_POST['pl_name'];
$value['pl_it_code'] = $_POST['pl_it_code'];
$value['pl_use']	 = $_POST['pl_use'];

if($w == '') {
	insert("shop_goods_plan", $value);
	$pl_no = sql_insert_id();

	goto_url(BV_MYPAGE_URL."/page.php?code=partner_goods_plan_form&w=u&pl_no=$pl_no");

} else if($w == 'u') {
	update("shop_goods_plan", $value, "where pl_no='$pl_no'");

	goto_url(BV_MYPAGE_URL."/page.php?code=partner_goods_plan_form&w=u&pl_no=$pl_no$qstr&page=$page");
}
?>