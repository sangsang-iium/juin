<?php
if(!defined("_BLUEVATION_")) exit; // 개별 페이지 접근 불가
?>

<div id="ctt">
	<div class="img_fix2">
		<?php echo conv_content($config['seller_reg_mobile_guide'], 1); ?>
	</div>

	<div class="btn_confirm">
		<a href="<?php echo BV_MBBS_URL; ?>/seller_reg_from.php" class="btn_medium wset">확인</a>
		<a href="<?php echo BV_MURL; ?>" class="btn_medium bx-white">취소</a>
	</div>
</div>