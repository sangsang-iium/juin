<?php //권한 선택삭제 _20240530_SY
include_once("./_common.php");

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

		$mn_idx = trim($_POST['index_no'][$k]);

    $mn_info_sql = " SELECT * FROM shop_manager WHERE index_no = '{$mn_idx}' ";
    $mn_info_row = sql_fetch($mn_info_sql);

		$row = sql_fetch(" SELECT COUNT(*) AS cnt FROM shop_member WHERE ju_manager = '{$mn_idx}' ");
		if($row['cnt'])
			alert("배정된 회원이 있을 경우 삭제할 수 없습니다.\\n\\n 배정된 회원의 담당자를 정보를 먼저 삭제하여 주십시오.", BV_ADMIN_URL."/member.php?code=list&sfl=ju_manager&stx={$mn_info_row['name']}");

		
		sql_query(" DELETE FROM shop_manager WHERE index_no = '$mn_idx' ");
	}
}

goto_url(BV_ADMIN_URL."/config.php?$q1&page=$page");
?>