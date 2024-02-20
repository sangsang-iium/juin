<?php
if(!defined("_BLUEVATION_")) exit; // 개별 페이지 접근 불가
?>

<div id="contents">

	<!-- 검색 { -->
	<form name="searchform" method="get">
		<input type="hidden" name="boardid" value="<?php echo $boardid; ?>">
		<div class="bottom_sch">
			<div class="container">
				<select name="sfl">
				<?php
				for($i=0;$i<sizeof($gw_search_value);$i++) {
					echo "<option value='{$gw_search_value[$i]}'".get_selected($gw_search_value[$i], $sfl).">{$gw_search_text[$i]}</option>\n";
				}
				?>
				</select>
				<!-- <input type="text" name="stx" class="frm_input" value="<?php echo $stx; ?>">
				<input type="submit" value="검색" class="btn_small grey"> -->
				<div class="search">
					<input type="text" name="stx" class="w-per100 round100 keyword" value="<?php echo $stx; ?>" placeholder="검색어를 입력하세요.">
					<button type="submit" class="ui-btn submit" title="검색하기" value="검색"></button>
				</div>
			</div>
		</div>
	</form>
	<!-- } 검색 -->

	<div class="faq-cate">
		<div class="container">
			<div id="" class="cp-horizon-menu">
				<input type="hidden" id="menuId" value="<?php echo $faqcate > 0?$faqcate:'all'; ?>">
				<div class="swiper-wrapper">
					<a href="<?php echo BV_MBBS_URL; ?>/faq.php" data-id="all" class="swiper-slide btn">전체</a>
					<?php
					$sql = "select * from shop_faq_cate order by index_no asc";
					$res = sql_query($sql);
					for($i=0; $row=sql_fetch_array($res); $i++) {
					?>
					<a href="<?php echo BV_MBBS_URL; ?>/faq.php?faqcate=<?php echo $row['index_no']; ?>" data-id="<?php echo $row['index_no']; ?>" class="swiper-slide btn"><?php echo $row['catename']; ?></a>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>

	<div class="txt-board-list" id="faq">
		<div class="container">
			<?php
			$sql = "select * from shop_faq ";
			if($faqcate) $sql .= " where cate='$faqcate'";
			$sql.= " order by index_no asc ";
			$rst = sql_query($sql);
			?>
			<div class="txt-board-cnt">
				총 <span class="cnt">160</span>건
			</div>
			<div class="qa-board">
				<?php
				for($i=0; $row=sql_fetch_array($rst); $i++) {
					$cate_sql = " select catename from shop_faq_cate where index_no='{$row['cate']}' ";
					$cate_result = sql_query($cate_sql);
					$cate_row = sql_fetch_array($cate_result);
				?>
				<div class="qa-board-item">
					<div class="q-cont arcodianBtn">
						<div class="ic"><img src="/src/img/qa-icon-top.png" alt=""></div>
						<p class="cate">[<?php echo $cate_row['catename'] ?>]</p>
						<p class="tRow1 tit"><?php echo $row['subject']; ?></p>
					</div>
					<div class="a-cont">
						<div class="a-box">
							<div class="a-text">
								<?php echo nl2br($row['memo']); ?>
							</div>
						</div>
					</div>
				</div>
				<?php } ?>
				<?php if($i==0) { ?>
				<div class="empty_list">자료가 없습니다.</div>
				<?php } ?>
			</div>
		</div>
	</div>

</div>

<!-- <div class="s_cont">
	<select name="faq_type" class="faq_sch" onchange="location=this.value;">
		<option value="<?php echo BV_MBBS_URL; ?>/faq.php">전체보기</option>
		<?php
		$sql = "select * from shop_faq_cate order by index_no asc";
		$res = sql_query($sql);
		for($i=0; $row=sql_fetch_array($res); $i++) {
			$selected = "";
			if($row['index_no']==$faqcate) {
				$selected = ' selected';
			}
		?>
		<option value="<?php echo BV_MBBS_URL; ?>/faq.php?faqcate=<?php echo $row['index_no']; ?>"<?php echo $selected; ?>><?php echo $row['catename']; ?></option>
		<?php } ?>
	</select>
	<div class="faq_li">
		<ul>
			<?php
			$sql = "select * from shop_faq ";
			if($faqcate) $sql .= " where cate='$faqcate'";
			$sql.= " order by index_no asc ";
			$rst = sql_query($sql);
			for($i=0; $row=sql_fetch_array($rst); $i++) {
			?>
			<li class="faq_q" onclick="js_faq('<?php echo $i; ?>');">
				<?php echo $row['subject']; ?>
			</li>
			<li id="sod_faq_con_<?php echo $i; ?>" class="faq_a">
				<?php echo nl2br($row['memo']); ?>
			</li>
			<?php } ?>
		</ul>
	</div>
	<?php if($i==0) { ?>
	<div class="empty_list">자료가 없습니다.</div>
	<?php } ?>
</div> -->

<script type="module">
	import * as f from '/src/js/function.js';

	let horizonMenuTarget = '.cp-horizon-menu';
	let horizonMenuActive = $('#menuId').val();
	let horizonMenu = f.hrizonMenu(horizonMenuTarget, horizonMenuActive);
</script>

<script>
function js_faq(id){
	var $con = $("#sod_faq_con_"+id);
	if($con.is(":visible")) {
		$con.slideUp("fast");
		$(".faq_q").removeClass("active");
	} else {
		$(".faq_a:visible").slideUp("fast");
		$con.slideDown("fast");
		$(".faq_q").removeClass("active");
		$con.prev().addClass("active");
	}
}
</script>
