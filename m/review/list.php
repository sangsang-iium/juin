<?php
include_once("./_common.php");
include_once(BV_MPATH."/_head.php"); // 상단
?>

<div id="contents" class="sub-contents">
  <div class="review-wrap">

    <ul class="review-list">
      <li>
        <a href="javascript:void(0);" class="review-img rv-popup-open" data-popupId="rv-popup">
          <img src="/data/review/jdZw9tdKnJWlPD7ymr1GkmjtzV56qL.jpg" alt="">
        </a>
      </li>
      <li>
        <a href="javascript:void(0);" class="review-img rv-popup-open" data-popupId="rv-popup">
          <img src="/data/review/wU5g8JAZGkcqrAskgcZc8eMFKkWqnx.jpg" alt="">
        </a>
      </li>
      <li>
        <a href="javascript:void(0);" class="review-img rv-popup-open" data-popupId="rv-popup">
          <img src="/data/review/jdZw9tdKnJWlPD7ymr1GkmjtzV56qL.jpg" alt="">
        </a>
      </li>
      <li>
        <a href="javascript:void(0);" class="review-img rv-popup-open" data-popupId="rv-popup">
          <img src="/data/review/wU5g8JAZGkcqrAskgcZc8eMFKkWqnx.jpg" alt="">
        </a>
      </li>
      <li>
        <a href="javascript:void(0);" class="review-img rv-popup-open" data-popupId="rv-popup">
          <img src="/data/review/jdZw9tdKnJWlPD7ymr1GkmjtzV56qL.jpg" alt="">
        </a>
      </li>
      <li>
        <a href="javascript:void(0);" class="review-img rv-popup-open" data-popupId="rv-popup">
          <img src="/data/review/wU5g8JAZGkcqrAskgcZc8eMFKkWqnx.jpg" alt="">
        </a>
      </li>
      <li>
        <a href="javascript:void(0);" class="review-img rv-popup-open" data-popupId="rv-popup">
          <img src="/data/review/jdZw9tdKnJWlPD7ymr1GkmjtzV56qL.jpg" alt="">
        </a>
      </li>
      <li>
        <a href="javascript:void(0);" class="review-img rv-popup-open" data-popupId="rv-popup">
          <img src="https://juinjang.kr/data/goods/1708931276/thumb-6YEtuSQMZhrR5U1CAP3dJS34t8Ds64_400x400.jpg" alt="양조간장" class="fitCover">
        </a>
      </li>
      <li>
        <a href="javascript:void(0);" class="review-img rv-popup-open" data-popupId="rv-popup">
          <img src="/data/review/wU5g8JAZGkcqrAskgcZc8eMFKkWqnx.jpg" alt="">
        </a>
      </li>
      <li>
        <a href="javascript:void(0);" class="review-img rv-popup-open" data-popupId="rv-popup">
          <img src="/data/review/jdZw9tdKnJWlPD7ymr1GkmjtzV56qL.jpg" alt="">
        </a>
      </li>
      <li>
        <a href="javascript:void(0);" class="review-img rv-popup-open" data-popupId="rv-popup">
          <img src="https://juinjang.kr/data/goods/1708931276/thumb-6YEtuSQMZhrR5U1CAP3dJS34t8Ds64_400x400.jpg" alt="양조간장" class="fitCover">
        </a>
      </li>
      <li>
        <a href="javascript:void(0);" class="review-img rv-popup-open" data-popupId="rv-popup">
          <img src="/data/review/wU5g8JAZGkcqrAskgcZc8eMFKkWqnx.jpg" alt="">
        </a>
      </li>
      <li>
        <a href="javascript:void(0);" class="review-img rv-popup-open" data-popupId="rv-popup">
          <img src="/data/review/jdZw9tdKnJWlPD7ymr1GkmjtzV56qL.jpg" alt="">
        </a>
      </li>
      <li>
        <a href="javascript:void(0);" class="review-img rv-popup-open" data-popupId="rv-popup">
          <img src="https://juinjang.kr/data/goods/1708931276/thumb-6YEtuSQMZhrR5U1CAP3dJS34t8Ds64_400x400.jpg" alt="양조간장" class="fitCover">
        </a>
      </li>
      <li>
        <a href="javascript:void(0);" class="review-img rv-popup-open" data-popupId="rv-popup">
          <img src="/data/review/wU5g8JAZGkcqrAskgcZc8eMFKkWqnx.jpg" alt="">
        </a>
      </li>
      <li>
        <a href="javascript:void(0);" class="review-img rv-popup-open" data-popupId="rv-popup">
          <img src="/data/review/jdZw9tdKnJWlPD7ymr1GkmjtzV56qL.jpg" alt="">
        </a>
      </li>
      <li>
        <a href="javascript:void(0);" class="review-img rv-popup-open" data-popupId="rv-popup">
          <img src="https://juinjang.kr/data/goods/1708931276/thumb-6YEtuSQMZhrR5U1CAP3dJS34t8Ds64_400x400.jpg" alt="양조간장" class="fitCover">
        </a>
      </li>
    </ul>

  </div>
</div>

<!-- 리뷰 팝업 { -->
<div id="rv-popup" class="popup type02 add-popup">
  <div class="pop-inner">
    <div class="pop-top">
      <p class="tit">이미지 상세보기</p>
      <button type="button" class="btn close"></button>
    </div>
    <div class="pop-content line">
      <div class="pop-content-in">
        <div class="rv-pop-img-box">
          <img src="/data/review/jdZw9tdKnJWlPD7ymr1GkmjtzV56qL.jpg" alt="">
        </div>
      </div>
    </div>
  </div>
</div>
<!-- } 리뷰 팝업 -->

<script>

  $(document).ready(function () {
    const popDim = $(".popDim");

    // Popup Open
    const rvPopOpenBtn = $('.rv-popup-open');
    rvPopOpenBtn.on('click', function(){
      const openPopup = $(this).attr('data-popupId');
      const popImgSrc = $(this).find('img').attr('src');
      popDim.fadeIn(200);
      $('#' + openPopup).fadeIn(200).addClass("on");
      $('.rv-pop-img-box').find('img').attr('src',popImgSrc);
    });
  });
</script>

<?php
//include_once(BV_MPATH."/_tail.php"); // 하단
?>