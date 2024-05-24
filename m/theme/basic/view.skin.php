<?php
if(!defined("_BLUEVATION_")) exit; // 개별 페이지 접근 불가
?>

<script src="<?php echo BV_MJS_URL; ?>/shop.js"></script>

<?php if($default['de_kakao_js_apikey']) { ?>
<script src="https://developers.kakao.com/sdk/js/kakao.min.js"></script>
<script src="<?php echo BV_JS_URL; ?>/kakaolink.js"></script>
<script>
    // 사용할 앱의 Javascript 키를 설정해 주세요.
    Kakao.init("<?php echo $default['de_kakao_js_apikey']; ?>");
</script>
<?php } ?>

<form name="fbuyform" method="post">
<input type="hidden" name="gs_id[]" value="<?php echo $gs_id; ?>">
<input type="hidden" id="it_price" value="<?php echo get_sale_price($gs_id); ?>">
<input type="hidden" name="ca_id" value="<?php echo $gs['ca_id']; ?>">
<input type="hidden" name="sw_direct">

<div id="contents" class="sub-contents prodDetail">
  <div class="prod-detailThumb">
    <div class="swiper-container">
      <div class="swiper-wrapper">
        <?php
        for($i = 2; $i <= 6; $i++) {
          if($gs['simg'.$i]) {
        ?>
        <div class="swiper-slide item">
          <a href="" class="link">
            <figure class="image">
              <img src="<?php echo get_it_image_url($gs_id, $gs['simg'.$i], $default['de_item_medium_wpx'], $default['de_item_medium_hpx']); ?>" alt="<?php echo get_text($gs['gname']); ?>" class="fitCover">
            </figure>
          </a>
        </div>
        <?php
          } //End if
        } //End for
        ?>
      </div>
      <div class="round swiper-control">
        <div class="pagination"></div>
      </div>
    </div>
  </div>

  <div class="prod-smInfo">
    <div class="bottomBlank container prod-smInfo__head">
      <div class="prod-tag_area">
        <span class="tag coupon">쿠폰</span>
        <span class="tag freeDelivery">무료배송</span>
      </div>
      <button type="button" class="ui-btn share-btn"></button>
      <div class="prod-info_area">
        <?php
        // (시중가 - 할인판매가) / 시중가 X 100 = 할인률%
        $gs_amount = get_sale_price($gs['index_no']);
        $gs_sprice = $gs_sale = '';
        if($gs['normal_price'] > $gs_amount && !is_uncase($gs['index_no'])) {
          $gs_sett = ($gs['normal_price'] - $gs_amount) / $gs['normal_price'] * 100;
          $gs_sale = number_format($gs_sett,0).'%';
          $gs_sprice = display_price2($gs['normal_price']);
        }
        ?>
        <p class="tRow2 name"><?php echo get_text($gs['gname']); ?></p>
        <?php if($gs_sprice) { ?>
          <p class="dc-price"><?php echo $gs_sprice; ?></p>
        <?php } ?>
        <p class="price-box">
          <?php if($gs_sale) { ?>
            <span class="dc-percent"><?php echo $gs_sale;?></span>
          <?php } ?>
          <span class="sale-price"><?php echo mobile_price($gs_id); ?></span>
        </p>
      </div>
      <div class="prod-review_area">
        <i class="rv-star cnt_only"></i>
        <span class="rv-rating"><?php echo $star_score; ?></span>
        <button type="button" class="ui-btn rv-move-btn" onclick="chk_tab('#prod-detailTab__review');"><?php echo number_format($item_use_count); ?>개 리뷰</button>
      </div>
      <?php if(!$is_only && !$is_pr_msg && !$is_buy_only && !$is_soldout && $cp_used) { ?>
      <div class="prod-cupon_area">
        <!--팝업작업: 기본 소스 참고
        <?php // echo $cp_btn; ?>
        -->

        <button type="button" class="ui-btn round st2 cupon-downlad-btn" data="stIconRight"><span class="txt">할인 쿠폰 받고 구매하기</span><i class="icn"></i></button>
      </div>
      <?php } ?>
    </div>
    <div class="bottomBlank container prod-smInfo__body">
      <div class="info-list">
        <?php if(!$is_only && !$is_pr_msg && !$is_buy_only && !$is_soldout && $gpoint) { ?>
        <div class="info-item">
          <p class="tit">포인트</p>
          <p class="cont"><?php echo $gpoint; ?></p>
        </div>
        <?php } ?>
        <?php if($gs['maker']) { ?>
        <div class="info-item">
          <p class="tit">제조사</p>
          <p class="cont"><?php echo $gs['maker']; ?></p>
        </div>
        <?php } ?>
        <?php if($gs['origin']) { ?>
        <div class="info-item">
          <p class="tit">원산지</p>
          <p class="cont"><?php echo $gs['origin']; ?></p>
        </div>
        <?php } ?>
        <?php if($gs['brand_nm']) { ?>
        <div class="info-item">
          <p class="tit">브랜드</p>
          <p class="cont"><?php echo $gs['brand_nm']; ?></p>
        </div>
        <?php } ?>
        <?php if($gs['model']) { ?>
        <div class="info-item">
          <p class="tit">모델명</p>
          <p class="cont"><?php echo $gs['model']; ?></p>
        </div>
        <?php } ?>
        <?php if($gs['odr_min']) { ?>
        <div class="info-item">
          <p class="tit">최소구매수량</p>
          <p class="cont"><?php echo display_qty($gs['odr_min']); ?></p>
        </div>
        <?php } ?>
        <?php if($gs['odr_max']) { ?>
        <div class="info-item">
          <p class="tit">최대구매수량</p>
          <p class="cont"><?php echo display_qty($gs['odr_max']); ?></p>
        </div>
        <?php } ?>
        <div class="info-item">
          <p class="tit">배송비</p>
          <p class="cont"><?php echo mobile_sendcost_amt(); ?></p>
        </div>
        <div class="info-item">
          <p class="tit">배송가능지역</p>
          <?php
          $regions = explode("||", $gs['zone']);
          $regionMap = [];

          foreach ($regions as $region) {
            list($province, $city) = explode(",", $region);
            if (!isset($regionMap[$province])) {
              $regionMap[$province] = [];
            }
            $regionMap[$province][] = $city;
          }

          $res_data = [];
          foreach ($regionMap as $province => $cities) {
            $cityString = implode("/", $cities);
            $res_data[]   = $province . " " . $cityString;
          }

          $gszone = implode(", ", $res_data);


          ?>
          <p class="cont"><?php echo $gszone; ?> <?php echo $gs['zone_msg']; ?></p>
        </div>
      </div>
    </div>
  </div>

  <div class="prod-detailInfo">
    <div id="prod-detailTab__info" class="bottomBlank prod-detailTabWrap">
      <div class="container prod-detailInfo__head">
        <div class="cp-tab-menu">
          <div class="inner">
            <button type="button" id="d1" class="ui-btn tab-btn on" onclick="chk_tab('#prod-detailTab__info');">상품정보</button>
            <button type="button" id="d2" class="ui-btn tab-btn" onclick="chk_tab('#prod-detailTab__review');">리뷰<small class="cnt">(<?php echo number_format($item_use_count); ?>)</small></button>
            <button type="button" id="d3" class="ui-btn tab-btn" onclick="chk_tab('#prod-detailTab__inquiry');">문의<small class="cnt">(<?php echo number_format($itemqa_count); ?>)</small></button>
            <button type="button" id="d4" class="ui-btn tab-btn" onclick="chk_tab('#prod-detailTab__dvex');">교환/반품</button>
          </div>
        </div>
      </div>
      <div class="container prod-detailInfo__body">
        <div class="dtinfo-box">
          <div class="dtinfo-inner">
            <div class="ht-cont">
              <div class="ht-wrap">
                <div class="ht-view prod-memo">
                  <?php echo conv_content($gs['memo'], 1); ?>
                </div>
              </div>
              <button type="button" class="ui-btn round stWhite more-btn" data="stIconRight">
                <span class="txt">더보기</span>
                <i class="icn"></i>
              </button>
            </div>

            <div class="prod-report">
              <button type="button" class="ui-btn sizeM stWhite prod-report__btn" onclick="chk_show('extra');">
                <span>전자상거래 등에서의 상품정보제공 고시</span>
                <span id="extra">보기</span>
              </button>

              <?php
              if($gs['info_value']) {
                $info_data = unserialize(stripslashes($gs['info_value']));
                if(is_array($info_data)) {
                  $gubun = $gs['info_gubun'];
                  $info_array = $item_info[$gubun]['article'];
              ?>
              <div class="info-list" id="ids_extra" style="display:none;">
                <?php
                foreach($info_data as $key=>$val) {
                  $ii_title = $info_array[$key][0];
                  $ii_value = $val;
                ?>
                <div class="info-item">
                  <p class="tit"><?php echo $ii_title; ?></p>
                  <p class="cont"><?php echo $ii_value; ?></p>
                </div>
                <?php
                } //foreach
                ?>
              </div>
              <?php
                } //array
              } //if
              ?>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div id="prod-detailTab__review" class="bottomBlank prod-detailTabWrap">
      <div class="container prod-detailInfo__head">
        <div class="cp-tab-menu">
          <div class="inner">
            <button type="button" id="d1" class="ui-btn tab-btn" onclick="chk_tab('#prod-detailTab__info');">상품정보</button>
            <button type="button" id="d2" class="ui-btn tab-btn on" onclick="chk_tab('#prod-detailTab__review');">리뷰<small class="cnt">(<?php echo number_format($item_use_count); ?>)</small></button>
            <button type="button" id="d3" class="ui-btn tab-btn" onclick="chk_tab('#prod-detailTab__inquiry');">문의<small class="cnt">(<?php echo number_format($itemqa_count); ?>)</small></button>
            <button type="button" id="d4" class="ui-btn tab-btn" onclick="chk_tab('#prod-detailTab__dvex');">교환/반품</button>
          </div>
        </div>
      </div>
      <div class="container prod-detailInfo__body">
        <div class="rv-head">
          <div class="round20 prod-review_area">
            <i class="rv-star cnt_<?php echo $star_score; ?>"></i>
            <span class="rv-rating"><?php echo $star_score; ?></span>
            <span class="rv-rating-total"> / 5</span>
          </div>

          <div class="rv-img-list">
            <style>
              /* 확인 필요 */
              .rv-img-list {overflow-x: scroll; white-space: nowrap; }
              .rv-img-list::-webkit-scrollbar { display: none; }
            </style>
            <?php 
              // 상품 리뷰 이미지 전체
              $reviewTotalImgArr = reviewTotalImg($gs_id);
              if(sizeof($reviewTotalImgArr) > 0) {
                foreach ($reviewTotalImgArr as $reviewImg) {
            ?>
              <a href="" class="rv-img-item">
                <div class="rv-img">
                  <img src="/data/review/<?php echo $reviewImg['thumbnail'] ?>" alt="">
                </div>
              </a>
            <?php } } ?>
            
          </div>
        </div>
        <div class="rv-body">
          <div class="rv-title">
            <p class="title">
              리뷰(<?php echo number_format($item_use_count); ?>)
            </p>
            <div class="rv-sort-wr">
              <div class="rv-sort-list">
                <div class="rv-sort-item active">
                  <button type="button" class="btn" id="last" >최신순</button>
                </div>
                <div class="rv-sort-item">
                  <button type="button" class="btn" id="high" >평점높은순</button>
                </div>
                <div class="rv-sort-item">
                  <button type="button" class="btn" id="low" >평점낮은순</button>
                </div>
              </div>
            </div>
          </div>
          
          <div class="rv-item-list">
            <?php echo mobile_goods_review("구매후기", $item_use_count, $gs_id); ?>
          </div>
          <!-- 팝업작업: 기본 소스 참고
          <a href="<?php echo BV_MSHOP_URL.'/view_user.php?gs_id='.$gs_id; ?>" class="ui-btn round moreLong">
            <span class="text">전체보기</span>
          </a>
          -->
          <button type="button" class="ui-btn round moreLong rv-all-btn">
            <span class="text">전체보기</span>
          </button>
        </div>
      </div>
    </div>

    <div id="prod-detailTab__inquiry" class="bottomBlank prod-detailTabWrap">
      <div class="container prod-detailInfo__head">
        <div class="cp-tab-menu">
          <div class="inner">
            <button type="button" id="d1" class="ui-btn tab-btn" onclick="chk_tab('#prod-detailTab__info');">상품정보</button>
            <button type="button" id="d2" class="ui-btn tab-btn" onclick="chk_tab('#prod-detailTab__review');">리뷰<small class="cnt">(<?php echo number_format($item_use_count); ?>)</small></button>
            <button type="button" id="d3" class="ui-btn tab-btn on" onclick="chk_tab('#prod-detailTab__inquiry');">문의<small class="cnt">(<?php echo number_format($itemqa_count); ?>)</small></button>
            <button type="button" id="d4" class="ui-btn tab-btn" onclick="chk_tab('#prod-detailTab__dvex');">교환/반품</button>
          </div>
        </div>
      </div>
      <div class="container prod-detailInfo__body">
        <div class="iq-head">
          <!--팝업작업: 기본 소스 참고
          <a href="<?php echo BV_MSHOP_URL.'/qaform.php?gs_id='.$gs_id; ?>" class="ui-btn round st2 iq-wbtn">문의하기</a>
          -->
          <button type="button" class="ui-btn round st2 iq-wbtn">문의하기</button>
          <p class="iq-wtext">배송 및 주문관련 문의는 <a href="<?php echo BV_MBBS_URL.'/qna_list.php'; ?>" class="link">FAQ 또는 1:1문의</a>를 이용해주세요.</p>
        </div>
        <div class="iq-body">
          <div class="iq-title">
            <p class="title">문의(<?php echo number_format($itemqa_count); ?>)</p>
            <div class="iq-sort-wr">
              <div class="frm-choice">
                <input type="checkbox" name="myInqSort" id="myInqSort" value="">
                <label for="myInqSort">내 문의 보기</label>
              </div>
            </div>
          </div>

          <div class="iq-list">
            <?php echo mobile_goods_qa("Q&A", $itemqa_count, $gs_id); ?>
          </div>
          <button type="button" class="ui-btn round moreLong iq-all-btn">
            <span class="text">전체보기</span>
          </button>
        </div>
      </div>
    </div>

    <div id="prod-detailTab__dvex" class="bottomBlank prod-detailTabWrap">
      <div class="container prod-detailInfo__head">
        <div class="cp-tab-menu">
          <div class="inner">
            <button type="button" id="d1" class="ui-btn tab-btn" onclick="chk_tab('#prod-detailTab__info');">상품정보</button>
            <button type="button" id="d2" class="ui-btn tab-btn" onclick="chk_tab('#prod-detailTab__review');">리뷰<small class="cnt">(<?php echo number_format($item_use_count); ?>)</small></button>
            <button type="button" id="d3" class="ui-btn tab-btn" onclick="chk_tab('#prod-detailTab__inquiry');">문의<small class="cnt">(<?php echo number_format($itemqa_count); ?>)</small></button>
            <button type="button" id="d4" class="ui-btn tab-btn on" onclick="chk_tab('#prod-detailTab__dvex');">교환/반품</button>
          </div>
        </div>
      </div>
      <div class="container prod-detailInfo__body">
        <div class="dvex-head">
          <div class="dvex-title">
            <p class="title">교환/반품</p>
          </div>
        </div>
        <div class="dvex-body">
          <?php echo conv_content(get_policy_content($gs_id), 1); ?>
        </div>
      </div>
    </div>
  </div>

  <div class="prod-detailRel">
    <div class="container rel-head">
      <p class="title">연관상품</p>
    </div>
    <div class="rel-body">
      <?php
      $sql = " select b.*
            from shop_goods_relation a left join shop_goods b ON (a.gs_id2=b.index_no)
            where a.gs_id = '{$gs_id}'
            and b.shop_state = '0'
            and b.isopen < 3 ";
      $res = sql_query($sql);
      $rel_count = sql_num_rows($res);
      if($rel_count > 0) {
      ?>
      <div class="container left prod-detailRel-slide">
        <div class="swiper-container">
          <div class="swiper-wrapper">
          <?php
          for($i=0; $row=sql_fetch_array($res); $i++) {
            $it_href = BV_MSHOP_URL.'/view.php?gs_id='.$row['index_no'];
            $it_name = cut_str($row['gname'], 50);
            $it_imageurl = get_it_image_url($row['index_no'], $row['simg2'], 400, 400);
            $it_price = mobile_price($row['index_no']);
            $it_amount = get_sale_price($row['index_no']);
            $it_point = display_point($row['gpoint']);

            // (시중가 - 할인판매가) / 시중가 X 100 = 할인률%
            $it_sprice = $sale = '';
            if($row['normal_price'] > $it_amount && !is_uncase($row['index_no'])) {
              $sett = ($row['normal_price'] - $it_amount) / $row['normal_price'] * 100;
              $sale = number_format($sett,0).'%';
              $it_sprice = display_price2($row['normal_price']);
            }
          ?>
          <div class="swiper-slide cp-item">
            <div class="round50 prod-thumb_area">
              <a href="<?php echo $it_href; ?>" class="thumb">
                <img src="<?php echo $it_imageurl; ?>" alt="">
              </a>
              <button type="button" class="ui-btn wish-btn" title="관심상품 등록하기"></button>
            </div>
            <a href="<?php echo $it_href; ?>" class="prod-info_area small">
              <p class="tRow2 name"><?php echo $it_name; ?></p>
              <?php if($it_sprice) { ?>
              <p class="dc-price"><?php echo $it_sprice; ?></p>
              <?php } ?>
              <p class="price">
                <?php if($sale) { ?>
                <span class="dc-percent"><?php echo $sale; ?></span>
                <?php } ?>
                <span class="sale-price"><?php echo $it_price; ?></span>
              </p>
            </a>
            <div class="prod-tag_area">
              <span class="tag coupon">쿠폰</span>
              <span class="tag freeDelivery">무료배송</span>
            </div>
          </div>
          <?php } ?>
          </div>
        </div>
      </div>
      <?php } ?>
      <?php if($rel_count == 0) echo "<p class=\"empty_list\">연관상품이 없습니다.</p>"; ?>
    </div>
  </div>

  <?php if(!$is_pr_msg) { ?>
  <div class="prod-buy_area">
    <div class="actBox">
      <div class="container">
        <div class="prod-buy__options">
          <button type="button" class="ui-btn close-btn"><img src="/src/img/arrow-down.png" alt=""></button>
          <p class="prod-name"><?php echo get_text($gs['gname']); ?></p>

          <div class="options-inner">
            <?php if(!$is_only && !$is_pr_msg && !$is_buy_only && !$is_soldout) { ?>
            <?php if($option_item || $supply_item) { ?>
            <div class="cp-option__select">
              <?php if($option_item) {
                echo $option_item; //주문옵션 : 필수옵션
              } ?>

              <?php if($supply_item) {
                $supply_item; //추가구성 : 선택옵션
              } ?>
            </div>
            <?php } ?>


            <!-- 선택된 옵션 시작 { -->
            <div id="option_set_list" class="cp-selected__option">
              <?php if(!$option_item) { ?>
              <ul id="option_set_added">
                <li class="sit_opt_list">
                  <div class="sp_tbox">
                  <input type="hidden" name="io_type[<?php echo $gs_id; ?>][]" value="0">
                  <input type="hidden" name="io_id[<?php echo $gs_id; ?>][]" value="">
                  <input type="hidden" name="io_value[<?php echo $gs_id; ?>][]" value="<?php echo $gs['gname']; ?>">
                  <input type="hidden" class="io_price" value="0">
                  <input type="hidden" class="io_stock" value="<?php echo $gs['stock_qty']; ?>">
                    <ul class="opt-list">
                      <!--
                      <li class="it_name">
                        <span class="sit_opt_subj"><?php echo get_text($gs['gname']); ?></span>
                        <span class="sit_opt_prc"></span>
                      </li>
                      -->
                      <li class="it_qty">
                        <div class="cp-qty">
                          <button type="button" class="minus ui-btn st3">감소</button>
                          <input type="text" name="ct_qty[<?php echo $gs_id; ?>][]" value="<?php echo $odr_min; ?>" title="수량설정">
                          <button type="button" class="plus ui-btn st3">증가</button>
                        </div>
                        <span class="sit_opt_prc"><?php echo mobile_price($gs_id); ?></span>
                      </li>
                    </ul>
                  </div>
                </li>
              </ul>
              <script>
              $(function() {
                price_calculate();
              });
              </script>
              <?php } ?>
            </div>
            <!-- } 선택된 옵션 끝 -->
          </div>

          <!-- 총 구매액 -->
          <div id="sit_tot_views" class="dn">
            <div class="sp_tot">
              <ul>
                <li class='tlst strong'>총 합계금액</li>
                <li class='trst'><span id="sit_tot_price" class="trss-amt"></span><span class="trss-amt">원</span></li>
              </ul>
            </div>
          </div>
          <?php } ?>
        </div>

        <div class="prod-buy__btns">
          <button type="button" class="<?php echo $gs_id;?> ui-btn wish-btn <?php echo zzimCheck($gs_id);?>" title="관심상품 등록하기" onclick="itemlistwish('<?php echo $gs_id;?>')"></button>
          <?php echo mobile_buy_button($script_msg, $gs_id); ?>
        </div>
        <?php if($naverpay_button_js) { ?>
        <div class="naverpay-item"><?php echo $naverpay_request_js.$naverpay_button_js; ?></div>
        <?php } ?>
      </div>
    </div>
    <div class="dfBox">
      <div class="container">
        <div class="prod-buy__btns">
          <button type="button" class="<?php echo $gs_id;?> ui-btn wish-btn <?php echo zzimCheck($gs_id);?>" title="관심상품 등록하기" onclick="itemlistwish('<?php echo $gs_id;?>')"></button>
          <button type="button" class="ui-btn round stBlack buy-btn dp">구매하기</button>
        </div>
      </div>
    </div>
  </div>
  <?php } ?>
