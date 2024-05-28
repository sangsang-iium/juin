<?php
include_once("./_common.php");

check_demo();

check_admin_token();

$upl_dir = BV_DATA_PATH."/live";
$upl = new upload_files($upl_dir);


unset($value);
if($_POST['thumbnail_del']) {
	$upl->del($_POST['thumbnail_del']);
	$value['thumbnail'] = '';
}
if($_FILES['thumbnail']['name']) {
	$value['thumbnail'] = $upl->upload($_FILES['thumbnail']);
}


$value['title']	 = $_POST['title'];
$value['url'] = $_POST['url'];


$dateArr = array(
	array('weekname'=>'월','weekval'=>'mon'),
	array('weekname'=>'화','weekval'=>'tues'),
	array('weekname'=>'수','weekval'=>'wednes'),
	array('weekname'=>'목','weekval'=>'thurs'),
	array('weekname'=>'금','weekval'=>'fri'),
	array('weekname'=>'토','weekval'=>'satur'),
	array('weekname'=>'일','weekval'=>'sun'),
);

$liveDateArr = array();
foreach ($dateArr as $dateVal) {
	$liveDate = $dateVal['weekval']."_live";
	$liveStartDate = $dateVal['weekval']."_start_time";
	$liveEndDate = $dateVal['weekval']."_end_time";
	if($$liveDate == 'Y') {
		$liveDateArr[] = array('live_date'=>$dateVal['weekval'], 'live_start_time'=>$$liveStartDate, 'live_end_time'=>$$liveEndDate);
	}
}

$value['live_time'] = json_encode($liveDateArr);

if($w == '') {
	$value['reg_time'] = date('Y-m-d H:i:s');
	insert("shop_goods_live", $value);
	$index_no = sql_insert_id();

	goto_url(BV_ADMIN_URL."/goods.php?code=live_form&w=u&index_no=$index_no");

} else if($w == 'u') {
	update("shop_goods_live", $value, "where index_no='$index_no'");

	goto_url(BV_ADMIN_URL."/goods.php?code=live_form&w=u&index_no=$index_no$qstr&page=$page");
}
?>