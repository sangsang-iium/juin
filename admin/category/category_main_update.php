<?php
include_once("./_common.php");

check_demo();

check_admin_token();

$srcfile = BV_DATA_PATH.'/category';
$upload_file = new upload_files($srcfile);

if(!is_dir($srcfile)) {
	@mkdir($srcfile, BV_DIR_PERMISSION);
	@chmod($srcfile, BV_DIR_PERMISSION);
}

if($sel_ca1) $upcate = $sel_ca1;
if($sel_ca2) $upcate = $sel_ca2;
if($sel_ca3) $upcate = $sel_ca3;
if($sel_ca4) $upcate = $sel_ca4;

unset($value);
if($_FILES['headimg']['name'])
	$value['headimg'] = $upload_file->upload($_FILES['headimg']);

$new_code = get_ca_depth("shop_category", $upcate);
$new_next = get_next_wr_num("shop_category", "caterank", " where upcate='$upcate' ");

$value['catecode']		= $new_code;
$value['upcate']		= $upcate;
$value['caterank']		= $new_next;
$value['catename']		= $_POST['catename'];
$value['headimgurl']  = $_POST['headimgurl'];
insert("shop_category", $value);

goto_url(BV_ADMIN_URL."/category.php?$q1");
?>