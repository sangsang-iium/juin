<?php
if(!defined('_BLUEVATION_')) exit;

include_once(BV_ADMIN_PATH.'/goods/goods_sub.php');
?>

<form name="fgoodslist" id="fgoodslist" method="post" action="./goods/goods_list_update.php" onsubmit="return fgoodslist_submit(this);">
<input type="hidden" name="q1" value="<?php echo $q1; ?>">
<input type="hidden" name="page" value="<?php echo $page; ?>">
<input type="hidden" name="token" value="">

<div class="local_ov mart30">
	전체 : <b class="fc_red"><?php echo number_format($total_count); ?></b> 건 조회
	<span class="ov_a">
		<select id="page_rows" onchange="location='<?php echo "{$_SERVER['SCRIPT_NAME']}?{$q1}&page=1"; ?>&page_rows='+this.value;">
			<?php echo option_selected('30',  $page_rows, '30줄 정렬'); ?>
			<?php echo option_selected('50',  $page_rows, '50줄 정렬'); ?>
			<?php echo option_selected('100', $page_rows, '100줄 정렬'); ?>
			<?php echo option_selected('150', $page_rows, '150줄 정렬'); ?>
		</select>
	</span>
</div>
<div class="local_frm01">
	<?php echo $btn_frmline; ?>
</div>

<div class="tbl_head02">
	<table id="sodr_list" class="tablef">
	<colgroup>
		<col class="w50">
		<col class="w50">
		<col class="w60">
		<col class="w120">
		<col>
		<col>
		<col class="w80">
		<col class="w80">
		<col class="w90">
		<col class="w90">
		<col class="w90">
		<col class="w90">
		<col class="w60">
		<col class="w60">
	</colgroup>
	<thead>
	<tr>
		<th scope="col" rowspan="2"><input type="checkbox" name="chkall" value="1" onclick="check_all(this.form);"></th>
		<th scope="col" rowspan="2">번호</th>
		<th scope="col" rowspan="2">이미지</th>
		<th scope="col"><?php echo subject_sort_link('gcode',$q2); ?>상품코드</a></th>
		<th scope="col" colspan="2"><?php echo subject_sort_link('gname',$q2); ?>상품명</a></th>
		<th scope="col"><?php echo subject_sort_link('reg_time',$q2); ?>최초등록일</a></th>
		<th scope="col"><?php echo subject_sort_link('isopen',$q2); ?>진열</a></th>
		<th scope="col" colspan="4" class="th_bg">가격정보</th>
		<th scope="col" rowspan="2"><?php echo subject_sort_link('rank',$q2); ?>순위</a></th>
		<th scope="col" rowspan="2">관리</th>
	</tr>
	<tr class="rows">
		<th scope="col"><?php echo subject_sort_link('mb_id',$q2); ?>업체코드</a></th>
		<th scope="col">공급사명</th>
		<th scope="col">카테고리</th>
		<th scope="col"><?php echo subject_sort_link('update_time',$q2); ?>최근수정일</a></th>
		<th scope="col"><?php echo subject_sort_link('stock_qty',$q2); ?>재고</a></th>
		<th scope="col" class="th_bg"><?php echo subject_sort_link('normal_price',$q2); ?>시중가</a></th>
		<th scope="col" class="th_bg"><?php echo subject_sort_link('supply_price',$q2); ?>공급가</a></th>
		<th scope="col" class="th_bg"><?php echo subject_sort_link('goods_price',$q2); ?>판매가</a></th>
		<th scope="col" class="th_bg"><?php echo subject_sort_link('gpoint',$q2); ?>포인트</a></th>
	</tr>
	</thead>
	<tbody>
	<?php
	for($i=0; $row=sql_fetch_array($result); $i++) {
		$gs_id = $row['index_no'];

		if($row['stock_mod'])
			$stockQty = number_format($row['stock_qty']);
		else
			$stockQty = '<span class="txt_false">무제한</span>';

		$bg = 'list'.($i%2);
	?>
	<tr class="<?php echo $bg; ?>">
		<td rowspan="2">
			<input type="hidden" name="gs_id[<?php echo $i; ?>]" value="<?php echo $gs_id; ?>">
			<input type="checkbox" name="chk[]" value="<?php echo $i; ?>">
		</td>
		<td rowspan="2"><?php echo $num--; ?></td>
		<td rowspan="2"><a href="<?php echo BV_SHOP_URL; ?>/view.php?index_no=<?php echo $gs_id; ?>" target="_blank"><?php echo get_it_image($gs_id, $row['simg1'], 40, 40); ?></a></td>
		<td><?php echo $row['gcode']; ?></td>
		<td colspan="2" class="tal"><?php echo get_text($row['gname']); ?></td>
		<td><?php echo substr($row['reg_time'],2,8); ?></td>
		<td><?php echo $gw_isopen[$row['isopen']]; ?></td>
		<td rowspan="2" class="tar"><?php echo number_format($row['normal_price']); ?></td>
		<td rowspan="2" class="tar"><?php echo number_format($row['supply_price']); ?></td>
		<td rowspan="2" class="tar"><?php echo number_format($row['goods_price']); ?></td>
		<td rowspan="2" class="tar"><?php echo number_format($row['gpoint']); ?></td>
		<td rowspan="2"><input type="text" class="frm_input" name="rank[<?php echo $i; ?>]" value='<?php echo $row['rank']; ?>'></td>
		<td rowspan="2"><a href="./goods.php?code=form&w=u&gs_id=<?php echo $gs_id.$qstr; ?>&page=<?php echo $page; ?>&bak=<?php echo $code; ?>" class="btn_small">수정</a></td>
	</tr>
	<tr class="<?php echo $bg; ?>">
		<td class="fc_00f"><?php echo $row['mb_id']; ?></td>
		<td class="tal txt_succeed"><?php echo get_seller_name($row['mb_id']); ?></td>
		<td class="tal txt_succeed"><?php echo get_cgy_info($row); ?></td>
		<td class="fc_00f"><?php echo substr($row['update_time'],2,8); ?></td>
		<td><?php echo $stockQty; ?></td>
	</tr>
	<?php
	}
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

