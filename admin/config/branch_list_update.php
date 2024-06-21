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
    $branch_idx = trim($_POST['branch_idx'][$k]);

    // 담당자 지회/지부 체크
    $mn_region_sql = " SELECT     
                            (SELECT COUNT(*) FROM shop_manager a LEFT JOIN kfia_branch b ON a.ju_region2 = b.branch_code WHERE branch_idx = '{$branch_idx}') + 
                            (SELECT COUNT(*) FROM kfia_office a LEFT JOIN kfia_branch b ON a.branch_code = b.branch_code WHERE branch_idx = '{$branch_idx}') 
                            AS cnt
                     ";
    $mn_region_row = sql_fetch($mn_region_sql);

    if($mn_region_row['cnt'])
      alert("담당직원 및 지부정보에 저장된 지회정보는 삭제할 수 없습니다.");

    sql_query(" DELETE FROM kfia_branch WHERE branch_idx = '{$branch_idx}' ");
	}
}


goto_url(BV_ADMIN_URL."/config.php?$q1&page=$page");