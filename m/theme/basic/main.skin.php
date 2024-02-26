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
      $cate_sql = "SELECT * FROM iu_category_main order by cm_rank asc";
      $cate_res = sql_query($cate_sql);

      while ($cate_row = sql_fetch_array($cate_res)) {
    ?>
    <a href="<?php echo BV_MSHOP_URL.'/list.php?ca_id='.$cate_row["cm_ca_id"];?>" class="ui-btn">
      <i class="icon">
        <img src="/data/category/<?php echo $cate_row['cm_img']?>" alt="<?php echo $cate_row['cm_catename'] ?>">
      </i>
      <p class="name"><?php echo $cate_row['cm_catename'] ?></p>
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
      <div class="swiper-control2">
        <button type="button" class="arrow prev"></button>
        <div class="pagination"></div>
        <button type="button" class="arrow next"></button>
      </div>
    </div>
  </div>
  <div class="container bottom_box">
    <a href="" class="ui-btn round moreLong">
      <span class="text">전체보기</span>
    </a>
  </div>
</div>
<!-- } 오늘만 특가상품 -->

<!-- { -->
<!-- } -->

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