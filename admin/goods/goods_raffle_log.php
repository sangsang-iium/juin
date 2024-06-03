<?php
if(!defined('_BLUEVATION_')) exit;

$query_string = "&raffle_index=$raffle_index&code=$code$qstr";
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

if($_SESSION['ss_page_rows'])
	$page_rows = $_SESSION['ss_page_rows'];
else
	$page_rows = 30;

$rows = $page_rows;
$total_page = ceil($total_count / $rows); // 전체 페이지 계산
if($page == "") { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함
$num = $total_count - (($page-1)*$rows);

$sql = " select * $sql_common $sql_search $sql_order limit $from_record, $rows ";
$result = sql_query($sql);

$raffleSql = " SELECT winner_number FROM shop_goods_raffle WHERE index_no = '$raffle_index' ";
$raffleRes = sql_fetch($raffleSql);
$raffleWinner = $raffleRes['winner_number'];

$raffleSql = " SELECT count(*) as cnt FROM shop_goods_raffle_log WHERE raffle_index = '$raffle_index' AND prize = 'Y' ";
$raffleRes = sql_fetch($raffleSql);
$raffleNowWinner = $raffleRes['cnt'];

include_once(BV_PLUGIN_PATH.'/jquery-ui/datepicker.php');

?>

<h2>기본검색</h2>
<form name="fsearch" id="fsearch" method="get">
<input type="hidden" name="code" value="<?php echo $code; ?>">
<input type="hidden" name="raffle_index" value="<?php echo $raffle_index; ?>">
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
				<?php echo option_selected('mb_name', $sfl, '신청자 이름'); ?>
			</select>
			<input type="text" name="stx" value="<?php echo $stx; ?>" class="frm_input" size="30">
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

<input type="hidden" name="q1" value="<?php echo $q1; ?>">
<input type="hidden" name="page" value="<?php echo $page; ?>">

<div class="local_ov mart30">
	<!-- 전체 : <b class="fc_red"><?php echo number_format($total_count); ?></b> 건 조회 -->
	<span>선정해야 하는 인원 : <b><?php echo number_format($raffleWinner); ?></b></span>명
	<span>선정된 인원 : <b class="now_winner"><?php echo number_format($raffleNowWinner); ?></b></span>명
	<span class="ov_a">
		<select id="page_rows" onchange="location='<?php echo "{$_SERVER['SCRIPT_NAME']}?{$q1}&page=1"; ?>&page_rows='+this.value;">
			<?php echo option_selected('30',  $page_rows, '30줄 정렬'); ?>
			<?php echo option_selected('50',  $page_rows, '50줄 정렬'); ?>
			<?php echo option_selected('100', $page_rows, '100줄 정렬'); ?>
		</select>
	</span>
	<button onclick="randomPrize()" >랜덤 선정</button>
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

		$prize1 = "<button data-index='$index_no1' onclick=\"prize('$index_no1','$row1[prize]')\">" . ($prizeCheck1 ? "선정 취소" : "선정") . "</button>";
		$prize2 = "<button data-index='$index_no2' onclick=\"prize('$index_no2','$row2[prize]')\">" . ($prizeCheck2 ? "선정 취소" : "선정") . "</button>";

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
    window.location.href = "/admin/goods.php?code=raffle_log&raffle_index=<?php echo $raffle_index; ?>";
});


function prize(indexno,check) {
	$.ajax({
		type: "POST",
		url: "/admin/goods/raffle.ajax.php",
		data : {index_no:indexno,check:check,raffle_index:<?php echo $raffle_index; ?>},
		dataType: "json",
		success: function(data) {
			if(data.res == "Y") {
				var button = $("button[data-index='" + indexno + "']");
				if (data.prize == "Y") {
					button.text("선정 취소").attr("onclick", "prize('" + indexno + "', 'Y')");
					$('.now_winner').text(data.total_cnt);
				} else {
					button.text("선정").attr("onclick", "prize('" + indexno + "', 'N')");
					$('.now_winner').text(data.total_cnt);
				}
            } else {
				alert('더이상 선정하지 못합니다.');
			}
		}
	});
}


function randomPrize() {
	$.ajax({
		type: "POST",
		url: "/admin/goods/raffle_random.ajax.php",
		data : {raffle_index:<?php echo $raffle_index; ?>},
		dataType: "json",
		success: function(data) {
			if(data.res == "Y") {
				var indexno = data.index;
				var button = $("button[data-index='" + indexno + "']");
				if (data.prize == "Y") {
					button.text("선정 취소").attr("onclick", "prize('" + indexno + "', 'Y')");
					$('.now_winner').text(data.total_cnt);
				} else {
					button.text("선정").attr("onclick", "prize('" + indexno + "', 'N')");
					$('.now_winner').text(data.total_cnt);
				}
            } else {
				alert('더이상 선정하지 못합니다.');
			}
		}
	});
}

</script>
