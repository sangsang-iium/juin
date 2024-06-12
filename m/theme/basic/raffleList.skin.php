<?php
if(!defined("_BLUEVATION_")) exit; // 개별 페이지 접근 불가
?>

<div id="contents" class="sub-contents orderList">
  <div class="order-list-wr">
    <div id="smb_order" class="raffle-list">
      <?php
      for($i=0; $row=sql_fetch_array($result); $i++){
        echo '<div class="bottomBlank cp-orderWrap">'.PHP_EOL;
        echo '<div class="container">'.PHP_EOL;

        $raffleEndCheck = raffleEventDateCheck($row['event_end_date'],$row['prize_date']);
      ?>
      <div class="order-info">
        <div class="order-info-box">
          <p class="order-date">2024.01.26</p>
          <a href="" class="view">
            <span>상세보기</span>
            <span><img src="/src/img/order-view-right.png" alt="상세보기"></span>
          </a>
        </div>
      </div>
      <div class="cp-orderItem">
        <a href="/m/raffle/view.php?index_no=<?php echo $row['raffle_index'] ?>" class="thumb round60">
        <?php echo get_raffle_list_img($row['simg1']); ?>
        </a>
        <div class="content">
          <?php if($raffleEndCheck == 1) { ?>
          <span class="tag com">응모완료</span>
          <?php } else if ($raffleEndCheck == 2) { ?>
          <span class="tag off">응모종료</span>
          <?php } else if ($raffleEndCheck == 3) { ?>
          <span class="tag on">응모당첨</span>
          <?php } ?>
          <a href="/m/raffle/view.php?index_no=<?php echo $row['raffle_index'] ?>" class="name"><?php echo $row['goods_name']; ?></a>
          <div class="info">
            <p class="p_cnt tRow1">20명 참여</p>
            <p class="date tRow1">응모기간 | 2024.01.01 ~ 2024.01.31</p>
          </div>
        </div>
        <!-- <a href="" class="ui-btn ord-review__btn iq-wbtn">상품후기 작성</a> -->
        <!-- <button class="ui-btn ord-review__btn iq-wbtn rv-write-btn" data-gs-id="<?php echo $ct['gs_id'];?>" data-od-no="<?php echo $ct['od_no'] ?>">상품후기 작성</button> -->
      </div>
      <?php if ($raffleEndCheck == 3) { ?>
        <?php if($row['prize'] == 'Y') { 
          if($row['order'] == 'N') {?>
        <button class="ui-btn ord-review__btn iq-wbtn rv-write-btn rf-order-btn" data-index-no="<?php echo $row['raffle_index'];?>">구매하기</button>
        <?php } else { ?>
          <p class="ui-btn ord-review__btn iq-wbtn rv-write-btn">구매 완료</p>
        <?php } ?>
        <?php } else { ?>
        <p class="ui-btn ord-review__btn iq-wbtn rv-write-btn">다음에 도전해주세요</p>
        <?php } ?>
      <?php } ?>

      <!-- 2024-06-12 수정 전 소스 { -->
      <!-- <div class="cp-orderItem">
        <a href="/m/raffle/view.php?index_no=<?php echo $row['raffle_index'] ?>" class="thumb round60">
        <?php echo get_raffle_list_img($row['simg1']); ?>
        </a>
        <div class="content">
          <a href="/m/raffle/view.php?index_no=<?php echo $row['raffle_index'] ?>" class="name"><?php echo $row['goods_name']; ?></a>
          <div class="info">
            <p class="price"><?php echo display_price($row['raffle_price']); ?></p>
          </div>
        </div>
        <?php if($raffleEndCheck == 1) { ?>
          <p class="ui-btn ord-review__btn iq-wbtn rv-write-btn">레플 진행중</p>
        <?php } else if ($raffleEndCheck == 2) { ?>
          <p class="ui-btn ord-review__btn iq-wbtn rv-write-btn">레플 추첨중</p>
        <?php } else if ($raffleEndCheck == 3) { ?>
          <?php if($row['prize'] == 'Y') { 
              if($row['order'] == 'N') {?>
            <button class="ui-btn ord-review__btn iq-wbtn rv-write-btn rf-order-btn" data-index-no="<?php echo $row['raffle_index'];?>">구매하기</button>
            <?php } else { ?>
              <p class="ui-btn ord-review__btn iq-wbtn rv-write-btn">구매 완료</p>
            <?php } ?>
          <?php } else { ?>
            <p class="ui-btn ord-review__btn iq-wbtn rv-write-btn">다음에 도전해주세요</p>
          <?php } ?>
        <?php } ?>

      </div> -->
      <!-- } 2024-06-12 수정 전 소스 -->

      <?php
        echo '</div>'.PHP_EOL;
        echo '</div>'.PHP_EOL;
      }

      if($i == 0)
        echo '<div class="empty_list">레플 내역이 없습니다.</div>';
      ?>

    </div>

    <?php
      echo get_paging($config['mobile_pages'], $page, $total_page, $_SERVER['SCRIPT_NAME'].'?page=');
    ?>
  </div>
</div>


<script type="module">
import * as f from '/src/js/function.js';


document.querySelectorAll(".rf-order-btn").forEach(btn => {
  btn.addEventListener("click", function(event) {
    const index_no = event.currentTarget.dataset.indexNo;
    $.ajax({
      url: "./raffleOrder.php",
        type: "POST",
        data: { "index_no": index_no },
        dataType: "json",
        async: false,
        cache: false,
        success: function(data, textStatus) {
          document.location.href = data.url;
          return false;
        }
    });

  });
});

</script>