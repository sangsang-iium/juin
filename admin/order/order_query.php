<?php
if (!defined('_BLUEVATION_')) {
  exit;
}

$od_wdays = [];

if ($od_wday1) {
  $od_wdays[] = '월';
}

if ($od_wday2) {
  $od_wdays[] = '화';
}

if ($od_wday3) {
  $od_wdays[] = '수';
}

if ($od_wday4) {
  $od_wdays[] = '목';
}

if ($od_wday5) {
  $od_wdays[] = '금';
}

if ($od_wday6) {
  $od_wdays[] = '토';
}


if (!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $fr_date)) {
  $fr_date = '';
}

if (!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $to_date)) {
  $to_date = '';
}

if (isset($sel_field)) {
  $qstr .= "&sel_field=$sel_field";
}

if (isset($od_settle_case)) {
  $qstr .= "&od_settle_case=" . urlencode($od_settle_case);
}

if ($od_wday1) {
  $qstr .= "&od_wday1 = '$od_wday1' ";
}
if ($od_wday2) {
  $qstr .= "&od_wday2 = '$od_wday2' ";
}
if ($od_wday3) {
  $qstr .= "&od_wday3 = '$od_wday3' ";
}
if ($od_wday4) {
  $qstr .= "&od_wday4 = '$od_wday4' ";
}
if ($od_wday5) {
  $qstr .= "&od_wday5 = '$od_wday5' ";
}
if ($od_wday6) {
  $qstr .= "&od_wday6 = '$od_wday6' ";
}

if ($od_week) {
  $qstr .= "&od_week = '$od_week' ";
}

if ($od_b_cnt) {
  $qstr .= "&od_b_cnt = '$od_b_cnt' ";
}

if ($od_begin_date) {
  $qstr .= "&od_begin_date = '$od_begin_date' ";
}

if (isset($od_status)) {
  $qstr .= "&od_status=$od_status";
}

if (isset($od_final)) {
  $qstr .= "&od_final=$od_final";
}

if (isset($od_taxbill)) {
  $qstr .= "&od_taxbill=$od_taxbill";
}

if (isset($od_taxsave)) {
  $qstr .= "&od_taxsave=$od_taxsave";
}

if (isset($od_memo)) {
  $qstr .= "&od_memo=$od_memo";
}

if (isset($od_shop_memo)) {
  $qstr .= "&od_shop_memo=$od_shop_memo";
}

if (isset($od_receipt_point)) {
  $qstr .= "&od_receipt_point=$od_receipt_point";
}

if (isset($od_coupon)) {
  $qstr .= "&od_coupon=$od_coupon";
}

if (isset($od_escrow)) {
  $qstr .= "&od_escrow=$od_escrow";
}

$query_string = "code=$code$qstr";
$q1           = $query_string;
$q2           = $query_string . "&page=$page";

if($code == 'reg_list'){
	$sql_common = " from shop_order_reg ";
} else {
	$sql_common = " from shop_order ";
}

$where = array();

if ($code == 'list' || $code == 'reg_list') // 전체주문내역
{
  $where[] = " dan != 0 ";
} else {
  
  if($code=="7"){
    $where[] = " (dan = '$code' or dan='10' or dan='18' )";  
  }else{
    if($code=='9')
    {
      $where[] = " (dan = '$code' or dan='17' )";
    }else{
      if($code=="8"){
        $where[] = "( dan = '$code'  or dan='11' or dan='12' )";  
      }else{
        $where[] = " dan = '$code' ";  
      } 
    } 
  } 
}

if ($sfl && $stx) {
  if($sfl == 'all') {
    $allColumns = array("od_id","od_no","mb_id","name","deposit_name","bank","b_name","b_telephone","b_cellphone","delivery_no","seller_id","pt_id");
    $where[] = allSearchSqlArr($allColumns,$stx);
  } else {
    $where[] = " $sfl like '%$stx%' ";
  }
}

if ($od_settle_case) {
  $where[] = " paymethod = '$od_settle_case' ";
}

if (!empty($od_wdays)) {
  $od_wday = implode(',', $od_wdays);
  $where[] = "od_wday IN ('$od_wday')";
}

if ($od_week) {
	$where[] = " od_week = '$od_week' ";
}

