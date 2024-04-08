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
        
        <li class="sct_cart_empty">선택한 상품이  없습니다.</li>
      </ul>
      <div class="sct_cart_ct_total">
        <span class="sct_cart_ct_total-txt">Total</span>
        <span class="sct_cart_ct_total-pri">
          <strong class="price">0</strong>원</span>
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