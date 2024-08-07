<?php
if(!defined('_BLUEVATION_')) exit;
?>
<link rel="stylesheet" href="<?php echo BV_THEME_URL; ?>/style_kim.css?ver=<?php echo BV_CSS_VER;?>">
<!-- 장바구니 시작 { -->
<script src="<?php echo BV_JS_URL; ?>/shop.js"></script>

<div class="tac mart20 marb50"><img src="<?php echo BV_IMG_URL; ?>/tit_cart.gif"></div>

<div>
	<a href="/mng/shop/cart.php?paytype=2" class="<?php echo $paytype == "2"?"wset":"" ?> btn_large bx-white marr10">일반배송 (<?php echo number_format($row_cnt['total_cnt2']) ?>)</a>
	<a href="/mng/shop/cart.php?paytype=1" class="<?php echo $paytype == "1"?"wset":"" ?> btn_large bx-white">정기배송 (<?php echo number_format($row_cnt['total_cnt1']) ?>)</a>
</div>

<p class="pg_cnt mart30">
	<em>총 <?php echo number_format($cart_count); ?>개</em>의 상품이 장바구니에 있습니다.
</p>



<form name="frmcartlist" id="sod_bsk_list" method="post" action="<?php echo $cart_action_url; ?>">
<div class="tbl_head01 tbl_wrap">
<table>
  <colgroup>
    <col class="w80">
    <col class="w150">
    <col>
    <col class="w80">
    <col class="w120">
    <col class="w120">
    <col class="w120">
    <col class="w120">
  </colgroup>
  <thead>
    <tr>
      <th scope="col">
        <label for="ct_all" class="sound_only">상품전체</label>
        <input type="checkbox" name="ct_all" value="1" id="ct_all" checked="checked">
      </th>
      <th scope="col">이미지</th>
      <th scope="col">상품/옵션정보</th>
      <th scope="col">수량</th>
      <th scope="col">상품금액</th>
      <th scope="col">소계</th>
      <th scope="col">포인트</th>
      <th scope="col">배송비</th>
    </tr>
  </thead>
  <tbody>
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
                      GROUP BY p.mb_id, p.sc_type;";
    $res_group = sql_query($sql_group);

    $groupNumRow = sql_num_rows($res_group);
    for ($z = 0; $rowG = sql_fetch_array($res_group); $z++) {
        $CARTGROUP[] = $rowG;
    }
// print_r2($sql_group);
    $tot_point = 0;
    $tot_sell_price = 0;
    $tot_opt_price = 0;
    $tot_sell_qty = 0;
    $tot_sell_amt = 0;

    $preVal = null;
    $groupStarted = false;

    for ($i = 0; $row = sql_fetch_array($result); $i++) {
        $gs = get_goods($row['gs_id']);

        // 합계금액 계산
        $sql = " select SUM(IF(io_type = 1, (io_price * ct_qty),((io_price + ct_price) * ct_qty))) as price,
                        SUM(IF(io_type = 1, (0),(ct_point * ct_qty))) as point,
                        SUM(IF(io_type = 1, (0),(ct_qty))) as qty,
                        SUM(io_price * ct_qty) as opt_price
                    from shop_cart
                   where gs_id = '$row[gs_id]'
                     and ct_direct = '$set_cart_id'
                     and ct_select = '0'";
        $sum = sql_fetch($sql);

        if ($i == 0) { // 계속쇼핑
            $continue_ca_id = $row['ca_id'];
        }

        unset($it_name);
        unset($mod_options);
        $it_options = print_item_options($row['gs_id'], $set_cart_id);
        if ($it_options) {
            $mod_options = '<div class="sod_option_btn"><button type="button" class="btn_small bx-white mod_options">옵션변경/추가</button></div>';
            $it_name = '<div class="sod_opt">' . $it_options . '</div>';
        }

        $point = $sum['point'];
        $sell_price = $sum['price'];
        $sell_opt_price = $sum['opt_price'];
        $sell_qty = $sum['qty'];
        $sell_amt = $sum['price'] - $sum['opt_price'];

        // 배송비
        if ($gs['use_aff']) {
            $sr = get_partner($gs['mb_id']);
        } else {
            $sr = get_seller_cd($gs['mb_id']);
        }

        $info = get_item_sendcost($sell_price);
        $item_sendcost[] = $info['pattern'];

        $it_href = BV_SHOP_URL . '/view.php?index_no=' . $row['gs_id'];

        $targetGs = $row['gs_id']; // 찾고자 하는 gs_id 값
        $targetId = $row['mb_id']; // 찾고자 하는 mb_id 값
        $filteredResults = array_filter($CARTGROUP, function ($item) use ($targetGs) {
            $indicesArray = explode(',', $item['gs_idx']);
            return in_array($targetGs, $indicesArray);
        });
        $filteredResults = array_values($filteredResults);

        $curVal = $gs['mb_id'];
        $sellerMinInfo = get_seller_cd($filteredResults[0]['mb_id']);
        if ($filteredResults[0]['mb_id'] == 'admin') {
            $sellerMinInfo['company_name'] = "관리자";
            $sellerMinInfo['min_delivery'] = 50000;
        }
				$styleTr = "";

        if (($filteredResults[0]['mb_id'] == $gs['mb_id']) && ($filteredResults[0]['sc_type'] == 4)) {
					$styleTr = "border: 1px solid red";

            if ($preVal !== $curVal) {
                if ($groupStarted) {
                    echo '<tr class="group-footer"><td colspan="8"></td></tr>';  // Close previous group
                    $groupStarted = false;
                }
                if ($filteredResults[0]['price'] >= $sellerMinInfo['min_delivery']) {
                    $orderable_txt = '주문가능';
                    $orderable_per = 100;
                    $highlight = 'style="border: solid 1px red;"';
                } else {
                    $orderable_amt = $sellerMinInfo['min_delivery'] - $filteredResults[0]['price'];
                    $orderable_txt = '<span>' . number_format($orderable_amt) . '</span> 추가시 주문가능';
                    $orderable_per = ($filteredResults[0]['price'] / $sellerMinInfo['min_delivery']) * 100;
                    $highlight = 'style="border: solid 1px red;"';
                }

                // 새로운 그룹 시작
                echo '<tr ' . $highlight . '>';
                echo '  <td colspan="8">';
                echo '    <div class="cart-gbox">';
                echo '      <div class="cart-process-bar-wr">';
                echo '        <div class="cart-process-top">';
                echo '          <p class="company">' . $sellerMinInfo['company_name'] . '</p>';
                echo '          <div class="available-price">';
                echo '            <p class="text01 odprice" data-minprice="' . $sellerMinInfo['min_delivery'] . '" data-odprice="' . $filteredResults[0]['price'] . '">(주문가능 금액 ' . number_format($sellerMinInfo['min_delivery']) . '원)</p>';
                echo '            <p class="text02">' . $orderable_txt . '</p>';
                echo '          </div>';
                echo '        </div>';
                echo '        <div class="cart-process-bot">';
                echo '          <div class="cart-process-bar">';
                echo '            <span class="active-bar" data-orderper="' . $orderable_per . '" style="width: ' . $orderable_per . '%;"></span>';
                echo '          </div>';
                // echo '          <div class="cart-process-icon">';
                // echo '            <img src="/src/img/cart-process-icon.png" alt="">';
                // echo '          </div>';
                echo '        </div>';
                echo '      </div>';
                echo '    </div>';
                echo '  </td>';
                echo '</tr>';
                $groupStarted = true;
            }
        } else {
            if ($groupStarted) {
                echo '<tr class="group-footer"><td colspan="8"></td></tr>';  // Close previous group
                $groupStarted = false;
            }
        }
        ?>

        <tr class="group-item" style="<?php echo $styleTr?>">
            <td class="tac">
                <label for="ct_chk_<?php echo $i; ?>" class="sound_only">상품</label>
                <input type="checkbox" name="ct_chk[<?php echo $i; ?>]" value="1" id="ct_chk_<?php echo $i; ?>" checked="checked">
            </td>
            <td class="tac"><a href="<?php echo $it_href; ?>"><?php echo get_it_image($row['gs_id'], $gs['simg1'], 100, 100); ?></a></td>
            <td class="">
                <input type="hidden" name="gs_id[<?php echo $i; ?>]" value="<?php echo $row['gs_id']; ?>">
                <div class="cart_name_box">
                    <a href="<?php echo $it_href; ?>"><?php echo $gs['gname']; ?></a>
                    <?php echo $it_name . $mod_options; ?>
                </div>
            </td>
            <td class="tac"><?php echo number_format($sell_qty); ?></td>
            <td class="tar"><?php echo number_format($sell_amt); ?></td>
            <td class="tar"><?php echo number_format($sell_price); ?></td>
            <td class="tar"><?php echo number_format($point); ?></td>
            <td class="tar"><?php echo number_format($info['price']); ?></td>
        </tr>

        <?php
        $preVal = $curVal;
        $tot_point += $point;
        $tot_sell_price += $sell_price;
        $tot_opt_price += $sell_opt_price;
        $tot_sell_qty += $sell_qty;
        $tot_sell_amt += $sell_amt;

        if (!$is_member) {
            $tot_point = 0;
        }
    } // for

    if ($groupStarted) {
        echo '<tr class="group-footer"><td colspan="8"></td></tr>';  // Close last group
    }

    if ($i == 0) {
        echo '<tr><td colspan="8" class="empty_table">장바구니에 담긴 상품이 없습니다.</td></tr>';
    }

    // 배송비 검사
    $send_cost = 0;
    $com_send_cost = 0;
    $sep_send_cost = 0;
    $max_send_cost = 0;

    if ($i > 0) {
        $k = 0;
        $condition = array();
        foreach ($item_sendcost as $key) {
            list($userid, $bundle, $price) = explode('|', $key);
            $condition[$userid][$bundle][$k] = $price;
            $k++;
        }

        $com_array = array();
        $val_array = array();
        foreach ($condition as $key => $value) {
            if ($condition[$key]['묶음']) {
                $com_send_cost += array_sum($condition[$key]['묶음']); // 묶음배송 합산
                $max_send_cost += max($condition[$key]['묶음']); // 가장 큰 배송비 합산
                $com_array[] = max(array_keys($condition[$key]['묶음'])); // max key
                $val_array[] = max(array_values($condition[$key]['묶음'])); // max value
            }
            if ($condition[$key]['개별']) {
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
    ?>
  </tbody>
</table>

<style>

.group-box {
    border: 1px solid red;
    margin-bottom: 20px;
    padding: 10px;
}
.group-footer td {
    border-bottom: 2px solid #ddd;
}

.cart-gbox {
    padding: 10px;
}

.cart-process-bar-wr {
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 5px;
    background-color: #f9f9f9;
}

.cart-process-bar {
    width: calc(100% - 2.84rem);
    border-radius: 2rem;
    background-color: #FBF1E5;
    height: 1.24rem;
    position: relative;
    overflow: hidden;
    box-shadow: inset 0px 4px 8px rgba(250, 105, 24, 0.1);
}

.cart-process-bar .active-bar {
    position: absolute;
    top: 0;
    left: 0;
    background-color: #ff6600;
    height: 100%;
    width: 100%;
}

.cart-process-top {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.cart-process-icon img {
    height: 30px;
}

.cart-process-top .company {
    font-weight: bold;
    font-size: 1.2em;
    color: #333;
		padding:0;
}

.cart-process-top .available-price {
    text-align: right;
    color: #777;
}

.cart-process-top .available-price .text01 {
    font-size: 1em;
    color: #333;
}

.cart-process-top .available-price .text02 {
    font-size: 0.9em;
    color: #ff6600;
}

</style>

</div>

<?php if($i > 0) { ?>
<div id="sod_bsk_btn">
	<div class="palt"><button type="button" onclick="return form_check('seldelete');" class="btn_large bx-red">선택상품 삭제</button></div>
	<div class="part"><button type="button" onclick="return form_check('alldelete');" class="btn_large bx-white">장바구니 비우기</button></div>
</div>

<div class="table_flex_box mart50">
    <div>
        <h5 class="htag_title">장바구니에 담긴 상품통계</h5>
        <p class="gap20"></p>
        <div class="tbl_frm01 tbl_wrap">
            <table>
                <colgroup>
                    <col width="180px">
                    <col width="200px">
                    <col>
                </colgroup>
                <tr>
                    <th scope="row">포인트</th>
                    <td class="tar">적립 포인트</td>
                    <td class="tar bl"><?php echo display_point($tot_point); ?></td>
                </tr>
                <tr>
                    <th scope="row" rowspan="3">상품</th>
                    <td class="tar">상품금액 합계</td>
                    <td class="tar bl"><?php echo display_price2($tot_sell_amt); ?></td>
                </tr>
                <tr>
                    <td class="tar">옵션금액 합계</td>
                    <td class="tar bl"><?php echo display_price2($tot_opt_price); ?></td>
                </tr>
                <tr>
                    <td class="tar">주문수량 합계</td>
                    <td class="tar bl"><?php echo display_qty($tot_sell_qty); ?></td>
                </tr>
                <tr>
                    <td class="list2 tac bold" colspan="2">현재 포인트 보유잔액</td>
                    <td class="list2 tar bold"><?php echo display_point($member['point']); ?></td>
                </tr>
            </table>
        </div>
    </div>
    <div>
        <h5 class="htag_title">결제 예상금액 통계</h5>
        <p class="gap20"></p>
        <div class="tbl_frm01 tbl_wrap">
            <table>
                <colgroup>
                    <col width="180px">
                    <col width="200px">
                    <col>
                </colgroup>
                <tr>
                    <th scope="row">주문</th>
                    <td class="tar">(A) 주문금액 합계</td>
                    <td class="tar bl"><?php echo display_price2($tot_sell_price); ?></td>
                </tr>
                <tr>
                    <th scope="row" rowspan="3">배송비</th>
                    <td class="tar">상품별 배송비합계</td>
                    <td class="tar bl"><?php echo display_price2($send_cost); ?></td>
                </tr>
                <tr>
                    <td class="tar">배송비할인</td>
                    <td class="tar bl">(-) <?php echo display_price2($tot_final_sum); ?></td>
                </tr>
                <tr>
                    <td class="tar">(B) 최종배송비</td>
                    <td class="tar bl"><?php echo display_price2($tot_send_cost); ?></td>
                </tr>
                <tr>
                    <td class="list2 tac bold" colspan="2">결제예정금액 (A+B)</td>
                    <td class="list2 tar bold fc_red"><?php echo display_price2($tot_price); ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>


<?php } ?>

<div class="btn_confirm mart40">
	<?php if($i == 0) { ?>
	<a href="<?php echo BV_URL; ?>/mng/" class="btn_large">주문계속하기</a>
	<?php } else { ?>
	<input type="hidden" name="url" value="./orderform.php">
	<input type="hidden" name="records" value="<?php echo $i; ?>">
	<input type="hidden" name="act" value="">
	<input type="hidden" name="paytype" value="<?php echo $paytype ?>">
	<button type="button"   class="btn_large wset btn-buy btn-disabled">선택상품주문</button>
	<a href="<?php echo BV_URL; ?>/mng/" class="btn_large bx-white">쇼핑계속하기</a>
	<?php if($naverpay_button_js) { ?>
	<div class="cart-naverpay"><?php echo $naverpay_request_js.$naverpay_button_js; ?></div>
	<?php } ?>
	<?php } ?>
</div>
</form>

<script>
$(document).ready(function() {
    var button = $('.btn-buy');
    var isButtonEnabled = false;

    $('.odprice').each(function() {
      var minprice = parseInt($(this).data('minprice'));
      var odprice = parseInt($(this).data('odprice'));

      if (odprice < minprice) {
        isButtonEnabled = true;
        return false; // 조건이 만족되면 더 이상 반복하지 않음
      }
    });

    if (isButtonEnabled) {
        button.addClass('btn-disabled');
    } else {
        button.removeClass('btn-disabled');
    }

    button.click(function () {
        if (!isButtonEnabled) {
            return form_check('buy');
        } else {
            alert("최소 주문금액이 맞지 않습니다.");
            return false;
        }
    });
});
$(function() {
	var close_btn_idx;

	// 선택사항수정
	$(".mod_options").click(function() {
		var gs_id = $(this).closest("tr").find("input[name^=gs_id]").val();
		var $this = $(this);
		close_btn_idx = $(".mod_options").index($(this));

		$.post(
			bv_url+"/mng/shop/cartoption.php",
			{ gs_id: gs_id, paytype: <?php echo $paytype?> },
			function(data) {
				$("#mod_option_frm").remove();
				$this.after("<div id=\"mod_option_frm\"></div>");
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
        $(".mod_options").eq(close_btn_idx).focus();
    });

    $("#win_mask").click(function () {
        $("#mod_option_frm").remove();
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
</script>
<!-- } 장바구니 끝 -->
