<?php
if(!defined('_BLUEVATION_')) exit;

if($w == "") {
	$pl['mb_id']		= 'admin';
	$pl['simg_type']	= 0;
}else if($w == 'u') {
	$pl = sql_fetch("select * from shop_goods_raffle where index_no = '{$index_no}' ");
	if(!$pl['index_no'])
		alert('자료가 존재하지 않습니다.');
}

$frm_submit = '<div class="btn_confirm">
	<input type="submit" value="저장" class="btn_large" accesskey="s">
	<a href="./goods.php?code=raffle'.$qstr.'&page='.$page.'" class="btn_large bx-white">목록</a>'.PHP_EOL;
if($w == 'u') {
	$frm_submit .= '<a href="./goods.php?code=raffle_form" class="btn_large bx-red">추가</a>'.PHP_EOL;
}
$frm_submit .= '</div>';

include_once(BV_PLUGIN_PATH.'/jquery-ui/datepicker.php');
?>

<form name="fregform" method="post" action="./goods/goods_raffle_update.php" enctype="MULTIPART/FORM-DATA" onsubmit="return fregform_submit(this);">
<input type="hidden" name="w" value="<?php echo $w; ?>">
<input type="hidden" name="sfl" value="<?php echo $sfl; ?>">
<input type="hidden" name="stx" value="<?php echo $stx; ?>">
<input type="hidden" name="page" value="<?php echo $page; ?>">
<input type="hidden" name="index_no" value="<?php echo $index_no; ?>">

<div class="tbl_frm02">
	<table>
	<colgroup>
		<col class="w140">
		<col>
	</colgroup>
	<tbody>
	<tr>
		<th scope="row">상품평</th>
		<td><input type="text" name="goods_name" value="<?php echo $pl['goods_name']; ?>" required itemname="상품평" class="frm_input required" size="50"></td>
	</tr>
	<tr>
		<th scope="row">응모기간</th>
		<td>
			<label for="event_start_date" class="sound_only">시작일</label>
			<input type="text" name="event_start_date" value="<?php echo ymdhisToYmd($pl['event_start_date']) ?>" id="event_start_date" class="frm_input w80" maxlength="10">
			<input type="text" name="event_start_time" value="<?php echo ymdhisToHi($pl['event_start_date']) ?>" id="event_start_time" class="frm_input w80" maxlength="10">
			~ 
			<label for="event_end_date" class="sound_only">종료일</label>
			<input type="text" name="event_end_date" value="<?php echo ymdhisToYmd($pl['event_end_date']) ?>" id="event_end_date" class="frm_input w80" maxlength="10">
			<input type="text" name="event_end_time" value="<?php echo ymdhisToHi($pl['event_end_date']) ?>" id="event_end_time" class="frm_input w80" maxlength="10">
		</td>
	</tr>
	<tr>
		<th scope="row">당첨자 발표</th>
		<td>
			<label for="prize_date" class="sound_only">시작일</label>
			<input type="text" name="prize_date" value="<?php echo ymdhisToYmd($pl['prize_date']) ?>" id="prize_date" class="frm_input w80" maxlength="10">
			<input type="text" name="prize_time" value="<?php echo ymdhisToHi($pl['prize_date']) ?>" id="prize_time" class="frm_input w80" maxlength="10">
		</td>
	</tr>
	<tr>
		<th scope="row">당첨자 구매기간</th>
		<td>
			<label for="prize_start_date" class="sound_only">시작일</label>
			<input type="text" name="prize_start_date" value="<?php echo ymdhisToYmd($pl['prize_start_date']) ?>" id="prize_start_date" class="frm_input w80" maxlength="10">
			<input type="text" name="prize_start_time" value="<?php echo ymdhisToHi($pl['prize_start_date']) ?>" id="prize_start_time" class="frm_input w80" maxlength="10">
			~ 
			<label for="prize_end_date" class="sound_only">종료일</label>
			<input type="text" name="prize_end_date" value="<?php echo ymdhisToYmd($pl['prize_end_date']) ?>" id="prize_end_date" class="frm_input w80" maxlength="10">
			<input type="text" name="prize_end_time" value="<?php echo ymdhisToHi($pl['prize_end_date']) ?>" id="prize_end_time" class="frm_input w80" maxlength="10">
		</td>
	</tr>
	<tr>
		<th scope="row">시중가격</th>
		<td>
			<input type="number" name="market_price" value="<?php echo $pl['market_price']; ?>" required itemname="시중가격" class="frm_input required" size="50">
		</td>
	</tr>
	<tr>
		<th scope="row">구매가격</th>
		<td>
			<input type="number" name="raffle_price" value="<?php echo $pl['raffle_price']; ?>" required itemname="구매가격" class="frm_input required" size="50">
		</td>
	</tr>
	<tr>
		<th scope="row">당첨자 수</th>
		<td>
			<input type="number" name="winner_number" id="winner_number" value="<?php echo $pl['winner_number']; ?>" required itemname="당첨자 수" class="frm_input required" size="50">
		</td>
	</tr>
	<tr>
		<th scope="row">응모 제한</th>
		<td>	
			<input type="radio" name="entry" id="entry_1" value="0"<?php echo get_checked('0', $pl['entry']); ?> onclick="chk_entry_type(0);">
			<label for="entry_1">예</label>
			<input type="radio" name="entry" id="entry_2" value="1"<?php echo get_checked('1', $pl['entry']); ?> onclick="chk_entry_type(1);">
			<label for="entry_2">아니오</label>

			<input type="number" name="entry_number" id="entry_number" value="<?php echo $pl['entry_number']; ?>"  itemname="응모 제한 수" class="frm_input" size="50">
		</td>
	</tr>
	<tr>
		<th scope="row">안내사항</th>
		<td>
			<textarea name="infomation" class="frm_textbox"><?php echo $pl['infomation']; ?></textarea>
		</td>
	</tr>
	<tr>
		<th scope="row">이미지 등록방식</th>
		<td class="td_label">
			<input type="radio" name="simg_type" id="simg_type_1" value="0"<?php echo get_checked('0', $pl['simg_type']); ?> onclick="chk_simg_type(0);">
			<label for="simg_type_1">직접 업로드</label>
			<input type="radio" name="simg_type" id="simg_type_2" value="1"<?php echo get_checked('1', $pl['simg_type']); ?> onclick="chk_simg_type(1);">
			<label for="simg_type_2">URL 입력</label>
		</td>
	</tr>
	<?php
	for($i=1; $i<=6; $i++) {
		if($i == 1) {
			$item_wpx = $default['de_item_small_wpx'];
			$item_hpx = $default['de_item_small_hpx'];
		} else {
			$item_wpx = $default['de_item_medium_wpx'];
			$item_hpx = $default['de_item_medium_hpx'];
		}

		$image_str = '';
		if(in_array($i,array(1,2,3))) {
			$image_str = ' <strong class="fc_red">[필수]</strong>';
		}
	?>
	<tr class="item_img_fld">
		<th scope="row">이미지<?php echo $i; ?> <span class="fc_197">(<?php echo $item_wpx; ?> * <?php echo $item_hpx; ?>)</span><?php echo $image_str; ?></th>
		<td>
			<div class="item_file_fld">
				<input type="file" name="simg<?php echo $i; ?>">
				<?php echo get_raffle_ahead($pl['simg'.$i], "simg{$i}_del"); ?>
			</div>
			<div class="item_url_fld">
				<input type="text" name="simg<?php echo $i; ?>" value="<?php echo $pl['simg'.$i]; ?>" class="frm_input" size="80" placeholder="http://">
			</div>
		</td>
	</tr>
	<?php } ?>
	<tr>
		<th scope="row">상세설명</th>
		<td>
			<?php echo editor_html('memo', get_text(stripcslashes($pl['memo']), 0)); ?>
		</td>
	</tr>
	<tr>
		<th scope="row">관리자메모</th>
		<td><textarea name="admin_memo" class="frm_textbox"><?php echo $pl['admin_memo']; ?></textarea></td>
	</tr>
	</tbody>
	</table>
