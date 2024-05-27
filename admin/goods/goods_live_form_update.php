<?php
include_once("./_common.php");

check_demo();

check_admin_token();

$upl_dir = BV_DATA_PATH."/plan";
$upl = new upload_files($upl_dir);

echo '<xmp>'; print_r($_POST); echo '</xmp>';

exit;


unset($value);
if($_POST['thumbnail_del']) {
	$upl->del($_POST['thumbnail_del']);
	$value['thumbnail'] = '';
}
if($_FILES['thumbnail']['name']) {
	$value['thumbnail'] = $upl->upload($_FILES['thumbnail']);
}


$value['pl_name']	 = $_POST['title'];
$value['pl_it_code'] = $_POST['pl_it_code'];
$value['pl_use']	 = $_POST['url'];

if($w == '') {
	insert("shop_goods_live", $value);
	$index_no = sql_insert_id();

	goto_url(BV_ADMIN_URL."/goods.php?code=plan_form&w=u&index_no=$index_no");

} else if($w == 'u') {
	update("shop_goods_live", $value, "where index_no='$index_no'");

	goto_url(BV_ADMIN_URL."/goods.php?code=plan_form&w=u&index_no=$index_no$qstr&page=$page");
}
?>