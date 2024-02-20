<?php
if(!defined('_BLUEVATION_')) exit;

if(!$pf_auth_good)
	alert('개별 상품판매 권한이 있어야만 이용 가능합니다.');

$pg_title = '주문리스트(전체)';
include_once("./admin_head.sub.php");

// 주문서 query 공통
include_once("./partner_odr_query.php");

$btn_frmline = <<<EOF
<a href="#" id="frmOrderPrint" class="btn_lsmall white"><i class="fa fa-print"></i> 주문서출력</a>
<a href="#" id="frmOrderExcel" class="btn_lsmall white"><i class="fa fa-file-excel-o"></i> 선택 엑셀저장</a>
<a href="./partner_odr_excel.php?$q1" class="btn_lsmall white"><i class="fa fa-file-excel-o"></i> 검색결과 엑셀저장</a>
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
				<?php echo option_selected('od_id', $sfl, '주문번호'); ?>
				<?php echo option_selected('od_no', $sfl, '일련번호'); ?>
				<?php echo option_selected("mb_id", $sfl, '회원아이디'); ?>
				<?php echo option_selected('name', $sfl, '주문자명'); ?>
				<?php echo option_selected('deposit_name', $sfl, '입금자명'); ?>
				<?php echo option_selected('bank', $sfl, '입금계좌'); ?>
				<?php echo option_selected('b_name', $sfl, '수령자명'); ?>
				<?php echo option_selected('b_telephone', $sfl, '수령자집전화'); ?>
				<?php echo option_selected('b_cellphone', $sfl, '수령자핸드폰'); ?>
				<?php echo option_selected('delivery_no', $sfl, '운송장번호'); ?>
			</select>
			<input type="text" name="stx" value="<?php echo $stx; ?>" class="frm_input" size="30">
		</td>
	</tr>
	<tr>
		<th scope="row">기간검색</th>
		<td>
			<select name="sel_field">
				<?php echo option_selected('od_time', $sel_field, "주문일"); ?>
				<?php echo option_selected('receipt_time', $sel_field, "입금완료일"); ?>
				<?php echo option_selected('delivery_date', $sel_field, "배송일"); ?>
				<?php echo option_selected('invoice_date', $sel_field, "배송완료일"); ?>
				<?php echo option_selected('user_date', $sel_field, "구매확정일"); ?>
				<?php echo option_selected('cancel_date', $sel_field, "주문취소일"); ?>
				<?php echo option_selected('refund_date', $sel_field, "환불완료일"); ?>
				<?php echo option_selected('return_date', $sel_field, "반품완료일"); ?>
				<?php echo option_selected('change_date', $sel_field, "교환완료일"); ?>
			</select>
			<?php echo get_search_date("fr_date", "to_date", $fr_date, $to_date); ?>
		</td>
	</tr>
	<tr>
		<th scope="row">결제방법</th>
		<td>
			<?php echo radio_checked('od_settle_case', $od_settle_case,  '', '전체'); ?>
			<?php echo radio_checked('od_settle_case', $od_settle_case, '무통장', '무통장'); ?>
			<?php echo radio_checked('od_settle_case', $od_settle_case, '가상계좌', '가상계좌'); ?>
			<?php echo radio_checked('od_settle_case', $od_settle_case, '계좌이체', '계좌이체'); ?>
			<?php echo radio_checked('od_settle_case', $od_settle_case, '휴대폰', '휴대폰'); ?>
			<?php echo radio_checked('od_settle_case', $od_settle_case, '신용카드', '신용카드'); ?>
			<?php echo radio_checked('od_settle_case', $od_settle_case, '간편결제', 'PG간편결제'); ?>
			<?php echo radio_checked('od_settle_case', $od_settle_case, 'KAKAOPAY', 'KAKAOPAY'); ?>
		</td>
	</tr>
	<tr>
		<th scope="row">주문상태</th>
		<td>
			<?php echo radio_checked('od_status', $od_status,  '', '전체'); ?>
			<?php echo radio_checked('od_status', $od_status, '1', $gw_status[1]); ?>
			<?php echo radio_checked('od_status', $od_status, '2', $gw_status[2]); ?>
			<?php echo radio_checked('od_status', $od_status, '3', $gw_status[3]); ?>
			<?php echo radio_checked('od_status', $od_status, '4', $gw_status[4]); ?>
			<?php echo radio_checked('od_status', $od_status, '5', $gw_status[5]); ?>
			<?php echo radio_checked('od_status', $od_status, '6', $gw_status[6]); ?>
			<?php echo radio_checked('od_status', $od_status, '9', $gw_status[9]); ?>
			<?php echo radio_checked('od_status', $od_status, '7', $gw_status[7]); ?>
			<?php echo radio_checked('od_status', $od_status, '8', $gw_status[8]); ?>
		</td>
	</tr>
	<tr>
		<th scope="row">구매확정</th>
		<td>
			<?php echo radio_checked('od_final', $od_final,  '', '전체'); ?>
			<?php echo radio_checked('od_final', $od_final, '1', '구매확정'); ?>
			<?php echo radio_checked('od_final', $od_final, '0', '구매미확정'); ?>
		</td>
	</tr>
	<tr>
		<th scope="row">기타선택</th>
		<td>
			<?php echo check_checked('od_taxbill', $od_taxbill, 'Y', '세금계산서'); ?>
			<?php echo check_checked('od_taxsave', $od_taxsave, 'Y', '현금영수증'); ?>
			<?php echo check_checked('od_memo', $od_memo, 'Y', '배송메세지'); ?>
			<?php echo check_checked('od_shop_memo', $od_shop_memo, 'Y', '관리자메모'); ?>
			<?php echo check_checked('od_receipt_point', $od_receipt_point, 'Y', '포인트주문'); ?>
			<?php echo check_checked('od_coupon', $od_coupon, 'Y', '쿠폰할인'); ?>
			<?php echo check_checked('od_escrow', $od_escrow, 'Y', '에스크로'); ?>
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
	전체 : <b class="fc_red"><?php echo number_format($total_count); ?></b> 건 조회
	<select id="page_rows" onchange="location='<?php echo "{$_SERVER['SCRIPT_NAME']}?{$q1}&page=1"; ?>&page_rows='+this.value;" class="marl5">
		<?php echo option_selected('30',  $page_rows, '30줄 정렬'); ?>
		<?php echo option_selected('50',  $page_rows, '50줄 정렬'); ?>
		<?php echo option_selected('100', $page_rows, '100줄 정렬'); ?>
		<?php echo option_selected('150', $page_rows, '150줄 정렬'); ?>
	</select>
	<strong class="ov_a">총주문액 : <?php echo number_format($tot_orderprice); ?>원</strong>
