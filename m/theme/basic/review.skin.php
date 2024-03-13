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
		<p class="review_cnt">내가 작성한 상품후기 <span><?php echo number_format($total_count); ?></span>건</p>
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
						<a href="<?php echo $href; ?>" class="thumb round60">
							<img src="<?php echo get_it_image_url($row['gs_id'], $gs['simg1'], 140, 140); ?>" alt="<?php echo get_text($gs['gname']); ?>" class="fitCover">
						</a>
						<div class="content">
							<a href="<?php echo $href; ?>" class="name"><?php echo cut_str($gs['gname'], 55); ?></a>
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
              <div class="tRow2 content_in">
                <?php 
                echo $row['memo']; 
                // echo cut_str($row['memo'], 55); 
                ?>
              </div>
						</div>
						<button type="button" class="cont-more-btn">더보기+</button>
					</div>
          <?php 
          if(is_admin() || ($member['id'] == $row['mb_id'])) { // 수정, 삭제 버튼 
            $hash = md5($row['index_no'].$row['reg_time'].$row['mb_id']);
          ?>
          <div class="mngArea">
            <a href="javascript:void(0);" data-gs-id="<?php echo $row['gs_id'];?>" data-me-id="<?php echo $row['index_no'];?>" class="ui-btn st3 rv-edit-btn">수정</a>
            <a href="<?php echo BV_MSHOP_URL."/orderreview_update.php?gs_id=".$row[gs_id]."&me_id=".$row[index_no]."&w=d&hash=".$hash;?>" class="ui-btn st3 itemqa_delete">삭제</a>
          </div>
          <?php } ?>
				</div>
			</div>
			<?php } ?>
		<?php
		echo get_paging($config['mobile_pages'], $page, $total_page, $_SERVER['SCRIPT_NAME'].'?page=');
		?>
		<?php } ?>
	</div>
</div>

<!-- 리뷰 수정 팝업 { -->
<div id="review-edit-popup" class="popup type02 add-popup">
  <div class="pop-inner">
    <div class="pop-top">
      <p class="tit">리뷰 수정</p>
      <button type="button" class="btn close"></button>
    </div>
    <div class="pop-content line">
      <div class="pop-content-in">
      </div>
    </div>
  </div>
</div>
<!-- } 리뷰 수정 팝업 -->

<script type="module">
import * as f from '/src/js/function.js';

//리뷰 수정 팝업
$(".rv-edit-btn").on("click", function () {
  const gsId = $(this).data('gs-id');
  const meId = $(this).data('me-id');

  console.log(gsId, meId, "wu")

  const popId = "#review-edit-popup";
  const reqPathUrl = "<?php echo BV_MSHOP_URL;?>/orderreview.php";
  const reqMethod = "GET";
  const reqData = { gs_id: gsId, me_id: meId, w: 'u' };

  f.callData(popId, reqPathUrl, reqMethod, reqData, true);
});
</script>