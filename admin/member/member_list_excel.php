<?php
include_once("./_common.php");

// check_demo();

$sql_region = "";
$sql_extra = "";

if (!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $fr_date)) {
  $fr_date = '';
}

if (!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $to_date)) {
  $to_date = '';
}

$query_string = "code=$code$qstr&os=$os&ssd=$ssd&ins=$ins&branch=$branch&office=$office&mgrade=$mgrade";
$q1           = $query_string;
$q2           = $query_string . "&page=$page";

$sql_common = " from shop_member AS mm";
$sql_search = " where mm.id <> 'admin' ";
// manager join 추가 _20240531_SY
$sql_join = " LEFT JOIN shop_manager AS mn
                     ON (mm.ju_manager = mn.index_no) ";


// Search > AliasFunc 추가 _20240610_SY
function addAliasFunc($column)
{
  if (strpos($column, '.') !== false) {
    return $column; // 이미 별칭이 붙어 있는 경우 그대로 반환
  }
  if ($column == 'ju_manager') {
    $alias = "mn.name";
  } else {
    $alias = "mm.$column";
  }
  return "$alias";
}


if ($sst) {
  $gradeColumn = addAliasFunc("grade");
  $sql_search .= " AND $gradeColumn = '$sst'";
}

if($os){
  if($os == "Windows"){
    $sql_search .= " AND mb_agent = '{$os}'";
  } else if($os == 'all') {
    $sql_search .= "";
  } else {
    $sql_search .= " AND mb_agent != 'Windows'";
  }
} else {
  $os = "all";
}

if ($ins) {
  if ($ins == "ins") {
    $sql_search .= " AND mm.login_sum >= 1";
  } else if ($ins == 'all') {
    $sql_search .= "";
  } else {
    $sql_search .= " AND mm.login_sum < 1";
  }
} else {
  $ins = "all";
}

$branch = ($branch == 'all') ? "" : $branch;
$office = ($office == 'all') ? "" : $office;
if ($branch) {
  $sql_search .= " AND mm.ju_region2 = '{$branch}' ";
}
if ($office) {
  $sql_search .= " AND mm.ju_region3 = '{$office}' ";
}
if ($mgrade) {
  $sql_search .= " AND mm.grade = '{$mgrade}' ";
}



// 기간검색
$sptColumn = addAliasFunc($spt);
if ($fr_date && $to_date) {
  $sql_search .= " and {$sptColumn} between '$fr_date 00:00:00' and '$to_date 23:59:59' ";
} else if ($fr_date && !$to_date) {
  $sql_search .= " and {$sptColumn} between '$fr_date 00:00:00' and '$fr_date 23:59:59' ";
} else if (!$fr_date && $to_date) {
  $sql_search .= " and {$sptColumn} between '$to_date 00:00:00' and '$to_date 23:59:59' ";
}

// 탈퇴 검색

if($ssd) {
  switch($ssd) {
    case "휴업":
      $ssd_code = "02";
      break;
    case "폐업":
      $ssd_code = "03";
      break;
  }
  if($ssd == '탈퇴') {
    $sql_search .= " and mm.intercept_date <> '' ";
  } else if($ssd == 'all') {
    $sql_search .= "";
  } else {
    $sql_search .= " and mm.ju_closed = '{$ssd_code}' ";
  }
} else {
  $ssd = "all";
}

if (!$orderby) {
  $filed = "mm.name";
  $sod   = "asc";
} else {
  $sod = $orderby;
}

/* ------------------------------------------------------------------------------------- _20240717_SY
    * 지회/지부 권한 관려 수정
   ------------------------------------------------------------------------------------- */
// if ($_SESSION['ss_mn_id'] && $_SESSION['ss_mn_id'] != "admin") {
//   if($member['ju_region2'] != "00400") {
//     $belong_list = getBelongList($_SESSION['ss_mn_id'], "mm.ju_manager");
//     $sql_region .= $belong_list;
//     if($member['grade'] > 2) {
//       $sql_region .= " AND mm.grade >= 8 ";
//     }
//   }
// }



