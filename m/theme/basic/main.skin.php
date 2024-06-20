<?php
if(!defined("_BLUEVATION_")) exit; // 개별 페이지 접근 불가
?>

<!-- contents { -->
<div id="contents" class="main-contents">

<?php if($main_topbnr_slider = mobile_slider(0, $pt_id)) { ?>
<div class="section mtb-wrap">
  <div class="mtb-sl swiper-container">
    <div class="swiper-wrapper">
      <?php echo $main_topbnr_slider; ?>
    </div>
  </div>
  <button type="button" class="mtb-close-btn"><img src="/src/img/mtb-close.png" alt=""></button>
</div>
<?php } ?>

<?php if($main_visual_slider = mobile_slider(1, $pt_id)) { ?>
<!-- 비주얼 배너 { -->
<div class="container section main_visual">
  <div class="cp-banner__round swiper-container">
    <div class="swiper-wrapper">
      <?php echo $main_visual_slider; ?>
    </div>
    <div class="round swiper-control">
      <div class="pagination"></div>
      <button type="button" class="ui-btn playToggle" title="일시정지"></button>
    </div>
  </div>
</div>
<!-- } 비주얼 배너 -->
<?php } ?>

<!-- 상품 카테고리 바로가기 { -->
<div class="container section main_category">
  <div class="cp-quick-category">
    <?php
      $cate_sql = "SELECT * FROM shop_category WHERE LENGTH(catecode) = 3 AND cateuse = 0 ORDER BY caterank asc";
      $cate_res = sql_query($cate_sql);

      while ($cate_row = sql_fetch_array($cate_res)) {
    ?>
    <a href="<?php echo BV_MSHOP_URL.'/list.php?ca_id='.$cate_row["catecode"];?>" class="ui-btn">
      <i class="icon">
        <img src="/data/category/<?php echo $cate_row['cateimg1']?>" alt="<?php echo $cate_row['catename'] ?>">
      </i>
      <p class="name"><?php echo $cate_row['catename'] ?></p>
    </a>
    <?php } ?>
    <!-- <a href="<?php echo BV_MSHOP_URL.'/list.php?ca_id=002';?>" class="ui-btn">
      <i class="icon">
        <img src="/src/img/category-b.png" alt="축산(육가공)">
      </i>
      <p class="name">축산<br>(육가공)</p>
    </a>
    <a href="<?php echo BV_MSHOP_URL.'/list.php?ca_id=002';?>" class="ui-btn">
      <i class="icon">
        <img src="/src/img/category-c.png" alt="위생/주방용품">
      </i>
      <p class="name">위생/주방<br>용품</p>
    </a>
    <a href="<?php echo BV_MSHOP_URL.'/list.php?ca_id=002';?>" class="ui-btn">
      <i class="icon">
        <img src="/src/img/category-d.png" alt="종합 식자재">
      </i>
      <p class="name">종합<br>식자재</p>
    </a>
    <a href="./sub/product-list.html" class="ui-btn">
      <i class="icon">
        <img src="/src/img/category-e.png" alt="수미안 전용관">
      </i>
      <p class="name">수미안<br>전용관</p>
    </a>
    <a href="./sub/product-list.html" class="ui-btn">
      <i class="icon st1">
        <img src="/src/img/category-f.png" alt="회원 전용관">
      </i>
      <p class="name">회원<br>전용관</p>
    </a> -->
  </div>
</div>
<!-- } 상품 카테고리 바로가기 -->

<!-- 관련 서비스 바로가기 { -->
<div class="container section main_service">
  <div class="main-service_wrap">
    <a href="/m/used/list.php?menu=used" class="box box1">
      <div class="box_in">
        <div class="icon">
          <img src="/src/img/main-service-icon1.png" alt="">
        </div>
        <p class="name">중고장터</p>
      </div>
    </a>
    <a href="/m/store/list.php?menu=store" class="box box2">
      <div class="box_in">
        <div class="icon">
          <img src="/src/img/main-service-icon2.png" alt="">
        </div>
        <p class="name">회원사현황</p>
      </div>
    </a>
    <a href="/m/service/list.php?menu=service" class="box box3">
      <div class="box_in">
        <div class="icon">
          <img src="/src/img/main-service-icon3.png" alt="">
        </div>
        <p class="name">제휴서비스</p>
      </div>
    </a>
  </div>
</div>
<!-- } 관련 서비스 바로가기 -->

<!-- 베스트 상품 { -->
<div class="section main_best">
  <div class="container right cp-title">
    <div class="left">
      <div class="icon-box"></div>
      <div class="text-box">
        <h3>베스트</h3>
        <p class="tp-expl">주인장에서 제일 잘 나가요!</p>
      </div>
    </div>
    <div class="right">
      <a href="<?php echo BV_MSHOP_URL;?>/listtype.php?type=2" class="ui-btn more">전체보기</a>
    </div>
  </div>
  <?php echo mobile_slide_goods('2', '20', 'container left main_best-slide'); ?>
</div>
<!-- } 베스트 상품 -->

<!-- 추천상품 { -->
<div class="section main_recomm">
  <div class="container right cp-title">
    <div class="left">
      <div class="icon-box"></div>
      <div class="text-box">
        <h3>추천상품</h3>
        <p class="tp-expl">주인장에서 추천하는 상품이에요!</p>
      </div>
    </div>
    <div class="right">
      <a href="<?php echo BV_MSHOP_URL;?>/listtype.php?type=5" class="ui-btn more">전체보기</a>
    </div>
  </div>
  <?php echo mobile_slide_goods('5', '20', 'container left main_recomm-slide', 'small'); ?>
</div>
<!-- } 추천상품 -->

<!-- 인기상품 { -->
<div class="section main_popular">
  <div class="container right cp-title">
    <div class="left">
      <div class="icon-box"></div>
      <div class="text-box">
        <h3>인기상품</h3>
        <p class="tp-expl">주인장의 인기상품을 만나보세요!</p>
      </div>
    </div>
    <div class="right">
      <a href="<?php echo BV_MSHOP_URL;?>/listtype.php?type=4" class="ui-btn more">전체보기</a>
    </div>
  </div>
  <?php echo mobile_slide_goods('4', '20', 'container left main_popular-slide', 'small'); ?>
</div>
<!-- } 인기상품 -->

<!-- 오늘만 특가상품 { -->
<div class="section main_today">
  <div class="container right cp-title">
    <div class="left">
      <div class="icon-box"></div>
      <div class="text-box">
        <h3>오늘만 <span class="highlight">특가할인!</span></h3>
        <p class="tp-expl">지금 놓치면 끝! 오늘만 특가할인!</p>
      </div>
    </div>
  </div>
  <div class="container left main_today-slide">
    <div class="swiper-container">
      <div class="swiper-wrapper">
        <?php echo mobile_display_today_goods_with_slide('2', '20', 'container left main_popular-slide') ?>
      </div>
      <!-- <div class="swiper-control2">
        <button type="button" class="arrow prev"></button>
        <div class="pagination"></div>
        <button type="button" class="arrow next"></button>
      </div> -->
    </div>
  </div>
  <div class="container bottom_box">
    <a href="<?php echo BV_MSHOP_URL;?>/timesale.php?menu=timesale" class="ui-btn round moreLong">
      <span class="text">전체보기</span>
    </a>
  </div>
</div>
<!-- } 오늘만 특가상품 -->

<!-- 라이브 { -->
<div class="section main_live">
  <div class="container cp-title">
    <div class="left">
      <div class="icon-box">
        <img src="/src/img/icon_liveon.svg" alt="Live ON">
      </div>
      <div class="text-box">
        <h3>주인장 <span class="highlight">LIVE</span></h3>
        <p class="tp-expl">좋은 제품을 라이브로 만나보세요!</p>
      </div>
    </div>
  </div>
  <div class="container left main_live-slide">
    <div class="swiper-container swiper-initialized swiper-horizontal swiper-free-mode swiper-backface-hidden">
      <div class="swiper-wrapper" id="swiper-wrapper-5adc34597a07ad06" aria-live="polite">
        <?php
          $liveListArr = mainLiveList();
          $liveListCount = 1;
          $liveListSize = sizeof($liveListArr);
          if($liveListSize > 0) {
          foreach ($liveListArr as $liveListVal) {
            $liteTime = liveTime($liveListVal['liveTime']['live_start_time']);
        ?>
        <a href="<?php echo $liveListVal['url'] ?>" class="swiper-slide cp-live swiper-slide-active" role="group" aria-label="<?php echo $liveListCount; ?> / 5">
          <div class="round50 prod-thumb_area">
            <div href="" class="thumb">
              <img src="<?php echo "/data/live/".$liveListVal['thumbnail'] ?>" alt="">
            </div>
          </div>
          <div class="prod-info_area">
            <div class="round60 live-reserv">
              <span class="round60 t1">LIVE</span>
              <span class="t2"><?php echo $liteTime ?></span>
            </div>
            <div class="live-title"><?php echo $liveListVal['title'] ?></div>
          </div>
        </a>
        <?php
          $liveListCount++;
          } }
        ?>
        <!-- 종료 추가 { -->
        <a href="" class="swiper-slide cp-live live-off">
          <div class="round50 prod-thumb_area">
            <div href="" class="thumb">
              <img src="/data/live/S7gTpPDgAX5ZHVrZdZJHU9s5vqS9xm.jpg" alt="">
            </div>
          </div>
          <div class="prod-info_area">
            <div class="round60 live-reserv">
              <span class="round60 t1">종료</span>
              <span class="t2">06/20 오전 00:00</span>
            </div>
            <div class="live-title">테스트5</div>
          </div>
        </a>
        <!-- } 종료 추가 -->
      </div>
      <?php if($liveListSize > 3) {?>
      <!-- <div class="swiper-control2">
        <button type="button" class="arrow prev swiper-button-disabled" disabled="" tabindex="-1" aria-label="Previous slide" aria-controls="swiper-wrapper-5adc34597a07ad06" aria-disabled="true"></button>
        <div class="pagination swiper-pagination-custom swiper-pagination-horizontal"><span class="current">1</span><span class="bar">|</span><span class="total">3</span></div>
        <button type="button" class="arrow next" tabindex="0" aria-label="Next slide" aria-controls="swiper-wrapper-5adc34597a07ad06" aria-disabled="false"></button>
      </div> -->
      <?php } ?>
    <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span></div>
  </div>
  <!-- <div class="container bottom_box">
    <a href="" class="ui-btn round moreLong">
      <span class="text">전체보기</span>
    </a>
  </div> -->
</div>
<!-- } 라이브 -->

</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
  var timers = document.querySelectorAll('.cp-timer__num');
  timers.forEach(function(timer) {
    var deadline = timer.getAttribute('data-deadline');
    var countdown = new Date(deadline).getTime();
    var x = setInterval(function() {
      var now = new Date().getTime();
      var distance = countdown - now;
      if (distance <= 0) {
        clearInterval(x);
        timer.innerHTML = '만료';
      } else {
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);
        hours = String(hours).padStart(2, '0');
        minutes = String(minutes).padStart(2, '0');
        seconds = String(seconds).padStart(2, '0');
        timer.innerHTML = hours + ':' + minutes + ':' + seconds ;
      }
    }, 1000);
  });
});
</script>