</div>
</form>

<!--
<div id="prodShare" class="pop-bottom">
  <div class="top">
    <span class="tit">공유하기</span>
    <button type="button" class="ui-btn close-btn"></button>
  </div>
  <div class="ct">
    <ul class="way">
      <?php echo $sns_share_links; ?>
    </ul>
  </div>
</div>
-->

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

<!-- 할인쿠폰받기 팝업 { -->
  <div id="coupon-popup" class="popup type02 add-popup">
  <div class="pop-inner">
    <div class="pop-top">
      <p class="tit">쿠폰 받기</p>
      <button type="button" class="btn close"></button>
    </div>
    <div class="pop-content line">
      <div class="pop-content-in">
      </div>
    </div>
  </div>
</div>
<!-- } 할인쿠폰받기 팝업 -->

<!-- 리뷰 전체보기 팝업 { -->
<div id="review-popup" class="popup type02 add-popup">
  <div class="pop-inner">
    <div class="pop-top">
      <p class="tit">리뷰 목록</p>
      <button type="button" class="btn close"></button>
    </div>
    <div class="pop-content line">
      <div class="pop-content-in">
      </div>
    </div>
  </div>
</div>
<!-- } 리뷰 전체보기 팝업 -->

<!-- 리뷰 전체보기 팝업 내 작성(수정) 팝업 { -->
<div id="review-write-popup" class="popup type02 add-popup add-in-popup">
  <div class="pop-inner">
    <div class="pop-top">
      <p class="tit">리뷰 작성</p>
      <button type="button" class="btn close"></button>
    </div>
    <div class="pop-content line">
      <div class="pop-content-in">
      </div>
    </div>
  </div>
</div>
<!-- } 리뷰 전체보기 팝업 내 작성(수정) 팝업 -->

