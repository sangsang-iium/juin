<?php
if(!defined('_BLUEVATION_')) exit;

// 주문서 query 공통
include_once(BV_ADMIN_PATH.'/order/order_query.php');

$btn_frmline = <<<EOF
<a href="#" id="frmOrderPrint" class="btn_lsmall bx-white"><i class="fa fa-print"></i> 거래명세서 출력</a>
<a href="javascript:void(0);" onclick="downloadExcel();" class="btn_lsmall bx-white"><i class="fa fa-file-excel-o"></i> 선택 엑셀저장</a>
<a href="./order/order_excel.php?$q1" class="btn_lsmall bx-white"><i class="fa fa-file-excel-o"></i> 검색결과 엑셀저장</a>
EOF;
?>

<h5 class="htag_title">기본검색</h5>
<p class="gap20"></p>
<form name="fsearch" id="fsearch" method="get">
<input type="hidden" name="code" value="<?php echo $code; ?>">
<div class="board_table">
	<table>
	<colgroup>
		<col style="width:220px;">
		<col style="width:auto">
	</colgroup>
	<tbody>
	<tr>
		<th scope="row">검색어</th>
		<td>
            <div class="tel_input">
                <div class="chk_select w200">
                    <select name="sfl">
						<?php echo option_selected('all', $sfl, '전체'); ?>
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
                        <?php echo option_selected('seller_id', $sfl, '판매자ID'); ?>
                        <?php echo option_selected('pt_id', $sfl, '가맹점ID'); ?>
                    </select>
                </div>
			    <input type="text" name="stx" value="<?php echo $stx; ?>" class="frm_input" size="30">
            </div>
		</td>
	</tr>
	<tr>
		<th scope="row">기간검색</th>
		<td>
            <div class="tel_input">
                <div class="chk_select w200">
                    <select name="sel_field">
                        <?php echo option_selected('od_time', $sel_field, "주문일"); ?>
                        <?php echo option_selected('return_date', $sel_field, "반품완료일"); ?>
                    </select>
                </div>
			    <?php echo get_search_date("fr_date", "to_date", $fr_date, $to_date); ?>
            </div>
		</td>
	</tr>
	<tr>
		<th scope="row">결제방법</th>
		<td>
            <div class="radio_group">
                <?php echo radio_checked('od_settle_case', $od_settle_case,  '', '전체'); ?>
                <?php echo radio_checked('od_settle_case', $od_settle_case, '무통장', '무통장'); ?>
                <?php echo radio_checked('od_settle_case', $od_settle_case, '가상계좌', '가상계좌'); ?>
                <?php echo radio_checked('od_settle_case', $od_settle_case, '계좌이체', '계좌이체'); ?>
                <?php echo radio_checked('od_settle_case', $od_settle_case, '휴대폰', '휴대폰'); ?>
                <?php echo radio_checked('od_settle_case', $od_settle_case, '신용카드', '신용카드'); ?>
                <?php echo radio_checked('od_settle_case', $od_settle_case, '간편결제', 'PG간편결제'); ?>
                <?php echo radio_checked('od_settle_case', $od_settle_case, 'KAKAOPAY', 'KAKAOPAY'); ?>
            </div>
		</td>
	</tr>
	<tr>
		<th scope="row">기타선택</th>
		<td>
            <div class="checks">
                <?php echo check_checked('od_taxbill', $od_taxbill, 'Y', '세금계산서'); ?>
                <?php echo check_checked('od_taxsave', $od_taxsave, 'Y', '현금영수증'); ?>
                <?php echo check_checked('od_memo', $od_memo, 'Y', '배송메세지'); ?>
                <?php echo check_checked('od_shop_memo', $od_shop_memo, 'Y', '관리자메모'); ?>
                <?php echo check_checked('od_receipt_point', $od_receipt_point, 'Y', '포인트주문'); ?>
                <?php echo check_checked('od_coupon', $od_coupon, 'Y', '쿠폰할인'); ?>
                <?php echo check_checked('od_escrow', $od_escrow, 'Y', '에스크로'); ?>
            </div>
		</td>
	</tr>
	</tbody>
	</table>
