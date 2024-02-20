<?php
if(!defined("_BLUEVATION_")) exit; // 개별 페이지 접근 불가
?>

<!-- contents { -->
<div id="contents" class="main-contents a123123">

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
    <a href="./sub/product-list.html" class="ui-btn">
      <i class="icon">
        <img src="/src/img/category-a.png" alt="농수산">
      </i>
      <p class="name">농수산</p>
    </a>
    <a href="./sub/product-list.html" class="ui-btn">
      <i class="icon">
        <img src="/src/img/category-b.png" alt="축산(육가공)">
      </i>
      <p class="name">축산<br>(육가공)</p>
    </a>
    <a href="./sub/product-list.html" class="ui-btn">
      <i class="icon">
        <img src="/src/img/category-c.png" alt="위생/주방용품">
      </i>
      <p class="name">위생/주방<br>용품</p>
    </a>
    <a href="./sub/product-list.html" class="ui-btn">
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
    </a>
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
        <div class="swiper-slide cp-item time">
          <div class="round50 prod-thumb_area">
            <a href="" class="thumb">
              <img src="/src/img/t-product3.jpg" alt="">
            </a>
            <div class="cp-timer">
              <div class="cp-timer-wrap white">
                <i class="cp-timer__icon"></i>
                <span class="cp-timer__num" data-deadline="2024-02-01 23:59:59">00:00:00</span>
                <span class="cp-timer__text">남음</span>
              </div>
            </div>
          </div>
          <a href="" class="prod-info_area">
            <p class="tRow2 name">백설 스팸&식용유 선물세트</p>
            <p class="dc-price">30,000원</p>
            <p class="price-box">
              <span class="dc-percent">10%</span>
              <span class="sale-price">27,000원</span>
            </p>
          </a>
        </div>
        <div class="swiper-slide cp-item time">
          <div class="round50 prod-thumb_area">
            <a href="" class="thumb">
              <img src="/src/img/t-product8.jpg" alt="">
            </a>
            <div class="cp-timer">
              <div class="cp-timer-wrap white">
                <i class="cp-timer__icon"></i>
                <span class="cp-timer__num" data-deadline="2024-02-01 23:59:59">00:00:00</span>
                <span class="cp-timer__text">남음</span>
              </div>
            </div>
          </div>
          <a href="" class="prod-info_area">
            <p class="tRow2 name">바다소리 건어물 선물세트 2호</p>
            <p class="dc-price">30,000원</p>
            <p class="price-box">
              <span class="dc-percent">10%</span>
              <span class="sale-price">27,000원</span>
            </p>
          </a>
        </div>
        <div class="swiper-slide cp-item time">
          <div class="round50 prod-thumb_area">
            <a href="" class="thumb">
              <img src="/src/img/t-product3.jpg" alt="">
            </a>
            <div class="cp-timer">
              <div class="cp-timer-wrap white">
                <i class="cp-timer__icon"></i>
                <span class="cp-timer__num" data-deadline="2024-02-01 23:59:59">00:00:00</span>
                <span class="cp-timer__text">남음</span>
              </div>
            </div>
          </div>
          <a href="" class="prod-info_area">
            <p class="tRow2 name">백설 스팸&식용유 선물세트</p>
            <p class="dc-price">30,000원</p>
            <p class="price-box">
              <span class="dc-percent">10%</span>
              <span class="sale-price">27,000원</span>
            </p>
          </a>
        </div>
        <div class="swiper-slide cp-item time">
          <div class="round50 prod-thumb_area">
            <a href="" class="thumb">
              <img src="/src/img/t-product8.jpg" alt="">
            </a>
            <div class="cp-timer">
              <div class="cp-timer-wrap white">
                <i class="cp-timer__icon"></i>
                <span class="cp-timer__num" data-deadline="2024-02-01 23:59:59">00:00:00</span>
                <span class="cp-timer__text">남음</span>
              </div>
            </div>
          </div>
          <a href="" class="prod-info_area">
            <p class="tRow2 name">바다소리 건어물 선물세트 2호</p>
            <p class="dc-price">30,000원</p>
            <p class="price-box">
              <span class="dc-percent">10%</span>
              <span class="sale-price">27,000원</span>
            </p>
          </a>
        </div>
        <div class="swiper-slide cp-item time">
          <div class="round50 prod-thumb_area">
            <a href="" class="thumb">
              <img src="/src/img/t-product3.jpg" alt="">
            </a>
            <div class="cp-timer">
              <div class="cp-timer-wrap white">
                <i class="cp-timer__icon"></i>
                <span class="cp-timer__num" data-deadline="2024-02-01 23:59:59">00:00:00</span>
                <span class="cp-timer__text">남음</span>
              </div>
            </div>
          </div>
          <a href="" class="prod-info_area">
            <p class="tRow2 name">백설 스팸&식용유 선물세트</p>
            <p class="dc-price">30,000원</p>
            <p class="price-box">
              <span class="dc-percent">10%</span>
              <span class="sale-price">27,000원</span>
            </p>
          </a>
        </div>
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