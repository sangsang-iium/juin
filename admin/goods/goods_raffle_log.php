<?php
if(!defined('_BLUEVATION_')) exit;

$query_string = "code=$code$qstr";
$q1 = $query_string;
$q2 = $query_string."&page=$page";

$sql_common = " from shop_goods_raffle_log ";
$sql_search = " where raffle_index = '$raffle_index' ";

if($sfl && $stx) {
    $sql_search .= " and ($sfl like '%$stx%') ";
}

if($fr_date && $to_date)
	$sql_search .= " and (event_start_date >= '$fr_date' and event_end_date <= '$to_date') ";
else if($fr_date && !$to_date)
	$sql_search .= " and (event_start_date >= '$fr_date' and event_start_date <= '$fr_date') ";
else if(!$fr_date && $to_date)
	$sql_search .= " and (event_end_date >= '$to_date' and event_end_date <= '$to_date') ";

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
				<?php echo option_selected('goods_name', $sfl, '레플명'); ?>
			</select>
			<input type="text" name="stx" value="<?php echo $stx; ?>" class="frm_input" size="30">
		</td>
	</tr>
	<tr>
		<th scope="row">레플 시작일</th>
		<td>
			<?php echo get_search_date("fr_date", "to_date", $fr_date, $to_date); ?>
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

<!-- <form name="frafflelist" id="frafflelist" method="post" action="./goods/goods_raffle_delete.php" onsubmit="return frafflelist_submit(this);"> -->
<input type="hidden" name="q1" value="<?php echo $q1; ?>">
<input type="hidden" name="page" value="<?php echo $page; ?>">

<div class="local_ov mart30">
	전체 : <b class="fc_red"><?php echo number_format($total_count); ?></b> 건 조회
</div>

<div class="tbl_head01">
	<table>
	<colgroup>
		<col class="w150">
		<col>
		<col class="w150">
		<col class="w150">
		<col class="w150">
		<col>
		<col class="w150">
		<col class="w150">
	</colgroup>
	<thead>
	<tr>
		<th scope="col">회원 명</th>
		<th scope="col">아이디</th>
		<th scope="col">응모일</th>
		<th scope="col">선정</th>
		<th scope="col">회원 명</th>
		<th scope="col">아이디</th>
		<th scope="col">응모일</th>
		<th scope="col">선정</th>
	</tr>
	</thead>
	<?php
	$hasData = false;
	for($i=0; $row1=sql_fetch_array($result); $i++) {
		$hasData = true;
		$index_no1 = $row1['index_no'];

		$iq_url1 = "code=raffle_form&w=u&index_no=$index_no1$qstr&page=$page";
		$iq_upd1 = "<a href=\"./goods.php?{$iq_url1}\" class=\"btn_small\">수정</a>";

		$row2 = sql_fetch_array($result); // 다음 행을 가져옴
		$index_no2 = $row2['index_no'];
		if($i==0)
			echo '<tbody class="list">'.PHP_EOL;

		$bg = 'list'.($i%2);

		$prizeCheck1 = ($row1['prize'] == 'N')? false:true;
		$prizeCheck2 = ($row2['prize'] == 'N')? false:true;

		if($prizeCheck1) {
			$prize1 = "<button onclick=\"prize('".$index_no1."','".$row1['prize']."')\">선정 취소</button>";
		} else {
			$prize1 = "<button onclick=\"prize('".$index_no1."','".$row1['prize']."')\">선정</button>";
		}

		if($prizeCheck2) {
			$prize2 = "<button onclick=\"prize('".$index_no2."','".$row2['prize']."')\">선정 취소</button>";
		} else {
			$prize2 = "<button onclick=\"prize('".$index_no2."','".$row2['prize']."')\">선정</button>";
		}

	?>
	<tr class="<?php echo $bg; ?>">
		<td><?php echo $row1['mb_name']; ?></td>
		<td><?php echo $row1['mb_id'] ?></td>
		<td><?php echo $row1['reg_time'] ?></td>
		<td><?php echo $prize1; ?></td>
		<?php if ($row2) { // 두 번째 행이 있을 때만 표시 ?>
			<td><?php echo $row2['mb_name']; ?></td>
			<td><?php echo $row2['mb_id'] ?></td>
			<td><?php echo $row2['reg_time'] ?></td>
			<td><?php echo $prize2; ?></td>
		<?php } else { // 두 번째 행이 없을 때 빈 셀 표시 ?>
			<td colspan="4"></td>
		<?php } ?>
	</tr>
	<?php 
	}
	if(!$hasData) {
		echo '<tbody><tr><td colspan="8" class="empty_table">자료가 없습니다.</td></tr></tbody>';
	}
	?>
	</tbody>
	</table>
</div>

<!-- </form> -->

<?php
echo get_paging($config['write_pages'], $page, $total_page, $_SERVER['SCRIPT_NAME'].'?'.$q1.'&page=');
?>

<script>
$(function(){
	// 날짜 검색 : TODAY MAX값으로 인식 (maxDate: "+0d")를 삭제하면 MAX값 해제
	$("#fr_date, #to_date").datepicker({ changeMonth: true, changeYear: true, dateFormat: "yy-mm-dd", showButtonPanel: true, yearRange: "c-99:c+99", maxDate: "+0d" });
});

$(document).on('click', '#frmRest', function() {
    window.location.href = "/admin/goods.php?code=raffle";
});


function prize(indexno,check) {
	$.ajax({
		type: "POST",
		url: "/admin/goods/raffle.ajax.php",
		data : {index_no:indexno,check:check},
		dataType: "json",
		success: function(data) {
			console.log(data);
		}
	});
}
</script>
