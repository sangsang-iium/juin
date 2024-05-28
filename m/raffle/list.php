<?php
include_once("./_common.php");
include_once(BV_MPATH."/_head.php"); // 상단
include_once(BV_PATH.'/include/topMenu.php');
?>

<div id="contents" class="sub-contents raffleList">
  <div class="container raffle-tab_box">
    <div class="cp-tab-menu">
      <ul class="inner">
        <li>
          <button type="button" class="ui-btn tab-btn on">진행중 응모</button>
        </li>
        <li>
          <button type="button" class="ui-btn tab-btn">종료된 응모</button>
        </li>
      </ul>
    </div>
  </div>

  <div class="prod-dp">
    <div class="prod-dp-wrap">
      <div class="container cp-title prod-dp__title">
        <div class="left">
          <div class="text-box">
            <h3>래플응모</h3>
          </div>
        </div>
      </div>

      <div class="container raffle-prod_list">
        <!-- 자료 없을때
        <p class="empty_list">자료가 없습니다.</p>
        -->
        <!-- loop { -->
        <div class="cp-item raffle">
          <div class="round50 prod-thumb_area">
            <a href="./view.php" class="thumb">
              <img src="/src/img/t-raffle-img.jpg" alt="">
            </a>
            <div class="cp-timer">
              <div class="cp-timer-wrap white">
                <i class="cp-timer__icon"></i>
                <span class="cp-timer__num" data-deadline="2024-06-30 23:59:59">00:00:00</span>
                <span class="cp-timer__text">남음</span>
              </div>
            </div>
          </div>
          <a href="./view.php" class="prod-info_area">
            <p class="tRow2 name">노르웨이 연어 2kg</p>
            <p class="dc-price">50,000원</p>
            <p class="price-box">
              <span class="dc-percent">20%</span>
              <span class="sale-price">40,000원</span>
            </p>
          </a>
          <div class="prod-tag_area">
            <div class="tag users">
              <i data-feather="users" class="icn"></i>
              <span class="txt">297명 참여</span>
            </div>
          </div>
        </div>
        <!-- } loop -->
        <div class="cp-item raffle">
          <div class="round50 prod-thumb_area">
            <a href="./view.php" class="thumb">
              <img src="/src/img/t-raffle-img.jpg" alt="">
            </a>
            <div class="cp-timer">
              <div class="cp-timer-wrap white">
                <i class="cp-timer__icon"></i>
                <span class="cp-timer__num" data-deadline="2024-06-30 23:59:59">00:00:00</span>
                <span class="cp-timer__text">남음</span>
              </div>
            </div>
          </div>
          <a href="./view.php" class="prod-info_area">
            <p class="tRow2 name">노르웨이 연어 2kg</p>
            <p class="dc-price">50,000원</p>
            <p class="price-box">
              <span class="dc-percent">20%</span>
              <span class="sale-price">40,000원</span>
            </p>
          </a>
          <div class="prod-tag_area">
            <div class="tag users">
              <i data-feather="users" class="icn"></i>
              <span class="txt">297명 참여</span>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>

<?php
include_once(BV_MPATH."/_tail.php"); // 하단
?>