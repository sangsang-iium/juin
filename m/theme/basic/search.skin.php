<?php
if(!defined("_BLUEVATION_")) exit; // 개별 페이지 접근 불가

$qstr1 = 'ss_tx='.$ss_tx.'&sort='.$sort.'&sortodr='.$sortodr;
$qstr2 = 'ss_tx='.$ss_tx;

$sort_str = '';
for($i=0; $i<count($gw_msort); $i++) {
	list($tsort, $torder, $tname) = $gw_msort[$i];

	$sct_sort_href = $_SERVER['SCRIPT_NAME'].'?'.$qstr2.'&sort='.$tsort.'&sortodr='.$torder;

	if($sort == $tsort && $sortodr == $torder)
		$sort_name = $tname;
	if($i==0 && !($sort && $sortodr))
		$sort_name = $tname;

	$sort_str .= '<li><a href="'.$sct_sort_href.'">'.$tname.'</a></li>'.PHP_EOL;
}
?>
<div id="contents" class="sub-contents schResult">
  <div class="container sch-result_top">
    <p class="sch-result__keyword"><b>"<?php echo $ss_tx;?>"</b>(으)로 검색한 결과입니다.</p>
  </div>

  <!-- 상품 정렬 선택 시작 { -->
  <div id="sch-result_sort">
    <div class="container dp-top">
      <div class="txt-board-cnt">총 <span class="cnt"><?php echo number_format($total_count); ?></span>건</div>
      <div class="cp-sort">
        <span class="cp-sort__btn"><?php echo $sort_name; ?></span>
      </div>
    </div>
  </div>

  <!-- } 상품 정렬 선택 끝 -->

  <div class="container prod-dp-ct">
    <?php
    if(!$total_count) {
      echo "<p class=\"empty_list\">자료가 없습니다.</p>";
    } else {
      for($i=0; $row=sql_fetch_array($result); $i++) {
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

        /*
        echo "<li>";
          echo "<a href=\"{$it_href}\">";
          echo "<dl>";
            echo "<dt><img src=\"{$it_imageurl}\"></dt>";
            echo "<dd class=\"pname\">{$it_name}</dd>\n";
            echo "<dd class=\"price\">{$it_sprice}{$it_price}</dd>\n";
            if( !$is_uncase && ($row['gpoint'] || $is_free_baesong || $is_free_baesong2) ) {
              echo "<dd class=\"petc\">\n";
              if($row['gpoint'])
                echo "<span class=\"fbx_small fbx_bg6\">{$it_point} 적립</span>\n";
              if($is_free_baesong)
                echo "<span class=\"fbx_small fbx_bg4\">무료배송</span>\n";
              if($is_free_baesong2)
                echo "<span class=\"fbx_small fbx_bg4\">조건부무료배송</span>\n";
              echo "</dd>\n";
            }
          echo "</dl>";
          echo "</a>";
          echo "<span onclick='javascript:itemlistwish(\"$row[index_no]\")' id='$row[index_no]' class='$row[index_no] ".zzimCheck($row['index_no'])."'></span>\n";
        echo "</li>";
        */
      }
    }

    echo get_paging($config['mobile_pages'], $page, $total_page, $_SERVER['SCRIPT_NAME'].'?'.$qstr1.'&page=');
    ?>
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

<!-- 정렬 팝업 변경 _20240328_SY -->
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
// $(function() {
//   var mbheight = $(window).height();

//   $('.cp-sort__btn').click(function(){
//     $('#sort_bg').fadeIn(300);
//     $('#sort_li').slideDown('fast');
//     $('html').css({'height':mbheight+'px', 'overflow':'hidden'});
//   });

//   $('#sort_bg, #sort_close').click(function(){
//     $('#sort_bg').fadeOut(300);
//     $('#sort_li').slideUp('fast');
//     $('html').css({'height':'100%', 'overflow':'scroll'});
//   });
// });
</script>