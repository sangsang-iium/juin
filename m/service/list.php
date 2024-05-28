<?php
include_once("./_common.php");
include_once(BV_MPATH."/_head.php"); // 상단
include_once(BV_PATH.'/include/topMenu.php');
?>

<div id="contents" class="sub-contents serviceList">
  <div class="container service-item_list">
    <!-- 자료 없을때
    <p class="empty_list">자료가 없습니다.</p>
    -->
    <!-- loop { -->
    <a href="./view.php" class="service-item">
      <div class="cp-banner__round thumb">
        <img src="/src/img/service/t-service_thumb1.png" alt="주인장 제휴카드" class="fitCover">
      </div>
      <div class="service-info">
        <p class="tRow2 title">
          <span class="cname">[제휴업체명]</span>
          <span class="subj">주인장 제휴카드 신청접수</span>
        </p>
        <p class="ex">
          <span class="period">2024.01.01~2024.12.31</span>
        </p>
      </div>
    </a>
    <!-- } loop -->

    <a href="./view.php" class="service-item">
      <div class="cp-banner__round thumb">
        <img src="/src/img/service/t-service_thumb2.png" alt="주인장 제휴보험" class="fitCover">
      </div>
      <div class="service-info">
        <p class="tRow2 title">
          <span class="cname">[제휴업체명]</span>
          <span class="subj">주인장 제휴보험 신청접수</span>
        </p>
        <p class="ex">
          <span class="period">2024.01.01~2024.12.31</span>
        </p>
      </div>
    </a>
  </div>
</div>

<?php
include_once(BV_MPATH."/_tail.php"); // 하단
?>