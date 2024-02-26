<?php
if(!defined("_BLUEVATION_")) exit; // 개별 페이지 접근 불가
?>

<div id="contents" class="sub-contents reviewList">
	<div id="review_top">
		<select name="" id="" class="frm-select review_select">
			<option value="">1개월</option>
			<option value="">3개월</option>
			<option value="">6개월</option>
			<option value="">1년</option>
		</select>
		<p class="review_cnt">총 <span><?php echo number_format($total_count); ?></span>개의 상품후기가 있습니다. </p>
	</div>

	<div id="sod_review">
		<?php
		if(!$total_count) {
			echo "<p class=\"empty_list\">상품후기가 없습니다.</p>";
		} else {
		?>
			<?php
			for($i=0; $row=sql_fetch_array($result); $i++) {
				$href = BV_MSHOP_URL.'/view.php?gs_id='.$row['gs_id'];
				$gs = get_goods($row['gs_id'], 'gname, simg1');

				$wr_star = $gw_star[$row['score']];
				$wr_id   = substr($row['mb_id'],0,3).str_repeat("*",strlen($row['mb_id']) - 3);
				$wr_time = substr($row['reg_time'],0,10);
			?>
			<div class="cp-cart order">
				<div class="cp-cart-item">
					<div class="cp-cart-body">
						<a href="<?php echo $href; ?>" target="_blank" class="thumb round60">
							<img src="<?php echo get_it_image_url($row['gs_id'], $gs['simg1'], 140, 140); ?>" alt="<?php echo get_text($gs['gname']); ?>" class="fitCover">
						</a>
						<div class="content">
							<a href="<?php echo $href; ?>" target="_blank" class="name"><?php echo cut_str($gs['gname'], 55); ?></a>
						</div>
					</div>
				</div>
				<div class="rv-item">
					<div class="rv-top">
						<div class="left">
							<div class="point">
								<img src="/src/img/icon-point<?php echo $row['score']; ?>.svg" alt="">
							</div>
							<p class="name"><?php echo $wr_id; ?></p>
						</div>
						<div class="right">
							<p class="date"><?php echo $wr_time; ?></p>
						</div>
					</div>
					<div class="rv-content-wr">
						<!-- 이미지 없을 경우 생략가능 { -->
						<div class="rv-img-list">
							<div class="rv-img-item">
								<div class="rv-img">
									<img src="/src/img/pd-rv-img01.png" alt="">
								</div>
							</div>
							<div class="rv-img-item">
								<div class="rv-img">
									<img src="/src/img/pd-rv-img02.png" alt="">
								</div>
							</div>
						</div>
						<!-- } 이미지 없을 경우 생략가능 -->
						<div class="content">
							<?php echo cut_str($row['memo'], 55); ?>
						</div>
						<button type="button" class="cont-more-btn">더보기+</button>
					</div>
				</div>
			</div>
			<?php } ?>
		<?php
		echo get_paging($config['mobile_pages'], $page, $total_page, $_SERVER['SCRIPT_NAME'].'?page=');
		?>
		<?php } ?>
	</div>
</div>