<!-- 리뷰 수정 팝업 { -->
  <div id="review-edit-popup" class="popup type02 add-popup">
  <div class="pop-inner">
    <div class="pop-top">
      <p class="tit">리뷰 수정</p>
      <button type="button" class="btn close"></button>
    </div>
    <div class="pop-content line">
      <div class="pop-content-in">
      </div>
    </div>
  </div>
</div>
<!-- } 리뷰 수정 팝업 -->

<!-- 상품문의작성 팝업 { -->
  <div id="inquiry-write-popup" class="popup type02 add-popup">
  <div class="pop-inner">
    <div class="pop-top">
      <p class="tit">문의 작성</p>
      <button type="button" class="btn close"></button>
    </div>
    <div class="pop-content line">
      <div class="pop-content-in">
      </div>
    </div>
  </div>
</div>
<!-- } 상품문의작성 팝업 -->

<!-- 상품문의목록 팝업 { -->
  <div id="inquiry-popup" class="popup type02 add-popup">
  <div class="pop-inner">
    <div class="pop-top">
      <p class="tit">문의 목록</p>
      <button type="button" class="btn close"></button>
    </div>
    <div class="pop-content line">
      <div class="pop-content-in">
      </div>
    </div>
  </div>
</div>
<!-- } 상품문의목록 팝업 -->

