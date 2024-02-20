<?php
include_once("./_common.php");

check_demo();

check_admin_token();

if(!$pf_auth_good)
	alert('개별 상품판매 권한이 있어야만 이용 가능합니다.');

$upl_dir = BV_DATA_PATH."/brand";
$upl = new upload_files($upl_dir);

unset($value);
if($_POST['br_logo_del']) {
	$upl->del($_POST['br_logo_del']);
	$value['br_logo'] = '';
}
if($_FILES['br_logo']['name']) {
	$value['br_logo'] = $upl->upload($_FILES['br_logo']);
}

$value['br_user_yes'] = 1;
$value['br_name'] = $_POST['br_name'];
$value['br_name_eng'] = $_POST['br_name_eng'];
$value['br_updatetime'] = BV_TIME_YMDHIS;

if($w == '') {
	$value['mb_id'] = $member['id'];
	$value['br_time'] = BV_TIME_YMDHIS;
	insert("shop_brand", $value);
	
	goto_url(BV_MYPAGE_URL."/page.php?$q1&page=$page");

} else if($w == 'u') {	
	update("shop_brand", $value, "where br_id='$br_id'");

	// 상품 정보도 동시에 수정
	$sql = "update shop_goods set brand_nm = '{$_POST['br_name']}' where brand_uid = '$br_id'";
	sql_query($sql, false);

	goto_url(BV_MYPAGE_URL."/page.php?code=partner_goods_brand_form&w=u&br_id=$br_id$qstr&page=$page");
}
?>