</div>
<div class="board_btns tac mart20">
    <div class="btn_wrap">
        <input type="submit" value="검색" class="btn_acc marr10">
        <input type="button" value="초기화" id="frmRest" class="btn_cen">
    </div>
</div>
</form>

<div class="local_ov mart30 fs18 line_search">
    <p>전체 : <b class="fc_red"><?php echo number_format($total_count); ?></b> 건 조회</p>
    <div class="chk_select">
        <select id="page_rows" onchange="location='<?php echo "{$_SERVER['SCRIPT_NAME']}?{$q1}&page=1"; ?>&page_rows='+this.value;">
            <?php echo option_selected('30',  $page_rows, '30줄 정렬'); ?>
            <?php echo option_selected('50',  $page_rows, '50줄 정렬'); ?>
            <?php echo option_selected('100', $page_rows, '100줄 정렬'); ?>
            <?php echo option_selected('150', $page_rows, '150줄 정렬'); ?>
        </select>
    </div>
	<strong class="ov_a">총주문액 : <?php echo number_format($tot_orderprice); ?>원</strong>
</div>

<form name="forderlist" id="forderlist" method="post">
<input type="hidden" name="q1" value="<?php echo $q1; ?>">
<input type="hidden" name="page" value="<?php echo $page; ?>">

<div class="local_frm01">
	<?php echo $btn_frmline; ?>