<script type="module">
import * as f from '/src/js/function.js';

function copyLink(url) {
  f.clipCopy(url);
}

$(document).ready(function(){
  //할인쿠폰받기 팝업
  $(".cupon-downlad-btn").on("click", function () {
    const gsId = "<?php echo $gs_id;?>";
    var mb_id = '<?=$member['id']?>';
    if(!mb_id){
      alert('회원만 이용가능한 서비스 입니다.');
      return false;
    }
    const popId = "#coupon-popup";
    const reqPathUrl = "./pop_coupon.php";
    const reqMethod = "GET";
    const reqData = { gs_id: gsId };

    f.callData(popId, reqPathUrl, reqMethod, reqData, true);
  });

  //리뷰 전체보기 팝업
  $(".rv-all-btn").on("click", function () {
    const gsId = "<?php echo $gs_id;?>";

    const popId = "#review-popup";
    const reqPathUrl = "./view_user.php";
    const reqMethod = "GET";
    const reqData = { gs_id: gsId };

    f.callData(popId, reqPathUrl, reqMethod, reqData, true);
  });

  //리뷰 전체보기 팝업 내 작성 팝업
  $("#review-popup").on("click", ".rv-write-btn", function () {
    const gsId = "<?php echo $gs_id;?>";
    let mb_id = "<?php echo $is_member ? $member['id'] : ''; ?>";

    const popId = "#review-write-popup";
    const reqPathUrl = "./orderreview.php";
    const reqMethod = "GET";
    // mb_id 추가 _20240320_SY
    const reqData = { gs_id: gsId, mb_id: mb_id };

    f.callData(popId, reqPathUrl, reqMethod, reqData, true);

    $(popId).find('.pop-top .tit').text("리뷰 작성");
  });

  //리뷰 전체보기 팝업 내 수정 팝업
  $("#review-popup").on("click", ".rv-inEdit-btn", function () {
    const gsId = "<?php echo $gs_id;?>";
    const meId = $(this).data('me-id');

    const popId = "#review-write-popup";
    const reqPathUrl = "./orderreview.php";
    const reqMethod = "GET";
    const reqData = { gs_id: gsId, me_id: meId, w: 'u' };

    f.callData(popId, reqPathUrl, reqMethod, reqData, true);

    $(popId).find('.pop-top .tit').text("리뷰 수정");
  });

  //리뷰 수정 팝업
  $(document).on('click', '.rv-edit-btn', function() {
    const gsId = "<?php echo $gs_id;?>";
    const meId = $(this).data('me-id');

    const popId = "#review-edit-popup";
    const reqPathUrl = "./orderreview.php";
    const reqMethod = "GET";
    const reqData = { gs_id: gsId, me_id: meId, w: 'u' };

    f.callData(popId, reqPathUrl, reqMethod, reqData, true);
  });

  //상품문의작성 팝업
  $(".iq-wbtn").on("click", function () {
    const gsId = "<?php echo $gs_id;?>";
    let mb_id = "<?php echo $is_member ? $member['pt_id'] : ''; ?>";

    const popId = "#inquiry-write-popup";
    const reqPathUrl = "./qaform.php";
    const reqMethod = "GET";
    // mb_id 추가 _20240320_SY
    const reqData = { gs_id: gsId, mb_id: mb_id };

    f.callData(popId, reqPathUrl, reqMethod, reqData, true);
  });

  //상품문의목록 팝업
  $(".iq-all-btn").on("click", function () {
    const gsId = "<?php echo $gs_id;?>";

    const popId = "#inquiry-popup";
    const reqPathUrl = "./qalist.php";
    const reqMethod = "GET";
    const reqData = { gs_id: gsId };

    f.callData(popId, reqPathUrl, reqMethod, reqData, true);
  });
});
</script>


