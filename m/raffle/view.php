<?php
include_once("./_common.php");
include_once(BV_MPATH."/_head.php"); // 상단

$raffle = raffleDetail($index_no);
if(!$raffle) {
  goto_url('/m/raffle/list.php?menu=raffle');
}

$per = round(($raffle['raffle_price'] / $raffle['market_price']) * 100);

$raffleLimit = raffleEntryCheck($index_no,$raffle['entry'],$raffle['entry_number']);
$rafflePrizeCheck = rafflePrizeCheck($index_no);
$raffleEndCheck = raffleEventDateCheck($raffle['event_end_date'],$raffle['prize_date']);
?>

<div id="contents" class="sub-contents flView raffleView">
  <div class="fl-detailThumb">
    <div class="swiper-container">
      <div class="cp-timer">
        <div class="cp-timer-wrap white">
          <?php if($raffleEndCheck > 1) { ?>
            <span class="cp-timer__text">종료</span>
          <?php } else { ?>
            <i class="cp-timer__icon"></i>
            <span class="cp-timer__num" data-deadline="<?php echo $raffle['event_end_date'] ?>">00:00:00</span>
            <span class="cp-timer__text">남음</span>
          <?php } ?>
        </div>
      </div>
      <div class="swiper-wrapper">
        <div class="swiper-slide item">
          <a href="" class="link">
            <figure class="image">
              <?php echo get_raffle_detail_img($raffle['simg1']); ?>
            </figure>
          </a>
        </div>
        <div class="swiper-slide item">
          <a href="" class="link">
            <figure class="image">
              <?php echo get_raffle_detail_img($raffle['simg2']); ?>
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
        <p class="tRow2 name"><?php echo $raffle['goods_name'] ?></p>
        <p class="dc-price"><span class="spr"><?php echo number_format($raffle['market_price']) ?><span class="won">원</span></span></p>
        <p class="price-box">
          <span class="dc-percent"><?php echo $per; ?>%</span>
          <span class="sale-price">
            <span class="mpr"><?php echo number_format($raffle['raffle_price']) ?>
              <span>원</span>
            </span>
          </span>
        </p>
        <div class="prod-tag_area mt">
          <div class="tag users">
            <i data-feather="users" class="icn"></i>
            <span class="txt"><?php echo number_format(raffleWinnerNumber($raffle['index_no'])) ?>명 참여</span>
          </div>
        </div>
      </div>
    </div>

    <div class="bottomBlank container prod-smInfo__body">
      <div class="info-list">
        <div class="info-item">
          <p class="tit">응모기간</p>
          <p class="cont"><?php echo ymdhisToYmd($raffle['event_start_date']) ?> ~ <?php echo ymdhisToYmd($raffle['event_end_date']) ?></p>
        </div>
        <div class="info-item">
          <p class="tit">당첨발표</p>
          <p class="cont"><?php echo ymdhisToYmd($raffle['prize_date']) ?></p>
        </div>
        <div class="info-item">
          <p class="tit">당첨자 수</p>
          <p class="cont"><?php echo number_format($raffle['winner_number']) ?>명</p>
        </div>
        <?php if($raffle['entry'] == 0) { ?>
        <div class="info-item">
          <p class="tit">응모 제한</p>
          <p class="cont"><?php echo number_format($raffle['entry_number']) ?>명</p>
        </div>
        <?php } ?>
        <div class="info-item">
          <p class="tit">구매기간</p>
          <p class="cont"><?php echo ymdhisToYmd($raffle['prize_start_date']) ?> ~ <?php echo ymdhisToYmd($raffle['prize_end_date']) ?></p>
        </div>
        <div class="info-item">
          <p class="tit">안내사항</p>
          <p class="cont"><?php echo nl2br($raffle['infomation']) ?></p>
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
                    <?php 
                    echo get_raffle_detail_img($raffle['simg3']);
                    if($raffle['simg4']){
                      echo get_raffle_detail_img($raffle['simg4']);
                    }
                    if($raffle['simg5']){
                      echo get_raffle_detail_img($raffle['simg5']);
                    }
                    ?>
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
        <?php echo nl2br($raffle['memo']) ?>
      </div>
    </div>
  </div>
  


  <div class="prod-buy_area">
    <div class="dfBox">
      <div class="container">
        <div class="prod-buy__btns">
          <?php if(!$rafflePrizeCheck) { ?>
            <button class="ui-btn round stBlack raffle-btn disabled">응모완료</button>
          <?php } else { ?>
            <?php if($raffleEndCheck > 1) { ?>
              <button class="ui-btn round stBlack raffle-btn disabled">응모 종료</button>
            <?php } else { ?>
              <button class="ui-btn round stBlack raffle-btn raffle-submit-btn active">응모하기</button>
            <?php } ?>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>
</div>

<?php
// SNS
$sns_title = get_text($gs['gname']).' | '.get_head_title('head_title', $pt_id);
$sns_url = BV_SHOP_URL.'/view.php?index_no='.$index_no;
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

<script>
  $('.raffle-submit-btn').on('click', function() {
    <?php if(!$member['id']) { ?>
      alert('로그인 이후 응모 가능합니다.');
      location.href="/m/bbs/login.php";
    <?php } else {
      if($raffleLimit) { ?>
      var indexno = '<?php echo $index_no ?>'
        $.ajax({
          type: "POST",
          url: "/m/raffle/raffle.ajax.php",
          data : {index_no:indexno},
          dataType: "json",
          success: function(data) {
            if(data.res == 'Y') {
              alert('응모 완료되었습니다.');
              location.reload();
            } else {
              alert('이미 응모 하셨습니다.');
              location.reload()
            }
          }
        });
      <?php } else { ?>
      alert('더이상 응모할 수 없습니다.')
      <?php }
    } ?>
  })
</script>


<?php
include_once(BV_MPATH."/_tail.php"); // 하단
?>