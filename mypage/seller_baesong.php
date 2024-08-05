<?php
if(!defined('_BLUEVATION_')) exit;

$pg_title = "업체 배송정책";
include_once("./admin_head.sub.php");
?>

<form name="fregform" method="post" action="./seller_baesong_update.php" onsubmit="return fregform_submit(this);">
<input type="hidden" name="token" value="">
<input type="hidden" name="mb_id" value="<?php echo $member['id'] ?>">

<h5 class="htag_title marb20">배송정책 설정</h5>
<div class="tbl_frm01">
	<table>
	<colgroup>
		<col width="220px">
		<col>
	</colgroup>
	<tbody>
		<!--<tr>
		 <th scope="row">배송관리</th>
		<td>
			<div id="sit_supply_frm2" class="tbl_frm02">
				<table>
				<colgroup>
					<col>
					<col class="w70">
				</colgroup>
				<thead>
				<tr>
					<th scope="col" class="tac">배송관리업체명</th>
					<th scope="col" class="tac">삭제</th>
				</tr>
				</thead>
				<tbody>
				<?php
				$spl_sorts2 = explode(",", $seller['delivery_mg']);
				$spl_count2 = count($spl_sorts2);

				for($i=0; $i < $spl_count2; $i++) {
				?>
				<tr>
					<td><input type="text" name="spl_name2[]" value="<?php echo $spl_sorts2[$i]; ?>" class="frm_input wfull"></td>
					<td class="tac">
						<?php if($i == 0) { ?>
						<button type="button" id="add_supply_row2" class="btn_small">추가</button>
						<?php } ?>
						<?php if($i > 0) { ?>
						<button type="button" id="del_supply_row2" class="btn_small red">삭제</button>
						<?php } ?>
					</td>
				</tr>
				<?php
				}
				?>
				</tbody>
				</table>
			</div>

			<script>
			$(function() {
				// 입력필드추가
				$("#add_supply_row2").click(function() {
					var $el = $("#sit_supply_frm2 tbody tr:last");
					var fld = "<tr>\n";
					fld += "<td><input type=\"text\" name=\"spl_name2[]\" value=\"\" class=\"frm_input wfull\"></td>\n";
					fld += "<td class=\"tac\"><button type=\"button\" id=\"del_supply_row2\" class=\"btn_small red\">삭제</button></td>\n";
					fld += "</tr>";

					$el.after(fld);
				});

				// 입력필드삭제
				$("#del_supply_row2").live("click", function() {
					$(this).closest("tr").remove();
				});
			});
			</script>
		</td>
	</tr>-->
	<!-- <tr>
		<th scope="row">배송업체</th>
		<td>
			<div id="sit_supply_frm" class="tbl_frm02">
				<table>
				<colgroup>
					<col class="w180">
					<col>
				</colgroup>
				<thead>
				<tr>
					<th scope="col" class="tac">배송업체명</th>
					<th scope="col" class="tac">배송추적 링크주소</th>
				</tr>
				</thead>
				<tbody>
					<?php
						$spl_sorts = explode(",", $seller['delivery_company']);
						$spl_count = count($spl_sorts);

						$i = 0;
						do {
							$seq = explode('|', trim($spl_sorts[$i]));
					?>
				<tr>
					<td><input type="text" name="spl_name[]" value="<?php echo $seq[0]; ?>" class="frm_input wfull"></td>
					<td><input type="text" name="spl_url[]" value="<?php echo $seq[1]; ?>" class="frm_input wfull"></td>
					<td class="tac">
						<?php if ($i == 0) {?>
						<button type="button" id="add_supply_row" class="btn_small">추가</button>
						<?php }?>
						<?php if ($i > 0) {?>
						<button type="button" id="del_supply_row" class="btn_small red">삭제</button>
						<?php }?>
					</td>
				</tr>
				<?php
					$i++;
					} while ($i < $spl_count);
					?>
				<?php //echo help('※ 배송업체등록은 본사에서만 가능하며 추가하실 업체는 본사로 문의주시기 바랍니다.'); ?>
			</div>
		</td>
	</tr> -->
	<tr>
		<th scope="row">기본 배송정책</th>
		<td>
			<ul class="radio_group">
                <li class="radios">
                    <input type="radio" name="delivery_method" value="1" id="delivery_method1"<?php echo get_checked($seller['delivery_method'], "1"); ?>>
                    <label for="delivery_method1">
                        무료배송<br/>
                        <span class="fs13">(배송비가 부과되지 않습니다)</span>
                    </label>
                </li>
                <li class="radios">
                    <input type="radio" name="delivery_method" value="4" id="delivery_method4"<?php echo get_checked($seller['delivery_method'], "4"); ?>>
                    <label for="delivery_method4">
                        차량배송<br/>
                        <span class="fs13">(공급사 배송 최소금액에 영향을 받습니다.)</span>
                    </label>
                </li>
				<!-- <tr>
					<th scope="row">
						<input type="radio" name="delivery_method" value="2" id="delivery_method2"<?php echo get_checked($seller['delivery_method'], "2"); ?>>
						<label for="delivery_method2">착불배송</label>
					</th>
					<td>주문시 또는 장바구니에 배송비가 <b>[착불]</b> 이라는 글이 출력되며 배송비는 부과되지 않습니다</td>
				</tr>
				<tr>
					<th scope="row">
						<input type="radio" name="delivery_method" value="3" id="delivery_method3"<?php echo get_checked($seller['delivery_method'], "3"); ?>>
						<label for="delivery_method3">유료배송</label>
					</th>
					<td><input type="text" name="delivery_price" value="<?php echo number_format($seller['delivery_price']); ?>" class="frm_input" size="10" onkeyup="addComma(this);"> 원을 주문금액 또는 수량에 상관없이 동일 주문건에 배송비를 한번만 부과됩니다</td>
				</tr>
				<tr>
					<th scope="row">
						<input type="radio" name="delivery_method" value="4" id="delivery_method4"<?php echo get_checked($seller['delivery_method'], "4"); ?>>
						<label for="delivery_method4">조건부무료배송</label>
					</th>
					<td>
						<input type="text" name="delivery_price2" value="<?php echo number_format($seller['delivery_price2']); ?>" class="frm_input" size="10" onkeyup="addComma(this);"> 원의 배송비를 부과하며 단! 주문금액이
						<input type="text" name="delivery_minimum" value="<?php echo number_format($seller["delivery_minimum"]); ?>" class="frm_input" size="10" onkeyup="addComma(this);"> 원 이상이면 무료배송 처리됩니다
					</td>
				</tr> -->
			</ul>
		</td>
	</tr>
	</tbody>
	</table>
</div>

<h5 class="htag_title marb20 mart50">배송/교환/반품안내</h5>
<div class="tbl_frm01">
	<table>
	<colgroup>
		<col width="220px">
		<col>
	</colgroup>
	<tbody>
	<tr>
		<th scope="row">PC 내용</th>
		<td>
			<?php echo editor_html('baesong_cont1', get_text($seller['baesong_cont1'], 0));?>
		</td>
	</tr>
	<tr>
		<th scope="row">모바일 내용</th>
		<td>
			<?php echo editor_html('baesong_cont2', get_text($seller['baesong_cont2'], 0));?>
		</td>
	</tr>
	</tbody>
	</table>
</div>

<div class="btn_confirm">
	<input type="submit" value="저장" class="btn_large" accesskey="s">
</div>
</form>

<script>
function fregform_submit(f) {
	<?php echo get_editor_js('baesong_cont1'); ?>
	<?php echo get_editor_js('baesong_cont2'); ?>

    return true;
}
</script>

<?php
include_once("./admin_tail.sub.php");
?>