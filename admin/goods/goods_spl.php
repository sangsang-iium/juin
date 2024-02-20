<?php
include_once('./_common.php');

$ps_run = false;

if($gs['index_no']) {
    $sql = " select *
			   from shop_goods_option
			  where io_type = '1'
			    and gs_id = '{$gs['index_no']}'
			  order by io_no asc ";
    $result = sql_query($sql);
    if(sql_num_rows($result))
        $ps_run = true;
} else if(!empty($_POST)) {
    $subject_count = count($_POST['subject']);
    $supply_count = count($_POST['supply']);

    if(!$subject_count || !$supply_count) {
        echo '추가옵션명과 추가옵션항목을 입력해 주십시오.';
        exit;
    }

    $ps_run = true;
}

if($ps_run) {
?>

<table class="mart20">
<colgroup>
	<col class="w40">
	<col>
	<col>
	<col class="w100">
	<col class="w100">
	<col class="w100">
	<col class="w100">
	<col class="w90">
</colgroup>
<thead>
<tr>
	<th scope="col" class="tac"><input type="checkbox" name="spl_chk_all" value="1"></th>
	<th scope="col" class="tac">옵션명</th>
	<th scope="col" class="tac">옵션항목</th>
	<th scope="col" class="tac">옵션공급가</th>
	<th scope="col" class="tac">상품금액</th>
	<th scope="col" class="tac">재고수량</th>
	<th scope="col" class="tac">통보수량</th>
	<th scope="col" class="tac">사용여부</th>
</tr>
</thead>
<tbody>
<?php
if($gs['index_no']) {
	for($i=0; $row=sql_fetch_array($result); $i++) {
		$spl_id = $row['io_id'];
		$spl_val = explode(chr(30), $spl_id);
		$spl_subject = $spl_val[0];
		$spl = $spl_val[1];
		$spl_supply_price = $row['io_supply_price'];
		$spl_price = $row['io_price'];
		$spl_stock_qty = $row['io_stock_qty'];
		$spl_noti_qty = $row['io_noti_qty'];
		$spl_use = $row['io_use'];
?>
<tr>
	<td class="tac">
		<input type="hidden" name="spl_id[]" value="<?php echo $spl_id; ?>">
		<input type="checkbox" name="spl_chk[]" value="1">
	</td>
	<td class="spl-subject-cell"><?php echo $spl_subject; ?></td>
	<td class="spl-cell"><?php echo $spl; ?></td>
	<td class="tac">
		<input type="text" name="spl_supply_price[]" value="<?php echo $spl_supply_price; ?>" class="frm_input wfull">
	</td>
	<td class="tac">
		<input type="text" name="spl_price[]" value="<?php echo $spl_price; ?>" class="frm_input wfull">
	</td>
	<td class="tac">
		<input type="text" name="spl_stock_qty[]" value="<?php echo $spl_stock_qty; ?>" class="frm_input wfull">
	</td>
	<td class="tac">
		<input type="text" name="spl_noti_qty[]" value="<?php echo $spl_noti_qty; ?>" class="frm_input wfull">
	</td>
	<td class="tac">
		<select name="spl_use[]">
			<option value="1"<?php echo get_selected('1', $spl_use); ?>>사용함</option>
			<option value="0"<?php echo get_selected('0', $spl_use); ?>>미사용</option>
		</select>
	</td>
</tr>
<?php
	} // for
} else {
	for($i=0; $i<$subject_count; $i++) {
		$spl_subject = preg_replace(BV_OPTION_ID_FILTER, '', trim(stripslashes($_POST['subject'][$i])));
		$spl_val = explode(',', preg_replace(BV_OPTION_ID_FILTER, '', trim(stripslashes($_POST['supply'][$i]))));
		$spl_count = count($spl_val);

		for($j=0; $j<$spl_count; $j++) {
			$spl = trim($spl_val[$j]);
			if($spl_subject && $spl) {
				$spl_id = $spl_subject.chr(30).$spl;
				$spl_supply_price = 0;
				$spl_price = 0;
				$spl_stock_qty = 0;
				$spl_noti_qty = 0;
				$spl_use = 1;

				// 기존에 설정된 값이 있는지 체크
				if($_POST['w'] == 'u') {
					$sql = " select io_no, io_supply_price, io_price, io_stock_qty, io_noti_qty, io_use
								from shop_goods_option
								where gs_id = '{$_POST['gs_id']}'
								  and io_id = '$spl_id'
								  and io_type = '1' ";
					$row = sql_fetch($sql);

					if($row['io_no']) {
						$spl_supply_price = (int)$row['io_supply_price'];
						$spl_price = (int)$row['io_price'];
						$spl_stock_qty = (int)$row['io_stock_qty'];
						$spl_noti_qty = (int)$row['io_noti_qty'];
						$spl_use = (int)$row['io_use'];
					}
				}
?>
<tr>
	<td class="tac">
		<input type="hidden" name="spl_id[]" value="<?php echo $spl_id; ?>">
		<input type="checkbox" name="spl_chk[]" value="1">
	</td>
	<td class="spl-subject-cell"><?php echo $spl_subject; ?></td>
	<td class="spl-cell"><?php echo $spl; ?></td>
	<td class="tac">
		<input type="text" name="spl_supply_price[]" value="<?php echo $spl_supply_price; ?>" class="frm_input wfull">
	</td>
	<td class="tac">
		<input type="text" name="spl_price[]" value="<?php echo $spl_price; ?>" class="frm_input wfull">
	</td>
	<td class="tac">
		<input type="text" name="spl_stock_qty[]" value="<?php echo $spl_stock_qty; ?>" class="frm_input wfull">
	</td>
	<td class="tac">
		<input type="text" name="spl_noti_qty[]" value="<?php echo $spl_noti_qty; ?>" class="frm_input wfull">
	</td>
	<td class="tac">
		<select name="spl_use[]">
			<option value="1"<?php echo get_selected('1', $spl_use); ?>>사용함</option>
			<option value="0"<?php echo get_selected('0', $spl_use); ?>>미사용</option>
		</select>
	</td>
</tr>
<?php
			} // if
		} // for
	} // for
}
?>
</tbody>
</table>

<div class="mart5">
	<button type="button" id="sel_supply_delete" class="btn_small bx-white">선택삭제</button>
</div>

<fieldset>
    <legend>옵션 일괄 적용</legend>
	<span class="sit_option_msg">전체 추가 옵션의 상품금액, 재고/통보수량 및 사용여부를 일괄 적용할 수 있습니다. 단, 체크된 수정항목만 일괄 적용됩니다.</span>
	<ul class="ofh dib">
		<li class="fl marr15">
			<label for="spl_com_supply_price_chk">옵션공급가</label>
			<input type="checkbox" name="spl_com_supply_price_chk" value="1" id="spl_com_supply_price_chk" class="spl_com_chk">
			<input type="text" name="spl_com_supply_price" value="0" id="spl_com_supply_price" class="frm_input" size="10">
		</li>
		<li class="fl marr15">
			<label for="spl_com_price_chk">상품금액</label>
			<input type="checkbox" name="spl_com_price_chk" value="1" id="spl_com_price_chk" class="spl_com_chk">
			<input type="text" name="spl_com_price" value="0" id="spl_com_price" class="frm_input" size="10">
		</li>
		<li class="fl marr15">
			<label for="spl_com_stock_chk">재고수량</label>
			<input type="checkbox" name="spl_com_stock_chk" value="1" id="spl_com_stock_chk" class="spl_com_chk">
			<input type="text" name="spl_com_stock" value="0" id="spl_com_stock" class="frm_input" size="10">
			<a href="javascript:spl_unlimited('spl_com_stock', '999999999');" class="btn_small grey">무제한</a>
		</li>
		<li class="fl marr15">
			<label for="spl_com_noti_chk">통보수량</label>
			<input type="checkbox" name="spl_com_noti_chk" value="1" id="spl_com_noti_chk" class="spl_com_chk">
			<input type="text" name="spl_com_noti" value="0" id="spl_com_noti" class="frm_input" size="10">
			<a href="javascript:spl_unlimited('spl_com_noti', '999999999');" class="btn_small grey">무제한</a>
		</li>
		<li class="fl marr15">
			<label for="spl_com_use_chk">사용여부</label>
			<input type="checkbox" name="spl_com_use_chk" value="1" id="spl_com_use_chk" class="spl_com_chk">
			<select name="spl_com_use" id="spl_com_use">
				<option value="1">사용함</option>
				<option value="0">미사용</option>
			</select>
		</li>
		<li class="fl">
			<button type="button" id="spl_value_apply" class="btn_small">일괄적용</button>
		</li>
	</ul>
</fieldset>
<?php } ?>

<script>
function spl_unlimited(fld, num){
	document.getElementById(fld).value = num;
}
</script>