if ($sfl && $stx) {
  if($sfl == 'all') {

    $allColumns = array("mm.ju_restaurant" , "mm.ju_b_num" , "mm.name" , "mm.cellphone" , "mm.id" , "mn.name");
    $i = 0;
    $sql_search .= " AND (";
    foreach ($allColumns as $columnVal) {
      if($i != 0) $sql_search .= " OR ";
      $sql_search .= " INSTR( LOWER($columnVal) , LOWER('$stx') ) ";
      $i++;
    }

    $branch_where = " WHERE (1) AND b.branch_name LIKE '%$stx%' ";
    $branch_data = getRegionFunc("branch",$branch_where);
    $b_sql = "";
    for($i=0; $i<count($branch_data); $i++) {
      $values[] = "'" . $branch_data[$i]['branch_code'] . "'";
    }
    if (!empty($values)) {
      $b_sql = implode(", ", $values);
      $sql_search .= " OR mm.ju_region2 IN ( $b_sql ) ";
    }

    $office_where = " WHERE (1) AND a.office_name LIKE '%$stx%' ";
    $office_data = getRegionFunc("office",$office_where);
    $s_sql = "";
    for($i=0; $i<count($office_data); $i++) {
      $values[] = "'" . $office_data[$i]['office_code'] . "'";
    }
    if (!empty($values)) {
      $s_sql = implode(", ", $values);
      $sql_search .= " OR mm.ju_region3 IN ( $s_sql ) ";
    }

    $sql_search .= ") ";

  } else {
    $sflColumn = addAliasFunc($sfl);
    $sql_search .= " AND {$sflColumn} like '%$stx%' ";
  }

}


/* ------------------------------------------------------------------------------------- _20240726_SY
  * 지회/지부 마스터 이상일 경우 본인 소속 사업장도 조회
 ------------------------------------------------------------------------------------- */
 if ($_SESSION['ss_mn_id'] && $_SESSION['ss_mn_id'] != "admin") {
  if($member['ju_region2'] != "00400" && $member['grade'] < 3 ) {
    $office_chk_sel = " SELECT COUNT(*) as cnt FROM kfia_branch WHERE branch_code = '{$member['ju_region3']}' ";
    $office_chk_res = sql_fetch($office_chk_sel);
    if($office_chk_res['cnt'] < 1) {
      $sql_extra .= " AND mm.ju_region3 = '{$member['ju_region3']}' ";
    } else {
      $sql_extra .= " AND mm.ju_region2 = '{$member['ju_region2']}' ";
    }
  } else if($member['grade'] > 2) {
    $sql_search .= " AND mm.ju_manager = '{$member['index_no']}'
                     AND mm.grade > 6 ";
  }
}


$sql_order = " order by $filed $sod ";


$sql    = " select mm.*, mn.name AS mn_name, mn.id AS mn_id, mn.index_no AS mn_idx $sql_common {$sql_join} $sql_search {$sql_region} {$sql_extra} $sql_order ";
$result = sql_query($sql);
$cnt = @sql_num_rows($result);
if(!$cnt)
	alert("출력할 자료가 없습니다.");

/** Include PHPExcel */
include_once(BV_LIB_PATH.'/PHPExcel.php');

// Create new PHPExcel object
$excel = new PHPExcel();

// Add some data
$char = 'A';
$excel->setActiveSheetIndex(0)
	->setCellValue($char++.'1', '회원명')
	->setCellValue($char++.'1', '업소명')
	->setCellValue($char++.'1', '사업자번호')
	->setCellValue($char++.'1', '아이디')
	->setCellValue($char++.'1', '성별')
	->setCellValue($char++.'1', '등급')
	->setCellValue($char++.'1', '담당자')
	->setCellValue($char++.'1', '지회')
	->setCellValue($char++.'1', '지부')
	->setCellValue($char++.'1', '전화번호')
	->setCellValue($char++.'1', '핸드폰')
	->setCellValue($char++.'1', '우편번호')
	->setCellValue($char++.'1', '주소')
	->setCellValue($char++.'1', '이메일')
	->setCellValue($char++.'1', '회원가입일')
	->setCellValue($char++.'1', '로그인횟수')
	->setCellValue($char++.'1', '앱설치')
	->setCellValue($char++.'1', '포인트')
	->setCellValue($char++.'1', '접속OS');

