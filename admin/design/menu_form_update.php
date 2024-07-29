<?php
include_once("./_common.php");

check_demo();

check_admin_token();

for($i=0; $i<count($m_idx); $i++) {
	unset($value);
	$m_yn = "N";
	if(isset($_POST['m_yn'][$i])){
		$m_yn =  $_POST['m_yn'][$i] == "Y" ? "Y" : "N";
	}
	$value['m_yn'] = $m_yn;
	$value['m_name'] = $_POST['m_name'][$i];
	$value['m_url'] = $_POST['m_url'][$i];
	$value['m_seq'] = $_POST['m_seq'][$i];
	$where = "WHERE m_idx = '{$_POST['m_idx'][$i]}'";
	update('shop_menu', $value, $where);
}

goto_url(BV_ADMIN_URL.'/design.php?code=menu_form');
?>