</div>
<div class="tbl_head01">
	<!-- <table id="sodr_list"> -->
	<table id="">
	<colgroup>
		<col class="w50">
		<col class="w150">
		<col class="w150">
		<col class="w170">
    <col class="w100">
    <col class="w80">
		<col class="w80">
		<col class="w80">
		<col class="w100">
		<col class="w40">
		<col class="w80">
		<col>
		<col class="w80">
		<col class="w80">
		<col class="w120">
		<!-- <col class="w90">
		<col class="w90"> -->
		<col class="w90">
		<col class="w90">
		<col class="w90">
		<col class="w90">
	</colgroup>
	<thead>
	<tr>
		<th scope="col">번호</th>
		<th scope="col">주문일시</th>
		<th scope="col">반품일시</th>
		<th scope="col">주문번호</th>
    <th scope="col">업소명</th>
    <th scope="col">대표자</th>
		<th scope="col">연락처</th>
		<th scope="col">담당지부</th>
		<th scope="col">신청자</th>
		<th scope="col"><input type="checkbox" name="chkall" value="1" onclick="check_all(this.form);"></th>
		<th scope="col" colspan="2">주문상품</th>
		<th scope="col">과세상품</th>
    <th scope="col">상품금액</th>
		<th scope="col">판매자</th>
		<!-- <th scope="col">가맹점</th>
		<th scope="col">주문자</th> -->
		<th scope="col">총주문액</th>
		<th scope="col">결제방법</th>
		<th scope="col">반품상태</th>
		<th scope="col">반품사유</th>
	</tr>
	</thead>
	<tbody>
	<?php
	for($i=0; $row=sql_fetch_array($result); $i++) {
		$bg = 'list'.($i%2);

		$amount = get_order_spay($row['od_id']);
		$sodr = get_order_list($row, $amount);

		$sql = " select * {$sql_common} {$sql_search} and od_id = '{$row['od_id']}' order by index_no ";
		$res = sql_query($sql);
		$rowspan = sql_num_rows($res);
		for($k=0; $row2=sql_fetch_array($res); $k++) {
			$gs = unserialize($row2['od_goods']);

      $sqlMember = "SELECT * FROM shop_member WHERE id = '{$row['mb_id']}'";
			$rowMember = sql_fetch($sqlMember);

      // 과세 _20240725_SY
      $notax = "";
      switch($gs['notax']) {
        case 1:
          $notax = "과세";
          break;
        case 0:
          $notax = "비과세";
          break;
      }
	?>
	<tr class="<?php echo $bg; ?>">
		<?php if($k == 0) { ?>
		<td rowspan="<?php echo $rowspan; ?>"><?php echo $num--; ?></td>
		<td rowspan="<?php echo $rowspan; ?>">
			<?php echo substr($row['od_time'],2,14); ?>
			<?php echo $sodr['disp_test']; ?>
		</td>
		<td rowspan="<?php echo $rowspan; ?>"><?php echo substr($row['return_date'],2,14); ?></td>
		<td rowspan="<?php echo $rowspan; ?>">
			<a href="<?php echo BV_ADMIN_URL; ?>/pop_orderform.php?od_id=<?php echo $row['od_id']; ?>" onclick="win_open(this,'pop_orderform','1200','800','yes');return false;" class="fc_197"><?php echo $row['od_id']; ?></a>
			<?php echo $sodr['disp_mobile']; ?>
		</td>
    <td rowspan="<?php echo $rowspan; ?>">
			<?php echo $rowMember['ju_restaurant'] ?>
		</td>
    <td rowspan="<?php echo $rowspan; ?>">
			<?php echo $rowMember['name'] ?>
		</td>
		<td rowspan="<?php echo $rowspan; ?>">
			<?php echo $rowMember['cellphone'] ?>
		</td>
		<td rowspan="<?php echo $rowspan; ?>">
			<?php
				// 공제회, 중앙회 왜 예외?
				$sqlJu = "SELECT * FROM kfia_office WHERE branch_code = '{$rowMember['ju_region2']}' AND office_code = '{$rowMember['ju_region3']}'";
				$rowJu = sql_fetch($sqlJu);
				if($rowJu['office_idx']){
					echo $rowJu['office_name'];
				} else {
					echo '-';
				}
			?>
		</td>
		<td rowspan="<?php echo $rowspan; ?>">
			<?php echo $sodr['disp_od_name']; ?>
			<?php echo $sodr['disp_mb_id']; ?>
		</td>
		<td rowspan="<?php echo $rowspan; ?>">
			<input type="hidden" name="od_id[<?php echo $i; ?>]" value="<?php echo $row['od_id']; ?>">
			<label for="chk_<?php echo $i; ?>" class="sound_only">주문번호 <?php echo $row['od_id']; ?></label>
			<input type="checkbox" name="chk[]" value="<?php echo $i; ?>" id="chk_<?php echo $i; ?>">
		</td>
		<?php } ?>
		<td class="td_img"><a href="<?php echo BV_SHOP_URL; ?>/view.php?index_no=<?php echo $row2['gs_id']; ?>" target="_blank"><?php echo get_od_image($row['od_id'], $gs['simg1'], 30, 30); ?></a></td>
		<td class="td_itname"><a href="<?php echo BV_ADMIN_URL; ?>/goods.php?code=form&w=u&gs_id=<?php echo $row2['gs_id']; ?>" target="_blank"><?php echo get_text($gs['gname']); ?></a></td>
		<td><?php echo $notax; ?></td>
    <td class="tar"><?php echo number_format($row2['goods_price']); ?></td>
		<td><?php echo get_order_seller_name($row2['seller_id']); ?></td>
		<?php if($k == 0) { ?>
		<!-- <td rowspan="<?php echo $rowspan; ?>"><?php echo $sodr['disp_pt_id']; ?></td>
		<td rowspan="<?php echo $rowspan; ?>">
			<?php echo $sodr['disp_od_name']; ?>
			<?php echo $sodr['disp_mb_id']; ?>
		</td> -->
		<td rowspan="<?php echo $rowspan; ?>" class="td_price"><?php echo $sodr['disp_price']; ?></td>
		<td rowspan="<?php echo $rowspan; ?>"><?php echo $sodr['disp_paytype']; ?></td>
		<td rowspan="<?php echo $rowspan; ?>">
			<?php echo $row['dan2']!='0'? $gw_status[$row2['dan2']]:""; ?>
		</td>
		<td rowspan="<?php echo $rowspan; ?>"><?php echo $row2['return_memo'] ?></td>
		<?php } ?>
	<?php
		}
	}
	sql_free_result($result);
	if($i==0)
		echo '<tr><td colspan="22" class="empty_table">자료가 없습니다.</td></tr>';
	?>
	</tbody>
	</table>
