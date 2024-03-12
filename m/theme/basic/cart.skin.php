<?php
if(!defined('_BLUEVATION_')) exit;
?>

<!-- 장바구니 시작 { -->
<script src="<?php echo BV_MJS_URL; ?>/shop.js"></script>

<!-- <div class="stit_txt">
	※ 총 <?php echo number_format($cart_count); ?>개의 상품이 담겨 있습니다.
</div> -->

<div id="sod_bsk">
	<form name="frmcartlist" id="sod_bsk_list" method="post" action="<?php echo $cart_action_url; ?>">	

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

    <div class="cart-sec container">
      <div class="cp-cart">
        <?php
        $tot_point		= 0;
        $tot_sell_price = 0;
        $tot_opt_price	= 0;
        $tot_sell_qty	= 0;
        $tot_sell_amt	= 0;

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
        ?>
        <!-- <li class="sod_li">
          <input type="hidden" name="gs_id[<?php echo $i; ?>]" value="<?php echo $row['gs_id']; ?>">
              <div class="li_chk">
                  <label for="ct_chk_<?php echo $i; ?>" class="sound_only">상품</label>
                  <input type="checkbox" name="ct_chk[<?php echo $i; ?>]" value="1" id="ct_chk_<?php echo $i; ?>" checked="checked">
              </div>
              <div class="li_name">
                  <a href="<?php echo $href; ?>"><?php echo stripslashes($gs['gname']); ?></a>
                  <?php if($it_options) { ?>
                  <div class="sod_opt"><?php echo $it_options; ?></div>
                  <?php } ?>
                  <span class="total_img"><?php echo get_it_image($row['gs_id'], $gs['simg1'], 80, 80); ?></span> 
          <div class="li_mod" style="padding-left:100px;">
            <?php if($it_options) { ?>
            <button type="button" id="mod_opt_<?php echo $row['gs_id']; ?>" class="mod_btn mod_options">옵션변경/추가</button>
            <?php } ?>
          </div>				
              </div>
              <div class="li_prqty">
                  <span class="prqty_price li_prqty_sp"><span>판매가</span>
          <?php echo number_format($sell_amt); ?></span>
                  <span class="prqty_qty li_prqty_sp"><span>수량</span>
          <?php echo number_format($sell_qty); ?></span>
                  <span class="prqty_sc li_prqty_sp"><span>배송비</span>
          <?php echo number_format($info['price']); ?></span>
              </div>
              <div class="li_total">
                  <span class="total_price total_span"><span>소계</span>
          <strong><?php echo number_format($sell_price); ?></strong></span>
                  <span class="total_point total_span"><span>적립포인트</span>
          <strong><?php echo number_format($point); ?></strong></span>
          </div>
        </li> -->
        <div class="cp-cart-item">
          <input type="hidden" name="gs_id[<?php echo $i; ?>]" value="<?php echo $row['gs_id']; ?>">
          <div class="cp-cart-head">
            <div class="title">
              <div class="frm-choice">
                <label for="ct_chk_<?php echo $i; ?>" class="sound_only">상품</label>
                <input type="checkbox" name="ct_chk[<?php echo $i; ?>]" value="1" id="ct_chk_<?php echo $i; ?>" checked="checked">
                <label for="ct_chk_<?php echo $i; ?>"></label>
              </div>
              <p class="name"><?php echo stripslashes($gs['gname']); ?></p>
            </div>
            <!-- 각 삭제 버튼 개발 필요 -->
            <button type="button" class="delete ui-btn" onclick="remove_cartItem(<?php echo $row['index_no']?>)">닫기</button>
          </div>
          <div class="cp-cart-body">
            <div class="thumb round60">
              <img src="<?php echo get_it_image_url($row['gs_id'], $gs['simg1'], 140, 140); ?>" alt="<?php echo get_text($gs['gname']); ?>" class="fitCover">
              
            </div>
            <div class="content">
              <div class="count">
                <?php if($it_options) { ?>
                <button type="button" id="mod_opt_<?php echo $row['gs_id']; ?>" class="mod_btn mod_options change ui-btn st3">옵션변경</button>
                <?php } ?>
              </div>
              <div class="info">
                <div class="set">
                  <div><?php echo number_format($sell_qty); ?>개</div>
                  <?php if($row['io_id']) { ?>
                  <div><?php echo $it_options; ?></div>
                  <?php } ?>
                </div>
                <p class="price"><?php echo display_price2($sell_price); ?><span class="dc-price">99,999원</span></p>
              </div>
            </div>
          </div>
        </div>
        <?php 
          $tot_point		+= $point;
          $tot_sell_price += $sell_price;
          $tot_opt_price	+= $sell_opt_price;
          $tot_sell_qty	+= $sell_qty;
          $tot_sell_amt	+= $sell_amt;

          if(!$is_member) {
            $tot_point = 0;
          }
        } // for 

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
            <?php echo display_price2($tot_price); ?>
            <span class="txt"> 구매하기</span>
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
$(function() {
    var close_btn_idx;

    // 선택사항수정
    $(".mod_options").click(function() {
        var gs_id = $(this).attr("id").replace("mod_opt_", "");
        var $this = $(this);
        close_btn_idx = $(".mod_options").index($(this));

        $.post(
            "./cartoption.php",
            { gs_id: gs_id },
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
