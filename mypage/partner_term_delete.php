<?php
include_once("./_common.php");

check_demo();

check_admin_token();

$count = count($_POST['chk']);
if(!$count) {
	alert($_POST['act_button']." 하실 항목을 하나 이상 체크하세요.");
}

for($i=0; $i<$count; $i++)
{
    // 실제 번호를 넘김
	$k = $_POST['chk'][$i];

	$sql = " delete from shop_partner_term where index_no = '{$_POST['index_no'][$k]}' ";
	sql_query($sql);
}

goto_url(BV_MYPAGE_URL."/page.php?$q1&page=$page");
?>