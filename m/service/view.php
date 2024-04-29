<?php
include_once("./_common.php");
include_once(BV_MPATH."/_head.php"); // 상단
?>

<div id="contents" class="sub-contents serviceView">
  <div class="service-info">
    <div class="container">
      <div class="service-info__head">
        <div class="service-info">
          <p class="tRow2 title">
            <span class="cname">[제휴업체명]</span>
            <span class="subj">주인장 제휴카드 신청접수</span>
          </p>
          <p class="ex">
            <span class="period">2024.01.01~2024.12.31</span>
          </p>
        </div>
        <button type="button" class="ui-btn share-btn"></button>
      </div>
      <div class="service-info__body">
        <div class="ht-cont">
          <div class="ht-wrap">
            <div class="ht-view">
              <div class="service-imgbox">
                <img src="/src/img/service/t-service_detail.png">
              </div>
              <div class="service-cont">
                내용입니다.
              </div>
            </div>
          </div>
          <button type="button" class="ui-btn round stWhite more-btn" data="stIconRight">
            <span class="txt">더보기</span>
            <i class="icn"></i>
          </button>
        </div>
      </div>
    </div>
  </div>
  <div class="prod-buy_area">
    <div class="dfBox">
      <div class="container">
        <div class="prod-buy__btns">
          <a href="" class="ui-btn round stBlack apply-btn">신청하기</a>
        </div>
      </div>
    </div>
  </div>
</div>

<?php
include_once(BV_MPATH."/_tail.php"); // 하단
?>