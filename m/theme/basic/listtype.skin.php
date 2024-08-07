<?php
if(!defined("_BLUEVATION_")) exit; // 개별 페이지 접근 불가

$qstr1 = 'type='.$type.'&sort='.$sort.'&sortodr='.$sortodr;
$qstr2 = 'type='.$type;

$sort_str = '';
for($i=0; $i<count($gw_msort); $i++) {
	list($tsort, $torder, $tname) = $gw_msort[$i];

	$sct_sort_href = $_SERVER['SCRIPT_NAME'].'?'.$qstr2.'&sort='.$tsort.'&sortodr='.$torder;

	if($sort == $tsort && $sortodr == $torder)
		$sort_name = $tname;
	if($i==0 && !($sort && $sortodr))
		$sort_name = '상품 정렬';

	$sort_str .= '<li><a href="'.$sct_sort_href.'">'.$tname.'</a></li>'.PHP_EOL;
}
?>

<div id="contents" class="sub-contents prodList">
  <?php //if($category_visual_slider = mobile_slider($type, $pt_id)) { ?>
  <?php if($category_visual_slider = mobile_slider(2, $pt_id)) { ?>
  <!-- 상단 롤링 배너 { -->
  <div class="container section prod-topBanner">
    <div class="cp-banner__round swiper-container">
      <div class="swiper-wrapper">
        <?php echo $category_visual_slider; ?>
      </div>
      <div class="round swiper-control">
        <div class="pagination"></div>
        <button type="button" class="ui-btn playToggle" title="일시정지"></button>
      </div>
    </div>
  </div>
  <!-- } 상단 롤링 배너 -->
  <?php } ?>

  <div class="prod-dp">
    <div class="prod-dp-wrap">
      <div class="container cp-title prod-dp__title">
        <div class="left">
          <div class="text-box">
            <h3><?php echo $tb['title']; ?></h3>
          </div>
        </div>

        <?php if($type==1){ ?>
        <div class="right">
          <div class="cp-timer">
            <div class="cp-timer-wrap">
              <i class="cp-timer__icon"></i>
              <span class="cp-timer__text">D-Day</span>
               <?php $deadline = date('Y-m-d', strtotime('+6 days')); ?>
              <span class="cp-timer__num" data-deadline="<?php echo $deadline?> 23:59:59">00:00:00</span>
              <span class="cp-timer__text">남음</span>
            </div>
          </div>
        </div>
        <?php } ?>
      </div>

      <div class="container dp-top">
        <div class="txt-board-cnt">총 <span class="cnt"><?php echo number_format($total_count); ?></span>건</div>
        <div class="cp-sort">
          <span class="cp-sort__btn"><?php echo $sort_name; ?></span>
        </div>
      </div>

      <div class="container prod-dp-ct">
        <?php
        if(!$total_count) {
          echo "<p class=\"empty_list\">자료가 없습니다.</p>";
        } else {
          // 기본배송지 추가 _20240712_SY
          $b_address = "";
          $ad_row = getBaddressFun();
          
          for($i=0; $row=sql_fetch_array($result); $i++) {
            if(isset($ad_row['mb_id'])){
              $b_address = $ad_row['b_addr1'];
            } else {
              $b_address = $member['addr1'];
            }

            if(!memberGoodsAble($b_address, $row['zone'])){
              continue;
            }
            $it_href = BV_MSHOP_URL.'/view.php?gs_id='.$row['index_no'];
            $it_name = cut_str($row['gname'], 50);
            $it_imageurl = get_it_image_url($row['index_no'], $row['simg1'], 400, 400);
            $it_price = mobile_price($row['index_no']);
            $it_amount = get_sale_price($row['index_no']);
            $it_point = display_point($row['gpoint']);

            $is_uncase = is_uncase($row['index_no']);
            $is_free_baesong = is_free_baesong($row);
            $is_free_baesong2 = is_free_baesong2($row);

            // (시중가 - 할인판매가) / 시중가 X 100 = 할인률%
            // 20240625 jjh 원래대로 돌려여ㅑ함
            $it_sprice = $sale = '';
            if($type==1){
              if($is_member){
                if ($row['normal_price'] > $it_amount && !$is_uncase) {
                  $sett      = ($row['normal_price'] - $it_amount) / $row['normal_price'] * 100;
                  $sale      = number_format($sett, 0) . '%';
                  $it_sprice = display_price2($row['normal_price']);
                }
              }
            } else {
              if($row['normal_price'] > $it_amount && !$is_uncase) {
                $sett = ($row['normal_price'] - $it_amount) / $row['normal_price'] * 100;
                $sale = number_format($sett,0).'%';
                $it_sprice = display_price2($row['normal_price']);
              }
            }
            item_card($row['index_no'], $it_href, $it_imageurl, $it_name, $it_sprice, $sale, $it_price, 'small');
          }
        }
        echo get_paging($config['mobile_pages'], $page, $total_page, $_SERVER['SCRIPT_NAME'] . '?' . $qstr1 . '&page=');

        ?>
      </div>
    </div>
  </div>
</div>

<!-- <div class="pop-bottom cp-sort__list">
  <div class="top">
    <span class="tit">상품 정렬</span>
    <button type="button" class="ui-btn close-btn"></button>
  </div>
  <div class="ct">
    <ul class="cp-sort-ct">
      <?php //echo $sort_str; // 탭메뉴 ?>
    </ul>
  </div>
</div> -->

<div id="cp-sort__list" class="popup type02">
  <div class="pop-inner">
    <div class="pop-top">
      <span class="tit">상품 정렬</span>
      <button type="button" class="btn close"></button>
    </div>
    <div class="pop-content line">
      <div class="ct">
        <ul class="cp-sort-ct">
          <?php echo $sort_str; // 탭메뉴 ?>
        </ul>
      </div>
    </div>
  </div>
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