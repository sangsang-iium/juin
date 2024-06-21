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

		$auth_idx = trim($_POST['idx'][$k]);

    // 쿼리 수정 _20240608_SY -> 쿼리 수정 _20240620_SY
		$row = sql_fetch(" SELECT COUNT(*) as cnt FROM shop_manager AS mng
                           LEFT JOIN kfia_office AS kf
                                  ON (mng.ju_region3 = kf.office_code)
                               WHERE kf.auth_idx = {$auth_idx} ");
		if($row['cnt'])
			alert("이 권한을 사용하는 담당직원이 있을 경우 삭제할 수 없습니다.\\n\\n이 권한을 사용중인 담당직원의 권한을 먼저 삭제하여 주십시오.", BV_ADMIN_URL."/config.php?code=manager_list&sfl=auth_idx&stx=$auth_idx");

		
		sql_query(" DELETE FROM authorization WHERE auth_idx = '$auth_idx' ");
	}
}

goto_url(BV_ADMIN_URL."/config.php?$q1&page=$page");
?>