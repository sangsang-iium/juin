<?php
if(!defined('_BLUEVATION_')) exit;

$query_string = "code=$code$qstr";
$q1 = $query_string;
$q2 = $query_string."&page=$page";

$sql_common = " from shop_goods_raffle ";
$sql_search = " where (1) ";

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

$btn_frmline = <<<EOF
<input type="submit" name="act_button" value="선택삭제" class="btn_lsmall bx-white" onclick="document.pressed=this.value">
<a href="./goods.php?code=raffle_form" class="fr btn_lsmall red"><i class="ionicons ion-android-add"></i> 레플등록</a>
EOF;


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

<form name="frafflelist" id="frafflelist" method="post" action="./goods/goods_raffle_delete.php" onsubmit="return frafflelist_submit(this);">
<input type="hidden" name="q1" value="<?php echo $q1; ?>">
<input type="hidden" name="page" value="<?php echo $page; ?>">

<div class="local_ov mart30">
	전체 : <b class="fc_red"><?php echo number_format($total_count); ?></b> 건 조회
</div>
<div class="local_frm01">
	<?php echo $btn_frmline; ?>
</div>
<div class="tbl_head01">
	<table>
	<colgroup>
		<col class="w50">
		<col class="w50">
		<col>
		<col class="w100">
		<col class="w100">
		<col class="w150">
		<col class="w150">
		<col class="w100">
		<col class="w100">
		<col class="w60">
	</colgroup>
	<thead>
	<tr>
		<th scope="col"><input type="checkbox" name="chkall" value="1" onclick="check_all(this.form);"></th>
		<th scope="col">번호</th>
		<th scope="col">상품명</th>
		<th scope="col">구매가격</th>
		<th scope="col">응모 수</th>
		<th scope="col">응모 기간</th>
		<th scope="col">당첨자 발표일</th>
		<th scope="col">등록자</th>
		<th scope="col">등록일시</th>
		<th scope="col">관리</th>
	</tr>
	</thead>
	<?php
	for($i=0; $row=sql_fetch_array($result); $i++) {
		$index_no = $row['index_no'];

		$iq_url = "code=raffle_form&w=u&index_no=$index_no$qstr&page=$page";
		$iq_upd = "<a href=\"./goods.php?{$iq_url}\" class=\"btn_small\">수정</a>";

		if($i==0)
			echo '<tbody class="list">'.PHP_EOL;

		$bg = 'list'.($i%2);
	?>
	<tr class="<?php echo $bg; ?>">
		<td>			
			<input type="hidden" name="cp_id[<?php echo $i; ?>]" value="<?php echo $cp_id; ?>">
			<input type="checkbox" name="chk[]" value="<?php echo $i; ?>">
		</td>
		<td><?php echo $num--; ?></td>
		<td><?php echo $row['goods_name'] ?></td>
		<td><?php echo $row['raffle_price'] ?></td>
		<td></td>
		<td><?php echo ymdhisToYmdhi($row['event_start_date'])."~<br>".ymdhisToYmdhi($row['event_end_date']) ?></td>
		<td><?php echo ymdhisToYmdhi($row['prize_date']) ?></td>
		<td><?php echo $row['mb_name'] ?></td>
		<td><?php echo substr($row['reg_time'],0,10); ?></td>
		<td><?php echo $iq_upd; ?></td>
	</tr>
	<?php 
	}
	if($i==0)
		echo '<tbody><tr><td colspan="9" class="empty_table">자료가 없습니다.</td></tr>';
	?>
	</tbody>
	</table>
</div>
<div class="local_frm02">
	<?php echo $btn_frmline; ?>
</div>
</form>

<?php
echo get_paging($config['write_pages'], $page, $total_page, $_SERVER['SCRIPT_NAME'].'?'.$q1.'&page=');
?>

<script>
function frafflelist_submit(f)
{
    if(!is_checked("chk[]")) {
        alert(document.pressed+" 하실 항목을 하나 이상 선택하세요.");
        return false;
    }

    if(document.pressed == "선택삭제") {
        if(!confirm("선택한 자료를 정말 삭제하시겠습니까?")) {
            return false;
        }
    }

    return true;
}

$(function(){
	// 날짜 검색 : TODAY MAX값으로 인식 (maxDate: "+0d")를 삭제하면 MAX값 해제
	$("#fr_date, #to_date").datepicker({ changeMonth: true, changeYear: true, dateFormat: "yy-mm-dd", showButtonPanel: true, yearRange: "c-99:c+99", maxDate: "+0d" });
});

$(document).on('click', '#frmRest', function() {
    window.location.href = "/admin/goods.php?code=raffle";
});

</script>
