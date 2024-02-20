<?php
if(!defined('_BLUEVATION_')) exit;

if(!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $fr_date)) $fr_date = '';
if(!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $to_date)) $to_date = '';

$query_string = "code=$code$qstr";
$q1 = $query_string;
$q2 = $query_string."&page=$page";

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

// 테이블의 전체 레코드수만 얻음
$sql = " select count(*) as cnt $sql_common $sql_search ";
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = 30;
$total_page = ceil($total_count / $rows); // 전체 페이지 계산
if($page == "") { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함
$num = $total_count - (($page-1)*$rows);

$sql = " select * $sql_common $sql_search $sql_order limit $from_record, $rows ";
$result = sql_query($sql);

// 가맹점 총 주문액 계산
$sql_time = "";
if($fr_date && $to_date)
    $sql_time .= " and left(od_time,10) between '$fr_date' and '$to_date' ";
else if($fr_date && !$to_date)
	$sql_time .= " and left(od_time,10) between '$fr_date' and '$fr_date' ";
else if(!$fr_date && $to_date)
	$sql_time .= " and left(od_time,10) between '$to_date' and '$to_date' ";

$sum_count = 0;
$sum_price = 0;

$res = sql_query($sql);
while($row=sql_fetch_array($res)) {
	$info = partner_order_status_sum($row['id'], $sql_time);
	$sum_count += $info['cnt'];
	$sum_price += $info['price'];
}

$btn_frmline = <<<EOF
<a href="./partner/pt_order1excel.php?$q1" class="btn_small bx-white"><i class="fa fa-file-excel-o"></i> 엑셀저장</a>
EOF;

include_once(BV_PLUGIN_PATH.'/jquery-ui/datepicker.php');
?>

<h2>기본검색</h2>
<form name="fsearch" id="fsearch" method="get">
<input type="hidden" name="code" value="<?php echo $code; ?>">
<div class="tbl_frm01">
	<table>
	<colgroup>
		<col class="w100">
		<col>
	</colgroup>
	<tbody>
	<tr>
		<th scope="row">검색어</th>
		<td>
			<select name="sfl">
				<?php echo option_selected('id', $sfl, '아이디'); ?>
				<?php echo option_selected('name', $sfl, '회원명'); ?>
			</select>
			<input type="text" name="stx" value="<?php echo $stx; ?>" class="frm_input" size="30">
		</td>
	</tr>
	<tr>
		<th scope="row">주문일</th>
		<td>
			<?php echo get_search_date("fr_date", "to_date", $fr_date, $to_date); ?>
		</td>
	</tr>
	<tr>
		<th scope="row">레벨검색</th>
		<td>
			<?php echo get_search_level('sst', $sst, 2, 6); ?>
		</td>
	</tr>
	</tbody>
	</table>
</div>
<div class="btn_confirm">
	<input type="submit" value="검색" class="btn_medium">
	<input type="button" value="초기화" id="frmRest" class="btn_medium grey">
</div>
</form>

<div class="local_ov mart30">
	전체 : <b class="fc_red"><?php echo number_format($total_count); ?></b> 명 조회
	<strong class="ov_a">총 주문액 : <?php echo number_format($sum_price); ?>원</strong>
	<strong class="ov_a">총 판매상품수 : <?php echo number_format($sum_count); ?>건</strong>
</div>
<div class="local_frm01">
	<?php echo $btn_frmline; ?>
</div>
<div class="tbl_head02">
	<table id="partner_list">
	<colgroup>
		<col class="w50">
		<col class="w130">
		<col class="w130">
		<col class="w130">
		<col>
		<col class="w100">
		<col class="w100">
		<col class="w100">
		<col class="w100">
		<col class="w100">
		<col class="w100">
		<col class="w100">
	</colgroup>
	<thead>
	<tr>
		<th scope="col" rowspan="2">번호</th>
		<th scope="col" rowspan="2"><?php echo subject_sort_link('name',$q2); ?>회원명</a></th>
		<th scope="col" rowspan="2"><?php echo subject_sort_link('id',$q2); ?>아이디</a></th>
		<th scope="col" rowspan="2"><?php echo subject_sort_link('grade',$q2); ?>레벨</a></th>
		<th scope="col" rowspan="2">그래프 (주문액)</th>
		<th scope="col" colspan="2">검색집계</th>
		<th scope="col" colspan="5">최근집계 (오늘날짜 기준)</th>
	</tr>
	<tr class="rows">
		<th scope="col" class="th_bg2">판매상품수</th>
		<th scope="col" class="th_bg2">주문액</th>
		<th scope="col" class="th_bg">오늘</th>
		<th scope="col" class="th_bg">어제</th>
		<th scope="col" class="th_bg">일주일</th>
		<th scope="col" class="th_bg">지난달</th>
		<th scope="col" class="th_bg">3개월</th>
	</tr>
	</thead>
	<?php
	if(!$sum_price) $sum_price = 1;
	for($i=0; $row=sql_fetch_array($result); $i++) {
		$info = partner_order_status_sum($row['id'], $sql_time);

		// 그래프
		$rate = ((int)$info['price'] / $sum_price * 100);
		$s_rate = number_format($rate, 1);

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

		if($i==0)
			echo '<tbody class="list">'.PHP_EOL;

		$bg = 'list'.($i%2);
	?>
	<tr class="<?php echo $bg; ?>">
		<td><?php echo $num--; ?></td>
		<td class="tal"><?php echo get_sideview($row['id'], $row['name']); ?></td>
		<td class="tal"><?php echo $row['id']; ?></td>
		<td><?php echo get_grade($row['grade']); ?></td>
		<td><div class="graph"><span class="bar" style="width:<?php echo $s_rate; ?>%"></span></div></td>
		<td class="tac"><?php echo number_format($info['cnt']); ?></td>
		<td class="tar"><?php echo number_format($info['price']); ?></td>
		<td class="tar"><?php echo number_format($row1['price']); ?></td>
		<td class="tar"><?php echo number_format($row2['price']); ?></td>
		<td class="tar"><?php echo number_format($row3['price']); ?></td>
		<td class="tar"><?php echo number_format($row4['price']); ?></td>
		<td class="tar"><?php echo number_format($row5['price']); ?></td>
	</tr>
	<?php
	}
	if($i==0)
		echo '<tbody><tr><td colspan="12" class="empty_table">자료가 없습니다.</td></tr>';
	?>
	</tbody>
	</table>
</div>
<div class="local_frm02">
	<?php echo $btn_frmline; ?>
</div>

<?php
echo get_paging($config['write_pages'], $page, $total_page, $_SERVER['SCRIPT_NAME'].'?'.$q1.'&page=');
?>

<div class="information">
	<h4>도움말</h4>
	<div class="content">
		<div class="desc02">
			<p>ㆍ가맹점 주문통계는 <strong>(취소/환불/반품)</strong> 내역은 제외 입니다.</p>
			<p>ㆍ최근집계 항목은 검색결과에 반영되지 않으며 오늘날짜를 기준으로 고정되어 노출됩니다.</p>
		</div>
	 </div>
</div>

<script>
$(function(){
	// 날짜 검색 : TODAY MAX값으로 인식 (maxDate: "+0d")를 삭제하면 MAX값 해제
	$("#fr_date, #to_date").datepicker({ changeMonth: true, changeYear: true, dateFormat: "yy-mm-dd", showButtonPanel: true, yearRange: "c-99:c+99" });
});
</script>
