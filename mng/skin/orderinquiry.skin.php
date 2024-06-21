<?php
if(!defined('_BLUEVATION_')) exit;
// include_once(BV_THEME_PATH.'/aside_my.skin.php');
?>

  <div >
    <div class="lc_wrap">
      <h4 class="htag_title"><?php echo $tb['title']; ?> </h4>
      <div class="pg_nav">
        <a href="/mng/" class="pg_home">HOME</a>
        <i>&gt;</i>
        <p>마이페이지</p>
        <i>&gt;</i>
        <p><?php echo $tb['title']; ?></p>
      </div>
    </div>

    <ul class="btn_wrap type02 tal">
        <li class="marr10">
            <a href="/mng/shop/orderinquiry.php" class="link_type1">
                <span>
                    이전상품주문
                </span>
            </a>
        </li>
        <li>
            <a href="/mng/" class="link_type2">
                <span>
                    주문가능상품
                </span>
            </a>
        </li>
    </ul>
    <h5 class="htag_title mart50 marb20">
      <span>상세보기 버튼을 클릭하시면 주문상세내역을 조회하실 수 있습니다.</span>
    </h5>
    <div class="prod_list">
        <div class="tbl_head01 prod_list_wrap">
            <table>
                <colgroup>
                    <col class="w150">
                    <col>
                    <col class="w120">
                    <col class="w140">
                    <col class="w140">
                </colgroup>
                <thead>
                    <tr>
                        <th scope="col">주문일자</th>
                        <th scope="col">상품정보</th>
                        <th scope="col">결제금액</th>
                        <th scope="col">상태</th>
                        <th scope="col">상태</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        for($i=0; $row=sql_fetch_array($result); $i++) {
                            $sql = " select * from shop_cart where od_id = '$row[od_id]' ";
                            $sql.= " group by gs_id order by io_type asc, index_no asc ";
                            $res = sql_query($sql);
                            $rowspan = sql_num_rows($res) + 1;

                        for($k=0; $ct=sql_fetch_array($res); $k++) {
                        $od = get_order($ct['od_no']);
                        $gs = unserialize($od['od_goods']);

                        $hash = md5($od['gs_id'].$od['od_no'].$od['od_id']);
                        $dlcomp = explode('|', trim($od['delivery']));
                        $href = BV_MNG_SHOP_URL.'/view.php?index_no='.$od['gs_id'];
                        if($k == 0) {
                    ?>
                        <tr>
                            <td class="tac" rowspan="<?php echo $rowspan; ?>">
                            <p><?php echo substr($od['od_time'],0,10);?></p>
                            <p class="padt5"><a href="<?php echo BV_MNG_SHOP_URL; ?>/orderinquiryview.php?od_id=<?php echo $od['od_id']; ?>" class="btn_small grey">상세보기</a></p>
                            </td>
                        </tr>
                    <?php } ?>
                        <tr class="rows">
                            <td>
                            <div class="ini_wrap">
                                <a href="<?php echo $href; ?>"><?php echo get_od_image($od['od_id'], $gs['simg1'], 60, 60); ?></a>
                                <div class="img_text_box">
                                    <a href="<?php echo $href; ?>" class="bold"><?php echo get_text($gs['gname']); ?></a>
                                    <p class="padt3 fc_999">주문번호 : <?php echo $od['od_id']; ?> / 수량 : <?php echo display_qty($od['sum_qty']); ?> / 배송비 : <?php echo display_price($od['baesong_price']); ?></p>
                                    <?php if($od['dan'] == 5) { ?>
                                    <div class="mart5">
                                        <?php if(is_null_time($od['user_date'])) { ?>
                                        <a href="javascript:final_confirm('<?php echo $hash; ?>');" class="btn_small red marr5">구매확정</a>
                                        <?php } ?>
                                        <a href="<?php echo BV_SHOP_URL; ?>/orderreview.php?gs_id=<?php echo $od['gs_id']; ?>&od_id=<?php echo $od['od_id']; ?>" onclick="win_open(this, 'winorderreview', '650', '530','yes');return false;" class="btn_small bx-white">구매후기 작성</a>
                                    </div>
                                    <?php } ?>
                                </div>
                            </div>
                            </td>
                            <td class="tar"><?php echo display_price($od['use_price']); ?></td>
                            <td class="tac">
                            <p><?php echo $gw_status[$od['dan']]; ?></p>
                            <?php if($dlcomp[0] && $od['delivery_no']) { ?>
                            <p class="padt3 fc_90"><?php echo $dlcomp[0]; ?><br><?php echo $od['delivery_no']; ?></p>
                            <?php } ?>
                            <?php if($dlcomp[1] && $od['delivery_no']) { ?>
                            <p class="padt3"><?php echo get_delivery_inquiry($od['delivery'], $od['delivery_no'], 'btn_ssmall'); ?></p>
                            <?php } ?>
                            </td>
                            <td id="pr_item<?php echo $ct['gs_id'];?>" class="tac pr_item">
                            <?php // SELECT 상품 정보 _20240409_SY
                                $gs_sel = "SELECT * FROM shop_goods WHERE index_no = '{$ct['gs_id']}' ";
                                $gs_res = sql_fetch($gs_sel);
                                $ct_sel = "SELECT * FROM shop_goods_option WHERE gs_id = '{$ct['gs_id']}' AND io_id = '{$ct['io_id']}' ";
                                $ct_res = sql_fetch($ct_sel);

                                // option _20240411_SY
                                $items = explode(",", $gs_res['opt_subject']);
                                $info = explode("", $ct['io_id']);
                                $options = "";
                                $count = count($items);
                                if($count > 1) {
                                for ($j = 0; $j < $count; $j++) {
                                    $options .= $items[$j] . " : " . $info[$j];
                                    if ($j < $count - 1) {
                                        $options .= ", ";
                                    }
                                }
                                }
                                

                                $it_name = cut_str($row['gname'], 100);

                                if($gs_res) {
                                if(!$gs_res['stock_mod']) {
                                    $gs_res['stock_qty'] = 999999999;
                                }
                                ?>
                                <input type="hidden" name="pr_id" value="<?php echo $gs_res['index_no'];?>">
                                <input type="hidden" class="io_stock" value="<?php echo $gs_res['stock_qty']; ?>">
                                <input type="hidden" class="pname" value="<?php echo $gs_res['gname']; ?>">
                                <input type="hidden" class="mpr" value="<?php echo $gs_res['goods_price']; ?>">
                                <input type="hidden" class="io_id" value="<?php echo $ct['io_id']; ?>">
                                <input type="hidden" class="io_price" value="<?php echo $ct_res['io_price']; ?>">
                                <input type="hidden" class="it_option" value="<?php echo $options; ?>">


                                <!-- <button type="button" class="qty-btn minus"></button> -->
                                <input type="hidden" name="" id="" value="<?php echo $ct['ct_qty'] ?>" class="qty-input">
                                <!-- <button type="button" class="qty-btn plus"></button> -->
                                <button type="button" class="add-list-btn"></button>
                            <?php } ?>
                            </td>
                        </tr>
                    <?php }
                    }
                    if($i==0)
                        echo '<tr><td colspan="4" class="empty_list">자료가 없습니다.</td></tr>';
                    ?>
                </tbody>
            </table>
        </div>
        <?php include_once(BV_THEME_PATH.'/sct_sub.php'); ?>
    </div>

    <?php
    echo get_paging($config['write_pages'], $page, $total_page, $_SERVER['SCRIPT_NAME'].'?page=');
    ?>
  </div>
  </div>


