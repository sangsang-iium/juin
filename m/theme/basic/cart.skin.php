<?php
if(!defined('_BLUEVATION_')) exit;
?>

<!-- 장바구니 시작 { -->
<script src="<?php echo BV_MJS_URL; ?>/shop.js"></script>

<!-- <div class="stit_txt">
	※ 총 <?php echo number_format($cart_count); ?>개의 상품이 담겨 있습니다.
</div> -->
<style>
  .btn-disabled {
    background-color: #ccc!important;
    cursor: not-allowed;
  }
</style>

<div id="sod_bsk">
	<form name="frmcartlist" id="sod_bsk_list" method="post" action="<?php echo $cart_action_url; ?>">

    <div class="cart-sec container">
      <!-- 2024-06-03 :  일반/정기 배송 탭 -->
      <div class="cart-regular-tab">
        <div class="regular-tab-item">
          <a href="/m/shop/cart.php?paytype=2" class="tab-btn <?php echo $paytype == "2" ? "active" : "" ?>">
            <span>
              <svg width="63" height="62" viewBox="0 0 63 62" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M57.8342 16.7087L38.4592 6.05242C38.1731 5.89503 37.8518 5.8125 37.5253 5.8125C37.1987 5.8125 36.8775 5.89503 36.5914 6.05242L17.2164 16.7087C16.9126 16.8759 16.6593 17.1216 16.4829 17.4202C16.3064 17.7187 16.2134 18.0591 16.2134 18.4059C16.2134 18.7527 16.3064 19.0931 16.4829 19.3917C16.6593 19.6902 16.9126 19.9359 17.2164 20.1032L35.5878 30.2072V50.9753L29.7055 47.7397L27.8378 51.1322L36.5914 55.9469C36.8775 56.1043 37.1987 56.1868 37.5253 56.1868C37.8518 56.1868 38.1731 56.1043 38.4592 55.9469L57.8342 45.2907C58.138 45.1235 58.3915 44.8778 58.568 44.5793C58.7446 44.2807 58.8377 43.9403 58.8378 43.5934V18.4059C58.8377 18.0591 58.7446 17.7186 58.568 17.4201C58.3915 17.1215 58.138 16.8758 57.8342 16.7087ZM37.5253 9.96229L52.88 18.4059L37.5253 26.8495L22.1706 18.4059L37.5253 9.96229ZM54.9628 42.4484L39.4628 50.9734V30.2053L54.9628 21.6803V42.4484Z" fill="#999999"/>
                <path d="M20.0879 31H4.58789V27.125H20.0879V31ZM23.9629 46.5H8.46289V42.625H23.9629V46.5ZM27.8379 38.75H12.3379V34.875H27.8379V38.75Z" fill="#999999"/>
              </svg>
            </span>
            <span>일반</span>
          </a>
        </div>
        <div class="regular-tab-item">
          <a href="/m/shop/cart.php?paytype=1" class="tab-btn <?php echo $paytype == "1" ? "active" : "" ?>">
            <span>
              <svg width="63" height="62" viewBox="0 0 63 62" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M51.0879 7.75H45.2754V5.8125C45.2754 5.29864 45.0713 4.80583 44.7079 4.44248C44.3446 4.07913 43.8517 3.875 43.3379 3.875C42.824 3.875 42.3312 4.07913 41.9679 4.44248C41.6045 4.80583 41.4004 5.29864 41.4004 5.8125V7.75H22.0254V5.8125C22.0254 5.29864 21.8213 4.80583 21.4579 4.44248C21.0946 4.07913 20.6017 3.875 20.0879 3.875C19.574 3.875 19.0812 4.07913 18.7179 4.44248C18.3545 4.80583 18.1504 5.29864 18.1504 5.8125V7.75H12.3379C11.3102 7.75 10.3246 8.15826 9.59785 8.88496C8.87115 9.61166 8.46289 10.5973 8.46289 11.625V50.375C8.46289 51.4027 8.87115 52.3883 9.59785 53.115C10.3246 53.8417 11.3102 54.25 12.3379 54.25H51.0879C52.1156 54.25 53.1012 53.8417 53.8279 53.115C54.5546 52.3883 54.9629 51.4027 54.9629 50.375V11.625C54.9629 10.5973 54.5546 9.61166 53.8279 8.88496C53.1012 8.15826 52.1156 7.75 51.0879 7.75ZM18.1504 11.625V13.5625C18.1504 14.0764 18.3545 14.5692 18.7179 14.9325C19.0812 15.2959 19.574 15.5 20.0879 15.5C20.6017 15.5 21.0946 15.2959 21.4579 14.9325C21.8213 14.5692 22.0254 14.0764 22.0254 13.5625V11.625H41.4004V13.5625C41.4004 14.0764 41.6045 14.5692 41.9679 14.9325C42.3312 15.2959 42.824 15.5 43.3379 15.5C43.8517 15.5 44.3446 15.2959 44.7079 14.9325C45.0713 14.5692 45.2754 14.0764 45.2754 13.5625V11.625H51.0879V19.375H12.3379V11.625H18.1504ZM51.0879 50.375H12.3379V23.25H51.0879V50.375ZM41.8024 29.6292C41.9826 29.8092 42.1255 30.0228 42.223 30.2581C42.3205 30.4933 42.3707 30.7454 42.3707 31C42.3707 31.2546 42.3205 31.5067 42.223 31.7419C42.1255 31.9772 41.9826 32.1908 41.8024 32.3708L30.1774 43.9958C29.9975 44.1759 29.7838 44.3188 29.5486 44.4163C29.3134 44.5138 29.0613 44.564 28.8066 44.564C28.552 44.564 28.2999 44.5138 28.0647 44.4163C27.8295 44.3188 27.6158 44.1759 27.4359 43.9958L21.6234 38.1833C21.2598 37.8197 21.0556 37.3266 21.0556 36.8125C21.0556 36.2984 21.2598 35.8053 21.6234 35.4417C21.9869 35.0782 22.48 34.8739 22.9941 34.8739C23.5083 34.8739 24.0014 35.0782 24.3649 35.4417L28.8066 39.8859L39.0609 29.6292C39.2408 29.4491 39.4545 29.3062 39.6897 29.2087C39.9249 29.1112 40.177 29.061 40.4316 29.061C40.6863 29.061 40.9384 29.1112 41.1736 29.2087C41.4088 29.3062 41.6225 29.4491 41.8024 29.6292Z" fill="white"/>
              </svg>
            </span>
            <span>정기</span>
          </a>
        </div>
        <!-- paytype == 3 | 렌탈 추가 _20240701_SY -->
        <div class="regular-tab-item">
          <a href="/m/shop/cart.php?paytype=3" class="tab-btn <?php echo $paytype == "3" ? "active" : "" ?>">
            <span>
              <svg width="63" height="62" viewBox="0 0 63 62" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M57.8342 16.7087L38.4592 6.05242C38.1731 5.89503 37.8518 5.8125 37.5253 5.8125C37.1987 5.8125 36.8775 5.89503 36.5914 6.05242L17.2164 16.7087C16.9126 16.8759 16.6593 17.1216 16.4829 17.4202C16.3064 17.7187 16.2134 18.0591 16.2134 18.4059C16.2134 18.7527 16.3064 19.0931 16.4829 19.3917C16.6593 19.6902 16.9126 19.9359 17.2164 20.1032L35.5878 30.2072V50.9753L29.7055 47.7397L27.8378 51.1322L36.5914 55.9469C36.8775 56.1043 37.1987 56.1868 37.5253 56.1868C37.8518 56.1868 38.1731 56.1043 38.4592 55.9469L57.8342 45.2907C58.138 45.1235 58.3915 44.8778 58.568 44.5793C58.7446 44.2807 58.8377 43.9403 58.8378 43.5934V18.4059C58.8377 18.0591 58.7446 17.7186 58.568 17.4201C58.3915 17.1215 58.138 16.8758 57.8342 16.7087ZM37.5253 9.96229L52.88 18.4059L37.5253 26.8495L22.1706 18.4059L37.5253 9.96229ZM54.9628 42.4484L39.4628 50.9734V30.2053L54.9628 21.6803V42.4484Z" fill="#999999"/>
                <path d="M20.0879 31H4.58789V27.125H20.0879V31ZM23.9629 46.5H8.46289V42.625H23.9629V46.5ZM27.8379 38.75H12.3379V34.875H27.8379V38.75Z" fill="#999999"/>
              </svg>
            </span>
            <span>렌탈</span>
          </a>
        </div>
      </div>
    </div>

    <?php if($cart_count) { ?>
    <div class="cart-sec container">
      <div id="sod_chk">
        <div class="frm-choice">
          <input type="checkbox" name="ct_all" value="1" id="ct_all" checked="checked">
          <label for="ct_all">전체상품 선택</label>
        </div>
        <button type="button" onclick="return form_check('seldelete');" class="select_del">선택삭제</button>
      </div>
    </div>
    <?php } ?>

    <div class="cart-sec noPadding">
      <div class="cp-cart">

        <?php
        $sql_group = "SELECT p.mb_id, p.index_no, p.sc_type,
                        SUM(IF(io_type = 1, (io_price * ct_qty),((io_price + ct_price) * ct_qty))) as price,
                        SUM(IF(io_type = 1, (0),(ct_point * ct_qty))) as point, SUM(IF(io_type = 1, (0),(ct_qty))) as qty,
                        SUM(io_price * ct_qty) as opt_price,
                        GROUP_CONCAT(a.gs_id) AS gs_idx
                      from shop_cart a
                      JOIN shop_goods p ON a.gs_id = p.index_no
                      where a.ct_direct = '{$set_cart_id}'
                      AND a.ct_select = '0'
                      AND a.reg_yn = '{$paytype}'
                      AND a.mb_id = '{$member['id']}'
                      GROUP BY p.mb_id, p.sc_type";
        $res_group = sql_query($sql_group);
        $groupNumRow = sql_num_rows($res_group);
        for ($z = 0; $rowG = sql_fetch_array($res_group); $z++) {
          $CARTGROUP[] = $rowG;
        }
        // print_r2($CARTGROUP);
        // $CARTGROUP = groupAndSortArray($CARTGROUP);
        $tot_point		= 0;
        $tot_sell_price = 0;
        $tot_opt_price	= 0;
        $tot_sell_qty	= 0;
        $tot_sell_amt	= 0;

        $preVal = null;
        $groupStarted = false;

        for($i=0; $row=sql_fetch_array($result); $i++) {
          $gs = get_goods($row['gs_id']);

          // 합계금액 계산
          $sql = " select
                  SUM(IF(io_type = 1, (io_price * ct_qty),((io_price + ct_price) * ct_qty))) as price,
                  SUM(IF(io_type = 1, (0),(ct_point * ct_qty))) as point,
                  SUM(IF(io_type = 1, (0),(ct_qty))) as qty,
                  SUM(io_price * ct_qty) as opt_price
                from shop_cart
                where gs_id = '$row[gs_id]'
                and ct_direct = '$set_cart_id'
                and ct_select = '0'";
          $sum = sql_fetch($sql);

          if($i==0) { // 계속쇼핑
            $continue_ca_id = $row['ca_id'];
          }

          $it_options = mobile_print_item_options($row['gs_id'], $set_cart_id);

          $point = $sum['point'];
          $sell_price = $sum['price'];
          $sell_opt_price = $sum['opt_price'];
          $sell_qty = $sum['qty'];
          $sell_amt = $sum['price'] - $sum['opt_price'];

          // 배송비
          if($gs['use_aff'])
            $sr = get_partner($gs['mb_id']);
          else
            $sr = get_seller_cd($gs['mb_id']);

          $info = get_item_sendcost($sell_price);
          $item_sendcost[] = $info['pattern'];

          $href = BV_MSHOP_URL.'/view.php?gs_id='.$row['gs_id'];

          $targetGs = $row['gs_id']; // 찾고자 하는 gs_id 값
          $targetId = $row['mb_id']; // 찾고자 하는 mb_id 값
          $filteredResults = array_filter($CARTGROUP, function ($item) use ($targetGs) {
            $indicesArray = explode(',', $item['gs_idx']);
            return in_array($targetGs, $indicesArray);
          });
          $filteredResults = array_values($filteredResults);

          $curVal = $gs['mb_id'];
          $sellerMinInfo = get_seller_cd($filteredResults[0]['mb_id']);
          if($filteredResults[0]['mb_id'] == 'admin'){
            $sellerMinInfo['company_name'] = "관리자";
            $sellerMinInfo['min_delivery'] = 50000;
          }

          $preSum = 0;
          if (($filteredResults[0]['mb_id'] == $gs['mb_id']) && ($filteredResults[0]['sc_type'] == 4)) {
            if ($preVal !== $curVal) {
              if ($groupStarted) {
                // 이전 그룹 div를 닫음
                echo "</div>";
                $groupStarted = false;
              }
              if($filteredResults[0]['price'] >= $sellerMinInfo['min_delivery']){
                $orderable_txt = '주문가능';
                $orderable_per = 100;
              } else {
                $orderable_amt = $sellerMinInfo['min_delivery'] - $filteredResults[0]['price'];
                $orderable_txt = '<span>' . number_format($orderable_amt) . '</span> 추가시 주문가능';
                $orderable_per = ($filteredResults[0]['price'] / $sellerMinInfo['min_delivery']) * 100;
              }

              // 새로운 그룹 시작
              echo '<div class="cart-gbox v">';
              echo '  <div class="cart-label v">';
              echo '    <div class="cart-label-img"></div>';
              echo '    <p class="cart-label-text">차량배송</p>';
              echo '  </div>';
              echo '  <div class="cart-process-bar-wr"> ';
              echo '    <div class="cart-process-top"> ';
              echo '      <p class="company">'.$sellerMinInfo['company_name'].'</p> ';
              echo '      <div class="available-price"> ';
              echo '        <p class="text01 odprice" data-minprice="'.$sellerMinInfo['min_delivery'].'" data-odprice="'.$filteredResults[0]['price'].'">(주문가능 금액 '.number_format($sellerMinInfo['min_delivery']).'원)</p> ';
              echo '        <p class="text02">'.$orderable_txt;
              echo '        </p> ';
              echo '      </div> ';
              echo '    </div> ';
              echo '    <div class="cart-process-bot"> ';
              echo '      <div class="cart-process-bar"> ';
              echo '        <span class="active-bar" data-orderper="'.$orderable_per.'" style="width: '.$orderable_per.'%;"></span> ';
              echo '      </div> ';
              echo '      <div class="cart-process-icon"> ';
              echo '        <img src="/src/img/cart-process-icon.png" alt=""> ';
              echo '      </div> ';
              echo '    </div> ';
              echo '  </div> ';
              $groupStarted = true;
            }
          } else {
            if ($groupStarted) {
              // 이전 그룹 div를 닫음
              echo "</div>";
              $groupStarted = false;
            }
          }


          // 항상 출력되는 부분
          // paytype == 3 | 렌탈 추가 _20240701_SY
          echo '<div class="cp-cart-item">';
          echo '<div class="cart-label g">';
          echo '<div class="cart-label-img"></div>';
          echo $paytype == "3" ? '<p class="cart-label-text">렌탈</p>' : '<p class="cart-label-text">일반배송</p>';
          echo '</div>';
          echo '<input type="hidden" name="gs_id[' . $i . ']" value="' . $row['gs_id'] . '">';
          echo '<div class="cp-cart-head">';
          echo '<div class="title">';
          echo '<div class="frm-choice">';
          echo '<label for="ct_chk_' . $i . '" class="sound_only">상품</label>';
          echo '<input type="checkbox" name="ct_chk[' . $i . ']" value="1" id="ct_chk_' . $i . '" checked="checked">';
          echo '<label for="ct_chk_' . $i . '"></label>';
          echo '</div>';
          echo '<p class="name">' . stripslashes($gs['gname']) . '</p>';
          echo '</div>';
          echo '<button type="button" class="delete ui-btn" onclick="remove_cartItem(' . $row['index_no'] . ')">닫기</button>';
          echo '</div>';
          echo '<div class="cp-cart-body">';
          echo '<div class="thumb round60">';
          echo '<a href="'.$href.'">';
          echo '<img src="' . get_it_image_url($row['gs_id'], $gs['simg1'], 140, 140) . '" alt="' . get_text($gs['gname']) . '" class="fitCover">';
          echo '</a>';
          echo '</div>';
          echo '<div class="content">';
          echo '<div class="count">';
          if ($it_options) {
            echo '<button type="button" id="mod_opt_' . $row['gs_id'] . '" class="mod_btn mod_options change ui-btn st3">옵션변경</button>';
          }
          echo '</div>';
          echo '<div class="info">';
          echo '<div class="set">';
          echo '<div>' . number_format($sell_qty) . '개</div>';
          if ($row['io_id']) {
            echo '<div>' . $it_options . '</div>';
          }
          echo '</div>';
          echo '<p class="price">' . display_price2($sell_price) . '</p>';
          echo '</div>';
          echo '</div>';
          echo '</div>';
          echo '</div>';
          $preVal = $curVal;

          $tot_point		+= $point;
          $tot_sell_price += $sell_price;
          $tot_opt_price	+= $sell_opt_price;
          $tot_sell_qty	+= $sell_qty;
          $tot_sell_amt	+= $sell_amt;

          if(!$is_member) {
            $tot_point = 0;
          }
          // if($rowG['sc_type'] == 4 && $gs['mb_id'] == $rowG['mb_id']){
          //   echo "</div>";
          // }
        } // for

        if ($groupStarted) {
          echo "</div>";
        }

        // 배송비 검사
        $send_cost = 0;
        $com_send_cost = 0;
        $sep_send_cost = 0;
        $max_send_cost = 0;

        if($i > 0) {
          $k = 0;
          $condition = array();
          foreach($item_sendcost as $key) {
            list($userid, $bundle, $price) = explode('|', $key);
            $condition[$userid][$bundle][$k] = $price;
            $k++;
          }

          $com_array = array();
          $val_array = array();
          foreach($condition as $key=>$value) {
            if($condition[$key]['묶음']) {
              $com_send_cost += array_sum($condition[$key]['묶음']); // 묶음배송 합산
              $max_send_cost += max($condition[$key]['묶음']); // 가장 큰 배송비 합산
              $com_array[] = max(array_keys($condition[$key]['묶음'])); // max key
              $val_array[] = max(array_values($condition[$key]['묶음']));// max value
            }
            if($condition[$key]['개별']) {
              $sep_send_cost += array_sum($condition[$key]['개별']); // 묶음배송불가 합산
              $com_array[] = array_keys($condition[$key]['개별']); // 모든 배열 key
              $val_array[] = array_values($condition[$key]['개별']); // 모든 배열 value
            }
          }

          $tune = get_tune_sendcost($com_array, $val_array);

          $send_cost = $com_send_cost + $sep_send_cost; // 총 배송비합계
          $tot_send_cost = $max_send_cost + $sep_send_cost; // 최종배송비
          $tot_final_sum = $send_cost - $tot_send_cost; // 배송비할인
          $tot_price = $tot_sell_price + $tot_send_cost; // 결제예정금액
        }

        if($i == 0) {
          echo '<div class="cp-cart-item empty">장바구니에 담긴 상품이 없습니다.</div>';
        }
        ?>
      </div>
    </div>

    <?php if($i > 0) { ?>
    <div class="cart-sec container">
      <dl id="sod_bsk_tot">
        <!-- <?php if($tot_send_cost > 0) { // 배송비가 0 보다 크다면 (있다면) ?>
        <dt class="sod_bsk_dvr"><span>배송비</span></dt>
        <dd class="sod_bsk_dvr"><strong><?php echo number_format($tot_send_cost); ?> 원</strong></dd>
        <?php } ?>

        <?php if($tot_price > 0) { ?>
        <dt class="sod_bsk_cnt"><span>총계</span></dt>
        <dd class="sod_bsk_cnt"><strong><?php echo number_format($tot_price); ?> 원</strong></dd>
        <dt><span>포인트</span></dt>
        <dd><strong><?php echo number_format($tot_point); ?> P</strong></dd>
        <?php } ?> -->
        <div class="info-list">
          <?php if($tot_price > 0) { ?>
          <div class="info-item">
            <p class="tit">총 상품금액</p>
            <p class="cont"><?php echo display_price2($tot_price); ?></p>
          </div>
          <div class="info-item">
            <p class="tit">총 할인금액</p>
            <p class="cont">0</p>
          </div>
          <?php } ?>
          <?php //if($tot_send_cost > 0) { ?>
          <div class="info-item">
            <p class="tit">총 배송비</p>
            <p class="cont"><?php echo display_price2($tot_send_cost); ?></p>
          </div>
          <?php //} ?>
          <div class="info-item main-color">
            <p class="tit">결제예상금액</p>
            <p class="cont"><?php echo display_price2($tot_price); ?></p>
          </div>
        </div>
        <p class="bsk-caption">
          장바구니에 담긴 상품은 30일 동안 보관됩니다. <br>최대 100개의 상품까지 보관되며, 100개 초과 시 장바구니 담긴 순으로 자동 삭제됩니다.
        </p>
      </dl>
    </div>
    <?php } ?>

    <div id="sod_bsk_act" class="btn_confirm">
      <div class="container">
        <?php if($i == 0) { ?>
        <a href="<?php echo BV_MURL; ?>" class="btn_medium btn-buy">쇼핑 계속하기</a>
        <?php } else { ?>
        <input type="hidden" name="url" value="<?php echo BV_MSHOP_URL; ?>/orderform.php">
        <input type="hidden" name="act" value="">
        <input type="hidden" name="records" value="<?php echo $i; ?>">
        <!-- <a href="<?php echo BV_MSHOP_URL; ?>/list.php?ca_id=<?php echo $continue_ca_id; ?>" class="btn_medium bx-black">쇼핑 계속하기</a> -->
        <button type="button" onclick="return form_check('buy');" class="btn_medium btn-buy">
          <p class="price">
            <?php // echo display_price2($tot_price); ?>
            <span class="txt"> <?php echo $paytype == '3' ? "신청하기" : "구매하기" ?></span>
          </p>
        </button>
        <!-- <div><button type="button" onclick="return form_check('seldelete');" class="btn01">선택삭제</button>
        <button type="button" onclick="return form_check('alldelete');" class="btn01">비우기</button></div> -->
        <?php if($naverpay_button_js) { ?>
        <div class="naverpay-cart"><?php echo $naverpay_request_js.$naverpay_button_js; ?></div>
        <?php } ?>
        <?php } ?>
      </div>
    </div>
  </form>
</div>

<script>
  function checkOrderValues() {
    const cartGboxes = document.querySelectorAll('.cart-gbox');
    let shouldDisableButton = false;

    cartGboxes.forEach(gbox => {
      const cartItems = gbox.querySelectorAll('.cp-cart-item');
      let totalCheckedPrice = 0;
      let anyChecked = false;

      cartItems.forEach(cart => {
        const checkbox = cart.querySelector('input[type="checkbox"]');
        const priceEl = cart.querySelector('.spr');
        if (checkbox && checkbox.checked && priceEl) {
          const price = parseInt(priceEl.textContent.replace(/[^0-9]/g, ''), 10);
          totalCheckedPrice += price;
          anyChecked = true;
        }
      });

      const odPriceEl = gbox.querySelector('.odprice');
      const orderLimit = parseInt(odPriceEl.getAttribute('data-minprice'), 10);

      if (totalCheckedPrice < orderLimit && anyChecked) {
        shouldDisableButton = true;
      }
    });

    const buyButton = document.querySelector('.btn-buy');
    if (shouldDisableButton) {
      buyButton.disabled = true;
      buyButton.classList.add('btn-disabled');
    } else {
      buyButton.disabled = false;
      buyButton.classList.remove('btn-disabled');
    }
  }

  function setupCheckboxListeners() {
    const checkboxes = document.querySelectorAll('.cp-cart-item input[type="checkbox"]');
    checkboxes.forEach(checkbox => {
      checkbox.addEventListener('change', checkOrderValues);
    });
  }

  // 초기 로드 시 실행
  document.addEventListener('DOMContentLoaded', () => {
      checkOrderValues();
      setupCheckboxListeners();
  });


$(function() {
    var close_btn_idx;

    // 선택사항수정
    $(".mod_options").click(function() {
        var gs_id = $(this).attr("id").replace("mod_opt_", "");
        var $this = $(this);
        close_btn_idx = $(".mod_options").index($(this));

        $.post(
            "./cartoption.php",
            // { gs_id: gs_id },
            { gs_id: gs_id, paytype: <?php echo $paytype?> },
            function(data) {
                $("#mod_option_frm").remove();
                $this.after("<div id=\"mod_option_frm\" class=\"layer-bg\"></div>");
                $("#mod_option_frm").html(data);
                price_calculate();
            }
        );
    });

    // 모두선택
    $("input[name=ct_all]").click(function() {
        if($(this).is(":checked"))
            $("input[name^=ct_chk]").attr("checked", true);
        else
            $("input[name^=ct_chk]").attr("checked", false);
    });

    // 옵션수정 닫기
    $(document).on("click", "#mod_option_close", function() {
        $("#mod_option_frm").remove();
        $("#win_mask, .window").hide();
        $(".mod_options").eq(close_btn_idx).focus();
    });
    $("#win_mask").click(function () {
        $("#mod_option_frm").remove();
        $("#win_mask").hide();
        $(".mod_options").eq(close_btn_idx).focus();
    });

});

function fsubmit_check(f) {
    if($("input[name^=ct_chk]:checked").size() < 1) {
        alert("구매하실 상품을 하나이상 선택해 주십시오.");
        return false;
    }

    return true;
}

function form_check(act) {
    var f = document.frmcartlist;
    var cnt = f.records.value;

    if(act == "buy")
    {
		if($("input[name^=ct_chk]:checked").size() < 1) {
			alert("주문하실 상품을 하나이상 선택해 주십시오.");
			return false;
		}

        f.act.value = act;
        f.submit();
    }
    else if(act == "alldelete")
    {
        f.act.value = act;
        f.submit();
    }
    else if(act == "seldelete")
    {
        if($("input[name^=ct_chk]:checked").size() < 1) {
            alert("삭제하실 상품을 하나이상 선택해 주십시오.");
            return false;
        }

        f.act.value = act;
        f.submit();
    }

    return true;
}

// 장바구니 개별 삭제 _20240312_SY
function remove_cartItem(e) {

  var form = document.createElement('form');
  form.method = 'POST';
  form.action = bv_url + '/m/shop/cartupdate.php';


  var actInput = document.createElement('input');
  actInput.type = 'hidden';
  actInput.name = 'act';
  actInput.value = 'deleteItem';
  form.appendChild(actInput);

  var indexNoInput = document.createElement('input');
  indexNoInput.type = 'hidden';
  indexNoInput.name = 'index_no';
  indexNoInput.value = e;
  form.appendChild(indexNoInput);

  document.body.appendChild(form);

  form.submit();
}
</script>
<!-- } 장바구니 끝 -->
