<?php
include_once("./_common.php");

check_demo();

if(!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $fr_date)) $fr_date = '';
if(!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $to_date)) $to_date = '';

$sql_common = " from shop_member ";
$sql_search = " where grade between 2 and 6 ";

if($sfl && $stx) {
    $sql_search .= " and $sfl like '%$stx%' ";
}

if(isset($sst) && is_numeric($sst))
	$sql_search .= " and grade = '$sst' ";

if(!$orderby) {
    $filed = "index_no";
    $sod = "desc";
} else {
	$sod = $orderby;
}

$sql_order = " order by $filed $sod ";

$sql = " select * $sql_common $sql_search $sql_order ";
$result = sql_query($sql);
$cnt = @sql_num_rows($result);
if(!$cnt)
	alert("출력할 내역이 없습니다.");

$sql_time = "";
if($fr_date && $to_date)
    $sql_time .= " and left(od_time,10) between '$fr_date' and '$to_date' ";
else if($fr_date && !$to_date)
	$sql_time .= " and left(od_time,10) between '$fr_date' and '$fr_date' ";
else if(!$fr_date && $to_date)
	$sql_time .= " and left(od_time,10) between '$to_date' and '$to_date' ";

/** Include PHPExcel */
include_once(BV_LIB_PATH.'/PHPExcel.php');

// Create new PHPExcel object
$excel = new PHPExcel();

// Add some data
$char = 'A';
$excel->setActiveSheetIndex(0)
	->setCellValue($char++.'1', '회원명')
	->setCellValue($char++.'1', '아이디')
	->setCellValue($char++.'1', '레벨')
	->setCellValue($char++.'1', '판매상품수')
	->setCellValue($char++.'1', '주문액')
	->setCellValue($char++.'1', '오늘')
	->setCellValue($char++.'1', '어제')
	->setCellValue($char++.'1', '일주일')
	->setCellValue($char++.'1', '지난달')
	->setCellValue($char++.'1', '3개월');

for($i=2; $row=sql_fetch_array($result); $i++)
{
	$info = partner_order_status_sum($row['id'], $sql_time);

	// 오늘
	$and1 = " and left(od_time,10) between '".BV_TIME_YMD."' and '".BV_TIME_YMD."' ";
	$row1 = partner_order_status_sum($row['id'], $and1);

	// 어제
	$yesterday = date("Y-m-d", strtotime("-1 day"));
	$and2 = " and left(od_time,10) between '".$yesterday."' and '".BV_TIME_YMD."' ";
	$row2 = partner_order_status_sum($row['id'], $and2);

	// 일주일
	$weekday = date("Y-m-d", strtotime("-7 day"));
	$and3 = " and left(od_time,10) between '".$weekday."' and '".BV_TIME_YMD."' ";
	$row3 = partner_order_status_sum($row['id'], $and3);

	// 지난달
	$month1 = date("Y-m", strtotime("-1 month"));
	$and4 = " and left(od_time,7) = '$month1' ";
	$row4 = partner_order_status_sum($row['id'], $and4);

	// 3개월
	$month3 = date("Y-m-d", strtotime("-3 month"));
	$and5 = " and left(od_time,10) between '".$month3."' and '".BV_TIME_YMD."' ";
	$row5 = partner_order_status_sum($row['id'], $and5);

	$char = 'A';
	$excel->setActiveSheetIndex(0)
		->setCellValueExplicit($char++.$i, $row['name'], PHPExcel_Cell_DataType::TYPE_STRING)
		->setCellValueExplicit($char++.$i, $row['id'], PHPExcel_Cell_DataType::TYPE_STRING)
		->setCellValueExplicit($char++.$i, get_grade($row['grade']), PHPExcel_Cell_DataType::TYPE_STRING)
		->setCellValueExplicit($char++.$i, $info['cnt'], PHPExcel_Cell_DataType::TYPE_NUMERIC)
		->setCellValueExplicit($char++.$i, $info['price'], PHPExcel_Cell_DataType::TYPE_NUMERIC)
		->setCellValueExplicit($char++.$i, $row1['price'], PHPExcel_Cell_DataType::TYPE_NUMERIC)
		->setCellValueExplicit($char++.$i, $row2['price'], PHPExcel_Cell_DataType::TYPE_NUMERIC)
		->setCellValueExplicit($char++.$i, $row3['price'], PHPExcel_Cell_DataType::TYPE_NUMERIC)
		->setCellValueExplicit($char++.$i, $row4['price'], PHPExcel_Cell_DataType::TYPE_NUMERIC)
		->setCellValueExplicit($char++.$i, $row5['price'], PHPExcel_Cell_DataType::TYPE_NUMERIC);
}

// Rename worksheet
$excel->getActiveSheet()->setTitle('가맹점 주문통계');

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$excel->setActiveSheetIndex(0);

// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="가맹점 주문통계-'.date("ymd", time()).'.xlsx"');
header('Cache-Control: max-age=0');

$writer = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
$writer->save('php://output');
?>