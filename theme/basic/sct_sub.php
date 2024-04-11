
<?php

  $myCartArr = $_SESSION['myCart'];
  $totalPrice = 0;
  $htmlView = "";
  if($myCartArr){
    for ($i = 0; $i < count($myCartArr[$member['id']]['gs_id']); $i++) {
      $myCart = $myCartArr[$member['id']];

      // 배열 키 추출
      $arrKeyType = array_keys($myCart['io_type']);
      $arrKeyId   = array_keys($myCart['io_id']);
      $arrKeyVal  = array_keys($myCart['io_value']);
      $arrKeyQty  = array_keys($myCart['ct_qty']);

      // HTML 뷰 생성
      $htmlView .= '<li id="sct_add_goods' . $myCart['gs_id'][$i] . '" class="sct_add_goods" data-goods-id="' . $myCart['gs_id'][$i] . '">';
      $htmlView .= '    <input type="hidden" name="gs_id[]" value="' . $myCart['gs_id'][$i] . '">';
      $htmlView .= '    <input type="hidden" name="gs_price[]" class="gs_price" value="' . $myCart['gs_price'][$i] . '">';
      $htmlView .= '    <input type="hidden" name="io_type[' . $arrKeyType[$i] . '][]" value="' . $myCart['io_type'][$arrKeyType[$i]][0] . '">';
      $htmlView .= '    <input type="hidden" name="io_id[' . $arrKeyId[$i] . '][]" value="' . $myCart['io_id'][$arrKeyId[$i]][0] . '">';
      $htmlView .= '    <input type="hidden" name="io_value[' . $arrKeyVal[$i] . '][]" value="' . $myCart['io_value'][$arrKeyVal[$i]][0] . '">';
      $htmlView .= '    <input type="hidden" name="io_price[]" class="io_price" value="' . $myCart['io_price'][$i] . '">';
      $htmlView .= '    <input type="hidden" name="io_stock[]" class="io_stock" value="' . $myCart['io_stock'][$i] . '">';
      $htmlView .= '    <div class="info">';
      $htmlView .= '        <p class="subject">' . $myCart['io_value'][$arrKeyVal[$i]][0] . '</p>';
      $htmlView .= '    </div>';
      $htmlView .= '    <div class="lot">';
      $htmlView .= '        <div class="it_li_add">';
      $htmlView .= '            <button type="button" class="qty-btn minus"></button>';
      $htmlView .= '            <input type="text" name="ct_qty[' . $arrKeyQty[$i] . '][]" value="' . $myCart['ct_qty'][$arrKeyQty[$i]][0] . '" class="qty-input">';
      $htmlView .= '            <button type="button" class="qty-btn plus"></button>';
      $htmlView .= '        </div>';
      $htmlView .= '        <p class="goods_price">' . number_format($myCart['gs_price'][$i]*$myCart['ct_qty'][$arrKeyQty[$i]][0]) . '</p>';
      $htmlView .= '    </div>';
      $htmlView .= '    <button type="button" class="remove">삭제</button>';
      $htmlView .= '</li>';

      // 총 가격 계산
      $totalPrice += $myCart['gs_price'][$i]*$myCart['ct_qty'][$arrKeyQty[$i]][0];
    }
  }

?>
<div class="sct_cart_wrap">
  <button type="button" id="mo_cart_close"></button>
  <div class="sct_cart_inner">
    <form name="frmcartlist" id="sod_bsk_list" method="post" action="/mng/shop/cartupdate.php">
    <input type="hidden" name="sw_direct">

    <div class="sct_cart_ct">
      <p class="t1">
        <span>선택상품</span>
          <span class="la_od"><a href="<?php echo BV_URL .'/mng/shop/orderinquiry.php'?>">이전상품 주문</a></span>
      </p>
      <ul class="sct_cart_ct_ul">

        <?php
          if($myCartArr){
            echo $htmlView;
          } else { ?>

            <li class="sct_cart_empty">선택한 상품이  없습니다.</li>
         <?php }
        ?>
      </ul>
      <div class="sct_cart_ct_total">
        <span class="sct_cart_ct_total-txt">Total</span>
        <span class="sct_cart_ct_total-pri">
          <strong class="price"><?php echo $myCartArr?number_format($totalPrice):"0"; ?></strong>원</span>
      </div>
    </div>
    <div class="sct_cart_bottom">
      <button type="button" class="sct_cart_bottom-button sct_cart-order" onclick="fbuyform_submit('buy');">바로 주문하기</button>
      <button type="button" class="sct_cart_bottom-button sct_cart-add" onclick="fbuyform_submit('cart');">장바구니 담기</button>
      <?php // echo get_buy_button($script_msg, $index_no); ?>
    </div>
    </form>
  </div>
</div>

<script>
// 바로구매, 장바구니 폼 전송
function fbuyform_submit(sw_direct)
{
	var f = document.frmcartlist;

  f.sw_direct.value = sw_direct;

	if(sw_direct == "cart") {
		f.sw_direct.value = 0;
	} else { // 바로구매
		f.sw_direct.value = 1;
	}

	f.action = "/mng/shop/cartupdate.php";
	f.submit();
}
</script>