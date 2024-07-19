<?php
if (!defined("_BLUEVATION_")) {
  exit;
}
// 개별 페이지 접근 불가

include_once(BV_PATH.'/include/introBtn.php');

// echo sendPushNotification($member['fcm_token'], "로그인", "로그인성공");

?>

<!-- contents { -->
<div id="contents" class="main-contents">

<?php if ($main_topbnr_slider = mobile_slider(0, $pt_id)) {?>
<div class="section mtb-wrap">
  <div class="mtb-sl swiper-container">
    <div class="swiper-wrapper">
      <?php echo $main_topbnr_slider; ?>
    </div>
  </div>
  <button type="button" class="mtb-close-btn"><img src="/src/img/mtb-close.png" alt=""></button>
</div>
<?php }?>

<?php if ($main_visual_slider = mobile_slider(1, $pt_id)) {?>
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
<?php }?>

<!-- 오늘만 특가상품 { -->
<div class="section main_today">
  <div class="container right cp-title">
    <div class="left">
      <div class="icon-box"></div>
      <div class="text-box">
        <h3>타임세일!<!-- <span class="highlight">특가</span> --></h3>
        <p class="tp-expl">지금 놓치면 끝! 오늘만 특가할인!</p>
      </div>
    </div>
    <div class="right">
      <div class="cp-timer">
        <div class="cp-timer-wrap">
          <i class="cp-timer__icon"></i>
          <span class="cp-timer__text">D-Day</span>
          <?php // $deadline = date('Y-m-d', strtotime('+6 days')); ?>
          <?php $deadline = "2024-07-21"; ?>
          <span class="cp-timer__num" data-deadline="<?php echo $deadline ?> 23:59:59">00:00:00</span>
        </div>
      </div>
      <a href="<?php echo BV_MSHOP_URL; ?>/listtype.php?type=1" class="ui-btn more">전체보기</a>
    </div>
  </div>
  <div class="container left main_today-slide">
    <div class="swiper-container">
      <div class="swiper-wrapper">
        <?php echo mobile_display_today_goods_with_slide('1', '20', 'container left main_popular-slide') ?>
      </div>
      <!-- <div class="swiper-control2">
        <button type="button" class="arrow prev"></button>
        <div class="pagination"></div>
        <button type="button" class="arrow next"></button>
      </div> -->
    </div>
  </div>
  <!-- <div class="container bottom_box">
    <a href="<?php echo BV_MSHOP_URL; ?>/timesale.php?menu=timesale" class="ui-btn round moreLong">
      <span class="text">전체보기</span>
    </a>
  </div> -->
</div>
<!-- } 오늘만 특가상품 -->


<!-- pb 상품 { -->
<div class="section main_best bgColor1">
  <div class="container right cp-title">
    <div class="left">
      <div class="icon-box"></div>
      <div class="text-box">
        <h3>회원 PB상품</h3>
        <p class="tp-expl">회원만을 위해 준비된 상품이에요</p>
      </div>
    </div>
    <div class="right">
      <a href="<?php echo BV_MSHOP_URL; ?>/listtype.php?type=2&menu=best" class="ui-btn more">전체보기</a>
    </div>
  </div>
  <?php echo mobile_slide_goods('2', '20', 'container left main_best-slide'); ?>
</div>
<!-- } pb 상품 -->

<!-- 띠 배너 1 { -->
<div class="line-banner-section line-banner01">
  <div class="container right cp-title">
    <div class="left">
      <div class="icon-box"></div>
      <div class="text-box">
        <h3>회원특별관</h3>
      </div>
    </div>
  </div>
  <div class="swiper-container">
    <div class="swiper-wrapper">
      <!-- 배너 { -->
       <?php
        /* ------------------------------------------------------------------------------------- _20240713_SY
          회원특별관 인트로 링크 삽입
          우선 내부에서만 인트로로 이동되도록 해 놓음, 업체에서 인트로로 연결되도록 해 달라고 하면 if문 빼면 됨
          나중에 배너 폴더 따로 만들어서 해당 폴더 이미지 돌아가게 개발 해 놓는게 편할거 같음
          ------------------------------------------------------------------------------------- */
      //  if($_SERVER['REMOTE_ADDR'] == '106.247.231.170') {
        $brand_href = "/m/brand/brandIntro.php?ca_id=006";
      //  } else {
      //   $brand_href = "/m/shop/list.php?ca_id=006";
      //  }
       ?>
      <a href="<?php echo $brand_href ?>" class="swiper-slide banner-item">
        <div class="banner-img">
          <img src="/src/img/mainbanner1_samsung.jpg" alt="">
        </div>
      </a>
      <!-- } 배너 -->
      <!-- 배너 { -->
      <a href="<?php echo $brand_href ?>" class="swiper-slide banner-item">
        <div class="banner-img">
          <img src="/src/img/mainbanner1_lg.jpg" alt="">
        </div>
      </a>
      <!-- } 배너 -->
      <!-- 배너 { -->
      <a href="<?php echo $brand_href ?>" class="swiper-slide banner-item">
        <div class="banner-img">
          <img src="/src/img/mainbanner1_cuckoo.jpg" alt="">
        </div>
      </a>
      <!-- } 배너 -->
    </div>
  </div>
</div>
<!-- } 띠 배너 1 -->


<!-- 추천 상품 { -->
<div class="section main_best bgColor1" style="margin-top: 0;">
  <div class="container right cp-title">
    <div class="left">
      <div class="icon-box"></div>
      <div class="text-box">
        <h3>추천상품</h3>
        <p class="tp-expl">주인장에서 제일 잘 나가요!</p>
      </div>
    </div>
    <div class="right">
      <a href="<?php echo BV_MSHOP_URL; ?>/listtype.php?type=5" class="ui-btn more">전체보기</a>
    </div>
  </div>
  <?php echo mobile_slide_goods('5', '20', 'container left main_best-slide'); ?>
</div>
<!-- } 추천 상품 -->


<!-- 띠 배너 2 { -->
<div class="line-banner-section line-banner02">
  <div class="swiper-container">
    <div class="swiper-wrapper">
      <!-- 배너 { -->
      <a href="/m/service/list.php?menu=service" class="swiper-slide banner-item">
        <div class="banner-img">
          <img src="/src/img/mainbanner2_signup.jpg" alt="">
        </div>
      </a>
      <!-- } 배너 -->
    </div>
  </div>
</div>
<!-- } 띠 배너 2 -->

<!-- 상품 카테고리 바로가기 { -->
<div class="container section main_category">
  <div class="cp-quick-category">
    <?php
$cate_sql = "SELECT * FROM shop_category WHERE LENGTH(catecode) = 3 AND cateuse = 0 ORDER BY caterank asc";
$cate_res = sql_query($cate_sql);

while ($cate_row = sql_fetch_array($cate_res)) {
  // 회원특별관 예외 처리
  if($cate_row['catecode']== '006'){
    continue;
  }
  ?>
    <a href="<?php echo BV_MSHOP_URL . '/list.php?ca_id=' . $cate_row["catecode"]; ?>" class="ui-btn">
      <i class="icon">
        <img src="/data/category/<?php echo $cate_row['cateimg1'] ?>" alt="<?php echo $cate_row['catename'] ?>">
      </i>
      <p class="name"><?php echo $cate_row['catename'] ?></p>
    </a>
    <?php
}?>
  </div>
</div>
<!-- } 상품 카테고리 바로가기 -->

<!-- 관련 서비스 바로가기 { -->
<!-- <div class="container section main_service">
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
</div> -->
<!-- } 관련 서비스 바로가기 -->

<!-- 신상품 상품 { -->
<div class="section main_best bgColor2">
  <div class="container right cp-title">
    <div class="left">
      <div class="icon-box"></div>
      <div class="text-box">
        <h3>신상품</h3>
        <p class="tp-expl">이제 갓 나온 신선한 신상품이에요</p>
      </div>
    </div>
    <div class="right">
      <a href="<?php echo BV_MSHOP_URL; ?>/listtype.php?type=3&menu=new" class="ui-btn more">전체보기</a>
    </div>
  </div>
  <?php echo mobile_slide_goods('3', '20', 'container left main_best-slide'); ?>
</div>
<!-- } 신상품 상품 -->
<!-- 추천상품 { -->
<!-- <div class="section main_recomm">
  <div class="container right cp-title">
    <div class="left">
      <div class="icon-box"></div>
      <div class="text-box">
        <h3>추천상품</h3>
        <p class="tp-expl">주인장에서 추천하는 상품이에요!</p>
      </div>
    </div>
    <div class="right">
      <a href="<?php echo BV_MSHOP_URL; ?>/listtype.php?type=5" class="ui-btn more">전체보기</a>
    </div>
  </div>
  <?php echo mobile_slide_goods('5', '20', 'container left main_recomm-slide', 'small'); ?>
</div> -->
<!-- } 추천상품 -->

<!-- 인기상품 { -->
<!-- <div class="section main_popular">
  <div class="container right cp-title">
    <div class="left">
      <div class="icon-box"></div>
      <div class="text-box">
        <h3>인기상품</h3>
        <p class="tp-expl">주인장의 인기상품을 만나보세요!</p>
      </div>
    </div>
    <div class="right">
      <a href="<?php echo BV_MSHOP_URL; ?>/listtype.php?type=4" class="ui-btn more">전체보기</a>
    </div>
  </div>
  <?php echo mobile_slide_goods('4', '20', 'container left main_popular-slide', 'small'); ?>
</div>
} 인기상품 -->

<!-- 띠 배너 3 { -->
<div class="line-banner-section line-banner03">
  <div class="swiper-container">
    <div class="swiper-wrapper">
      <!-- 배너 { -->
      <a href="/m/bbs/board_read.php?index_no=9&boardid=13&page=1" class="swiper-slide banner-item">
        <div class="banner-img">
          <img src="/src/img/mainbanner3_service.jpg" alt="">
        </div>
      </a>
      <!-- } 배너 -->
    </div>
  </div>
</div>
<!-- } 띠 배너 3 -->

<!-- 띠 배너 4 { -->
<!-- <div class="line-banner-section line-banner04">
  <div class="swiper-container">
    <div class="swiper-wrapper">
      <a href="/m/shop/list.php?ca_id=006011" class="swiper-slide banner-item">
        <div class="banner-img">
          <img src="/src/img/mainbanner4_fan.jpg" alt="">
        </div>
      </a>
    </div>
  </div>
</div> -->
<!-- } 띠 배너 4 -->

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
        $weekDays = ['sun', 'mon', 'tues', 'wednes', 'thurs', 'fri', 'satur'];
        $currentDayIndex = date('w');
        $dateArr = [
            'mon' => '월', 'tues' => '화', 'wednes' => '수', 'thurs' => '목',
            'fri' => '금', 'satur' => '토', 'sun' => '일',
        ];

        if ($liveListSize > 0) {
            foreach ($liveListArr as $liveListVal) {
                $eventAct = '종료';
                $eventActClass = 'live-off';
                $current_time = new DateTime('now');
                $liveTime = '';
                $liveDate = '';
                $foundLiveData = false;

                $liveData = json_decode($liveListVal['live_time'], true);

                for ($i = 0; $i < 7; $i++) {
                    $checkDayIndex = ($currentDayIndex - $i + 7) % 7;
                    $checkDay = $weekDays[$checkDayIndex];

                    foreach ($liveData as $live) {
                        if ($live['live_date'] == $checkDay) {
                            $event_start_time = new DateTime($live['live_start_time']);
                            $event_end_time = new DateTime($live['live_end_time']);

                            if ($i == 0) {
                                if ($current_time >= $event_start_time && $current_time <= $event_end_time) {
                                    $eventAct = 'LIVE';
                                    $eventActClass = 'swiper-slide-active';
                                    $liveTime = $live['live_start_time'];
                                    $liveDate = $live['live_date'];
                                    $foundLiveData = true;
                                    break 2;
                                } else if ($current_time < $event_start_time) {
                                    $liveTime = $live['live_start_time'];
                                    $liveDate = $live['live_date'];
                                    $foundLiveData = true;
                                    break 2;
                                }
                            } else {
                                $liveTime = $live['live_end_time'];
                                $liveDate = $live['live_date'];
                                $foundLiveData = true;
                                break 2;
                            }
                        }
                    }
                }

                if (!$foundLiveData && !empty($liveData)) {
                    $first_live = reset($liveData);
                    $liveTime = $first_live['live_end_time'];
                    $liveDate = $first_live['live_date'];
                }

                $formattedLiveTime = liveTime($liveTime, $liveDate);
        ?>
                <a href="<?php echo $liveListVal['url'] ?>" class="swiper-slide cp-live <?php echo $eventActClass ?>" role="group" aria-label="<?php echo $liveListCount; ?> / <?php echo $liveListSize; ?>">
                    <div class="round50 prod-thumb_area">
                        <div href="" class="thumb">
                            <img src="<?php echo "/data/live/" . $liveListVal['thumbnail'] ?>" alt="">
                        </div>
                    </div>
                    <div class="prod-info_area">
                        <div class="round60 live-reserv">
                            <span class="round60 t1"><?php echo $eventAct;?></span>
                            <span class="t2"><?php echo $formattedLiveTime ?></span>
                        </div>
                        <div class="live-title"><?php echo $liveListVal['title'] ?></div>
                    </div>
                </a>
        <?php
                $liveListCount++;
            }
        }
        ?>

        <!-- 종료 추가 { -->
        <!-- <a href="" class="swiper-slide cp-live live-off">
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
        </a> -->
        <!-- } 종료 추가 -->
      </div>
      <?php if($liveListSize > 3) {?>
      <div class="swiper-control2">
        <button type="button" class="arrow prev swiper-button-disabled" disabled="" tabindex="-1" aria-label="Previous slide" aria-controls="swiper-wrapper-5adc34597a07ad06" aria-disabled="true"></button>
        <div class="pagination swiper-pagination-custom swiper-pagination-horizontal"><span class="current">1</span><span class="bar">|</span><span class="total">3</span></div>
        <button type="button" class="arrow next" tabindex="0" aria-label="Next slide" aria-controls="swiper-wrapper-5adc34597a07ad06" aria-disabled="false"></button>
      </div>
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
                        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                        var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                        // 숫자를 2자리 형식으로 맞추기
                        days = String(days).padStart(2, '0');
                        hours = String(hours).padStart(2, '0');
                        minutes = String(minutes).padStart(2, '0');
                        seconds = String(seconds).padStart(2, '0');

                        // 결과를 출력
                        timer.innerHTML = days + '일 ' + hours + ':' + minutes + ':' + seconds;
                    }
                }, 1000);
            });
        });
</script>