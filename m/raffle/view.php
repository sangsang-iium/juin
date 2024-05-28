<?php
include_once("./_common.php");
include_once(BV_MPATH."/_head.php"); // 상단
?>

<div id="contents" class="sub-contents flView raffleView">
  <div class="fl-detailThumb">
    <div class="swiper-container">
      <div class="cp-timer">
        <div class="cp-timer-wrap white">
          <i class="cp-timer__icon"></i>
          <span class="cp-timer__num" data-deadline="2024-06-30 23:59:59">00:00:00</span>
          <span class="cp-timer__text">남음</span>
        </div>
      </div>
      <div class="swiper-wrapper">
        <div class="swiper-slide item">
          <a href="" class="link">
            <figure class="image">
              <img src="/src/img/t-raffle-img.jpg" class="fitCover" alt="노르웨이 연어 2kg">
            </figure>
          </a>
        </div>
        <div class="swiper-slide item">
          <a href="" class="link">
            <figure class="image">
              <img src="/src/img/t-raffle-img.jpg" class="fitCover" alt="노르웨이 연어 2kg">
            </figure>
          </a>
        </div>
      </div>
      <div class="round swiper-control">
        <div class="pagination"></div>
      </div>
    </div>
  </div>

  <div class="prod-smInfo">
    <div class="bottomBlank container prod-smInfo__head">
      <div class="prod-tag_area">
        <span class="tag freeDelivery">무료배송</span>
      </div>
      <button type="button" class="ui-btn share-btn"></button>
      <div class="prod-info_area">
        <p class="tRow2 name">노르웨이 연어 2kg</p>
        <p class="dc-price"><span class="spr">50,000<span class="won">원</span></span></p>
        <p class="price-box">
          <span class="dc-percent">20%</span>
          <span class="sale-price">
            <span class="mpr">40,000
              <span>원</span>
            </span>
          </span>
        </p>
        <div class="prod-tag_area mt">
          <div class="tag users">
            <i data-feather="users" class="icn"></i>
            <span class="txt">297명 참여</span>
          </div>
        </div>
      </div>
    </div>

    <div class="bottomBlank container prod-smInfo__body">
      <div class="info-list">
        <div class="info-item">
          <p class="tit">응모기간</p>
          <p class="cont">2024-01-01 ~ 2024-12-31</p>
        </div>
        <div class="info-item">
          <p class="tit">당첨발표</p>
          <p class="cont">2025-01-01</p>
        </div>
        <div class="info-item">
          <p class="tit">당첨자 수</p>
          <p class="cont">1,000명</p>
        </div>
        <div class="info-item">
          <p class="tit">응모 제한</p>
          <p class="cont">1,0000명</p>
        </div>
        <div class="info-item">
          <p class="tit">구매기간</p>
          <p class="cont">2025-01-02 ~ 2025-01-07</p>
        </div>
        <div class="info-item">
          <p class="tit">안내사항</p>
          <p class="cont">안내사항입니다. 안내사항입니다.</p>
        </div>
      </div>
    </div>

    <div class="prod-detailInfo">
      <div id="prod-detailTab__info" class="bottomBlank prod-detailTabWrap">
        <div class="container prod-detailInfo__head">
          <div class="cp-tab-menu">
            <div class="inner">
              <button type="button" id="d1" class="ui-btn tab-btn on" onclick="chk_tab('#prod-detailTab__info');">상품정보</button>
            </div>
          </div>
        </div>
        <div class="container prod-detailInfo__body">
          <div class="dtinfo-box">
            <div class="dtinfo-inner">
              <div class="ht-cont">
                <div class="ht-wrap">
                  <div class="ht-view prod-memo">
                    <img src="http://juin.eumsvr.com/data/editor/2402/e90eeb7acdd42fa6a913b215b9105162_1708402246_8415.jpg" title="e90eeb7acdd42fa6a913b215b9105162_1708402246_8415.jpg" alt="e90eeb7acdd42fa6a913b215b9105162_1708402246_8415.jpg">
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
      </div>
    </div>

    <div class="container fl-explan2">
      <p class="t1">유의사항</p>
      <div class="t2">
        유의사항 영역입니다. 유의사항 영역입니다.<br/>
        유의사항 영역입니다. 유의사항 영역입니다.<br/>
        유의사항 영역입니다. 
      </div>
    </div>
  </div>
  


  <div class="prod-buy_area">
    <div class="dfBox">
      <div class="container">
        <div class="prod-buy__btns">
          <button href="" class="ui-btn round stBlack raffle-submit-btn">응모하기</button>
        </div>
      </div>
    </div>
  </div>
</div>

<?php
// SNS
$sns_title = get_text($gs['gname']).' | '.get_head_title('head_title', $pt_id);
$sns_url = BV_SHOP_URL.'/view.php?index_no='.$gs_id;
$sns_share_links .= '<li><a href="javascript:void(0);" data-url="'.$sns_url.'" class="copyLink-btn"><img src="/src/img/share_linkcopy.png" alt="Copy Link"><span class="txt">링크 복사하기</span></a></li>';
if($default['de_kakao_js_apikey']) {
  $sns_share_links .= "<li>".get_sns_share_link('kakaotalk', $sns_url, $sns_title, '/src/img/share_kakaotalk.png')."</li>";
}
$sns_share_links .= "<li>".get_sns_share_link('naver', $sns_url, $sns_title, '/src/img/share_naverblog.png')."</li>";
$sns_share_links .= "<li>".get_sns_share_link('kakaostory', $sns_url, $sns_title, '/src/img/share_kakaostory.png')."</li>";
$sns_share_links .= "<li>".get_sns_share_link('naverband', $sns_url, $sns_title, '/src/img/share_naverband.png')."</li>";
$sns_share_links .= "<li>".get_sns_share_link('facebook', $sns_url, $sns_title, '/src/img/share_facebook.png')."</li>";
$sns_share_links .= "<li>".get_sns_share_link('twitter', $sns_url, $sns_title, '/src/img/share_twitter.png')."</li>";
$sns_share_links .= "<li>".get_sns_share_link('pinterest', $sns_url, $sns_title, '/src/img/share_pinterest.png')."</li>";
?>

<div id="prodShare" class="popup type02">
  <div class="pop-inner">
    <div class="pop-top">
      <span class="tit">공유하기</span>
      <button type="button" class="btn close"></button>
    </div>
    <div class="pop-content line">
      <div class="ct">
        <ul class="way">
          <?php echo $sns_share_links; ?>
        </ul>
      </div>
    </div>
  </div>
</div>

<?php
include_once(BV_MPATH."/_tail.php"); // 하단
?>