for($i=2; $row=sql_fetch_array($result); $i++)
{
  $grade_name_sql = " SELECT gb_name FROM shop_member AS mm
                   LEFT JOIN shop_member_grade AS mg
                          ON mm.grade = mg.gb_no
                       WHERE mm.id = '{$row['id']}' ";
  $grade_name_row = sql_fetch($grade_name_sql);

  $manager_sel = " SELECT mn.id AS managerId, mn.name AS managerName FROM shop_manager AS mn
                LEFT JOIN shop_member AS mm
                       ON (mn.index_no = mm.ju_manager)
                    WHERE mm.id = '{$row['id']}' ";
  $manager_row = sql_fetch($manager_sel);
  $managerText = $manager_row ? "{$manager_row['managerName']} ({$manager_row['managerId']})" : "없음";

  $officeData = getRegionFunc("office"," WHERE b.branch_code = '{$row['ju_region2']}' AND a.office_code = '{$row['ju_region3']}' ");
  $genderText = "";
  if($row['gender'] == "M") {
    $genderText = "남성";
  } else if($row['gender'] == "F")
  $genderText = "여성";

  if($row['mb_agent'] == "Window") {
    $agent = "웹";
  } else {
    $agent = "모바일";
  }
  $insData = $row['login_sum'] < 1 ? "미설치" : "설치";

	$char = 'A';
	$excel->setActiveSheetIndex(0)
		->setCellValueExplicit($char++.$i, $row['name'], PHPExcel_Cell_DataType::TYPE_STRING)
		->setCellValueExplicit($char++.$i, $row['ju_restaurant'], PHPExcel_Cell_DataType::TYPE_STRING)
		->setCellValueExplicit($char++.$i, $row['ju_b_num'], PHPExcel_Cell_DataType::TYPE_STRING)
		->setCellValueExplicit($char++.$i, $row['id'], PHPExcel_Cell_DataType::TYPE_STRING)
		->setCellValueExplicit($char++.$i, $genderText, PHPExcel_Cell_DataType::TYPE_STRING)
		->setCellValueExplicit($char++.$i, $grade_name_row['gb_name'], PHPExcel_Cell_DataType::TYPE_STRING)
		->setCellValueExplicit($char++.$i, $managerText, PHPExcel_Cell_DataType::TYPE_STRING)
		->setCellValueExplicit($char++.$i, $officeData[0]['branch_name'], PHPExcel_Cell_DataType::TYPE_STRING)
		->setCellValueExplicit($char++.$i, $officeData[0]['office_name'], PHPExcel_Cell_DataType::TYPE_STRING)
		->setCellValueExplicit($char++.$i, $row['telephone'], PHPExcel_Cell_DataType::TYPE_STRING)
		->setCellValueExplicit($char++.$i, $row['cellphone'], PHPExcel_Cell_DataType::TYPE_STRING)
		->setCellValueExplicit($char++.$i, $row['zip'], PHPExcel_Cell_DataType::TYPE_STRING)
		->setCellValueExplicit($char++.$i, print_address($row['addr1'], $row['addr2'], $row['addr3'], $row['addr_jibeon']), PHPExcel_Cell_DataType::TYPE_STRING)
		->setCellValueExplicit($char++.$i, $row['email'], PHPExcel_Cell_DataType::TYPE_STRING)
		->setCellValueExplicit($char++.$i, $row['reg_time'], PHPExcel_Cell_DataType::TYPE_STRING)
		->setCellValueExplicit($char++.$i, $row['login_sum'], PHPExcel_Cell_DataType::TYPE_NUMERIC)
		->setCellValueExplicit($char++.$i, $insData, PHPExcel_Cell_DataType::TYPE_STRING)
		->setCellValueExplicit($char++.$i, $row['point'], PHPExcel_Cell_DataType::TYPE_NUMERIC)
		->setCellValueExplicit($char++.$i, $agent, PHPExcel_Cell_DataType::TYPE_STRING);
}

// Rename worksheet
$excel->getActiveSheet()->setTitle('회원목록');

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$excel->setActiveSheetIndex(0);

// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="회원목록-'.date("ymd", time()).'.xlsx"');
header('Cache-Control: max-age=0');

$writer = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
$writer->save('php://output');
?>