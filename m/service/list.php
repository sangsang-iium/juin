<?php
include_once("./_common.php");
include_once(BV_MPATH."/_head.php"); // 상단
//include_once(BV_PATH.'/include/topMenu.php');
?>

<div id="contents" class="sub-contents serviceList">
  <div class="container service-item_list">
    <!-- 자료 없을때
    <p class="empty_list">자료가 없습니다.</p>
    -->
    <!-- loop { -->
    <a href="./view01.php" class="service-item">
      <div class="cp-banner__round thumb">
        <img src="/src/img/service/t-service_thumb1.png" alt="주인장 제휴카드 신청접수" class="fitCover">
      </div>
      <div class="service-info">
        <p class="tRow2 title">
          <span class="cname">[신한은행]</span>
          <span class="subj">주인장 제휴카드 신청접수</span>
        </p>
        <p class="ex">
          <span class="period">2024.01.01~2024.01.31</span>
        </p>
      </div>
    </a>
    <!-- } loop -->

    <!-- loop { -->
    <a href="./view02.php" class="service-item">
      <div class="cp-banner__round thumb">
        <img src="/src/img/service/t-service_thumb2.png" alt="주인장 hi-point 신한 제휴카드" class="fitCover">
      </div>
      <div class="service-info">
        <p class="tRow2 title">
          <span class="cname">[신한은행]</span>
          <span class="subj">주인장 Hi-Point 신한 제휴카드</span>
        </p>
        <p class="ex">
          <span class="period">2024.01.01~2024.12.31</span>
        </p>
      </div>
    </a>
    <!-- } loop -->

    <!-- loop { -->
    <a href="./view03.php" class="service-item">
      <div class="cp-banner__round thumb">
        <img src="/src/img/service/t-service_thumb3.png" alt="주인장 외식업 전문 노무법인" class="fitCover">
      </div>
      <div class="service-info">
        <p class="tRow2 title">
          <span class="cname">[신승HR]</span>
          <span class="subj">주인장 외식업 전문 노무법인</span>
        </p>
        <p class="ex">
          <span class="period">2024.01.01~2024.12.31</span>
        </p>
      </div>
    </a>
    <!-- } loop -->

    <!-- loop { -->
    <a href="./view04.php" class="service-item">
      <div class="cp-banner__round thumb">
        <img src="/src/img/service/t-service_thumb4.png" alt="주인장 한국외식업 장례서비스" class="fitCover">
      </div>
      <div class="service-info">
        <p class="tRow2 title">
          <span class="cname">[신승HR]</span>
          <span class="subj">주인장 한국외식업 장례서비스</span>
        </p>
        <p class="ex">
          <span class="period">2024.01.01~2024.12.31</span>
        </p>
      </div>
    </a>
    <!-- } loop -->
      
  </div>
</div>

<?php
include_once(BV_MPATH."/_tail.php"); // 하단
?>