<script>
// 상품보관
function item_wish(f)
{
	f.action = "./wishupdate.php";
	f.submit();
}

function fsubmit_check(f)
{
    // 판매가격이 0 보다 작다면
    if (document.getElementById("it_price").value < 0) {
        alert("전화로 문의해 주시면 감사하겠습니다.");
        return false;
    }

	if($(".sit_opt_list").size() < 1) {
		alert("주문옵션을 선택해주시기 바랍니다.");
		return false;
	}

    var val, io_type, result = true;
    var sum_qty = 0;
	var min_qty = parseInt('<?php echo $odr_min; ?>');
	var max_qty = parseInt('<?php echo $odr_max; ?>');
    var $el_type = $("input[name^=io_type]");

    $("input[name^=ct_qty]").each(function(index) {
        val = $(this).val();

        if(val.length < 1) {
            alert("수량을 입력해 주십시오.");
            result = false;
            return false;
        }

        if(val.replace(/[0-9]/g, "").length > 0) {
            alert("수량은 숫자로 입력해 주십시오.");
            result = false;
            return false;
        }

        if(parseInt(val.replace(/[^0-9]/g, "")) < 1) {
            alert("수량은 1이상 입력해 주십시오.");
            result = false;
            return false;
        }

        io_type = $el_type.eq(index).val();
        if(io_type == "0")
            sum_qty += parseInt(val);
    });

    if(!result) {
        return false;
    }

    if(min_qty > 0 && sum_qty < min_qty) {
		alert("주문옵션 개수 총합 "+number_format(String(min_qty))+"개 이상 주문해 주세요.");
        return false;
    }

    if(max_qty > 0 && sum_qty > max_qty) {
		alert("주문옵션 개수 총합 "+number_format(String(max_qty))+"개 이하로 주문해 주세요.");
        return false;
    }

    return true;
}

