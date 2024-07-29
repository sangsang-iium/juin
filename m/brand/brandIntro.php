<?php
include_once("./_common.php");
include_once(BV_MPATH."/_head.php"); // 상단

/* ------------------------------------------------------------------------------------- _20240713_SY
  * 미개발 상태이므로 강제로 ca_id 값 넣어 놓음
  * 이미지 이후에 DB 넣어줘야 함 → 그에 따른 쿼리 및 img태그 수정 필요
  * mobile_horizon_category() 함수 기용함
*/
  $ca_id = '006';


  $sql = " select *
        from shop_category
        where catecode = '$ca_id'
          and cateuse = '0'
        and find_in_set('$pt_id', catehide) = '0' ";
  $ca = sql_fetch($sql);
  if(!$ca['catecode']){
    alert('등록된 분류가 없습니다.');
  }

	$sql_common = " from shop_category ";
	$sql_where  = " where cateuse = '0' and find_in_set('$pt_id', catehide) = '0' ";
	$sql_order  = " order by caterank, catecode ";

	$sql = "select * {$sql_common} {$sql_where} and upcate = '$ca_id' {$sql_order} ";

	$result = sql_query($sql);

/* ------------------------------------------------------------------------------------- */


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
        <?php // 임시 링크 연결 _20240713_SY
          for($i=0; $row=sql_fetch_array($result); $i++) {
            $k = $i + 1;
            $href = BV_MSHOP_URL.'/list.php?ca_id='.$row['catecode'];
            $img_url = !empty($row['cateimg1']) ? BV_DATA_URL."/category/".$row['cateimg1'] : "";
            if(!empty($img_url)){
              $img_tag = "<img src=\"{$img_url}\" alt=\"\">";
            } else {
              $img_tag = "<p>{$row['catename']}</p>";
            }

            echo "<div class=\"brand-item\">
                    <a href=\"{$href}\" data-id=\"{$row['catecode']}\" class=\"brand-box\">
                      {$img_tag}
                    </a>
                  </div>";
          }
        ?>
        <!-- <div class="brand-item">
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
        </div> -->
      </div>

    </div>
  </div>
</div>

<?php
include_once(BV_MPATH."/_tail.php"); // 하단
?>