if ($od_b_cnt) {
	$where[] = " od_reg_cnt = '$od_reg_cnt' ";
}

if ($od_begin_date) {
	$where[] = " od_begin_date = '$od_begin_date' ";
}

if (is_numeric($od_status)) {
  $where[] = " dan = '$od_status' "; 
}

if (is_numeric($od_final)) {
  /* ------------------------------------------------------------------------------------- _20240714_SY 
    * 강제출고, 강제출고완료, 강제입금 추가
  /* ------------------------------------------------------------------------------------- */
  if(in_array($od_final, ['15', '16', '13'])) {
    $where[] = " dan3 = '$od_final' ";
  } else {
    $where[] = " user_ok = '$od_final' ";
  }
}

if ($od_taxbill) {
  $where[] = " taxbill_yes = 'Y' ";
}

if ($od_taxsave) {
  $where[] = " taxsave_yes IN ('Y','S') ";
}

if ($od_memo) {
  $where[] = " memo <> '' ";
}

if ($od_shop_memo) {
  $where[] = " shop_memo <> '' ";
}

if ($od_receipt_point) {
  $where[] = " use_point != 0 ";
}

if ($od_coupon) {
  $where[] = " coupon_price != 0 ";
}

if ($od_escrow) {
  $where[] = " od_escrow = 1 ";
}

if ($fr_date && $to_date) {
  $where[] = " left({$sel_field},10) between '$fr_date' and '$to_date' ";
} else if ($fr_date && !$to_date) {
  $where[] = " left({$sel_field},10) between '$fr_date' and '$fr_date' ";
} else if (!$fr_date && $to_date) {
  $where[] = " left({$sel_field},10) between '$to_date' and '$to_date' ";
}

// 담당자 정보 추가 _20240619_SY
if($_SESSION['ss_mn_id'] && $_SESSION['ss_mn_id'] != "admin") {
  $mn_sql = " SELECT index_no FROM shop_manager WHERE `id` = '{$_SESSION['ss_mn_id']}' ";
  $mn_row = sql_fetch($mn_sql);
  $where[] = " mb_id IN ( SELECT id FROM shop_member WHERE ju_manager = '{$mn_row['index_no']}' ) ";
}

if ($where) {
  $sql_search = ' where ' . implode(' and ', $where);
}

$sql_group = " group by od_id ";
$sql_order = " order by index_no desc ";

// 테이블의 전체 레코드수만 얻음
$sql         = " select od_id {$sql_common} {$sql_search} {$sql_group} ";
$result      = sql_query($sql);
$total_count = sql_num_rows($result);

if ($_SESSION['ss_page_rows']) {
  $page_rows = $_SESSION['ss_page_rows'];
} else {
  $page_rows = 30;
}

$rows       = $page_rows;
$total_page = ceil($total_count / $rows); // 전체 페이지 계산
if ($page == "") {$page = 1;}             // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows;       // 시작 열을 구함
$num         = $total_count - (($page - 1) * $rows);

$sql    = " select * {$sql_common} {$sql_search} {$sql_group} {$sql_order} limit {$from_record}, {$rows} ";
$result = sql_query($sql);
//echo $sql;

$tot_orderprice = 0; // 총주문액
$sql            = " select od_id {$sql_common} {$sql_search} {$sql_group} {$sql_order} ";
$res            = sql_query($sql);
while ($row = sql_fetch_array($res)) {
  if($code == "reg_list"){
    $amount = get_order_spay2($row['od_id']);
  } else {
    $amount = get_order_spay($row['od_id']);
  }
  $tot_orderprice += $amount['buyprice'];
}



// 2024-06-20 태그 추가
function addTag($tagName){
  switch($tagName){
    case '강제입금' :
      $text = '강제입금';
      $class = 't1';
    break;

    case '강제입금완료' :
      $text = '강제입금완료';
      $class = 't2';
    break;

    case '강제출고' :
      $text = '강제출고';
      $class = 't3';
    break;

    case '강제출고완료' :
      $text = '강제출고완료';
      $class = 't4';
    break;
  }
  
  echo '<span class="admin-tag '.$class.'">'.$text.'</span>';
}

include_once BV_PLUGIN_PATH . '/jquery-ui/datepicker.php';
?>