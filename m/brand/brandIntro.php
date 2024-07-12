<?php
include_once("./_common.php");
include_once(BV_MPATH."/_head.php"); // 상단

$qstr1 = 'ca_id='.$ca_id.'&sort='.$sort.'&sortodr='.$sortodr;
$qstr2 = 'ca_id='.$ca_id;

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
            <h3>회원 특별관</h3>
          </div>
        </div>
      </div>

      <div class="container brand-list">
        <div class="brand-item">
          <a href="" class="brand-box">
            <img src="/src/img/brand-logo01.png" alt="">
          </a>
        </div>
        <div class="brand-item">
          <a href="" class="brand-box">
            <img src="/src/img/brand-logo02.png" alt="">
          </a>
        </div>
        <div class="brand-item">
          <a href="" class="brand-box">
            <img src="/src/img/brand-logo03.png" alt="">
          </a>
        </div>
        <div class="brand-item">
          <a href="" class="brand-box">
            <img src="/src/img/brand-logo04.png" alt="">
          </a>
        </div>
        <div class="brand-item">
          <a href="" class="brand-box">
            <img src="/src/img/brand-logo05.png" alt="">
          </a>
        </div>
      </div>

    </div>
  </div>
</div>

<?php
include_once(BV_MPATH."/_tail.php"); // 하단
?>