</div>

<form name="forderlist" id="forderlist" method="post">
<input type="hidden" name="q1" value="<?php echo $q1; ?>">
<input type="hidden" name="page" value="<?php echo $page; ?>">

<div class="local_frm01">
	<?php echo $btn_frmline; ?>
</div>
<div class="tbl_head01">
	<table id="sodr_list">
	<colgroup>
		<col class="w50">
		<col class="w100">
		<col class="w150">
		<col class="w40">
		<col class="w40">
		<col>
		<col class="w60">
		<col class="w80">
		<col class="w80">
		<col class="w90">
		<col class="w90">
		<col class="w90">
		<col class="w90">
		<col class="w90">
	</colgroup>
	<thead>
	<tr>
		<th scope="col">번호</th>
		<th scope="col">주문일시</th>
		<th scope="col">주문번호</th>
		<th scope="col"><input type="checkbox" name="chkall" value="1" onclick="check_all(this.form);"></th>
		<th scope="col" colspan="2">주문상품</th>
		<th scope="col">수량</th>
		<th scope="col">상품금액</th>
		<th scope="col">배송비</th>
		<th scope="col">주문상태</th>
		<th scope="col">주문자</th>
		<th scope="col">수령자</th>
		<th scope="col">총주문액</th>
		<th scope="col">결제방법</th>
	</tr>
	</thead>
	<tbody>
	<?php
	for($i=0; $row=sql_fetch_array($result); $i++) {
		$bg = 'list'.($i%2);

		$amount = get_order_spay($row['od_id'], " and seller_id = '{$member['id']}' ");
		$sodr = get_order_list($row, $amount);

		$sql = " select * {$sql_common} {$sql_search} and od_id = '{$row['od_id']}' order by index_no ";
		$res = sql_query($sql);
		$rowspan = sql_num_rows($res);
		for($k=0; $row2=sql_fetch_array($res); $k++) {
			$gs = unserialize($row2['od_goods']);
	?>
	<tr class="<?php echo $bg; ?>">
		<?php if($k == 0) { ?>
		<td rowspan="<?php echo $rowspan; ?>"><?php echo $num--; ?></td>
		<td rowspan="<?php echo $rowspan; ?>">
			<?php echo substr($row['od_time'],2,14); ?>
			<?php echo $sodr['disp_test']; ?>
		</td>
		<td rowspan="<?php echo $rowspan; ?>">
			<a href="<?php echo BV_MYPAGE_URL; ?>/partner_odr_form.php?od_id=<?php echo $row['od_id']; ?>" onclick="win_open(this,'partner_odr_form','1200','800','yes');return false;" class="fc_197"><?php echo $row['od_id']; ?></a>
			<?php echo $sodr['disp_mobile']; ?>
		</td>
		<td rowspan="<?php echo $rowspan; ?>">
			<input type="hidden" name="od_id[<?php echo $i; ?>]" value="<?php echo $row['od_id']; ?>">
			<label for="chk_<?php echo $i; ?>" class="sound_only">주문번호 <?php echo $row['od_id']; ?></label>
			<input type="checkbox" name="chk[]" value="<?php echo $i; ?>" id="chk_<?php echo $i; ?>">
		</td>
		<?php } ?>
		<td class="td_img"><a href="<?php echo BV_SHOP_URL; ?>/view.php?index_no=<?php echo $row2['gs_id']; ?>" target="_blank"><?php echo get_od_image($row['od_id'], $gs['simg1'], 30, 30); ?></a></td>
		<td class="td_itname"><a href="<?php echo BV_MYPAGE_URL; ?>/page.php?code=partner_goods_form&w=u&gs_id=<?php echo $row2['gs_id']; ?>" target="_blank"><?php echo get_text($gs['gname']); ?></a></td>
		<td><?php echo number_format($row2['sum_qty']); ?></td>
		<td class="tar"><?php echo number_format($row2['goods_price']); ?></td>
		<td class="tar"><?php echo number_format($row2['baesong_price']); ?></td>
		<td><?php echo $gw_status[$row2['dan']]; ?></td>
		<?php if($k == 0) { ?>
		<td rowspan="<?php echo $rowspan; ?>">
			<?php echo $sodr['disp_od_name']; ?>
			<?php echo $sodr['disp_mb_id']; ?>
		</td>
		<td rowspan="<?php echo $rowspan; ?>"><?php echo $row['b_name']; ?></td>
		<td rowspan="<?php echo $rowspan; ?>" class="td_price"><?php echo $sodr['disp_price']; ?></td>
		<td rowspan="<?php echo $rowspan; ?>"><?php echo $sodr['disp_paytype']; ?></td>
		<?php } ?>
	<?php
		}
	}
	sql_free_result($result);
	if($i==0)
		echo '<tr><td colspan="14" class="empty_table">자료가 없습니다.</td></tr>';
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
$(function(){
    $("#fr_date, #to_date").datepicker({ changeMonth: true, changeYear: true, dateFormat: "yy-mm-dd", showButtonPanel: true, yearRange: "c-99:c+99", maxDate: "+0d" });

	// 주문서출력
	$("#frmOrderPrint, #frmOrderExcel").on("click", function() {
		var type = $(this).attr("id");
		var od_chk = new Array();
		var od_id = "";
		var $el_chk = $("input[name='chk[]']");

		$el_chk.each(function(index) {
			if($(this).is(":checked")) {
				od_chk.push($("input[name='od_id["+index+"]']").val());
			}
		});

		if(od_chk.length > 0) {
			od_id = od_chk.join();
		}

		if(od_id == "") {
			alert("처리할 자료를 하나 이상 선택해 주십시오.");
			return false;
		} else {
			if(type == 'frmOrderPrint') {
				var url = "./partner_odr_print.php?od_id="+od_id;
				window.open(url, "frmOrderPrint", "left=100, top=100, width=670, height=600, scrollbars=yes");
				return false;
			} else {
				this.href = "./partner_odr_excel2.php?od_id="+od_id;
				return true;
			}
		}
	});
});
</script>

<?php
include_once("./admin_tail.sub.php");
?>