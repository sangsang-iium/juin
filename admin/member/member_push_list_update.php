<?php // 푸시 삭제 _20240802_SY
include_once "./_common.php";

check_demo();

check_admin_token();

$count = count($_POST['chk']);
if(!$count) {
	alert($_POST['act_button']." 하실 항목을 하나 이상 체크하세요.");
}

if($_POST['act_button'] == "선택삭제") 
{
	for($i=0; $i<$count; $i++)
	{
		// 실제 번호를 넘김
		$k = $_POST['chk'][$i];

		$push_idx = trim($_POST['push_id'][$k]);
		
		sql_query(" DELETE FROM iu_push WHERE idx = '$push_idx' ");
	}
}

goto_url(BV_ADMIN_URL."/member.php?$q1&page=$page");
?>