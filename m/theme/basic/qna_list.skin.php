<?php
if(!defined("_BLUEVATION_")) exit; // 개별 페이지 접근 불가
?>

<div id="contents">

	<div class="faq-cate">
		<div class="container">
			<div id="" class="cp-horizon-menu">
				<input type="hidden" id="menuId" value="<?php echo $qacate > 0? $qacate:'all'; ?>">
				<div class="swiper-wrapper">
					<a href="<?php echo BV_MBBS_URL; ?>/qna_list.php" data-id="all" class="swiper-slide btn">전체</a>
					<?php
					$sql = "select * from shop_qa_cate order by index_no asc";
					$res = sql_query($sql);
					for($i=0; $row=sql_fetch_array($res); $i++) {
					?>
					<a href="<?php echo BV_MBBS_URL; ?>/qna_list.php?qacate=<?php echo $row['index_no']; ?>" data-id="<?php echo $row['index_no']; ?>" class="swiper-slide btn"><?php echo $row['catename']; ?></a>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>

	<div class="txt-board-list" id="qna">
		<div class="container">
			<div class="txt-board-cnt">
				총 <span class="cnt"><?php echo $result->num_rows; ?></span>건
			</div>
			<div class="qa-board">
				<?php
				for($i=0; $row=sql_fetch_array($result); $i++) {
					$bo_date = $row['mb_id']."<span class='padl10'>".substr($row['wdate'],0,10);
				?>
				<!-- <li class="list">
					<a href="<?php echo BV_MBBS_URL; ?>/qna_read.php?index_no=<?php echo $row['index_no']; ?>">
					<p class="subj"><b class="cate">[ <?php echo $row['catename']; ?> ]</b> <?php echo cut_str($row['subject'],60); ?></p>
					<p class="date"><?php echo $bo_date; ?></p>
					</a>
				</li> -->
				<div class="qa-board-item">
					<div class="q-cont arcodianBtn">
						<div class="ic"><img src="/src/img/qa-icon-top.png" alt=""></div>
						<p class="cate">[<?php echo $row['catename']; ?>]</p>
						<p class="tRow1 tit"><?php echo cut_str($row['subject'],60); ?></p>
					</div>
					<div class="a-cont">
						<p class="q-text">
							<?php echo nl2br(stripslashes($row['memo'])); ?>
						</p>
						<div class="a-box">
							<?php if($row['reply']){ ?>
							<p class="a-text">
								<?php echo nl2br($row['reply']); ?>
							</p>
							<?php }else{ ?>
							<p class="a-text">
								답변 준비중입니다.
							</p>
							<?php } ?>
						</div>
						<div class="qna-btn-wrap">
							<a href="<?php echo BV_MBBS_URL; ?>/qna_modify.php?index_no=<?php echo $row['index_no']; ?>" class="ui-btn stBlack sizeS">수정</a>
							<a href="javascript:del('<?php echo BV_MBBS_URL; ?>/qna_read.php?index_no=<?php echo $row['index_no']; ?>&mode=d');" class="ui-btn stWhite sizeS">삭제</a>
						</div>
					</div>
				</div>
				<?php
				}
				if($i==0) echo '<div class="empty_list">자료가 없습니다.</div>';
				?>
			</div>
			<?php 
			echo get_paging($config['mobile_pages'], $page, $total_page, $_SERVER['SCRIPT_NAME'].'?page='); 
			?>

			<div class="cp-btnbar__btns">
				<a href="<?php echo BV_MBBS_URL; ?>/qna_write.php" class="ui-btn round stBlack">상담문의하기</a>
			</div>
		</div>
	</div>

</div>

<script type="module">
	import * as f from '/src/js/function.js';

	let horizonMenuTarget = '.cp-horizon-menu';
	let horizonMenuActive = $('#menuId').val();
	let horizonMenu = f.hrizonMenu(horizonMenuTarget, horizonMenuActive);
</script>

<script>
function del(url) {
	answer = confirm('삭제 하시겠습니까?');
	if(answer==true) { 
		location.href = url; 
	}
}
</script>