<?php
if(!defined('_BLUEVATION_')) exit;

$pl = sql_fetch("select * from shop_goods_raffle where index_no = '{$index_no}' ");
if(!$pl['index_no'])
	alert('자료가 존재하지 않습니다.');

?>


<div class="tbl_frm02">
	<table>
	<colgroup>
		<col class="w140">
		<col>
	</colgroup>
	<tbody>
	<tr>
		<th scope="row">상품평</th>
		<td><p><?php echo $pl['goods_name']; ?></p></td>
	</tr>
	<tr>
		<th scope="row">응모기간</th>
		<td>
			<span><?php echo ymdhisToYmd($pl['event_start_date'])." ".ymdhisToHi($pl['event_start_date']) ?></span>
			~ 
			<span><?php echo ymdhisToYmd($pl['event_end_date'])." ".ymdhisToHi($pl['event_end_date']) ?></span>
		</td>
	</tr>
	<tr>
		<th scope="row">당첨자 발표</th>
		<td>
			<span><?php echo ymdhisToYmd($pl['prize_date'])." ".ymdhisToHi($pl['prize_date']) ?></span>
		</td>
	</tr>
	<tr>
		<th scope="row">당첨자 구매기간</th>
		<td>
			<span><?php echo ymdhisToYmd($pl['prize_start_date'])." ".ymdhisToHi($pl['prize_start_date']) ?></span>
			~ 
			<span><?php echo ymdhisToYmd($pl['prize_end_date'])." ".ymdhisToHi($pl['prize_end_date']) ?></span>
		</td>
	</tr>
	<tr>
		<th scope="row">시중가격</th>
		<td>
			<span><?php echo $pl['market_price']; ?></span>
		</td>
	</tr>
	<tr>
		<th scope="row">구매가격</th>
		<td>
			<span><?php echo $pl['raffle_price']; ?></span>
		</td>
	</tr>
	<tr>
		<th scope="row">당첨자 수</th>
		<td>
			<span><?php echo $pl['winner_number']; ?></span>
		</td>
	</tr>
	<tr>
		<th scope="row">응모 제한</th>
		<td>	
			<span><?php echo ($pl['entry'] == 0)? "예":"아니요"; ?></span>
			<span><?php echo ($pl['entry'] == 0)? raffleWinnerNumber($pl['index_no'])." / ".$pl['entry_number']." 명":""; ?></span>
		</td>
	</tr>
	<tr>
		<th scope="row">안내사항</th>
		<td>
			<span><?php echo nl2br($pl['infomation']); ?></span>
		</td>
	</tr>
	<tr>
		<th scope="row">이미지 등록방식</th>
		<td class="td_label">
			<span><?php echo ($pl['simg_type'] == 0)? "직접 업로드":"URL 입력"; ?></span>
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
		if(in_array($i,array(1,2))) {
			$image_str = ' <strong class="fc_red">[필수]</strong>';
		}
	?>
	<tr class="item_img_fld">
		<th scope="row">이미지<?php echo $i; ?> <span class="fc_197">(<?php echo $item_wpx; ?> * <?php echo $item_hpx; ?>)</span><?php echo $image_str; ?></th>
		<td>
			<div class="item_file_fld">
				<!-- <input type="file" name="simg<?php echo $i; ?>"> -->
				<?php echo get_raffle_detail_ahead($pl['simg'.$i], "simg{$i}_del"); ?>
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
			<span><?php echo nl2br($pl['memo']) ?></span>
		</td>
	</tr>
	<tr>
		<th scope="row">관리자메모</th>
		<td>
			<span><?php echo nl2br($pl['admin_memo']) ?></span>
		</td>
	</tr>
	</tbody>
	</table>
</div>
<div class="btn_confirm">
	<a href="<?php echo './goods.php?code=raffle'.$qstr.'&page='.$page.'' ?>" class="btn_large bx-white">목록</a>
	<a href="<?php echo './goods.php?code=raffle_log&raffle_index='.$index_no.'' ?>" class="btn_large bx-white">신청 목록</a>
</div>
<script>
	function chk_entry_type(type) {
		if(type == 0) {
			$("#winner_number").prop('readonly', false);
		} else {
			$("#winner_number").val('');
			$("#winner_number").prop('readonly', true);
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
	
	chk_simg_type("<?php echo $pl['simg_type']; ?>");
</script>