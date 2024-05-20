<?php
if(!defined("_BLUEVATION_")) exit; // 개별 페이지 접근 불가
?>

<div id="review_top">
  <div class="btn_confirm">
		<!-- <button type="button" onclick="window.open('<?php echo BV_MSHOP_URL; ?>/orderreview.php?gs_id=<?php echo $gs_id; ?>');" class="ui-btn round stBlack writeBtn rv-write-btn">구매후기쓰기</button> -->
    <button type="button" class="ui-btn round stBlack writeBtn rv-write-btn">구매후기쓰기</button>
	</div>
  <select name="review_select" id="review_select" class="frm-select review_select">
    <option value="1">1개월</option>
    <option value="3">3개월</option>
    <option value="6">6개월</option>
    <option value="12">1년</option>
  </select>
  <p class="review_cnt">총 <span><?php echo number_format($total_count); ?></span>개의 상품후기가 있습니다. </p>
</div>

<div id="sit_review">
  <div class="cp-cart order">
    <div class="cp-cart-item">
      <div class="cp-cart-body">
        <div class="thumb round60">
					<img src="<?php echo get_it_image_url($gs_id, $gs['simg1'], 140, 140); ?>" alt="<?php echo get_text($gs['gname']); ?>" class="fitCover">
        </div>
        <div class="content">
          <p class="name"><?php echo get_text($gs['gname']); ?></p>
          <div class="info">
            <!-- <div class="set">
              <p>1개</p>
              <p>1세트</p>
            </div> -->
            <p class="price"><?php echo mobile_price($gs_id); ?></p>
          </div>
        </div>
      </div>
    </div>
  </div>

	<?php
	echo "<ul>\n";
	for($i=0; $row=sql_fetch_array($result); $i++)
	{
		$wr_star = $gw_star[$row['score']];
		$wr_id   = substr($row['mb_id'],0,3).str_repeat("*",strlen($row['mb_id']) - 3);
		$wr_time = substr($row['reg_time'],0,10);

		$hash = md5($row['index_no'].$row['reg_time'].$row['mb_id']);

    $reviewImgArr = reviewImg($row['index_no']);
    $reviewOption = reviewGoodOption($gs_id);
		//상단 {
    echo "<div class='rv-item'>";
    echo "<div class='rv-top'>";
    echo "<div class='left'>";
    echo "<div class='point'>";
    echo "<img src='/src/img/icon-point".$row['score'].".svg' alt=''>";
    echo "</div>";
    echo "<p class='name'>$wr_id</p>";
    echo "</div>";
    echo "<div class='right'>";
    echo "<p class='date'>$wr_time</p>";
    echo "</div>";
    echo "</div>";
    // } 상단

    if($row['option1'] || $row['option2']) {
    // 옵션이 있다면 {
    echo "<div class='rv-option-wr'>";
    if($row['option1']) {
    echo "<div class='rv-option-item'>";
    echo "<p class='tit'>".$reviewOption[0]."</p>";
    echo "<p class='cont'>".$row['option1']."</p>";
    echo "</div>";
    }
    if($row['option2']) {
    echo "<div class='rv-option-item'>";
    echo "<p class='tit'>".$reviewOption[1]."</p>";
    echo "<p class='cont'>".$row['option2']."</p>";
    echo "</div>";
    }
    echo "</div>";
    // } 옵션이 있다면
    }

    //내용 {
    echo "<div class='rv-content-wr'>";

    if(sizeof($reviewImgArr) > 0) {
      //이미지가 있다면 {
      echo "<div class='rv-img-list'>";
      foreach ($reviewImgArr as $reviewImg) {
        echo "<div class='rv-img-item'>";
        echo "<div class='rv-img'>";
        echo "<img src='/data/review/".$reviewImg['thumbnail']."' alt=''>";
        echo "</div>";
        echo "</div>";
      }
      echo "</div>";
      // } 이미지가 있다면
    }

    echo "<div class='content'>$row[memo]</div>";

    echo "<button type='button' class='cont-more-btn'>더보기+</button>";
    echo "</div>";

    if(is_admin() || ($member['id'] == $row['mb_id'])) { // 수정, 삭제 버튼
      echo "<div class='mngArea'>";
      echo "<a href=\"javascript:void(0);\" data-me-id='".$row[index_no]."' class='ui-btn st3 rv-inEdit-btn'>수정</a>";
      echo "<a href=\"".BV_MSHOP_URL."/orderreview_update.php?gs_id=$row[gs_id]&me_id=$row[index_no]&w=d&hash=$hash&p=1\" class='ui-btn st3 itemqa_delete'>삭제</a>";
      echo "</div>";
    }
    // } 내용

    echo "</div>\n";
	}

	if($i == 0) {
		echo "<div class='empty_box'>자료가 없습니다</div>\n";
	}

	echo "</ul>\n";

	// echo get_paging($config['mobile_pages'], $page, $total_page, $_SERVER['SCRIPT_NAME'].'?'.$q1.'&page=');
	echo get_paging_popup($config['mobile_pages'], $page, $total_page, $_SERVER['SCRIPT_NAME'].'?'.$q1.'&page=');
  
	?>
</div>

<script>
  function cl_list(){
    opener.location.href = bv_mobile_shop_url+'/list.php?ca_id=<?php echo $gs[ca_id]; ?>';
    window.close();
  }

  // 삭제
  $(function(){
      $(".itemqa_delete").click(function(){
          return confirm("정말 삭제 하시겠습니까?\n\n삭제후에는 되돌릴수 없습니다.");
      });
  });

  $(document).ready(function() {
  $('#review_select').on('change', fetchReviews);
});

function fetchReviews() {
  const period = $('#review_select').val();
  const gsId = '<?php echo $gs_id; ?>';

  $.ajax({
    url: '/m/shop/reviewPeriodList.php',
    type: 'POST',
    data: { period: period, gs_id: gsId },
    success: function(response) {
      const data = JSON.parse(response);
      $('#sit_review ul').html(data.reviewHtml);
      $('.review_cnt span').text(data.totalCount);
    },
    error: function() {
      console.error('Error fetching reviews');
    }
  });
};


function changePage(page, url) {
    const period = $('#review_select').val();
    const gsId = '<?php echo $gs_id; ?>';

    $.ajax({
        url: '/m/shop/reviewPeriodList.php',
        type: 'POST',
        data: { period: period, gs_id: gsId, page: page },
        success: function(response) {
            const data = JSON.parse(response);
            $('#sit_review ul').html(data.reviewHtml);
            $('.review_cnt span').text(data.totalCount);

            $('.pg_page').removeClass('pg_current');
            $('.pg_page').eq(page - 2).addClass('pg_current');
            updatePagination('<?php echo $config['mobile_pages'] ?>', page, data.totalPages, '<?php echo $_SERVER['SCRIPT_NAME'].'?'.$q1.'&page=' ?>' );
        },
        error: function() {
            console.error('Error fetching reviews');
        }
    });
}

// 새로운 페이징을 가져와서 업데이트하는 함수
function updatePagination(write_pages, cur_page, total_page, url) {
    $.ajax({
        url: '/m/shop/reviewPaging.php',
        type: 'GET',
        data: { write_pages : write_pages, cur_page: cur_page, total_page: total_page, url:url },
        success: function(response) {
          // 페이징을 업데이트
          $('.pg_wrap').html(response);
        },
        error: function() {
          console.error('Error fetching pagination');
        }
    });
}

</script>