</div>
<div class="local_frm02">
	<?php echo $btn_frmline; ?>
</div>
</form>


<!-- admin만 노출 _2040624_SY -->
<?php if($_SESSION['ss_mb_id'] == 'admin') { ?>
<p class="gap50"></p>
<h5 class="htag_title">주문 일괄처리</h5>
<p class="gap20"></p>
<div class="tbl_frm01">
	<table>
	<colgroup>
    <col width="220px">
		<col>
	</colgroup>
	<tbody>
	<tr>
		<th scope="row">선택한 주문을</th>
		<td>
			<input type="button"  id="return_goods"  name="act_button" value="반품완료 처리" class="btn_medium red">

			
			
			<!-- <input type="submit" name="act_button" value="전체환불" class="btn_lsmall white" onclick="document.pressed=this.value">
			
			<input type="submit" name="act_button" value="전체반품" class="btn_lsmall white" onclick="document.pressed=this.value"> -->
			
		</td>
	</tr>
	</tbody>
	</table>
</div>
<?php } ?>
<?php
echo get_paging($config['write_pages'], $page, $total_page, $_SERVER['SCRIPT_NAME'].'?'.$q1.'&page=');
?>


<div class="text_box btn_type mart50">
    <h5 class="tit">도움말</h5>
    <ul class="cnt_list step01">
        <li>주문상태를 변경할 수 있나요?
            <ul class="cnt_list step02">
                <li>반품 리스트 내 주문은 상태변경 및 원복이 불가능하며, 삭제도 하실 수 없습니다.</li>
            </ul>
        </li>
    </ul>
</div>

<!-- <div class="information">
	<h4>도움말</h4>
	<div class="content">
		<div class="hd">ㆍ주문상태를 변경할 수 있나요?</div>
		<div class="desc01 accent">
			<p>ㆍ반품 리스트 내 주문은 상태변경 및 원복이 불가능하며, 삭제도 하실 수 없습니다.</p>
		</div>
	 </div>
</div> -->

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
				var url = "./order/order_print.php?od_id="+od_id;
				window.open(url, "frmOrderPrint", "left=100, top=100, width=670, height=600, scrollbars=yes");
				return false;
			} else {
				this.href = "./order/order_excel2.php?od_id="+od_id;
				return true;
			}
		}
	});

	$("#return_goods").on("click", function() {
		console.log("return_goods")
		var type = $(this).attr("id");
		var od_chk = new Array();
		var od_id = "";
		var $el_chk = $("input[name='chk[]']");
		

		$el_chk.each(function(index) {
			if($(this).is(":checked")) {
				od_chk.push($("input[name='od_id["+index+"]']").val());
			}
		});

		console.log(type,od_chk,od_id);

		if(od_chk.length > 0) {
			od_id = od_chk.join();
		}

		if(od_id == "") {
			alert("처리할 자료를 하나 이상 선택해 주십시오.");
			return false;
		} else {
			if(type == 'return_goods') {
				var url = "./order/order_return_money.php?code=7&od_id="+od_id; 
				window.location.href=url;
				return false;
			}  
		}
	});

});
</script>
<script>
function downloadExcel() {
	var checkedIds = [];
	$('input[name="chk[]"]:checked').each(function() {
		var index = $(this).val();
		var gsId = $('input[name="od_id[' + index + ']"]').val();
		checkedIds.push(gsId);
	});
	
	var ids = checkedIds.join(',');
	window.location.href = './order/order_excel.php?<?php echo $q1; ?>&selected_ids=' + ids;
}
</script>