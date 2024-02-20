<?php
if(!defined('_BLUEVATION_')) exit; // 개별 페이지 접근 불가

$sql = " select * 
		   from shop_popup
		  where '".BV_TIME_YMD."' between begin_date and end_date
		    and device IN ( 'both', 'mobile' )
            and state = '0' 
			and mb_id = '$pt_id'
          order by index_no asc ";
$res = sql_query($sql, false);
$nwpop_count = sql_num_rows($res);
?>
<!-- 팝업레이어 시작 { -->
<?php if($nwpop_count > 0 && !$_COOKIE["nw-popup"]) { ?>
<div id="nw-popup" class="mpb-wrap main-popup active">
  <div class="mpb-img-wrap swiper-container">
    <div class="swiper-wrapper">
      <?php for($i=0; $nw=sql_fetch_array($res); $i++) { ?>
      <div id="nw_pops_<?php echo $nw['index_no']; ?>" class="swiper-slide item">
        <a href="" class="link">
          <?php echo conv_content($nw['memo'], 1); ?>
        </a>
      </div>
      <?php } ?>
    </div>
  </div>
  <div class="mpb-btn-wrap">
    <div class="container">
      <button type="button" class="hd_pops_reject onlytodayshow">오늘 하루 보지 않기</button>
      <button type="button" class="hd_pops_close mpb-close-btn">닫기</button>
    </div>
  </div>
</div>
<?php } ?>

<script>
$(function() {
  if($("#nw-popup").hasClass('active')) {
    $(".popDim").show();
  }

  $(".hd_pops_reject").click(function() {
    let id = $(this).attr('class').split(' ');
    let ck_name = "nw-popup";
    let exp_time = 24;
    let cookie_domain = '';

    $("#nw-popup").removeClass('active');
    $(".popDim").fadeOut(500);
    set_cookie(ck_name, 1, exp_time, cookie_domain);
    // console.log(ck_name, 1, exp_time, cookie_domain);
  });

  $('.hd_pops_close').click(function() {
      $("#nw-popup").removeClass('active');
      $(".popDim").fadeOut(500);
  });
});
</script>
<!-- } 팝업레이어 끝 -->