</div>

<?php echo $frm_submit; ?>
</form>

<script>
	function fregform_submit(f) {
		<?php echo get_editor_js('memo'); ?>

		return true;
	}

	function chk_entry_type(type) {
		if(type == 0) {
			$("#entry_number").show();
		} else {
			$("#entry_number").hide();
		}
	}

	// 이미지 등록방식
	function chk_simg_type(type) {
		if(type == 0) { // 직접업로드
			$(".item_file_fld").show();
			$(".item_url_fld").hide();
		} else { // URL 입력
			$(".item_img_fld").show();
			$(".item_file_fld").hide();
			$(".item_url_fld").show();
		}
	}

	$("#event_start_date,#event_end_date,#prize_date,#prize_start_date,#prize_end_date").datepicker({ changeMonth: true, changeYear: true, dateFormat: "yy-mm-dd", showButtonPanel: true, yearRange: "c-99:c+99",minDate: 0 });

	chk_simg_type("<?php echo $pl['simg_type']; ?>");
	
	$(document).ready(function() {
		$('#event_start_time , #event_end_time , #prize_time , #prize_start_time , #prize_end_time').on('focus', function() {
			$(this).val('');
		}).on('input', function() {
			var inputValue = $(this).val().replace(/\D/g, '');
			var formattedTime = formatTime(inputValue);
			$(this).val(formattedTime);
		}).on('keydown', function(event) {
			if (event.key === 'Backspace' && $(this).val().length === 3 && $(this).val().includes(':')) {
			$(this).val($(this).val().slice(0, 2));
			}
		});
	});

	function formatTime(time) {
		if (time === '') {
			return '';
		}
		if (isNaN(time)) {
			return '';
		}
		if (time.length !== 4) {
			if (time.length === 1) {
				return time;
			} else if (time.length === 2) {
				return time + ':';
			} else if (time.length === 3) {
				return time.slice(0, 2) + ':' + time.slice(2);
			} else {
				return '';
			}
		}
		var hours = time.slice(0, 2);
		var minutes = time.slice(2, 4);
		return hours + ':' + minutes;
	}
</script>