<?php
if(!defined('_BLUEVATION_')) exit;

$qstr1 = 'page_rows='.$page_rows.'&sort='.$sort.'&sortodr='.$sortodr;
$qstr2 = 'page_rows='.$page_rows;

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

<!--
<script language="javascript">
function CountDownTimer(dt, id)
{
	var end = new Date(dt);

	var _second = 1000;
	var _minute = _second * 60;
	var _hour = _minute * 60;
	var _day = _hour * 24;
	var timer;

	function showRemaining() {
		var now = new Date();
		var distance = end - now;
		if (distance < 0) {
			clearInterval(timer);
			document.getElementById(id).innerHTML = 'EXPIRED!';
			return;
		}
		var days = Math.floor(distance / _day);
		var hours = Math.floor((distance % _day) / _hour);
		var minutes = Math.floor((distance % _hour) / _minute);
		var seconds = Math.floor((distance % _minute) / _second);
		var str = "";
		str += '<span class="num">'+days + '</span> 일 ';
		str += '<span class="num marl5">'+pad(hours,2) + '</span> : ';
		str += '<span class="num">'+pad(minutes,2) + '</span> : ';
		str += '<span class="num">'+pad(seconds,2) + '</span>';
		document.getElementById(id).innerHTML = str;
	}

	timer = setInterval(showRemaining, 1000);
}

function pad(n, width) {
  n = n + '';
  return n.length >= width ? n : new Array(width - n.length + 1).join('0') + n;
}
</script>
-->

<div id="contents" class="sub-contents prodList todaySaleList">
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
        <div class="right">
          <div class="cp-timer">
            <div class="cp-timer-wrap">
              <i class="cp-timer__icon"></i>
              <span class="cp-timer__num" data-deadline="<?php echo date("Y-m-d");?> 23:59:59">00:00:00</span>
              <span class="cp-timer__text">남음</span>
            </div>
          </div>
        </div>
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
          for($i=0; $row=sql_fetch_array($result); $i++) {
            $it_href = BV_MSHOP_URL.'/view.php?gs_id='.$row['index_no'];
            $it_name = cut_str($row['gname'], 50);
            $it_imageurl = get_it_image_url($row['index_no'], $row['simg2'], 400, 400);
            $it_price = mobile_price($row['index_no']);
            $it_amount = get_sale_price($row['index_no']);
            $it_point = display_point($row['gpoint']);

            $is_uncase = is_uncase($row['index_no']);
            $is_free_baesong = is_free_baesong($row);
            $is_free_baesong2 = is_free_baesong2($row);

            // (시중가 - 할인판매가) / 시중가 X 100 = 할인률%
            $it_sprice = $sale = '';
            if($row['normal_price'] > $it_amount && !$is_uncase) {
              $sett = ($row['normal_price'] - $it_amount) / $row['normal_price'] * 100;
              $sale = '<span class="sale">['.number_format($sett,0).'%]</span>';
              $it_sprice = display_price2($row['normal_price']);
            }

            // $eb_date = date("Y-m-d",strtotime("+1 day", strtotime($row['eb_date'])));
            // $yy = substr($eb_date, 0, 4);
            // $mm = substr($eb_date, 5, 2);
            // $dd = substr($eb_date, 8, 2);

            $eb_date = date("Y-m-d");

            item_card($row['index_no'], $it_href, $it_imageurl, $it_name, $it_sprice, $sale, $it_price, 'small', $eb_date);
          ?>
            <!--
            <li>
              <a href="<?php echo $it_href; ?>">
              <dl>
                <dt><img src="<?php echo $it_imageurl; ?>"></dt>
                <dd class="ptime"><span id="countdown_<?php echo $i; ?>"></span></dd>
                <dd class="pname"><?php echo $it_name; ?></dd>
                <dd class="price"><?php echo $it_sprice; ?><?php echo $it_price; ?></dd>
                        <?php if( !$is_uncase && ($row['gpoint'] || $is_free_baesong || $is_free_baesong2) ) { ?>
                <dd class="petc">
                            <?php if($row['gpoint']) { ?>
                  <span class="fbx_small fbx_bg6"><?php echo $it_point; ?> 적립</span>
                            <?php } ?>
                            <?php if($is_free_baesong) { ?>
                  <span class="fbx_small fbx_bg4">무료배송</span>
                            <?php } ?>
                            <?php if($is_free_baesong2) { ?>
                  <span class="fbx_small fbx_bg4">조건부무료배송</span>
                            <?php } ?>
                        </dd>
                <?php } ?>
              </dl>
              </a>
              <span onclick="javascript:itemlistwish('<?php echo $row['index_no']; ?>')" id="<?php echo $row['index_no']; ?>" class="<?php echo $row['index_no']; ?> <?php echo zzimCheck($row['index_no']); ?>"></span>
              <script language="javascript">
              CountDownTimer("<?php echo $mm; ?>/<?php echo $dd; ?>/<?php echo $yy; ?> 00:00 AM", "countdown_<?php echo $i; ?>");
              </script>
            </li>
            -->
          <?php
          }
        }

        echo get_paging($config['mobile_pages'], $page, $total_page, $_SERVER['SCRIPT_NAME'].'?'.$qstr1.'&page=');
        ?>
      </div>
    </div>
  </div>
</div>

<div class="pop-bottom cp-sort__list">
  <div class="top">
    <span class="tit">상품 정렬</span>
    <button type="button" class="ui-btn close-btn"></button>
  </div>
  <div class="ct">
    <ul class="cp-sort-ct">
      <?php echo $sort_str; // 탭메뉴 ?>
    </ul>
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
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);
        hours = String(hours).padStart(2, '0');
        minutes = String(minutes).padStart(2, '0');
        seconds = String(seconds).padStart(2, '0');
        timer.innerHTML = hours + ':' + minutes + ':' + seconds ;
      }
    }, 1000);
  });
});
</script>
