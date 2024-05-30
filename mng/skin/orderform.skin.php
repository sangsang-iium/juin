<?php
if(!defined("_BLUEVATION_")) exit; // 개별 페이지 접근 불가
include_once BV_PLUGIN_PATH . '/jquery-ui/datepicker.php';

require_once(BV_SHOP_PATH.'/settle_kakaopay.inc.php');
?>
<script>
  function cp_submit2() {
    var f = document.flist;
    var tot_price = 0;
    var tot_price = document.buyform.tot_price.value;

    if(f.sum_dc_amt.value == 0 || !f.sum_dc_amt.value) {
      alert("상품에 쿠폰을 선택해주세요.");
      return false;
    }

    if(parseInt(no_comma(tot_price)) < f.sum_dc_amt.value) {
      alert("쿠폰 할인 금액이 결제금액을 초과하였습니다.");
      return false;
    }

    if(!confirm("쿠폰적용을 하시겠습니까?"))
      return false;


    var tmp_dc_amt	= '';
    var tmp_lo_id	= '';
    var tmp_cp_id	= '';
    var chk_dc_amt	= '';
    var chk_lo_id	= '';
    var chk_cp_id	= '';
    var comma		= '';
    for(i = 0; i < max_layer; i++) {
      chk_dc_amt	= eval("f.gd_dc_amt_"+i).value ? eval("f.gd_dc_amt_"+i).value : 0;
      chk_lo_id   = eval("f.gd_cp_idx_"+i).value ? eval("f.gd_cp_idx_"+i).value : 0;
      chk_cp_id	= eval("f.gd_cp_no_"+i).value ? eval("f.gd_cp_no_"+i).value : 0;

      tmp_dc_amt += comma + chk_dc_amt;
      tmp_lo_id  += comma + chk_lo_id;
      tmp_cp_id  += comma + chk_cp_id;
      comma = '|';
    }

    // 로그
    document.buyform.coupon_price.value = tmp_dc_amt;
    document.buyform.coupon_lo_id.value = tmp_lo_id;
    document.buyform.coupon_cp_id.value = tmp_cp_id;

    // 총 할인액
    document.buyform.coupon_total.value = f.sum_dc_amt.value;
    document.getElementById("dc_amt").innerText = number_format(String(f.sum_dc_amt.value));
    document.getElementById("totdc_amt").innerText = number_format(String(f.sum_dc_amt.value));
    document.getElementById("cpdc_amt").innerText = number_format(String(f.sum_dc_amt.value));
    //document.getElementById("dc_cancel").style.display = "";
    //document.getElementById("dc_coupon").style.display = "none";

    tot_price = parseInt(no_comma(tot_price)) - f.sum_dc_amt.value;

    // 최종 결제금액
    document.buyform.tot_price.value = number_format(String(tot_price));
    $(".pop-content-in").empty();
    $("#coupon-popup").hide();

    $(".popDim").fadeOut(200);
  }

</script>

<style>
#document {width: 100%; box-shadow: none;}

#header {border-bottom: 1px solid #ddd;}
#hd_inner {
  width: 1400px;
  max-width: 100%;
  margin: 0 auto;
}
#hd_inner .hd_logo {
  width: 100px;
  height: 100px;
  line-height: 100px;
}
#hd_inner .hd_logo a {
  display: block;
  vertical-align: middle;
}
#hd_inner .hd_logo img {
    max-width: 100%;
}

#contents {width: 1400px; max-width: 100%; margin: 0 auto !important;}

#buyform .btn_confirm {position: inherit; bottom: inherit; left: inherit; box-shadow: none;}

#sod_frm_pay .sod_frm_pay_ul {display: flex; flex-flow: row wrap; gap: 10px 20px;}
#sod_frm .odf_tbl table tbody td,
#sod_frm .odf_tbl table tbody th {font-size: 1.8rem; border: 1px solid #ddd}
</style>

<div id="header">
  <div id="hd">
    <div id="hd_inner">
      <h1 class="hd_logo">
        <a href="/mng/">
          <img src="/img/logo.png" alt="주인장">
        </a>
      </h1>
    </div>
  </div>
</div>

