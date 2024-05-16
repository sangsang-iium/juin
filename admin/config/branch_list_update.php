<?php //지회 삭제 _20240516_SY
include_once("./_common.php");

alert("Notice : 담당자관리 개발 후 작업 예정", BV_ADMIN_URL."/config.php?$q1&page=$page");
// print_r2($_POST);
exit;


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

    // 보류 : 담당자 테이블 만들어지면 다시 작업 할 예정 _20240516_SY

	}
}


goto_url(BV_ADMIN_URL."/config.php?$q1&page=$page");