<h2>배송비 일괄처리</h2>
<form name="frmdelivery" id="frmdelivery" method="post" autocomplete="off">
<div class="tbl_frm01">
	<table>
	<colgroup>
		<col class="w100">
		<col>
	</colgroup>
	<tbody>
	<tr>
		<th scope="row">적용조건</th>
		<td>
			<input type="radio" name="gubun" value="1" id="gubun_1" checked="checked">
			<label for="gubun_1">선택한 상품만 적용</label>
			<input type="radio" name="gubun" value="2" id="gubun_2">
			<label for="gubun_2">검색된 상품 전체(<?php echo number_format($total_count); ?>개)를 적용</label>
		</td>
	</tr>
	<tr>
		<th scope="row">배송정보</th>
		<td>
			<select name="sc_type" onChange="chk_sc_type(this.value);">
				<?php echo option_selected('0', '', '공통설정'); ?>
				<?php echo option_selected('1', '', '무료배송'); ?>
				<?php echo option_selected('2', '', '조건부무료배송'); ?>
				<?php echo option_selected('3', '', '유료배송'); ?>
			</select>
			<div id="sc_method" class="mart7">
				배송비결제
				<select name="sc_method" class="marl10">
					<?php echo option_selected('0', '', '선불'); ?>
					<?php echo option_selected('1', '', '착불'); ?>
					<?php echo option_selected('2', '', '사용자선택'); ?>
				</select>
			</div>
			<div id="sc_amt" class="padt5">
				기본배송비 <input type="text" name="sc_amt" value="0" class="frm_input w80 marl10"> 원
				<label class="marl10"><input type="checkbox" name="sc_each_use" value="1"> 묶음배송불가</label>
			</div>
			<div id="sc_minimum" class="padt5">
				조건배송비 <input type="text" name="sc_minimum" value="0" class="frm_input w80 marl10"> 원 이상이면 무료배송
			</div>
		</td>
	</tr>
	<tr>
		<th scope="row"><label for="zone">배송가능 지역</label></th>
		<td>
			<select name="zone" id="zone">
			<?php echo option_selected('전국', '', '전국'); ?>
			<?php echo option_selected('강원도', '', '강원도'); ?>
			<?php echo option_selected('경기도', '', '경기도'); ?>
			<?php echo option_selected('경상도', '', '경상도'); ?>
			<?php echo option_selected('서울/경기도', '', '서울/경기도'); ?>
			<?php echo option_selected('서울특별시', '', '서울특별시'); ?>
			<?php echo option_selected('전라도', '', '전라도'); ?>
			<?php echo option_selected('제주도', '', '제주도'); ?>
			<?php echo option_selected('충청도', '', '충청도'); ?>
			</select>
		</td>
	</tr>
	<tr>
		<th scope="row"><label for="zone_msg">추가설명</label></th>
		<td><input type="text" name="zone_msg" id="zone_msg" class="frm_input" size="60" placeholder="예 : 제주 (도서지역 제외)"></td>
	</tr>
	</tbody>
	</table>
