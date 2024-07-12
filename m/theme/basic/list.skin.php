<?php
if(!defined("_BLUEVATION_")) exit; // 개별 페이지 접근 불가

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
            <h3><?php echo $tb['title']; ?></h3>
          </div>
        </div>
      </div>

      <div class="container left prod-list__category">
        <div class="cp-horizon-menu2 category-wrap">
          <div class="swiper-wrapper">
            <?php echo mobile_horizon_category($ca_id);?>
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
            if(!memberGoodsAble($member['addr1'], $row['zone'])){
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
            $it_sprice = $sale = '';
            if($row['normal_price'] > $it_amount && !$is_uncase) {
              $sett = ($row['normal_price'] - $it_amount) / $row['normal_price'] * 100;
              $sale = number_format($sett,0).'%';
              $it_sprice = display_price2($row['normal_price']);
            }

            item_card($row['index_no'], $it_href, $it_imageurl, $it_name, $it_sprice, $sale, $it_price, 'small');
          }
        }

        echo get_paging($config['mobile_pages'], $page, $total_page, $_SERVER['SCRIPT_NAME'].'?'.$qstr1.'&page=');
        ?>
      </div>
    </div>
  </div>
</div>

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

<script type="module">
import * as f from '/src/js/function.js';

//Category Menu
let caMenuActive = '<?php echo $_GET['ca_id']?>';
const caMenuTarget = '.prod-list__category .category-wrap';
const caMenu = f.hrizonMenu(caMenuTarget, caMenuActive);
</script>