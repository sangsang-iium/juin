<?php //지회 삭제 _20240516_SY
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
    $kf_code = trim($_POST['kf_code'][$k]);

    // 담당자 체크
    $mn_region_sql = " SELECT COUNT(*) AS cnt FROM shop_manager WHERE ju_region_code = '{$kf_code}' ";
    $mn_region_row = sql_fetch($mn_region_sql);
    if($mn_region_row['cnt'])
      alert("담당자에 저장된 지부정보는 삭제할 수 없습니다.");

    sql_query(" DELETE FROM kfia_region WHERE kf_code = '{$kf_code}' ");
	}
}


goto_url(BV_ADMIN_URL."/config.php?$q1&page=$page");