<div id="contents" class="sub-contents prodOrder">
  <div id="sod_approval_frm">
    <?php
    ob_start();
    ?>
    <div class="cp-cart order">
      <?php
      $tot_point = 0;
      $tot_sell_price = 0;
      $tot_opt_price = 0;
      $tot_sell_qty = 0;
      $tot_sell_amt = 0;
      $seller_id = array();

      $sql = " select *
            from shop_cart
            where index_no IN ({$ss_cart_id})
            and ct_select = '0'
            group by gs_id
            order by index_no ";
      $result = sql_query($sql);
      for($i=0; $row=sql_fetch_array($result); $i++) {
        $gs = get_goods($row['gs_id']);

        // 합계금액 계산
        $sql = " select SUM(IF(io_type = 1, (io_price * ct_qty), ((io_price + ct_price) * ct_qty))) as price,
                SUM(IF(io_type = 1, (io_supply_price * ct_qty), ((io_supply_price + ct_supply_price) * ct_qty))) as supply_price,
                SUM(IF(io_type = 1, (0),(ct_point * ct_qty))) as point,
                SUM(IF(io_type = 1, (0),(ct_qty))) as qty,
                SUM(io_price * ct_qty) as opt_price
              from shop_cart
              where gs_id = '$row[gs_id]'
              and ct_direct = '$set_cart_id'
              and ct_select = '0'";
        $sum = sql_fetch($sql);

        $it_name = stripslashes($gs['gname']);
        $it_options = mobile_print_item_options($row['gs_id'], $set_cart_id);

        $point = $sum['point'];
        $supply_price = $sum['supply_price'];
        $sell_price = $sum['price'];
        $sell_opt_price = $sum['opt_price'];
        $sell_qty = $sum['qty'];
        $sell_amt = $sum['price'] - $sum['opt_price'];

        // 회원이 아니면 포인트초기화
        if(!$is_member) $point = 0;

        // 배송비
        if($gs['use_aff'])
          $sr = get_partner($gs['mb_id']);
        else
          $sr = get_seller_cd($gs['mb_id']);

        $info = get_item_sendcost($sell_price);
        $item_sendcost[] = $info['pattern'];

        $seller_id[$i] = $gs['mb_id'];

        $href = BV_MSHOP_URL.'/view.php?gs_id='.$row['gs_id'];
      ?>

      <div class="cp-cart-item">
        <input type="hidden" name="gs_id[<?php echo $i; ?>]" value="<?php echo $row['gs_id']; ?>">
        <input type="hidden" name="gs_notax[<?php echo $i; ?>]" value="<?php echo $gs['notax']; ?>">
        <input type="hidden" name="gs_price[<?php echo $i; ?>]" value="<?php echo $sell_price; ?>">
        <input type="hidden" name="seller_id[<?php echo $i; ?>]" value="<?php echo $gs['mb_id']; ?>">
        <input type="hidden" name="supply_price[<?php echo $i; ?>]" value="<?php echo $supply_price; ?>">
        <input type="hidden" name="sum_point[<?php echo $i; ?>]" value="<?php echo $point; ?>">
        <input type="hidden" name="sum_qty[<?php echo $i; ?>]" value="<?php echo $sell_qty; ?>">
        <input type="hidden" name="cart_id[<?php echo $i; ?>]" value="<?php echo $row['od_no']; ?>">

        <div class="cp-cart-body">
          <div class="thumb round60">
            <img src="<?php echo get_it_image_url($row['gs_id'], $gs['simg1'], $default['de_item_medium_wpx'], $default['de_item_medium_hpx']); ?>" alt="<?php echo get_text($gs['gname']); ?>" class="fitCover">
          </div>
          <div class="content">
            <p class="name"><?php echo $it_name; ?></p>
            <div class="info">
              <div class="set">
                <div><?php echo number_format($sell_qty).'개'; ?></div>
                <?php if($row['io_id']) { ?>
                <div>
                  <?php echo $it_options; ?>
                </div>
                <?php } ?>
              </div>
              <p class="price"><?php echo number_format($row['ct_price']); ?>원<span class="dc-price"><?php echo number_format('99999'); ?>원</span></p>
            </div>
          </div>
        </div>
      </div>

      <!-- 기존소스 {
      <li class="sod_li">
        <input type="hidden" name="gs_id[<?php //echo $i; ?>]" value="<?php //echo $row['gs_id']; ?>">
        <input type="hidden" name="gs_notax[<?php //echo $i; ?>]" value="<?php //echo $gs['notax']; ?>">
        <input type="hidden" name="gs_price[<?php //echo $i; ?>]" value="<?php //echo $sell_price; ?>">
        <input type="hidden" name="seller_id[<?php //echo $i; ?>]" value="<?php //echo $gs['mb_id']; ?>">
        <input type="hidden" name="supply_price[<?php //echo $i; ?>]" value="<?php //echo $supply_price; ?>">
        <input type="hidden" name="sum_point[<?php //echo $i; ?>]" value="<?php //echo $point; ?>">
        <input type="hidden" name="sum_qty[<?php //echo $i; ?>]" value="<?php //echo $sell_qty; ?>">
        <input type="hidden" name="cart_id[<?php //echo $i; ?>]" value="<?php //echo $row['od_no']; ?>">

        <div class="li_name">
          <?php //echo $it_name; ?>
          <div class="li_mod" style="padding-left:100px;"></div>
          <span class="total_img"><?php //echo get_it_image($row['gs_id'], $gs['simg1'], 80, 80); ?></span>
        </div>
        <div class="li_prqty">
          <span class="prqty_price li_prqty_sp"><span>판매가</span>
            <?php //echo number_format($sell_amt); ?></span>
          <span class="prqty_qty li_prqty_sp"><span>수량</span>
            <?php //echo number_format($sell_qty); ?></span>
          <span class="prqty_sc li_prqty_sp"><span>배송비</span>
            <?php //echo number_format($info['price']); ?></span>
        </div>
        <div class="li_total">
          <span class="total_price total_span"><span>소계</span>
            <strong><?php //echo number_format($sell_price); ?></strong></span>
          <span class="total_point total_span"><span>적립포인트</span>
            <strong><?php //echo number_format($point); ?></strong></span>
        </div>
      </li>
      } 기존소스 -->

      <?php
        $tot_point += (int)$point;
        $tot_sell_price += (int)$sell_price;
        $tot_opt_price += (int)$sell_opt_price;
        $tot_sell_qty += (int)$sell_qty;
        $tot_sell_amt += (int)$sell_amt;
      } // for 끝

      // 배송비 검사
      $send_cost = 0;
      $com_send_cost = 0;
      $sep_send_cost = 0;
      $max_send_cost = 0;

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

      $baesong_price = get_tune_sendcost($com_array, $val_array);

      $send_cost = $com_send_cost + $sep_send_cost; // 총 배송비합계
      $tot_send_cost = $max_send_cost + $sep_send_cost; // 최종배송비
      $tot_final_sum = $send_cost - $tot_send_cost; // 배송비할인
      $tot_price = $tot_sell_price + $tot_send_cost; // 결제예정금액

      if($i == 0) {
        alert('장바구니가 비어 있습니다.', BV_MSHOP_URL.'/cart.php');
      }
      ?>
    </div>

    <!--
    <dl id="sod_bsk_tot">
      <dt class="sod_bsk_sell"><span>주문</span></dt>
      <dd class="sod_bsk_sell"><strong><?php echo number_format($tot_sell_price); ?> 원</strong></dd>
      <dt class="sod_bsk_dvr"><span>배송비</span></dt>
      <dd class="sod_bsk_dvr"><strong><?php echo number_format($tot_send_cost); ?> 원</strong></dd>
      <dt class="sod_bsk_cnt"><span>총계</span></dt>
      <dd class="sod_bsk_cnt"><strong><?php echo number_format($tot_price); ?> 원</strong></dd>
      <dt class="sod_bsk_point"><span>포인트</span></dt>
      <dd class="sod_bsk_point"><strong><?php echo number_format($tot_point); ?> P</strong></dd>
    </dl>
    -->

    <?php
    $content = ob_get_contents();
    ob_end_clean();

    $sql_card = "SELECT * FROM iu_card_reg WHERE mb_id = '{$member['id']}' AND cr_use = 'Y'";
    $row_card = sql_fetch($sql_card);
    ?>
  </div>

  <!-- 주문서작성 시작 { -->
  <div id="sod_frm">
    <form name="buyform" id="buyform" method="post" action="<?php echo $order_action_url; ?>"
      onsubmit="return fbuyform_submit(this);" autocomplete="off">
      <input type="hidden" name="ss_cart_id" value="<?php echo $ss_cart_id; ?>">
      <input type="hidden" name="mb_point" value="<?php echo $member['point']; ?>">
      <input type="hidden" name="card_id" value="<?php echo $row_card['idx'] ?>">
      <input type="hidden" name="pt_id" value="<?php echo $mb_recommend; ?>">
      <input type="hidden" name="shop_id" value="<?php echo $pt_id; ?>">
      <input type="hidden" name="coupon_total" value="0">
      <input type="hidden" name="coupon_price" value="">
      <input type="hidden" name="coupon_lo_id" value="">
      <input type="hidden" name="coupon_cp_id" value="">
      <input type="hidden" name="baesong_price" value="<?php echo $baesong_price; ?>">
      <input type="hidden" name="baesong_price2" value="0">
      <input type="hidden" name="org_price" value="<?php echo $tot_price; ?>">
      <?php if(!$is_member || !$config['usepoint_yes']) { ?>
      <input type="hidden" name="use_point" value="0">
      <?php } ?>
      <input type="hidden" name="resulturl" value="pc">
      <?php
        if($gs['reg_yn'] == 1) {
      ?>

      <!-- 정기배송 주문 추가 -->
      <input type="hidden" name="reg_yn" value="<?php echo $gs['reg_yn'] ?>">
      <div class="bottomBlank">
        <div class="container">
          <div class="arcodianBtn od-top active">
            <button type="button" class="ui-btn od-toggle-btn">
              <span class="od-tit">주문자정보</span>
            </button>
          </div>

          <div class="od-ct info-list">
            <div class="info-item">
              <p class="tit">배송요일</p>
              <label><input type="checkbox" name="od_wday1" value="월" > 월</label>
              <label><input type="checkbox" name="od_wday2" value="화" > 화</label>
              <label><input type="checkbox" name="od_wday3" value="수" > 수</label>
              <label><input type="checkbox" name="od_wday4" value="목" > 목</label>
              <label><input type="checkbox" name="od_wday5" value="금" > 금</label>
              <label><input type="checkbox" name="od_wday6" value="토" > 토</label>
            </div>
            <div class="info-item">
              <p class="tit">배송요일</p>
              <select name="od_week" id="od_week" require>
                <option value="1">1주</option>
                <option value="2">2주</option>
                <option value="3">3주</option>
                <option value="4">4주</option>
              </select>
            </div>
            <div class="info-item">
              <p class="tit">배송횟수</p>
              <select name="od_reg_cnt" id="od_reg_cnt" require>
                <option value="2">2회</option>
                <option value="4">4회</option>
                <option value="6">6회</option>
                <option value="8">8회</option>
                <option value="10">10회</option>
                <option value="12">12회</option>
              </select>
            </div>
            <div class="info-item">
              <p class="tit">첫 배송 시점</p>
              <input type="text" name="od_begin_date" value="" id="od_begin_date" class="frm_input w100 " maxlength="10" require>
            </div>

          </div>
        </div>
      </div>
      <script>
      $(function(){
        $('#od_begin_date').datepicker({
          changeMonth: true,
          changeYear: true,
          dateFormat: "yy-mm-dd",
          showButtonPanel: true,
          yearRange: "-99:c+99",
          minDate: '-0d',
          changeMonth: true,
          onSelect: function(selectedDate) {
            var currentDate = $.datepicker.formatDate('yy-mm-dd', new Date()); // 현재 날짜
            // 선택된 날짜가 오늘 날짜보다 과거인 경우
            if (selectedDate < currentDate) {
              alert('미래 날짜만 선택할 수 있습니다.');
              $('#od_begin_date').val(''); // 입력 필드를 비움
            }
          }
        });
      });
      </script>
      <?php } ?>

      <!-- 주문자 기본 정보 추가 _20240412_SY -->
      <div class="bottomBlank">
        <div class="container">
          <div class="arcodianBtn od-top active">
            <button type="button" class="ui-btn od-toggle-btn">
              <span class="od-tit">주문자정보</span>
            </button>
          </div>

          <div class="od-ct info-list">
            <div class="info-item">
              <p class="tit">회원명</p>
              <input type="text" name="ju_restaurant" value="<?php echo $member['ju_restaurant'] ?>" class="w-per50 frm-input">
            </div>
            <div class="info-item">
              <p class="tit">대표자명</p>
              <input type="text" name="name" value="<?php echo $member['name'] ?>" class="w-per50 frm-input">
            </div>
            <div class="info-item">
              <p class="tit">사업자번호</p>
              <input type="text" name="ju_b_num" value="<?php echo $member['ju_b_num'] ?>" class="w-per50 frm-input" <?php echo ($is_member) ? "readonly" : ""?> >
            </div>
            <div class="info-item">
              <p class="tit">연락처</p>
              <input type="text" name="cellphone" value="<?php echo $member['cellphone'] ?>" class="w-per50 frm-input">
              <input type="hidden" name="telephone" value="<?php echo $member['cellphone'] ?>">
            </div>
          </div>
        </div>
      </div>

      <div id="od-dtn" class="bottomBlank">
        <div class="container">
          <div class="arcodianBtn od-top active">
            <button type="button" class="ui-btn od-toggle-btn">
              <span class="od-tit">배송지</span>
            </button>
          </div>

          <input type="hidden" name="b_name"      class="frm_input required od-dtn__contact">
          <input type="hidden" name="b_cellphone" class="frm_input required od-dtn__contact">
          <input type="hidden" name="b_telephone" class="frm_input od-dtn__contact">
          <input type="hidden" name="b_zip"       class="frm_input required od-dtn__contact">
          <input type="hidden" name="b_addr1"     class="frm_input frm_address required od-dtn__contact">
          <input type="hidden" name="b_addr2"     class="frm_input frm_address od-dtn__contact">
          <input type="hidden" name="b_addr3"     class="frm_input frm_address od-dtn__contact">
          <input type="hidden" name="b_addr_jibeon" value="">

          <!-- <section id="sod_frm_taker" style="display:none">
            <h2 class="anc_tit">받으시는 분</h2>
            <div class="odf_tbl">
              <table>
                <tbody>
                  <tr>
                    <th style="display:none">배송지선택</th>
                    <td style="display:none">
                      <input type="radio" name="ad_sel_addr" value="1" id="sel_addr1" class="css-checkbox lrg">
                      <label for="sel_addr1" class="css-label padr5">주문자와 동일</label><br>
                      <input type="radio" name="ad_sel_addr" value="2" id="sel_addr2" class="css-checkbox lrg">
                      <label for="sel_addr2" class="css-label">신규배송지</label>
                      <?php //if($is_member) { ?>
                      <br><input type="radio" name="ad_sel_addr" value="3" id="sel_addr3" class="css-checkbox lrg">
                      <label for="sel_addr3" class="css-label">배송지목록</label>
                      <?php //} ?>
                    </td>
                  </tr>
                  <tr>
                                    <th scope="row">이름</th>
                    <td>
                      <input type="text" name="b_name"  class="frm_input required od-dtn__contact"  placeholder="이름">
                      <span class="tags1">기본배송지</span>

                      <span class="od-dtn-btns">
                        <button type="button" class="ui-btn st3 od-dtn__change">변경</button>
                      </span>
                    </td>
                  </tr>
                  <tr>
                             <th scope="row">핸드폰</th>
                    <td><input type="text" name="b_cellphone"  class="frm_input required od-dtn__contact" placeholder="핸드폰"></td>
                  </tr>
                  <tr>
                                    <th scope="row">전화번호</th>
                    <td><input type="text" name="b_telephone" class="frm_input od-dtn__contact" placeholder="전화번호"></td>
                  </tr>
                  <tr>
                             <th scope="row">주소</th>
                    <td>
                      <input type="text" name="b_zip"  class="frm_input required od-dtn__contact" size="5" maxlength="5" placeholder="우편번호">
                      <button type="button"
                        onclick="win_zip('buyform', 'b_zip', 'b_addr1', 'b_addr2', 'b_addr3', 'b_addr_jibeon');"
                        class="btn_ btn_search" style="padding:0.8rem">주소검색</button><br>
                      <input type="text" name="b_addr1"  class="frm_input frm_address required od-dtn__contact"><br>
                      <input type="text" name="b_addr2" class="frm_input frm_address od-dtn__contact"><br>
                      <input type="text" name="b_addr3" class="frm_input frm_address od-dtn__contact" readonly><br>
                      <input type="hidden" name="b_addr_jibeon" value="">
                    </td>
                  </tr>
                  <tr>
                                    <th scope="row">전하실말씀</th>
                    <td>
                      <select name="sel_memo" class="wfull">
                        <option value="">요청사항 선택하기</option>
                        <option value="부재시 경비실에 맡겨주세요.">부재시 경비실에 맡겨주세요</option>
                        <option value="빠른 배송 부탁드립니다.">빠른 배송 부탁드립니다.</option>
                        <option value="부재시 핸드폰으로 연락바랍니다.">부재시 핸드폰으로 연락바랍니다.</option>
                        <option value="배송 전 연락바랍니다.">배송 전 연락바랍니다.</option>
                      </select>
                      <div class="padt5">
                        <textarea name="memo" id="memo" class="frm_textbox od-dtn__contact" placeholder="전하실말씀을 작성해주십시요"></textarea>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </section> -->
          <!-- } 주문자 및 수령자 기본형식 -->


          <div class="od-ct">
            <div class="od-dtn-info">
              <?php // 배송지 수정 _20240503_SY
                $mb_id = $member['id'];
                $addr1 = '';
                $cellphone = '';
                $msg = '';

                    $sqlb_address = "select * from b_address where mb_id='$mb_id'  and b_base='1' ";
                    $res = sql_fetch($sqlb_address);
                    if($res['b_base'] == '1'){
                      $msg = "<span class='tag'>기본배송지</span></p>";
                      $addr1 = print_address($res['b_addr1'], $res['b_addr2'], $res['b_addr3'], $res['b_addr_jibeon']);
                      $cellphone = $res['b_cellphone'];
                    } else if($res['b_base'] == '0') {
                      $msg = "<br/>변경 버튼을 눌러 기본 배송지를 설정해 주십시요";
                    } else {
                      if(!empty($member['addr1'])) {
                        $addr1 = print_address($member['addr1'], $member['addr2'], $member['addr3'], '');
                        $cellphone = $member['cellphone'];
                      } else if(!empty($member['ju_addr_full'])) {
                        $addr1 = $member['ju_addr_full'];
                        $cellphone = $member['cellphone'];
                      } else {
                        $msg = "<br/>변경 버튼을 눌러 기본 배송지를 설정해 주십시요";
                      }
                    }
                ?>
                  <p class="od-dtn__name">
                    <span class="nm"><?php echo $member['name']; ?></span>
                <?php echo $msg; ?>
                <p class="od-dtn__addr"><?php echo $addr1 ?></p>
                <p class="od-dtn__contact"><?php echo $cellphone; ?></p>
            </div>

            <input type="hidden" name="email" value="<?php echo $member['email']; ?>" >
            <input type="hidden" name="zip"   value="<?php echo !empty($addr1) ? "" : $member['zip']; ?>" >
            <input type="hidden" name="addr1" value="<?php echo $addr1; ?>" >
            <input type="hidden" name="addr2" value="<?php echo !empty($addr1) ? "" : $member['addr2']; ?>" >
            <input type="hidden" name="addr3" value="<?php echo !empty($addr1) ? "" : $member['addr3']; ?>" >
            <input type="hidden" name="addr_jibeon" value="<?php echo !empty($addr1) ? "" : $member['addr_jibeon']; ?>">


            <div class="od-dtn-btns">
              <button type="button" class="ui-btn st3 od-dtn__change">변경</button>
            </div>
          </div>

          <!-- 배송요청사항 추가 _20240507_SY -->
          <div class="od-ct">
            <div class="od-dtn-info">
              <div class="info-item">
                <p class="tit">배송요청사항</p>
                <input type="text" name="b_addr_req" value="<?php echo $b_addr_req?>" class="w-per50 frm-input">
              </div>
            </div>
          </div>
        </div>
      </div>

      <div id="od-prod" class="bottomBlank">
        <div class="container">
          <div class="arcodianBtn od-top active">
            <button type="button" class="ui-btn od-toggle-btn">
              <span class="od-tit">주문상품</span>
            </button>
          </div>
          <div class="od-ct">
            <?php echo $content; ?>
          </div>
        </div>
      </div>

      <div id="od-benf" class="bottomBlank">
        <div class="container">
          <div class="arcodianBtn od-top active">
            <button type="button" class="ui-btn od-toggle-btn">
              <span class="od-tit">할인/혜택적용</span>
            </button>
          </div>
          <div class="od-ct">
            <div class="od-benf-fm">
              <?php
              if($is_member && $config['coupon_yes']) { // 보유쿠폰
                $sp_count = get_cp_precompose($member['id']);
              ?>
              <div class="form-row">
                <div class="form-head">
                  <p class="title">쿠폰할인 <span>(보유쿠폰 : <?php echo $sp_count[3]; ?>장)</span></p>
                </div>
                <div class="form-body">
                  <span id="dc_coupon">

<!--                    <a href="javascript:window.open('<?php echo BV_MSHOP_URL; ?>/ordercoupon.php');" class="ui-btn st2">사용 가능 쿠폰</a>-->
                    <a href="javascript:(0)" class="ui-btn st2 couponopen">사용 가능 쿠폰</a>

                  </span>
                  <span id="dc_amt">0원
                    <span id="dc_cancel" style="display:none;">
                      <a href="javascript:coupon_cancel();" class="btn_small grey">&nbsp;삭제</a>
                    </span>
                  </span>
                </div>
              </div>
              <?php } ?>

              <?php if($is_member && $config['usepoint_yes']) { ?>
              <div class="form-row">
                <div class="form-head">
                  <p class="title">적립금 사용 <span>(보유적립금 : <?php echo display_point($member['point']); ?>)</span></p>
                </div>
                <div class="form-body">
                  <input type="text" name="use_point" id="use_point" value="0" class="w-per100 frm-input" onkeyup="calculate_temp_point(this.value); this.value=number_format(this.value);">
                  <div class="form-itxt">
                    <p><?php echo display_point($config['usepoint']); ?> 부터 사용가능</p>
                  </div>
                  <div class="od-esPoint">
                    <span class="t1">구매시 예상 적립금</span>
                    <span class="t2"><?php echo number_format($tot_point); ?>원</span>
                  </div>
                  <div class="form-itxt">
                    <p>예상 적립금은 최종 결제 금액에서 사용하신 적립금을 제외한 결제금액을 기준으로 지급됩니다.</p>
                    <p>구매확정 이후 적립될 적립금은 해당 예상 적립금 내역과 상이할 수 있습니다.</p>
                  </div>
                </div>
              </div>
              <?php } ?>
            </div>
          </div>
        </div>
      </div>

      <div id="od-prc" class="bottomBlank">
        <div class="container">
          <div class="arcodianBtn od-top active">
            <button type="button" class="ui-btn od-toggle-btn">
              <span class="od-tit">결제금액</span>
            </button>
          </div>
          <div class="od-ct">
            <ul class="prc-tot">
              <li>
                <span class="lt-txt">총 상품금액</span>
                <span class="rt-txt"><?php echo number_format($tot_sell_price) ?>원</span>
              </li>
              <li>
                <span class="lt-txt">배송비</span>
                <span class="rt-txt"><?php echo number_format($tot_send_cost) ?>원</span>
                <ul class="prc-tot2">
                  <li>
                    <span class="lt-txt">기본배송비</span>
                    <span class="rt-txt"><?php echo number_format($tot_send_cost) ?>원</span>
                  </li>
                  <li>
                    <span class="lt-txt">추가배송비</span>
                    <span id="send_cost2" class="rt-txt">0원</span>
                  </li>
                </ul>
              </li>
              <li>
                <span class="lt-txt">총 할인금액</span>
                <span class="rt-txt totdc_amt" id="totdc_amt">0원</span>
                <ul class="prc-tot2">
                  <li>
                    <span class="lt-txt">즉시할인</span>
                    <span class="rt-txt">0원</span>
                  </li>
                  <li>
                    <span class="lt-txt ">쿠폰할인</span>
                    <span class="rt-txt cpdc_amt" id="cpdc_amt">0원</span>
                  </li>
                </ul>
              </li>
              <li>
                <span class="lt-txt">적립금 사용</span>
                <span class="rt-txt">
                  <span id="rst-usePoint">0원</span>
                </span>
              </li>
              <li class="rst">
                <span class="lt-txt">최총 결제금액</span>
                <span class="rt-txt">
                  <input type="text" name="tot_price" value="<?php echo number_format($tot_price); ?>" readonly>원
                </span>
              </li>
            </ul>
          </div>
        </div>
      </div>

      <div id="od-pay">
        <div class="container">
          <div class="arcodianBtn od-top active">
            <button type="button" class="ui-btn od-toggle-btn">
              <span class="od-tit">결제수단</span>
            </button>
          </div>
          <div class="od-ct">
            <?php
            $escrow_title = "";
            if($default['de_escrow_use']) {
              $escrow_title = "에스크로 ";
            }

            $multi_settle = '';
            if($is_kakaopay_use) {
              // $multi_settle .= "<option value='KAKAOPAY'>카카오페이</option>\n";
              $multi_settle .= "<li>\n";
              $multi_settle .= "<div class=\"frm-choice\">\n";
              $multi_settle .= "<input type=\"radio\" name=\"paymethod\" value=\"KAKAOPAY\" id=\"kakaopay\">\n";
              $multi_settle .= "<label for=\"kakaopay\">카카오페이</label>\n";
              $multi_settle .= "</div>\n";
              $multi_settle .= "</li>\n";
            }
            if($default['de_bank_use']) {
              // $multi_settle .= "<option value='무통장'>무통장입금</option>\n";
              $multi_settle .= "<li>\n";
              $multi_settle .= "<div class=\"frm-choice\">\n";
              $multi_settle .= "<input type=\"radio\" name=\"paymethod\" value=\"무통장\" id=\"de_bank\">\n";
              $multi_settle .= "<label for=\"de_bank\">무통장입금</label>\n";
              $multi_settle .= "</div>\n";
              $multi_settle .= "</li>\n";
            }
            if($default['de_card_use']) {
              // $multi_settle .= "<option value='신용카드'>신용카드</option>\n";
              $multi_settle .= "<li>\n";
              $multi_settle .= "<div class=\"frm-choice\">\n";
              $multi_settle .= "<input type=\"radio\" name=\"paymethod\" value=\"신용카드\" id=\"de_card\">\n";
              $multi_settle .= "<label for=\"de_card\">신용카드</label>\n";
              $multi_settle .= "</div>\n";
              $multi_settle .= "</li>\n";
            }
            if($default['de_hp_use']) {
              // $multi_settle .= "<option value='휴대폰'>휴대폰</option>\n";
              $multi_settle .= "<li>\n";
              $multi_settle .= "<div class=\"frm-choice\">\n";
              $multi_settle .= "<input type=\"radio\" name=\"paymethod\" value=\"휴대폰\" id=\"de_hp\">\n";
              $multi_settle .= "<label for=\"de_hp\">휴대폰</label>\n";
              $multi_settle .= "</div>\n";
              $multi_settle .= "</li>\n";
            }
            if($default['de_iche_use']) {
              // $multi_settle .= "<option value='계좌이체'>".$escrow_title."계좌이체</option>\n";
              $multi_settle .= "<li>\n";
              $multi_settle .= "<div class=\"frm-choice\">\n";
              $multi_settle .= "<input type=\"radio\" name=\"paymethod\" value=\"계좌이체\" id=\"de_iche\">\n";
              $multi_settle .= "<label for=\"de_iche\">계좌이체</label>\n";
              $multi_settle .= "</div>\n";
              $multi_settle .= "</li>\n";
            }
            if($default['de_vbank_use']) {
              // $multi_settle .= "<option value='가상계좌'>".$escrow_title."가상계좌</option>\n";
              $multi_settle .= "<li>\n";
              $multi_settle .= "<div class=\"frm-choice\">\n";
              $multi_settle .= "<input type=\"radio\" name=\"paymethod\" value=\"가상계좌\" id=\"de_vbank\">\n";
              $multi_settle .= "<label for=\"de_vbank\">가상계좌</label>\n";
              $multi_settle .= "</div>\n";
              $multi_settle .= "</li>\n";
            }
            if($is_member && $config['usepoint_yes'] && ($tot_price <= $member['point'])) {
              // $multi_settle .= "<option value='포인트'>포인트결제</option>\n";
              $multi_settle .= "<li>\n";
              $multi_settle .= "<div class=\"frm-choice\">\n";
              $multi_settle .= "<input type=\"radio\" name=\"paymethod\" value=\"포인트\" id=\"de_point\">\n";
              $multi_settle .= "<label for=\"de_point\">포인트결제</label>\n";
              $multi_settle .= "</div>\n";
              $multi_settle .= "</li>\n";
            }

            // PG 간편결제
            if($default['de_easy_pay_use']) {
              switch($default['de_pg_service']) {
                case 'lg':
                  $pg_easy_pay_name = 'PAYNOW';
                  break;
                case 'inicis':
                  $pg_easy_pay_name = 'KPAY';
                  break;
                case 'kcp':
                  $pg_easy_pay_name = 'PAYCO';
                  break;
              }
              if($pg_easy_pay_name)
                $multi_settle .= "<option value='간편결제'>{$pg_easy_pay_name}</option>\n";
            }

            // 이니시스를 사용중일때만 삼성페이 결제가능
            if($default['de_samsung_pay_use'] && ($default['de_pg_service'] == 'inicis')) {
              $multi_settle .= "<option value='삼성페이'>삼성페이</option>\n";
            }

            ?>

            <section id="sod_frm_pay">
              <ul class="sod_frm_pay_ul">
                <?php echo $multi_settle; ?>
              </ul>
            </section>

            <section id="bank_section" style="display:none;">
              <h2 class="anc_tit">입금하실 계좌</h2>
              <div class="odf_tbl">
                <table>
                  <tbody>
                    <!-- <tr>
                      <th scope="row">무통장계좌</th>
                      <td>
                        <?php echo mobile_bank_account("bank"); ?>
                      </td>
                    </tr>
                    <tr>
                      <th scope="row">입금자명</th>
                      <td><input type="text" name="deposit_name" value="<?php echo $member['name']; ?>" class="frm-input w-per100">
                      </td>
                    </tr> -->
                    <tr>
                      <th scope="row">은행</th>
                      <td>
                        <select id="bank_code" name="bank_code" class="frm-select w-per100">
                          <option value="">은행 선택</option>
                          <?php
                            foreach($BANKS as $bkCode => $v ) { ?>
                              <option value="<?php echo $v['code'] ?>"><?php echo $v['bank'] ?></option>
                          <?php } ?>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <th scope="row">이메일</th>
                      <td><input type="text" name="customerEmail" value="" class="frm-input w-per100">
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </section>

            <!-- 환불계좌 정보 추가 _20240507_SY -->
            <section id="refund_section" style="display:none;">
              <h2 class="anc_tit">환불받으실 계좌</h2>
              <div class="odf_tbl">
                <table>
                  <tbody>
                    <tr>
                      <th scope="row"><label for="refund_bank">은행명</label></th>
                      <td><input type="text" name="refund_bank" value="" class="frm-input w-per100" id="refund_bank"></td>
                    </tr>
                    <tr>
                      <th scope="row"><label for="refund_num">계좌번호</label></th>
                      <td><input type="text" name="refund_num" value="" class="frm-input w-per100" id="refund_num"></td>
                    </tr>
                    <tr>
                      <th scope="row"><label for="refund_name">예금주</label></th>
                      <td><input type="text" name="refund_name" value="" class="frm-input w-per100" id="refund_name"></td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </section>

            <section id="taxsave_section" style="display:none;">
              <h2 class="anc_tit">증빙서류 발급</h2>
              <div class="odf_tbl">
                <table>
                  <tbody>
                    <tr>
                      <th scope="row" id="cash_receipt_section">증빙서류 선택</th>
                      <td>
                        <input type="radio" name="documentType" value="cash_receipt" onclick="toggleTaxDocument(this.value);" checked> 현금영수증
                        <input type="radio" name="documentType" value="tax_bill" onclick="toggleTaxDocument(this.value);"> 세금계산서
                        <input type="radio" name="documentType" value="no_bill" onclick="toggleTaxDocument(this.value);"> 미발행
                      </td>
                    </tr>
                    <tr id="cash_bill_section">
                      <th scope="row">현금영수증</th>
                      <td>
                        <select name="taxsave_yes" onchange="tax_save(this.value);" class="frm-select w-per100">
                          <option value="N">발행안함</option>
                          <option value="Y">개인 소득공제용</option>
                          <option value="S">사업자 지출증빙용</option>
                        </select>
                        <div id="taxsave_fld_1" style="display:none;">
                          <input type="text" name="tax_hp" class="w-per100 frm-input" placeholder="핸드폰번호">
                        </div>
                        <div id="taxsave_fld_2" style="display:none;">
                          <input type="text" name="tax_saupja_no" class="w-per100 frm-input" placeholder="사업자등록번호">
                        </div>
                      </td>
                    </tr>
                    <tr id="tax_bill_section" style="display: none;">
                      <th scope="row">세금계산서</th>
                      <td>
                        <select name="taxbill_yes" onchange="tax_bill(this.value);" class="frm-select w-per100">
                          <option value="N">발행안함</option>
                          <option value="Y">발행요청</option>
                        </select>
                        <div id="taxbill_section" style="display:none;">
                          <input type="text" name="company_saupja_no" class="w-per100 frm-input" value="<?php echo $member['ju_b_num'] ?>" placeholder="사업자등록번호"><br>
                          <input type="text" name="company_name" class="w-per100 frm-input" value="<?php echo $member['ju_restaurant'];?>" placeholder="상호(법인명)"><br>
                          <input type="text" name="company_owner" class="w-per100 frm-input"value="<?php echo $member['ju_name'];?>" placeholder="대표자명"><br>
                          <input type="text" name="company_addr" class="w-per100 frm-input"value="<?php echo $member['ju_addr_full'];?>" placeholder="사업장주소"><br>
                          <input type="text" name="company_item" class="w-per100 frm-input"value="<?php echo $member['ju_business_type'];?>" placeholder="업태"><br>
                          <input type="text" name="company_service" class="w-per100 frm-input"value="<?php echo $member['ju_sectors'];?>" placeholder="업종">
                          <input type="text" name="" class="w-per100 frm-input"value="<?php echo $member['cellphone']?>" placeholder="신청자 전화번호">
                          <input type="text" name="" class="w-per100 frm-input"value="<?php echo $member['email']?>" placeholder="이메일">
                        </div>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </section>

            <section id="card_section" style="display:none;" >
              <h2 class="anc_tit">신용카드 선택</h2>
              <div class="odf_tbl">
                <select name="cardsel" id="cardsel">
                  <?php
                    $sqlCard = "SELECT * FROM iu_card_reg WHERE mb_id = '{$member['id']}'";
                    $resCard = sql_query($sqlCard);
                    for ($c = 0; $rowCard = sql_fetch_array($resCard); $c++) {
                  ?>
                    <option value="<?php echo $rowCard['idx'] ?>" <?php echo $rowCard['cr_use']=="Y"?"selected":"" ?>>(<?php echo $rowCard['cr_company'] ?>)<?php echo $rowCard['cr_card'] ?></option>
                  <?php } ?>
                </select>
              </div>
            </section>

            <script>
              function toggleTaxDocument(documentType) {
                if (documentType === 'cash_receipt') {
                  document.getElementById('cash_receipt_section').style.display = '';
                  document.getElementById('cash_bill_section').style.display = '';
                  document.getElementById('tax_bill_section').style.display = 'none';
                } else if (documentType === 'tax_bill') {
                  // document.getElementById('cash_receipt_section').style.display = 'none';
                  document.getElementById('cash_bill_section').style.display = 'none';
                  document.getElementById('tax_bill_section').style.display = '';
                } else {
                  document.getElementById('cash_bill_section').style.display = 'none';
                  document.getElementById('tax_bill_section').style.display = 'none';
                  $("select[name=taxsave_yes]").val('N');
                  $("select[name=taxbill_yes]").val('N');
                  tax_save('N')
                  tax_bill('N')
                }
              }
            </script>

            <!-- <div class="od-userInfo">
              결제관련 안내사항 영역입니다. 결제관련 안내사항 영역입니다. 결제관련 안내사항 영역입니다. 결제관련 안내사항 영역입니다. 결제관련 안내사항 영역입니다. 결제관련 안내사항 영역입니다.
            </div> -->

            <?php if(!$is_member) { ?>
            <section id="guest_privacy">
              <h2 class="anc_tit">비회원 구매</h2>
              <div class="tbl_head01 tbl_wrap">
                <table>
                  <thead>
                    <tr>
                      <th>목적</th>
                      <th>항목</th>
                      <th>보유기간</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>이용자 식별 및 본인 확인</td>
                      <td>이름, 비밀번호</td>
                      <td>5년(전자상거래등에서의 소비자보호에 관한 법률)</td>
                    </tr>
                    <tr>
                      <td>배송 및 CS대응을 위한 이용자 식별</td>
                      <td>주소, 연락처(이메일, 휴대전화번호)</td>
                      <td>5년(전자상거래등에서의 소비자보호에 관한 법률)</td>
                    </tr>
                  </tbody>
                </table>
              </div>

              <div id="guest_agree" class="frm-choice">
                <input type="checkbox" id="agree" value="1" class="css-checkbox lrg">
                <label for="agree">개인정보 수집 및 이용 내용을 읽었으며 이에 동의합니다.</label>
              </div>
            </section>
            <?php } ?>
          </div>
        </div>
      </div>



      <div class="btn_confirm" class="btn_confirm">
        <div class="container">
          <input type="submit" value="주문하기" class="btn_medium btn-buy">
          <!-- 시안대로 금액표시할 경우 사용
          <button type="submit" class="btn_medium btn-buy">
            <p class="price">
              <span class="spr">92,000<span class="won">원</span></span>
              <span class="txt"> 구매하기</span>
            </p>
          </button>
          -->
        </div>
      </div>
    </form>
    <!-- <div id="btn_confirm2" class="btn_confirm">
    <button class="button" id="payment-button" class="btn_medium btn-buy" style="margin-top: 30px" disabled>결제하기</button>
    </div> -->
  </div>