<script>
  const selectedItemArray = [];

// 세자리 콤마 추가
const addCommas = (number) => {
  return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

const reNumber = (str) => {
  let result = parseInt(str.replace(/[^0-9]/g, ''));

  return result;
}

const qtyMinus = (v) => {
  if(v <= 1) {
    alert("최소판매수량보다 작습니다.");
    return 1;
  }

  v--;

  return v;
}

const qtyPlus = (v) => {
  // if(v <= 1) {
  //   alert("최대판매수량보다 많습니다.");
  //   return false;
  // }

  v++;

  return v;
}

const totalCalc = (targetList, target) => {
  let total = 0;

  $(targetList).each(function(){
    let priceText = $(this).find(target).text();
    let price = reNumber(priceText);

    total += price;
  });

  return total;
}

const duplCheck = (itid) => {
  let resultBool = selectedItemArray.includes(itid);

  return resultBool;
}

const stockCheck = (itid, stock) => {
  let prItemQty = parseInt($(`#pr_item${itid}`).find(".qty-input").val());
  let sctItemQty = parseInt($(`#sct_add_goods${itid}`).find(".qty-input").val());
  let tottalQty = sctItemQty ? (prItemQty + sctItemQty) : prItemQty;

  if(tottalQty <= stock) {
    return true;
  } else {
    return false;
  }
}

const addItem = (itid, name, qty, stock, price, optval, optid, opt=null) => {
  const selectedItemBox = $(".sct_cart_wrap .sct_cart_ct_ul");
  let selectedItemPrice;

  selectedItemPrice = price * qty;

  let goodsId = optid ? itid+"-"+optid : itid;
  let hasItem = duplCheck(goodsId);

  if(!hasItem) { //새로 담는 상품이라면
    if(!opt){ //옵션이 없다면
      selectedItemBox.append(`
      <li id="sct_add_goods${goodsId}" class="sct_add_goods" data-goods-id="${goodsId}">
        <input type="hidden" name="gs_id[]" value="${itid}">
        <input type="hidden" name="gs_price[]" class="gs_price" value="${price}">

        <input type="hidden" name="gs_name[${itid}][]" value="${name}">
        <input type="hidden" name="io_type[${itid}][]" value="0">
        <input type="hidden" name="io_id[${itid}][]" value="">
        <input type="hidden" name="io_value[${itid}][]" value="${name}">
        <input type="hidden" name="io_price[]" class="io_price" value="0">
        <input type="hidden" name="io_stock[]" class="io_stock" value="${stock}">

        <div class="info">
          <p class="subject">${name}</p>
        </div>
        <div class="lot">
          <div class="it_li_add">
            <button type="button" class="qty-btn minus"></button>
            <input type="text" name="ct_qty[${itid}][]" id="" value="${qty}" class="qty-input">
            <button type="button" class="qty-btn plus"></button>
          </div>
          <p class="goods_price">${addCommas(selectedItemPrice)}</p>
        </div>
        <button type="button" class="remove">삭제</button>
      </li>
      `);
    } else { //옵션이 있다면
      let price2 = parseInt(opt.io_price) + parseInt(opt.io_amt);
      selectedItemPrice = (parseInt(opt.io_price) + parseInt(opt.io_amt)) * qty;
      let optInfo = opt.io_value; // 옵션 분할
      let optInfo1 = opt.io_id.split('');

      selectedItemBox.append(`
      <li id="sct_add_goods${goodsId}" class="sct_add_goods useOpt" data-goods-id="${goodsId}">
        <input type="hidden" class="io_id" name="gs_id[]" value="${itid}">
        <input type="hidden" class="gs_price" name="gs_price[]" value="${price2}">

        <input type="hidden" name="gs_name[${itid}][]" value="${name}">
        <input type="hidden" name="io_type[${itid}][]" value="0">
        <input type="hidden" name="io_id[${itid}][]" value="${opt.io_id}">
        <input type="hidden" name="io_value[${itid}][]" value="${optval}" class="gs_optInfo">
        <input type="hidden" name="io_price[]" class="io_price" value="${opt.io_price}">
        <input type="hidden" name="io_stock[]" class="io_stock" value="${opt.io_stock}">

        <div class="info">
          <p class="subject">${name}</p>
          <span class="option">
            <span class="item">옵션 : ${optInfo1[0]} </span>
          </span>
        </div>
        <div class="lot">
          <div class="it_li_add">
            <button type="button" class="qty-btn minus"></button>
            <input type="text" name="ct_qty[${itid}][]" id="" value="${qty}" class="qty-input">
            <button type="button" class="qty-btn plus"></button>
          </div>
          <p class="goods_price">${addCommas(selectedItemPrice)}</p>
        </div>
        <button type="button" class="remove">삭제</button>
      </li>
      `);
    }

    selectedItemArray.push(goodsId);
  } else { //이미 담긴 상품이라면 (옵션이 달라도 같은 상품일 경우도 해당됨)
    let currentQty = 0;

    if(!opt){ // 옵션이 없다면
      currentQty = parseInt($(`#sct_add_goods${itid} .qty-input`).val());
      let newQty = currentQty + qty;
      selectedItemPrice = price * newQty;

      $(`#sct_add_goods${itid} .qty-input`).val(newQty);
      $(`#sct_add_goods${itid} .goods_price`).text(addCommas(selectedItemPrice));
    }else{ // 옵션이 있다면
      let optValue = optval;

      // 이미 그려진 상품들 중에서 동일한 옵션값을 가진 상품이 있는지 확인
      let existingItem = $(".sct_cart_wrap .sct_cart_ct_ul").find(`#sct_add_goods${goodsId}`);

      if (existingItem.length > 0) { // 동일한 상품이 있다면
        let currentQty = parseInt(existingItem.find('.qty-input').val());
        let newQty = currentQty + qty;
        let existingPrice = parseFloat(existingItem.find('.gs_price').val());
        selectedItemPrice = existingPrice * newQty;

        existingItem.find('.qty-input').val(newQty);
        existingItem.find('.goods_price').text(addCommas(selectedItemPrice));
      } else { // 동일한 상품이 없다면
        let price2 = parseInt(opt.io_price) + parseInt(opt.io_amt);
        selectedItemPrice = (parseInt(opt.io_price) + parseInt(opt.io_amt)) * qty;
        let optInfo = opt.io_value.split(','); // 옵션 분할
        let optInfo1 = opt.io_id.split('');

        goodsId = itid+"-"+optid;

        selectedItemBox.append(`
        <li id="sct_add_goods${goodsId}" class="sct_add_goods useOpt" data-goods-id="${goodsId}">
          <input type="hidden" class="io_id" name="gs_id[]" value="${itid}">
          <input type="hidden" class="gs_price" name="gs_price[]"  value="${price2}">

          <input type="hidden" name="gs_name[${itid}][]" value="${name}">
          <input type="hidden" name="io_type[${itid}][]" value="0">
          <input type="hidden" name="io_id[${itid}][]" value="${opt.io_id}">
          <input type="hidden" name="io_value[${itid}][]" value="${optval}" class="gs_optInfo">
          <input type="hidden" name="io_price[]" class="io_price" value="${opt.io_price}">
          <input type="hidden" name="io_stock[]" class="io_stock" value="${opt.io_stock}">

          <div class="info">
            <p class="subject">${name}</p>
            <span class="option">
              <span class="item">옵션 : ${optInfo1[0]} ${optInfo[0] != optInfo1[0] ? '('+optInfo[0]+')' : ''} ${optInfo[1] != 0 ? '+'+addCommas(optInfo[1])+'원' : ''}</span>
            </span>
          </div>
          <div class="lot">
            <div class="it_li_add">
              <button type="button" class="qty-btn minus"></button>
              <input type="text" name="ct_qty[${itid}][]" id="" value="${qty}" class="qty-input">
              <button type="button" class="qty-btn plus"></button>
            </div>
            <p class="goods_price">${addCommas(selectedItemPrice)}</p>
          </div>
          <button type="button" class="remove">삭제</button>
        </li>
        `);
      }

    }
  }
}

$(document).ready(function(){
  const addListBtn = $(".add-list-btn");
  const qtyMinusBtn = ".qty-btn.minus";
  const qtyPlusBtn = ".qty-btn.plus";
  const qtyInputs = ".qty-input";

  // 수량 감소
  $(".prod_list2").on('click', qtyMinusBtn, function(){
    let $tgItem = $(this).closest(".pr_item");
    let $sctItem = $(this).closest(".sct_add_goods");

    // 옵션이 있는 경우 옵션 선택헸는지 체크
    if($tgItem.find('.it_li_option').length > 0) {
      let optionSelected = true;

      $tgItem.find(".it_option").each(function(){
        if($(this).val() == '') {
          alert('필수 옵션을 선택해주세요.');
          optionSelected = false;
          return false;
        }
      });

      if (!optionSelected) {
        return;
      }
    }

    let qtyInput = $(this).siblings(".qty-input");
    let curQty = qtyInput.val();

    // 담긴 상품의 재고량 체크
    if($sctItem) {
      let stock = parseInt($sctItem.find('.io_stock').val());

      if(curQty >= stock){
        alert("재고수량은 "+stock+"개 입니다.");

        return false;
      }
    }

    let chgQty = qtyMinus(curQty);

    qtyInput.val(chgQty);

    //선택된 상품이라면 가격까지 계산
    if($(this).closest("li").hasClass("sct_add_goods")) {
      let itemPrice = parseInt($(this).closest(".sct_add_goods").find('.gs_price').val());
      let itemQty = parseInt($(this).closest(".sct_add_goods").find('.qty-input').val());
      let $itemPriceEl = $(this).closest(".sct_add_goods").find('.goods_price');
      let itemSubTotal = itemPrice * itemQty;

      $itemPriceEl.text(addCommas(itemSubTotal));

      let totalPrice = totalCalc('.sct_add_goods', '.goods_price');
      let $totalEl = $(".sct_cart_wrap .sct_cart_ct_total-pri strong.price");

      $totalEl.text(addCommas(totalPrice));
    }
    chValue();

  });

  // 수량 증가
  $(".prod_list2").on('click', qtyPlusBtn, function(){
    let $tgItem = $(this).closest(".pr_item");
    let $sctItem = $(this).closest(".sct_add_goods");

    // 옵션이 있는 경우 옵션 선택헸는지 체크
    if($tgItem.length > 0 && $tgItem.find('.it_li_option').length > 0) {
      let optionSelected = true;

      $tgItem.find(".it_option").each(function(){
        if($(this).val() == '') {
          alert('필수 옵션을 선택해주세요.');
          optionSelected = false;
          return false;
        }
      });

      if (!optionSelected) {
        return;
      }
    }

    let qtyInput = $(this).siblings(".qty-input");
    let curQty = qtyInput.val();
    let stock = 0;

    // 담긴 상품의 재고량 체크
    if($sctItem.length > 0) {
      stock = parseInt($sctItem.find('.io_stock').val());
    } else if($tgItem.length > 0) {
      stock = parseInt($tgItem.find('.io_stock').val());
    } else {
      console.log("재고 데이터가 없습니다.")
    }

    if(curQty >= stock){
      alert("재고수량은 "+stock+"개 입니다.");

      return false;
    }

    let chgQty = qtyPlus(curQty);

    qtyInput.val(chgQty);

    //선택된 상품이라면 가격까지 계산
    if($(this).closest("li").hasClass("sct_add_goods")) {
      let itemPrice = parseInt($(this).closest(".sct_add_goods").find('.gs_price').val());
      let itemQty = parseInt($(this).closest(".sct_add_goods").find('.qty-input').val());
      let $itemPriceEl = $(this).closest(".sct_add_goods").find('.goods_price');
      let itemSubTotal = itemPrice * itemQty;

      $itemPriceEl.text(addCommas(itemSubTotal));

      let totalPrice = totalCalc('.sct_add_goods', '.goods_price');
      let $totalEl = $(".sct_cart_wrap .sct_cart_ct_total-pri strong.price");

      $totalEl.text(addCommas(totalPrice));
    }
    chValue();

  });

  // 담긴 상품 삭제하기
  const removeListBtn = ".sct_add_goods .remove";
  const emptyEl = $(".sct_cart_empty");

  $(".sct_cart_ct_ul").on('click', removeListBtn, function(){
    let $goodsItem = $(this).closest(".sct_add_goods");
    let goodsId = String($goodsItem.data("goods-id"));

    $goodsItem.remove();

    for(let i = 0; i < selectedItemArray.length; i++) {
      if(selectedItemArray[i] === goodsId)  {
        selectedItemArray.splice(i, 1);
        i--;
      }
    }

    let $totalEl = $(".sct_cart_wrap .sct_cart_ct_total-pri strong.price");

    if($(".sct_add_goods").length == 0) {
      emptyEl.show();
      $totalEl.text(0);
    } else {
      let totalPrice = totalCalc('.sct_add_goods', '.goods_price');

      $totalEl.text(addCommas(totalPrice));
    }
    chValue('remove',goodsId);

  });

  // 상품 선택하기
  addListBtn.on('click', function(){
    let $tgItem = $(this).closest('.pr_item');
    let itemId = $tgItem.find('input[name=pr_id]').val();
    let itemIoid = $tgItem.find('.io_id').val();
    let itemName = $tgItem.find('.pname').val();
    let itemIoPrice = $tgItem.find('.io_price').val();
    let itemQty = parseInt($tgItem.find('.qty-input').val());
    let itemStock = parseInt($tgItem.find('.io_stock').val());
    let itemPriceText = $tgItem.find('.mpr').val();
    let itemPrice = reNumber(itemPriceText);
    let itemOpt = "";
    let itemValue = "";
    let optId = "";

    let gsIdValues = $('input[name^="gs_id"]').map(function() {
      return $(this).val(); // 각 요소의 값 반환
    }).get();
    if (gsIdValues . includes(itemId)) {
      alert("같은 상품이 담겨 있습니다.");
      return false;
    }

    let price, stock, amt = 0;

    if($tgItem.find('.io_id').val() != "") { //옵션이 있는 상품이라면

      let id = "";
      let value, item, sel_opt = false;
      let option = sep = "";

      $tgItem.find('.it_option').each(function(index) {
        let selectedIndex = $(this).prop('selectedIndex');
        if(index == 0) {
          optId = selectedIndex;
        } else {
          optId = optId+"_"+selectedIndex;
        }

        value = $tgItem.find('.it_option').val();

        itemValue = value

      });
      price = itemPrice;
      stock = itemStock;
      amt = itemIoPrice;

      itemOpt = {
        io_id : itemIoid,
        io_value : value,
        io_price : price,
        io_stock : stock,
        io_amt : amt,
      }
    } else {
      stock = itemStock;
    }

    // 선택 상품
    let stockConfm = stockCheck(itemId, stock);
    if(!stockConfm) {
      alert("재고수량은 "+stock+"개 입니다.");

      return false;
    }

    emptyEl.hide();
    addItem(itemId, itemName, itemQty, itemStock, itemPrice, itemValue, optId, itemOpt);

    // 총 가격
    let totalPrice = totalCalc('.sct_add_goods', '.goods_price');
    let $totalEl = $(".sct_cart_wrap .sct_cart_ct_total-pri strong.price");

    $totalEl.text(addCommas(totalPrice));
    chValue();
  });

  // 옵션 선택 이벤트
  $("select.it_option").on('change', function(){
    let $tgItem = $(this).closest('.pr_item');
    let sel_count = $tgItem.find("select.it_option").size();
    let idx = parseInt($(this).attr('id').slice(-1));
    let val = $(this).val();
    let gs_id = $tgItem.find("input[name='pr_id']").val();

    // 선택값이 없을 경우 하위 옵션은 disabled
    if(val == "") {
      $tgItem.find("select.it_option:gt("+(idx - 1)+")").val("").attr("disabled", true);
      return;
    }

    if(sel_count > 1 && idx < sel_count) {
      let opt_id = "";

      // 상위 옵션의 값을 읽어 옵션id 만듬
      if((idx - 1) > 0) {
        $("select.it_option:lt("+(idx - 1)+")").each(function() {
          if(!opt_id)
            opt_id = $(this).val();
          else
            opt_id += String.fromCharCode(30)+$(this).val();
        });

        opt_id += String.fromCharCode(30)+val;
      } else if((idx - 1) == 0) {
        opt_id = val;
      }

      $.post(
        "/mng/shop/list_option.php",
        { gs_id: gs_id, opt_id: opt_id, idx: (idx - 1), sel_count: sel_count },
        function(data) {
          $tgItem.find("select#it_option_"+(idx + 1)).empty().html(data).attr("disabled", false);

          // select의 옵션이 변경됐을 경우 하위 옵션 disabled
          if(idx < sel_count) {
            let idx2 = idx;

            $tgItem.find("select.it_option:gt("+idx2+")").val("").attr("disabled", true);
          }
        }
      );
    }
    let $optionSelect = $tgItem.find('.it_option');
    let lastIndex = $optionSelect.length - 1;
    let curIndex = $(this).closest("dl").index();

    if(curIndex == lastIndex){
      $optionSelectLast = $tgItem.find('.it_option:last');
      let info = $optionSelectLast.val().split(',');
      let stock = info[2];

      $tgItem.find('.io_stock').val(stock);
    }

    chValue();
  });

  let prevValue = "";

  $(".prod_list2").on('keyup', qtyInputs, function(){
    let $qtyInput = $(this);
    let currentValue = $qtyInput.val();
    let $tgItem = $qtyInput.closest('.pr_item');

    if (currentValue !== prevValue) {
      if($tgItem.length > 0 && $tgItem.find('.it_li_option').length > 0) {
        let optionSelected = true;

        $tgItem.find(".it_option").each(function(){
          if($(this).val() == '') {
            alert('필수 옵션을 선택해주세요.');
            optionSelected = false;
            return false;
          }
        });

        if (!optionSelected) {
          $qtyInput.val(prevValue);
          return false;
        }
      }

      // 담긴 상품의 재고량 체크
      let curQty = parseInt($qtyInput.val());
      let stock = parseInt($tgItem.find('.io_stock').val());

      if(curQty > stock){
        alert("재고수량은 "+stock+"개 입니다.");

        $qtyInput.val(prevValue);
        return false;
      }
    }

    if(prevValue == "") {
      prevValue = 1;
    } else {
      prevValue = currentValue;
    }

    chValue();

  });

  const chValue = (r='',idx='') => {
    let $totalEl = $(".sct_cart_wrap .sct_cart_ct_total-pri strong.price");
    let emptyEl = $(".sct_cart_empty");
    
    let form = $("#sod_bsk_list").serialize();
    if(r=='remove'){
      // let hiddenField = `<input type="hidden" name="remove" value="${r}">`;
      // form . append(hiddenField);
      form += `&remove=${idx}`;
    }
      $.ajax({
        type: 'POST', // 전송 방식 (POST)
        url: '/mng/shop/orderinquiry.ajax.php', // 폼의 action 속성 값 (submit.php)
        data: form, // 직렬화된 폼 데이터
        success: function(res) {
          // console.log(res)
          // 세선 비울때 선택한 상품이 없습니다 작업 필요 _20240411_SY
        },
      });
    }
    chValue();
});

</script>