// 바로구매, 장바구니 폼 전송
function fbuyform_submit(sw_direct)
{
	var f = document.fbuyform;
	f.sw_direct.value = sw_direct;

	if(sw_direct == "cart") {
		f.sw_direct.value = 0;
	} else { // 바로구매
		f.sw_direct.value = 1;
	}

	if($(".sit_opt_list").size() < 1) {
		alert("주문옵션을 선택해주시기 바랍니다.");
		return;
	}

	var val, io_type, result = true;
	var sum_qty = 0;
	var min_qty = parseInt('<?php echo $odr_min; ?>');
	var max_qty = parseInt('<?php echo $odr_max; ?>');
	var $el_type = $("input[name^=io_type]");

	$("input[name^=ct_qty]").each(function(index) {
		val = $(this).val();

		if(val.length < 1) {
			alert("수량을 입력해 주세요.");
			result = false;
			return;
		}

		if(val.replace(/[0-9]/g, "").length > 0) {
			alert("수량은 숫자로 입력해 주세요.");
			result = false;
			return;
		}

		if(parseInt(val.replace(/[^0-9]/g, "")) < 1) {
			alert("수량은 1이상 입력해 주세요.");
			result = false;
			return;
		}

		io_type = $el_type.eq(index).val();
		if(io_type == "0")
			sum_qty += parseInt(val);
	});

	if(!result) {
		return;
	}

	if(min_qty > 0 && sum_qty < min_qty) {
		alert("주문옵션 개수 총합 "+number_format(String(min_qty))+"개 이상 주문해 주세요.");
		return;
	}

	if(max_qty > 0 && sum_qty > max_qty) {
		alert("주문옵션 개수 총합 "+number_format(String(max_qty))+"개 이하로 주문해 주세요.");
		return;
	}

	f.action = "./cartupdate.php";
	f.submit();
}

