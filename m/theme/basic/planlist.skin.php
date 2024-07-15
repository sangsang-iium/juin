<?php
if(!defined('_BLUEVATION_')) exit;
?>


<div id="contents" class="sub-contents exhibDetail">
  <div class="bottomBlank exhib-info">
    <div class="container">
      <div class="exhib-info__head">
        <p class="tRow2 subj"><?php echo $pl['pl_name']; ?></p>
        <p class="ex">
          <span class="tag on">진행</span>
          <span class="period">2024.01.01~2024.12.31</span>
        </p>
        <button type="button" class="ui-btn share-btn"></button>
      </div>
      <div class="exhib-info__body">
        <div class="ht-cont">
          <div class="ht-wrap">
            <div class="ht-view exhib-imgbox">
              <?php if($bimg_url) { ?>
              <div class="plan_v_img"><img src="<?php echo $bimg_url; ?>" width="1000"></div>
              <?php } ?>
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
  <div class="bottomBlank exhib-prod">
    <div class="container">
      <div class="exhib-prod-ct">
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
          }
        }

        echo get_paging($config['mobile_pages'], $page, $total_page, $_SERVER['SCRIPT_NAME'].'?'.$qstr.'&page=');
        ?>
      </div>
    </div>
  </div>
</div>