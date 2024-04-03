<?php
if(!defined('_BLUEVATION_')) exit;

$qstr1 = 'ca_id='.$ca_id.'&page_rows='.$page_rows.'&sort='.$sort.'&sortodr='.$sortodr;
$qstr2 = 'ca_id='.$ca_id.'&page_rows='.$page_rows;
$qstr3 = 'ca_id='.$ca_id.'&sort='.$sort.'&sortodr='.$sortodr;

$sort_str = '';
for($i=0; $i<count($gw_psort); $i++) {
	list($tsort, $torder, $tname) = $gw_psort[$i];

	$sct_sort_href = $_SERVER['SCRIPT_NAME'].'?'.$qstr2.'&sort='.$tsort.'&sortodr='.$torder;

	$active = '';
	if($sort == $tsort && $sortodr == $torder)
		$active = ' class="active"';
	if($i==0 && !($sort && $sortodr))
		$active = ' class="active"';

	$sort_str .= '<li><a href="'.$sct_sort_href.'"'.$active.'>'.$tname.'</a></li>'.PHP_EOL;
}
?>

<div class="prod_wrap">
  <h2 class="pg_tit">
    <span><?php echo $ca['catename']; ?></span>
    <p class="pg_nav">HOME<?php echo get_move($ca_id); ?></p>
  </h2>

  <?php
  $cgy = get_category_head_image($ca_id);
  echo $cgy['headimg']; // 분류별 상단이미지

  echo tree_category($ca_id); // 하위분류
  ?>

  <div class="tab_sort">
    <span class="total">전체상품 <b class="fc_90" id="total"><?php echo number_format($total_count); ?></b>개</span>
    <ul>
      <?php echo $sort_str; // 탭메뉴 ?>
    </ul>
    <select id="page_rows" onchange="location='<?php echo "{$_SERVER['SCRIPT_NAME']}?{$qstr3}";?>&page_rows='+this.value;">
      <?php echo option_selected(($mod*5),  $page_rows, '5줄 정렬'); ?>
      <?php echo option_selected(($mod*10), $page_rows, '10줄 정렬'); ?>
      <?php echo option_selected(($mod*15), $page_rows, '15줄 정렬'); ?>
    </select>
  </div>

  <div class="cf contents prod_list">
    <div class="prod_list_wrap">
      <ul class="pr_list_ul">
      <?php
      for($i=0; $row=sql_fetch_array($result); $i++) {
        $it_href = BV_MNG_SHOP_URL.'/view.php?index_no='.$row['index_no'];
        $it_image = get_it_image($row['index_no'], $row['simg1'], 235, 235);
        $it_name = cut_str($row['gname'], 100);
        $it_price = get_price($row['index_no']);
        $it_amount = get_sale_price($row['index_no']);
        $it_point = display_point($row['gpoint']);

        $is_uncase = is_uncase($row['index_no']);
        $is_free_baesong = is_free_baesong($row);
        $is_free_baesong2 = is_free_baesong2($row);

        // (시중가 - 할인판매가) / 시중가 X 100 = 할인률%
        $it_sprice = $sale = '';
        if($row['normal_price'] > $it_amount && !$is_uncase) {
          $sett = ($row['normal_price'] - $it_amount) / $row['normal_price'] * 100;
          $sale = '<p class="sale">'.number_format($sett,0).'<span>%</span></p>';
          $it_sprice = display_price2($row['normal_price']);
        }

        // 수량체크 (무제한 체크 경우)
        if(!$row['stock_mod']) {
          $row['stock_qty'] = 999999999;
        }

        // 필수 옵션
        $option_item = get_item_options($row['index_no'], $row['opt_subject']);
      ?>
        <li id="pr_item<?php echo $row['index_no'];?>" class="pr_item">
          <input type="hidden" name="pr_id" value="<?php echo $row['index_no'];?>">
          <input type="hidden" class="io_stock" value="<?php echo $row['stock_qty']; ?>">

          <a href="<?php echo $it_href;?>" class="it_li_top">
            <dl>
              <dt><?php echo $it_image; ?></dt>
              <dd class="pname"><?php echo $it_name; ?></dd>
              <dd class="price"><?php echo $it_price; ?></dd>
            </dl>
          </a>

          <?php if($option_item) { ?>
          <div class="it_li_option">
            <?php echo $option_item; ?>
          </div>
          <?php } ?>

          <div class="it_li_add">
            <button type="button" class="qty-btn minus"></button>
            <input type="text" name="" id="" value="1" class="qty-input">
            <button type="button" class="qty-btn plus"></button>
            <button type="button" class="add-list-btn"></button>
          </div>

        </li>
      <?php } ?>
      </ul>
    </div>

    <?php include_once(BV_THEME_PATH.'/sct_sub.php'); ?>
  </div>

  <?php if(!$total_count) { ?>
  <div class="empty_list bb">자료가 없습니다.</div>
  <?php } ?>

  <?php
  echo get_paging($config['write_pages'], $page, $total_page, $_SERVER['SCRIPT_NAME'].'?'.$qstr1.'&page=');
  ?>

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

  const addItem = (itid, name, qty, stock, price, opt=null) => {
    const selectedItemBox = $(".sct_cart_wrap .sct_cart_ct_ul");
    let selectedItemPrice;
    selectedItemPrice = price * qty;
    let hasItem = duplCheck(itid);

    if(!hasItem) { //새로 담는 상품이라면
      if(!opt){ //옵션이 없다면
        selectedItemBox.append(`
        <li id="sct_add_goods${itid}" class="sct_add_goods">
          <input type="hidden" name="gs_id[]" value="${itid}">
          <input type="hidden" class="gs_price" value="${price}">

          <input type="hidden" name="io_type[${itid}][]" value="0">
          <input type="hidden" name="io_id[${itid}][]" value="">
          <input type="hidden" name="io_value[${itid}][]" value="${name}">
          <input type="hidden" class="io_price" value="0">
          <input type="hidden" class="io_stock" value="${stock}">

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
        </li>
        `);
      } else { //옵션이 있다면
        let price2 = parseInt(opt.io_price) + parseInt(opt.io_amt);
        selectedItemPrice = (parseInt(opt.io_price) + parseInt(opt.io_amt)) * qty;
        let optInfo = opt.io_value.split(','); // 옵션 분할
        let optInfo1 = opt.io_id.split('');

        selectedItemBox.append(`
        <li id="sct_add_goods${itid}" class="sct_add_goods useOpt">
          <input type="hidden" class="io_id" name="gs_id[]" value="${itid}">
          <input type="hidden" class="gs_price" value="${price2}">

          <input type="hidden" name="io_type[${itid}][]" value="0">
          <input type="hidden" name="io_id[${itid}][]" value="${opt.io_id}">
          <input type="hidden" name="io_value[${itid}][]" value="${opt.io_value}" class="gs_optInfo">
          <input type="hidden" class="io_price" value="${opt.io_price}">
          <input type="hidden" class="io_stock" value="${opt.io_stock}">

          <div class="info">
            <p class="subject">${name}</p>
            <span class="option">
              <span class="item">옵션 : ${optInfo1[0]} (${optInfo[0]}) ${addCommas(optInfo[1])}원</span>
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
        </li>
        `);
      }

      selectedItemArray.push(itid);
    } else { //이미 담긴 상품이라면
      let currentQty = 0;

      if(!opt){ // 옵션이 없다면
        currentQty = parseInt($(`#sct_add_goods${itid} .qty-input`).val());
        let newQty = currentQty + qty; 
        selectedItemPrice = price * newQty;

        $(`#sct_add_goods${itid} .qty-input`).val(newQty);
        $(`#sct_add_goods${itid} .goods_price`).text(addCommas(selectedItemPrice));
      }else{ // 옵션이 있다면
        
        let optValue = opt.io_value;

        // 이미 그려진 상품들 중에서 동일한 옵션값을 가진 상품이 있는지 확인
        let existingItem = $(".sct_cart_wrap .sct_cart_ct_ul").find(`.sct_add_goods.useOpt .gs_optInfo[value="${optValue}"]`).closest(".sct_add_goods");

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

          selectedItemBox.append(`
          <li id="sct_add_goods${itid}" class="sct_add_goods useOpt">
            <input type="hidden" class="io_id" name="gs_id[]" value="${itid}">
            <input type="hidden" class="gs_price" value="${price2}">

            <input type="hidden" name="io_type[${itid}][]" value="0">
            <input type="hidden" name="io_id[${itid}][]" value="${opt.io_id}">
            <input type="hidden" name="io_value[${itid}][]" value="${opt.io_value}" class="gs_optInfo">
            <input type="hidden" class="io_price" value="${opt.io_price}">
            <input type="hidden" class="io_stock" value="${opt.io_stock}">

            <div class="info">
              <p class="subject">${name}</p>
              <span class="option">
                <span class="item">옵션 : ${optInfo1[0]} (${optInfo[0]}) ${addCommas(optInfo[1])}원</span>
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
          </li>
          `);
        }

      }
    }

    // console.log(selectedItemArray);
  }

  $(document).ready(function(){
    const addListBtn = $(".add-list-btn");
    const qtyMinusBtn = ".qty-btn.minus";
    const qtyPlusBtn = ".qty-btn.plus";

    // 수량 감소
    $(".prod_list").on('click', qtyMinusBtn, function(){
      let qtyInput = $(this).siblings(".qty-input");
      let curQty = qtyInput.val();
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
    });

    // 수량 증가
    $(".prod_list").on('click', qtyPlusBtn, function(){
      let qtyInput = $(this).siblings(".qty-input");
      let curQty = qtyInput.val();
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
    });

    // 상품 선택하기
    addListBtn.on('click', function(){
      let $tgItem = $(this).closest('.pr_item');
      let itemId = $tgItem.find('input[name=pr_id]').val();
      let itemName = $tgItem.find('.pname').text();
      let itemQty = parseInt($tgItem.find('.qty-input').val());
      let itemStock = parseInt($tgItem.find('.io_stock').val());
      let itemPriceText = $tgItem.find('.mpr').text();
      let itemPrice = reNumber(itemPriceText);
      let itemOpt = "";
      let emptyEl = $(".sct_cart_empty");

      if($tgItem.find('.it_li_option').length > 0) { //옵션이 있는 상품이라면

        if($tgItem.find('.it_option').val() == ''){ // 옵션 선택을 안하면
          alert('필수 옵션을 선택해주세요.');
          return false;
        }

        let id = "";
        let value, item, sel_opt = false;
        let option = sep = "";
        let info = $tgItem.find('.it_option:last').val().split(',');

        $tgItem.find('.it_option').each(function(index) {
          value = $(this).val();
          // value = $tgItem.find('.it_option').val();
          item = $(this).closest("dl").find("dt label").text();

          // 옵션선택정보
          sel_opt = value.split(",")[0];

          if(id == "") {
              id = sel_opt;
          } else {
              // id += chr(30)+sel_opt;
              id += String.fromCharCode(30)+sel_opt;
              sep = " / ";
          }

          option += sep + item + ":" + sel_opt;
        });

        price = info[1];
        stock = info[2];
        amt = info[3];

        /*
        io_id : '100g',
        io_value : '무게:100g / 상태:B',
        io_price : '1000',
        io_stock : '100'
        */
        itemOpt = {
          io_id : id,
          io_value : value,
          io_price : price,
          io_stock : stock,
          io_amt : amt,
        }
      }

      emptyEl.hide();

      // 선택 상품
      addItem(itemId, itemName, itemQty, itemStock, itemPrice, itemOpt);

      // 총 가격
      let totalPrice = totalCalc('.sct_add_goods', '.goods_price');
      let $totalEl = $(".sct_cart_wrap .sct_cart_ct_total-pri strong.price");

      $totalEl.text(addCommas(totalPrice));
    });
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
  })
  </script>
</div>