// 전자상거래 등에서의 상품정보제공 고시
var old = '';
function chk_show(name) {
	submenu=eval("ids_"+name+".style");

	if(old!=submenu) {
		if(old) { old.display='none'; }

		submenu.display='';
		eval("extra").innerHTML = "닫기";
		old = submenu;

	} else {
		submenu.display='none';
		eval("extra").innerHTML = "보기";
		old = '';
	}
}

// 상품문의
var qa_old = '';
function qna(name){
	qa_submenu = eval("qna"+name+".style");

	if(qa_old!=qa_submenu) {
		if(qa_old) { qa_old.display='none'; }

		qa_submenu.display='block';
		qa_old=qa_submenu;

	} else {
		qa_submenu.display='none';
		qa_old='';
	}
}

// 상품문의 삭제
$(function(){
    $(".itemqa_delete").click(function(){
        return confirm("정말 삭제 하시겠습니까?\n\n삭제후에는 되돌릴수 없습니다.");
    });
});

// 탭메뉴 컨트롤
function chk_tab(t) {
  let tabOffset = $(t).offset();

  $("html, body").animate({scrollTop: tabOffset.top}, 400);
}

// 미리보기 이미지
var num = 0;
var img_url = '<?php echo $slide_url; ?>';
var img_max = '<?php echo $slide_cnt; ?>';
var img_arr = img_url.split('|');
var slide   = new Array;
for(var i=0 ;i<parseInt(img_max);i++) {
	slide[i] = img_arr[i];
}