</div>

  <!--쿠폰 팝업 { -->
<div id="coupon-popup" class="popup type02 add-popup">
  <div class="pop-inner">
    <div class="pop-top">
      <p class="tit">쿠폰선택</p>
      <button type="button" class="btn close"></button>
    </div>
    <div class="pop-content line">
      <div class="pop-content-in"></div>
    </div>
  </div>
</div>

<!-- 배송지 목록 팝업 { -->
<div id="delv-popup" class="popup type02 add-popup">
  <div class="pop-inner">
    <div class="pop-top">
      <p class="tit">배송지 목록</p>
      <button type="button" class="btn close"></button>
    </div>
    <div class="pop-content line">
      <div class="pop-content-in"></div>
    </div>
  </div>
</div>
<!-- } 배송지 목록 팝업 -->

<!-- 배송지 추가 팝업 { -->
<div id="delv-write-popup" class="popup type02 add-popup add-in-popup">
  <div class="pop-inner">
    <div class="pop-top">
      <p class="tit">배송지 추가</p>
      <button type="button" class="btn close"></button>
    </div>
    <div class="pop-content line">
      <div class="pop-content-in"></div>
    </div>
  </div>
</div>
<!-- } 배송지 추가 팝업 -->
<!-- <script>

  const button = document.getElementById("payment-button");
  const coupon = document.getElementById("coupon-box");
  const odId = '<?php echo get_session('ss_order_id'); ?>';

  const clientKey = 'live_ck_yL0qZ4G1VO5bLkJzDP7Y8oWb2MQY';
  const customerKey = '<?php echo $member['id']?>'; // 내 상점에서 고객을 구분하기 위해 발급한 고객의 고유 ID
  var amount = 2000;

  const paymentWidget = PaymentWidget(clientKey, customerKey) // 회원 결제
    // const paymentWidget = PaymentWidget(clientKey, PaymentWidget.ANONYMOUS) // 비회원 결제
    // ------  결제 UI 렌더링 ------
    // @docs https://docs.tosspayments.com/reference/widget-sdk#renderpaymentmethods선택자-결제-금액-옵션
  paymentMethodWidget = paymentWidget.renderPaymentMethods(
    "#payment-method",
    { value: amount },
    // 렌더링하고 싶은 결제 UI의 variantKey
    // 결제 수단 및 스타일이 다른 멀티 UI를 직접 만들고 싶다면 계약이 필요해요.
    // @docs https://docs.tosspayments.com/guides/payment-widget/admin#멀티-결제-ui
    { variantKey: "DEFAULT" }
  );
  // ------  이용약관 UI 렌더링 ------
  // @docs https://docs.tosspayments.com/reference/widget-sdk#renderagreement선택자-옵션
  paymentWidget.renderAgreement("#agreement", { variantKey: "AGREEMENT" });

  //  ------  결제 UI 렌더링 완료 이벤트 ------
  paymentMethodWidget.on("ready", function () {
    button.disabled = false;
    coupon.disabled = false;
  });

  // ------  결제 금액 업데이트 ------
  // @docs https://docs.tosspayments.com/reference/widget-sdk#updateamount결제-금액
  coupon.addEventListener("change", function () {
    if (coupon.checked) {
      paymentMethodWidget.updateAmount(amount - 5000);
    } else {
      paymentMethodWidget.updateAmount(amount);
    }
  });

  var formSubmitOrder = $("#buyform").serialize();
  // ------ '결제하기' 버튼 누르면 결제창 띄우기 ------
  // @docs https://docs.tosspayments.com/reference/widget-sdk#requestpayment결제-정보
  button.addEventListener("click", function () {
    // 결제를 요청하기 전에 orderId, amount를 서버에 저장하세요.
    // 결제 과정에서 악의적으로 결제 금액이 바뀌는 것을 확인하는 용도입니다.
    paymentWidget.requestPayment({
      orderId: odId,
      orderName: "토스 티셔츠 외 2건",
      successUrl: window.location.origin+"/m/theme/basic/success.php",
      failUrl: window.location.origin + "/fail.php",
      customerEmail: "jjh@iium.kr",
      customerName: "김토스",
      customerMobilePhone: "01068620286",
    });
  });

</script> -->
<script type="module">
  import * as f from '/src/js/function.js';

  $(function () {
    //배송지 목록 팝업
    const delvPopId = "delv-popup";

    $(".od-dtn__change").on("click", function () {
      // win_open('./orderaddress.php','win_address');

      $.ajax({
        url: '/m/shop/orderaddress.php',
        success: function (data) {
          $(`#${delvPopId}`).find(".pop-content-in").html(data);
          $(".popDim").show();
          f.popupOpen(delvPopId);
        }
      });
    });

    //배송지 추가 팝업
    const delvWritePopId = "delv-write-popup";

    $(`#${delvPopId}`).on("click", ".od-dtn__add", function () {
      $.ajax({
        url: '/m/shop/orderaddress_write.php',
        success: function (data) {
          $(`#${delvWritePopId}`).find(".pop-content-in").html(data);
          f.popupOpen(delvWritePopId);
        }
      });
    });

    //쿠폰 적용 팝업
    $(".couponopen").on("click", function () {
      // const couponpop = "coupon-popup";
      // $.ajax({
      //   url: './ordercoupon.php',
      //   success: function (data) {
      //     $(`#${couponpop}`).find(".pop-content-in").html(data);
      //     //$(".popDim").show();
      //     f.popupOpen(couponpop);
      //   }
      // });

      const popId = "#coupon-popup";
      const reqPathUrl = "/m/shop/ordercoupon.php";
      const reqMethod = "GET";
      const reqData = "";

      f.callData(popId, reqPathUrl, reqMethod, reqData, true);
    });
    // win_open('./orderaddress.php','win_address');


  });
</script>

<script>
  $(function () {
    var zipcode = "";

    $("input[name=b_addr2]").focus(function () {
      var zip = $("input[name=b_zip]").val().replace(/[^0-9]/g, "");
      if (zip == "")
        return false;

      var code = String(zip);

      if (zipcode == code)
        return false;

      zipcode = code;
      calculate_sendcost(code);
    });

    //배송요청사항
    $("select[name=sel_memo]").change(function () {
      $("textarea[name=memo]").val($(this).val());
    });
  });

  function getSelectVal(selectElement) {
    // 선택된 라디오 버튼의 값을 반환
    let selectedValue = '';
    selectElement.forEach(element => {
        if (element.checked) {
            selectedValue = element.value;
        }
    });
    return selectedValue;
}

  // 도서/산간 배송비 검사
  function calculate_sendcost(code) {
    $.post(
      bv_shop_url + "/ordersendcost.php", {
        zipcode: code
      },
      function (data) {
        $("input[name=baesong_price2]").val(data);
        $("#send_cost2").text(number_format(String(data)));

        calculate_order_price();
      }
    );
  }

  function calculate_order_price() {
    var sell_price = parseInt($("input[name=org_price]").val()); // 합계금액
    var send_cost2 = parseInt($("input[name=baesong_price2]").val()); // 추가배송비
    var mb_coupon = parseInt($("input[name=coupon_total]").val()); // 쿠폰할인
    var mb_point = parseInt($("input[name=use_point]").val().replace(/[^0-9]/g, "")); //포인트결제
    var tot_price = sell_price + send_cost2 - (mb_coupon + mb_point);

    $("input[name=tot_price]").val(number_format(String(tot_price)));
  }
  function getSelectVal2(selectElement) {
      // 선택된 라디오 버튼의 값을 반환
    let selectedValue = '';
    selectElement.forEach(element => {
      if (element.checked) {
        selectedValue = element.value;
      }
    });
    return selectedValue;
  }
  function fbuyform_submit(f) {

    errmsg = "";
    errfld = "";

    var min_point = parseInt("<?php echo $config['usepoint']; ?>");
    var temp_point = parseInt(no_comma(f.use_point.value));
    var card_id = f.card_id.value.trim();
    var sell_price = parseInt(f.org_price.value);
    var send_cost2 = parseInt(f.baesong_price2.value);
    var mb_coupon = parseInt(f.coupon_total.value);
    var mb_point = parseInt(f.mb_point.value);
    var tot_price = sell_price + send_cost2 - mb_coupon;

    var paymethodRadios = f.querySelectorAll('input[name="paymethod"]');
    var selectedPaymentMethod = getSelectVal2(paymethodRadios);
    // 무통장 예외 처리 필요
    if (selectedPaymentMethod === '신용카드' && (card_id === '' || card_id === null)) {
        // 카드 등록 여부 확인
        const card_confirm = confirm("등록된 카드가 없습니다.\n카드 등록 후 구매하시겠습니까?");
        if (card_confirm) {
            window.location.href = "/m/shop/card.php";
            return false;
        }
    }

    if(f.b_addr1.value==''){
      alert('배송지를 지정해 주십시요');
      return false;
    }
    var checkboxes = $('input[name^="od_wday"]');

    // 체크박스가 존재하고, 그 중 하나라도 체크되었는지 확인
    var isChecked = checkboxes.length > 0 && checkboxes.is(':checked');

    if (checkboxes.length > 0 && !isChecked) {
      alert('요일을 하나 이상 선택해주세요.');
      checkboxes.focus();
      return false;
    }

    if (f.use_point.value == '') {
      alert('포인트사용 금액을 입력하세요. 사용을 원치 않을경우 0을 입력하세요.');
      f.use_point.value = 0;
      f.use_point.focus();
      return false;
    }

    if (temp_point > mb_point) {
      alert('포인트사용 금액은 현재 보유포인트 보다 클수 없습니다.');
      f.tot_price.value = number_format(String(tot_price));
      f.use_point.value = 0;
      f.use_point.focus();
      return false;
    }

    if (temp_point > tot_price) {
      alert('포인트사용 금액은 최종결제금액 보다 클수 없습니다.');
      f.tot_price.value = number_format(String(tot_price));
      f.use_point.value = 0;
      f.use_point.focus();
      return false;
    }

    if (temp_point > 0 && (mb_point < min_point)) {
      alert('포인트사용 금액은 ' + number_format(String(min_point)) + '원 부터 사용가능 합니다.');
      f.tot_price.value = number_format(String(tot_price));
      f.use_point.value = 0;
      f.use_point.focus();
      return false;
    }

    if (selectedPaymentMethod === '') {
      alert("결제방법을 선택하세요.");
      paymethodRadios[0] . focus(); // 선택할 라디오 버튼으로 포커스 이동
      return false;
    }

    if (typeof (f.od_pwd) != 'undefined') {
      clear_field(f.od_pwd);
      if ((f.od_pwd.value.length < 3) || (f.od_pwd.value.search(/([^A-Za-z0-9]+)/) != -1))
        error_field(f.od_pwd, "회원이 아니신 경우 주문서 조회시 필요한 비밀번호를 3자리 이상 입력해 주십시오.");
    }
    if (f . bank_code . value == "") {
      alert("가상계좌 은행 선택하세요.");
      f . bank_code . focus();

      return false;
    }

    if (getSelectVal(f["paymethod"]) == '무통장') {
      if (f . bank_code . value == "") {
        alert("가상계좌 은행 선택하세요.");
        f . bank_code . focus();

        return false;
      }
      if (f . customerEmail . value == "") {
        alert("가상계좌 받으실 메일 작성하세요.");
        f . customerEmail . focus();

        return false;
      }
    }

    <?php if (!$config['company_type']) { ?>
      if (getSelectVal(f["paymethod"]) == '무통장' && getSelectVal(f["taxsave_yes"]) == 'Y') {
        check_field(f.tax_hp, "핸드폰번호를 입력하세요");
      }

      if (getSelectVal(f["paymethod"]) == '무통장' && getSelectVal(f["taxsave_yes"]) == 'S') {
        check_field(f.tax_saupja_no, "사업자번호를 입력하세요");
      }

      if (getSelectVal(f["paymethod"]) == '무통장' && getSelectVal(f["taxbill_yes"]) == 'Y') {
        check_field(f.company_saupja_no, "사업자번호를 입력하세요");
        check_field(f.company_name, "상호명을 입력하세요");
        check_field(f.company_owner, "대표자명을 입력하세요");
        check_field(f.company_addr, "사업장소재지를 입력하세요");
        check_field(f.company_item, "업태를 입력하세요");
        check_field(f.company_service, "종목을 입력하세요");
      }
    <?php } ?>

    if (errmsg) {
      alert(errmsg);
      errfld.focus();
      return false;
    }

    if (getSelectVal(f["paymethod"]) == '계좌이체') {
      if (tot_price < 150) {
        alert("계좌이체는 150원 이상 결제가 가능합니다.");
        return false;
      }
    }

    if (getSelectVal(f["paymethod"]) == '신용카드') {
      if (tot_price < 1000) {
        alert("신용카드는 1000원 이상 결제가 가능합니다.");
        return false;
      }
    }

    if (getSelectVal(f["paymethod"]) == '휴대폰') {
      if (tot_price < 350) {
        alert("휴대폰은 350원 이상 결제가 가능합니다.");
        return false;
      }
    }

    if (document.getElementById('agree')) {
      if (!document.getElementById('agree').checked) {
        alert("개인정보 수집 및 이용 내용을 읽고 이에 동의하셔야 합니다.");
        return false;
      }
    }

    if (!confirm("주문내역이 정확하며, 주문 하시겠습니까?"))
      return false;

    f.use_point.value = no_comma(f.use_point.value);
    f.tot_price.value = no_comma(f.tot_price.value);

    return true;
  }

  function calculate_temp_point(val) {
    var f = document.buyform;
    var temp_point = parseInt(no_comma(f.use_point.value));
    var sell_price = parseInt(f.org_price.value);
    var send_cost2 = parseInt(f.baesong_price2.value);
    var mb_coupon = parseInt(f.coupon_total.value);
    var tot_price = sell_price + send_cost2 - mb_coupon;

    if (val == ''){
      temp_point = 0;
    }

    if (!checkNum(no_comma(val))) {
      alert('포인트 사용액은 숫자이어야 합니다.');
      f.tot_price.value = number_format(String(tot_price));
      $("#rst-usePoint").text('0');
      f.use_point.value = 0;
      f.use_point.focus();
      return;
    } else {
      f.tot_price.value = number_format(String(tot_price - temp_point));
      $("#rst-usePoint").text("-"+number_format(String(temp_point))+'원');
    }
  }

  // 결제방법
  // function calculate_paymethod(type) {
  $('input[type=radio][name=paymethod]').on('change', function(){
    let type = $(this).val();

    var sell_price = parseInt($("input[name=org_price]").val()); // 합계금액
    var send_cost2 = parseInt($("input[name=baesong_price2]").val()); // 추가배송비
    var mb_coupon = parseInt($("input[name=coupon_total]").val()); // 쿠폰할인
    var mb_point = parseInt($("input[name=mb_point]").val()); // 보유포인트
    var tot_price = sell_price + send_cost2 - mb_coupon;

    // 포인트잔액이 부족한가?
    if (type == '포인트' && mb_point < tot_price) {
      alert('포인트 잔액이 부족합니다.');

      $("select[name=paymethod]").val('무통장');
      $("#bank_section").show();
      $("input[name=use_point]").val(0);
      $("input[name=use_point]").attr("readonly", false);
      calculate_order_price();

      $("#refund_section").show();

      <?php if (!$config['company_type']) { ?>
        $("#taxsave_section").show();
      <?php } ?>

      return;
    }

    switch (type) {
      case '무통장':
        $("#bank_section").show();
        $("#card_section").hide();
        $("#toss_section").hide();
        $("input[name=use_point]").val(0);
        $("input[name=use_point]").attr("readonly", false);
        calculate_order_price();

        $("#refund_section").show();

        <?php if (!$config['company_type']) { ?>
          $("#taxsave_section").show();
        <?php } ?>
        break;
      case '일반':
        $("#toss_section").show();
        $("#card_section").hide();
        $("#bank_section").hide();
        $("input[name=use_point]").val(0);
        $("input[name=use_point]").attr("readonly", false);
        $("#taxsave_section").hide();
        $("#taxbill_section").hide();
        $("#taxsave_fld_1").hide();
        $("#taxsave_fld_2").hide();
        calculate_order_price();

        $("#refund_section").hide();

        break;
      case '신용카드':
        $("#card_section").show();
        $("#bank_section").hide();
        $("#toss_section").hide();
      case '포인트':
        $("#bank_section").hide();
        $("input[name=use_point]").val(number_format(String(tot_price)));
        $("input[name=use_point]").attr("readonly", true);
        calculate_order_price();

        $("#refund_section").hide();

        <?php if (!$config['company_type']) { ?>
          $("#taxsave_section").hide();
          $("#taxbill_section").hide();
          $("#taxsave_fld_1").hide();
          $("#taxsave_fld_2").hide();
        <?php } ?>
        break;
      default: // 그외 결제수단
        $("#bank_section").hide();
        $("#card_section").hide();
        $("#toss_section").hide();
        $("input[name=use_point]").val(0);
        $("input[name=use_point]").attr("readonly", false);
        calculate_order_price();

        $("#refund_section").hide();

        <?php if (!$config['company_type']) { ?>
          $("#taxsave_section").hide();
          $("#taxbill_section").hide();
          $("#taxsave_fld_1").hide();
          $("#taxsave_fld_2").hide();
        <?php } ?>
        break;
    }
  });

  // 현금영수증
  function tax_save(val) {
    switch (val) {
      case 'Y': // 개인 소득공제용
        $("#taxsave_fld_1").show();
        $("#taxsave_fld_2").hide();
        $("#taxbill_section").hide();
        $("select[name=taxbill_yes]").val('N');
        break;
      case 'S': // 지출증빙용
        $("#taxsave_fld_1").hide();
        $("#taxsave_fld_2").show();
        $("#taxbill_section").hide();
        $("select[name=taxbill_yes]").val('N');
        break;
      default: // 발행안함
        $("#taxsave_fld_1").hide();
        $("#taxsave_fld_2").hide();
        break;
    }
  }

  // 세금계산서
  function tax_bill(val) {
    switch (val) {
      case 'Y': // 발행함
        $("#taxsave_fld_1").hide();
        $("#taxsave_fld_2").hide();
        $("select[name=taxsave_yes]").val('N');
        $("#taxbill_section").show();
        break;
      case 'N': //미발행
        $("#taxbill_section").hide();
        break;
      default:
        $("#taxbill_section").hide();
        $("select[name=taxsave_yes]").val('N');
        break;
    }
  }

  // 할인쿠폰 삭제
  function coupon_cancel() {
    var f = document.buyform;
    var sell_price = parseInt(no_comma(f.tot_price.value)); // 최종 결제금액
    var mb_coupon = parseInt(f.coupon_total.value); // 쿠폰할인
    var tot_price = sell_price + mb_coupon;

    $("#dc_amt").text(0);
    $("#dc_cancel").hide();
    $("#dc_coupon").show();

    $("input[name=tot_price]").val(number_format(String(tot_price)));
    $("input[name=coupon_total]").val(0);
    $("input[name=coupon_price]").val("");
    $("input[name=coupon_lo_id]").val("");
    $("input[name=coupon_cp_id]").val("");
  }

  // 구매자 정보와 동일합니다.
  function gumae2baesong(checked) {
    var f = document.buyform;

    if (checked == true) {
      f.b_name.value = f.name.value;
      f.b_cellphone.value = f.cellphone.value;
      f.b_telephone.value = f.telephone.value;
      f.b_zip.value = f.zip.value;
      f.b_addr1.value = f.addr1.value;
      f.b_addr2.value = f.addr2.value;
      f.b_addr3.value = f.addr3.value;
      f.b_addr_jibeon.value = f.addr_jibeon.value;

      calculate_sendcost(String(f.b_zip.value));
    } else {
      f.b_name.value = '';
      f.b_cellphone.value = '';
      f.b_telephone.value = '';
      f.b_zip.value = '';
      f.b_addr1.value = '';
      f.b_addr2.value = '';
      f.b_addr3.value = '';
      f.b_addr_jibeon.value = '';

      calculate_sendcost('');
    }
  }

  gumae2baesong(true);
</script>
<!-- } 주문서작성 끝 -->
<style>
textarea.od-dtn__contact,	.wfull,input.od-dtn__contact{font-size:2.16rem !important;height:4rem}
	.tags1{
	    display: inline-block;
    margin-left: 1.2rem;
    font-size: 2rem;
    color: var(--color-gray2);
    background-color: var(--color-gray);}
</style>