</div>

<div class="btn_confirm">
	<input type="button" value="일괄적용하기" onclick="js_chk_frm(this.form);" class="btn_large">
</div>
</form>

<div class="information">
	<h4>도움말</h4>
	<div class="content">
		<div class="desc02">
			<p>ㆍ<em>[기본설정]</em>  <a href="<?php echo BV_ADMIN_URL; ?>/config.php?code=baesong">환경설정 > 배송/교환/반품 설정</a>에서 적용된값으로 부과됩니다.</p>
			<p>ㆍ서버 부하등 안정적인 서비스를 위해서 수정할 상품이 많은 경우에는 "검색된 상품에 적용"은 피하시기 바랍니다.</p>
		</div>
	</div>
</div>

<script>
function fgoodslist_submit(f)
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

// 일괄적용하기
function js_chk_frm(f2)
{
	var f = document.fgoodslist;
	if(getRadioVal(f2.gubun) == 1) {
		var chk = document.getElementsByName("chk[]");
		var bchk = false;
		for(i=0; i<chk.length; i++)
		{
			if(chk[i].checked)
				bchk = true;
		}

		if(!bchk)
		{
			alert("적용할 자료를 하나 이상 선택하세요.");
			return;
		}
	}

	addHidden(f, 'gubun', getRadioVal(f2.gubun));
	addHidden(f, 'sc_type', getSelectVal(f2.sc_type));
	addHidden(f, 'sc_method', getSelectVal(f2.sc_method));
	addHidden(f, 'sc_amt', f2.sc_amt.value);
	addHidden(f, 'sc_each_use', f2.sc_each_use.value);
	addHidden(f, 'sc_minimum', f2.sc_minimum.value);
	addHidden(f, 'zone', getSelectVal(f2.zone));
	addHidden(f, 'zone_msg', f2.zone_msg.value);

	if(confirm("일괄적용 후에는 이전상태로 복원이 되지않습니다.\n\n정말 적용하시겠습니까?")) {
		var token = get_ajax_token();
        if(!token) {
            alert("토큰 정보가 올바르지 않습니다.");
            return false;
        }

		f.token.value = token;
		f.action = "./goods/goods_getdeliveryupdate.php";
		f.submit();
	}
}

// 배송비 설정
function chk_sc_type(type) {
	switch(type) {
		case "0" : // 공통설정
			$("#sc_amt").hide();
			$("#sc_minimum").hide();
			$("#sc_method").show();
			$("input[name=sc_amt]").attr('disabled', true);
			$("input[name=sc_minimum]").attr('disabled', true);
			$("select[name=sc_method]").attr('disabled', false);
			break;
		case "1" : // 무료배송
			$("#sc_amt").hide();
			$("#sc_minimum").hide();
			$("#sc_method").hide();
			$("input[name=sc_amt]").attr('disabled', true);
			$("input[name=sc_minimum]").attr('disabled', true);
			$("select[name=sc_method]").attr('disabled', true);
			break;
		case "2" : // 조건부무료배송
			$("#sc_amt").show();
			$("#sc_minimum").show();
			$("#sc_method").show();
			$("input[name=sc_amt]").attr('disabled', false);
			$("input[name=sc_minimum]").attr('disabled', false);
			$("select[name=sc_method]").attr('disabled', false);
			break;
		case "3" : // 유료배송
			$("#sc_amt").show();
			$("#sc_minimum").hide();
			$("#sc_method").show();
			$("input[name=sc_amt]").attr('disabled', false);
			$("input[name=sc_minimum]").attr('disabled', true);
			$("select[name=sc_method]").attr('disabled', false);
			break;
	}
}

chk_sc_type('0');

$(function(){
	// 날짜 검색 : TODAY MAX값으로 인식 (maxDate: "+0d")를 삭제하면 MAX값 해제
	$("#fr_date,#to_date").datepicker({ changeMonth: true, changeYear: true, dateFormat: "yy-mm-dd", showButtonPanel: true, yearRange: "c-99:c+99", maxDate: "+0d" });
});
</script>