var cnt = slide.length-1;

function chgimg(ergfun) {
	if(document.images) {
		num = num + ergfun;
		if(num > cnt) { num = 0; }
		if(num < 0) { num = cnt; }

		document.slideshow.src = slide[num];
	}
}

$('#last, #high, #low').click(function () {
  const sortType = $(this).attr('id');
  const gsId = "<?php echo $gs_id ?>";
  $('.rv-sort-item').removeClass('active');
  $.ajax({
    url: './reviewList.php',
    data: { sort: sortType, gs_id:gsId },
    success: function (data) {
      $('.rv-item-list').html(data);
      $(this).closest('.rv-sort-item').addClass('active');
      reviewMore();
    }.bind(this),
    error: function () {
      console.error('Error fetching reviews');
    }
  });
});

function reviewMore() {
  const reviewItem = $(".rv-item");
  const reviewConMoreBtn = $(".rv-content-wr .cont-more-btn");

  reviewItem.each(function(){
    let reviewCon = $(this).find(".content_in");
    let reviewConMore = $(this).find(".cont-more-btn");
    let reviewConMax = parseInt(reviewCon.css('max-height'));
    
    if(reviewCon.height() < reviewConMax) {
      reviewConMore.remove();
    }
  });
}

$(document).on('click', '.rv-content-wr .cont-more-btn', function() {
    $(this).siblings('.content').addClass('auto');
  });
</script>