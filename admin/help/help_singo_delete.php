<?php
include_once("./_common.php");

check_demo();

check_admin_token();

$count = count($_POST['chk']);
if(!$count) {
	alert($_POST['act_button']." 하실 항목을 하나 이상 체크하세요.");
}

for($i=0; $i<$count; $i++){
    // 실제 번호를 넘김
    $k = $_POST['chk'][$i];
	$no = trim($_POST['no'][$k]);
	$row = sql_fetch("select img from shop_used_singo where no = '$no'");
	@unlink(BV_DATA_PATH.'/singo/'.$row['img']);
	sql_query(" delete from shop_used_singo where no = '$no' ");
}

goto_url(BV_ADMIN_URL."/help.php?$q1&page=$page");
?>