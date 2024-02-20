<?php
include_once("./_common.php");

check_demo();

check_admin_token();

$gubun = trim($_POST['gubun']);
$new_brand = trim($_POST['new_brand']);
$act = trim($_POST['act']);

if($gubun == '1') // 선택한 상품만 적용
{
	for($i=0; $i<count($_POST['chk']); $i++)
	{
		// 실제 번호를 넘김
		$k = $_POST['chk'][$i];

		if($act == 1) {
			$brand_uid = $new_brand;
			$brand_nm = get_brand($new_brand); //브랜드명
		} else {
			$brand_uid = "";
			$brand_nm = "";
		}

		$sql = " update shop_goods
					set brand_uid = '$brand_uid',
					    brand_nm = '$brand_nm'
				  where index_no = '{$_POST['gs_id'][$k]}' ";
		sql_query($sql);
	}
}
else if($gubun == '2') // 검색된 상품에 적용
{
	foreach(explode("&", $q1) as $arr_param) {
		$param = explode("=", $arr_param);
		$$param[0] = $param[1];
	}

	if($sel_ca1) $sca = $sel_ca1;
	if($sel_ca2) $sca = $sel_ca2;
	if($sel_ca3) $sca = $sel_ca3;
	if($sel_ca4) $sca = $sel_ca4;
	if($sel_ca5) $sca = $sel_ca5;

	$sql_common = " from shop_goods ";
	$sql_search = " where use_aff = 0 and shop_state = 0 ";
	$sql_order  = " order by index_no desc ";

	include_once(BV_ADMIN_PATH.'/goods/goods_query.inc.php');

	$sql = " select index_no $sql_common $sql_search $sql_order ";
	$result = sql_query($sql);
	for($i=0; $row=sql_fetch_array($result); $i++)
	{
		if($act == 1) {
			$brand_uid = $new_brand;
			$brand_nm = get_brand($new_brand); //브랜드명
		} else {
			$brand_uid = "";
			$brand_nm = "";
		}

		$sql = " update shop_goods
					set brand_uid = '$brand_uid',
					    brand_nm = '$brand_nm'
				  where index_no = '{$row['index_no']}' ";
		sql_query($sql);
	}
}

goto_url(BV_ADMIN_URL."/goods.php?$q1&page=$page");
?>