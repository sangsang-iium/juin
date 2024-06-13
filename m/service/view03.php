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
            <span class="cname">[신승HR]</span>
            <span class="subj">주인장 외식업 전문 노무법인</span>
          </p>
          <p class="ex">
            <span class="period">2023.02.15~2024.02.15</span>
          </p>
        </div>
        <button type="button" class="ui-btn share-btn"></button>
      </div>
      <div class="service-info__body">
        <div class="ht-cont">
          <div class="ht-wrap">
            <div class="ht-view">
              <!-- top title { -->
              <div class="ht-view-top">
                <p>주인장 외식업 전문 노무법인 신승HR</p>
              </div>
              <!-- } top title -->
              <div class="service-imgbox">
                <img src="/src/img/service/service-view03_01.jpg">
              </div>
              <!-- <div class="service-cont">
              </div> -->
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
  <div class="service-apply_area">
    <div class="dfBox">
      <div class="container">
        <div class="service-apply__btns">
          <a href="/m/service/apply03.php" class="ui-btn round stBlack apply-btn">신청 바로가기</a>
          <a href="/m/service/list.php?menu=service" class="ui-btn round stWhite goback-btn">목록</a>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- 팝업 1 { -->
<div id="ht-popup1" class="popup type02 add-popup">
  <div class="pop-inner">
    <div class="pop-top">
      <p class="tit">포인트적립 혜택</p>
      <button type="button" class="btn close"></button>
    </div>
    <div class="pop-content line">
      <div class="pop-content-in">
        <div class="service-imgbox">
          <img src="/src/img/service/service-view02_03.jpg">
        </div>
      </div>
    </div>
  </div>
</div>
<!-- } 팝업 1 -->

<!-- 팝업 2 { -->
<div id="ht-popup2" class="popup type02 add-popup">
  <div class="pop-inner">
    <div class="pop-top">
      <p class="tit">영화/테마파크 할인 혜택</p>
      <button type="button" class="btn close"></button>
    </div>
    <div class="pop-content line">
      <div class="pop-content-in">
        <div class="service-imgbox">
          <img src="/src/img/service/service-view02_04.jpg">
        </div>
      </div>
    </div>
  </div>
</div>
<!-- } 팝업 2 -->

<!-- 팝업 3 { -->
<div id="ht-popup3" class="popup type02 add-popup">
  <div class="pop-inner">
    <div class="pop-top">
      <p class="tit">금융 우대 혜택</p>
      <button type="button" class="btn close"></button>
    </div>
    <div class="pop-content line">
      <div class="pop-content-in">
        <div class="service-imgbox">
          <img src="/src/img/service/service-view02_05.jpg">
        </div>
      </div>
    </div>
  </div>
</div>
<!-- } 팝업 3 -->

<!-- 팝업 4 { -->
<div id="ht-popup4" class="popup type02 add-popup">
  <div class="pop-inner">
    <div class="pop-top">
      <p class="tit">금융 우대 혜택</p>
      <button type="button" class="btn close"></button>
    </div>
    <div class="pop-content line">
      <div class="pop-content-in">
        <div class="service-imgbox">
          <img src="/src/img/service/service-view02_06.jpg">
        </div>
      </div>
    </div>
  </div>
</div>
<!-- } 팝업 4 -->

<script type="module">
import * as f from '/src/js/function.js';
$(function() {
  // 팝업1
  const htPopId1 = "ht-popup1";
  $(".pop-btn1").on("click", function() {
    $(".popDim").show();
    f.popupOpen(htPopId1);
  });

  // 팝업2
  const htPopId2 = "ht-popup2";
  $(".pop-btn2").on("click", function() {
    $(".popDim").show();
    f.popupOpen(htPopId2);
  });

  // 팝업3
  const htPopId3 = "ht-popup3";
  $(".pop-btn3").on("click", function() {
    $(".popDim").show();
    f.popupOpen(htPopId3);
  });

  // 팝업4
  const htPopId4 = "ht-popup4";
  $(".pop-btn4").on("click", function() {
    $(".popDim").show();
    f.popupOpen(htPopId4);
  });
});
</script>

<?php
include_once(BV_MPATH."/_tail.php"); // 하단
?>