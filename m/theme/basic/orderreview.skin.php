<?php
if(!defined("_BLUEVATION_")) exit; // 개별 페이지 접근 불가
?>

<div class="sub-contents orderReview">
	<h2 class="pop_title">
		<?php echo $tb['title']; ?>
		<a href="javascript:window.close();" class="btn_small bx-white">창닫기</a>
	</h2>

	<form name="forderreview" id="sit_review" method="post" action="<?php echo $form_action_url; ?>" onsubmit="return forderreview_submit(this);">
	<input type="hidden" name="w" value="<?php echo $w; ?>">
	<input type="hidden" name="me_id" value="<?php echo $me_id; ?>">
	<input type="hidden" name="gs_id" value="<?php echo $gs_id; ?>">
	<input type="hidden" name="seller_id" value="<?php echo $gs['mb_id']; ?>">
	<input type="hidden" name="token" value="<?php echo $token; ?>">

	<div class="cp-cart order">
		<div class="cp-cart-item">
			<div class="cp-cart-body">
				<div class="thumb round60">
					<?php echo get_it_image($gs_id, $gs['simg1'], 140, 140); ?>
				</div>
				<div class="content">
					<p class="name"><?php echo get_text($gs['gname']); ?></p>
					<div class="info">
						<p class="price"><?php echo mobile_price($gs_id); ?></p>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="score">
		<div class="score-list">
			<input type="radio" id="star5" name="wr_score" value="5" <?php echo get_checked($wr_score, '5'); ?>><label for="star5">5점(<?php echo $gw_star[5]; ?>)</label>
			<input type="radio" id="star4" name="wr_score" value="4" <?php echo get_checked($wr_score, '4'); ?>><label for="star4">4점(<?php echo $gw_star[4]; ?>)</label>
			<input type="radio" id="star3" name="wr_score" value="3" <?php echo get_checked($wr_score, '3'); ?>><label for="star3">3점(<?php echo $gw_star[3]; ?>)</label>
			<input type="radio" id="star2" name="wr_score" value="2" <?php echo get_checked($wr_score, '2'); ?>><label for="star2">2점(<?php echo $gw_star[2]; ?>)</label>
			<input type="radio" id="star1" name="wr_score" value="1" <?php echo get_checked($wr_score, '1'); ?>><label for="star1">1점(<?php echo $gw_star[1]; ?>)</label>
		</div>
		<div class="score-text">
			<span class="score-add">0</span>/ 5
		</div>
	</div>

	<div class="form-list">
		<div class="form-row">
			<div class="form-head">
				<p class="title"><label for="wr_content">상품후기<b>*</b></label></p>
			</div>
			<div class="form-body">
				<textarea name="wr_content" id="wr_content" class="frm-txtar st2 w-per100" placeholder="내용을 입력해주세요."><?php echo $wr_content; ?></textarea>
			</div>
		</div>
		<div class="form-row">
			<div class="form-head">
				<p class="title">이미지등록</p>
			</div>
			<div class="form-body">
				<div class="img-upload">
					
				</div>
			</div>
		</div>
	</div>

	<div class="btn_confirm btn_confirm_2">
		<button type="submit" class="ui-btn round stBlack">등록</button>
		<button type="button" onclick="window.close();" class="ui-btn round stWhite">취소</button>
	</div>
	</form>
</div>

<script>
function forderreview_submit(f) {
	if(!f.wr_content.value) {
		alert('내용을 입력하세요.');
		f.wr_content.focus();
		return false;
	}

	if(!getSelectVal(f["wr_score"])){
		alert('평점을 선택하세요.');
		f.wr_score.focus();
		return false;
	}

	if(confirm("등록 하시겠습니까?") == false)
		return false;

    return true;
}
</script>
