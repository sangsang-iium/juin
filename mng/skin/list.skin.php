<?php
if(!defined('_BLUEVATION_')) exit;

if(!empty($paytype)){
  $paytypeurl = "&paytype=".$paytype;
} else {
  $paytype = 2;
}

if (isset($_SERVER['HTTP_REFERER'])) {
  $referer_url = $_SERVER['HTTP_REFERER'];

  $query_string = parse_url($referer_url, PHP_URL_QUERY);
  parse_str($query_string, $query_params);

  $pre_paytype = isset($query_params['paytype']) ? $query_params['paytype'] : 2;

} else {
  $pre_paytype = 2;
}

if($pre_paytype != $paytype){
  unset($_SESSION['myCart']);
}


$qstr1 = 'ca_id='.$ca_id.'&page_rows='.$page_rows.'&sort='.$sort.'&sortodr='.$sortodr.$paytypeurl;
$qstr2 = 'ca_id='.$ca_id.'&page_rows='.$page_rows.$paytypeurl;
$qstr3 = 'ca_id='.$ca_id.'&sort='.$sort.'&sortodr='.$sortodr;

$sort_str = '';
for($i=0; $i<count($gw_psort); $i++) {
	list($tsort, $torder, $tname) = $gw_psort[$i];

	$sct_sort_href = $_SERVER['SCRIPT_NAME'].'?'.$qstr2.'&sort='.$tsort.'&sortodr='.$torder.$paytypeurl;

	$active = '';
	if($sort == $tsort && $sortodr == $torder)
		$active = ' class="active"';
	if($i==0 && !($sort && $sortodr))
		$active = ' class="active"';

	$sort_str .= '<li><a href="'.$sct_sort_href.'"'.$active.'>'.$tname.'</a></li>'.PHP_EOL;
}

// 상품 선택옵션
function get_item_options2($gs_id, $subject)
{
  if(!$gs_id || !$subject)
    return '';

  $amt = get_sale_price($gs_id);

  $sql = " select * from shop_goods_option where io_type = '0' and gs_id = '$gs_id' and io_use = '1' order by io_no asc ";
  $result = sql_query($sql);
  if(!sql_num_rows($result))
    return '';

  $str = '';
  $subj = explode(',', $subject);
  $subj_count = count($subj);

  if($subj_count > 1) {
    $options = array();

    // 옵션항목 배열에 저장
    for($i=0; $row=sql_fetch_array($result); $i++) {
      $opt_id = explode(chr(30), $row['io_id']);

      for($k=0; $k<$subj_count; $k++) {
        if(!is_array($options[$k]))
          $options[$k] = array();

        if($opt_id[$k] && !in_array($opt_id[$k], $options[$k]))
          $options[$k][] = $opt_id[$k];
      }
    }

    // 옵션선택목록 만들기
    for($i=0; $i<$subj_count; $i++) {
      $opt = $options[$i];
      $opt_count = count($opt);
      $disabled = '';
      if($opt_count) {
        $seq = $i + 1;
        if($i > 0)
          $disabled = ' disabled="disabled"';
        $str .= '<dl>'.PHP_EOL;
        $str .= '<dt><label for="it_option_'.$seq.'" class="sound_only">'.$subj[$i].'</label></dt>'.PHP_EOL;

        $select  = '<select id="it_option_'.$seq.'" class="it_option wfull"'.$disabled.'>'.PHP_EOL;
        $select .= '<option value="">'.$subj[$i].'</option>'.PHP_EOL;
        for($k=0; $k<$opt_count; $k++) {
          $opt_val = $opt[$k];
          if($opt_val) {
            $select .= '<option value="'.$opt_val.'">'.$opt_val.'</option>'.PHP_EOL;
          }
        }
        $select .= '</select>'.PHP_EOL;

        $str .= '<dd class="li_select">'.$select.'</dd>'.PHP_EOL;
        $str .= '</dl>'.PHP_EOL;
      }
    }
  } else {
    $str .= '<dl>'.PHP_EOL;
    $str .= '<dt><label for="it_option_1" class="sound_only">'.$subj[0].'</label></dt>'.PHP_EOL;

    $select  = '<select id="it_option_1" class="it_option wfull">'.PHP_EOL;
    $select .= '<option value="">'.$subj[0].'</option>'.PHP_EOL;
    for($i=0; $row=sql_fetch_array($result); $i++) {
      if($row['io_price'] >= 0)
        $price = '&nbsp;&nbsp;(+'.display_price($row['io_price']).')';
      else
        $price = '&nbsp;&nbsp;('.display_price($row['io_price']).')';

      if(!$row['io_stock_qty'])
        $soldout = '&nbsp;&nbsp;[품절]';
      else
        $soldout = '';

      $select .= '<option value="'.$row['io_id'].','.$row['io_price'].','.$row['io_stock_qty'].','.$amt.'">'.$row['io_id'].$price.$soldout.'</option>'.PHP_EOL;
    }
    $select .= '</select>'.PHP_EOL;

    $str .= '<dd class="li_select">'.$select.'</dd>'.PHP_EOL;
    $str .= '</dl>'.PHP_EOL;
  }
  return $str;
}

function tree_category_pc($catecode)
{
	global $pt_id;

	$str = "";

	$t_catecode = $catecode;

	$sql_common = " from shop_category ";
	$sql_where  = " where cateuse = '0' and find_in_set('$pt_id', catehide) = '0' ";
	$sql_order  = " order by caterank, catecode ";

	$sql = " select count(*) as cnt {$sql_common} {$sql_where} and upcate = '$catecode' ";
	$res = sql_fetch($sql);
	if($res['cnt'] < 1) {
		$catecode = substr($catecode,0,-3);
	}

	$mod = 5; // 1줄당 노출 수
	$li_width = (int)(100 / $mod);

	$sql = "select * {$sql_common} {$sql_where} and upcate = '$catecode' {$sql_order} ";

	$result = sql_query($sql);
	for($i=0; $row=sql_fetch_array($result); $i++) {
		if($i==0) $str .= '<ul class="sub_tree">'.PHP_EOL;

		$addclass = "";
		if($t_catecode==$row['catecode'])
			$addclass = ' class="active"';

		$href = BV_URL.'/mng/?ca_id='.$row['catecode'];
		$str .= "<li style=\"width:{$li_width}%\"{$addclass}><a href=\"{$href}\">{$row['catename']}</a></li>".PHP_EOL;
	}

	if($i > 0) $str .= '</ul>'.PHP_EOL;

	return $str;
}

function get_move_pc($ca_id)
{
	$str = "";

	$len = strlen($ca_id);
	for($i=1;$i<=($len/3);$i++) {
		$cut_id = substr($ca_id,0,($i*3));
		$row = sql_fetch("select * from shop_category where catecode='$cut_id' ");

		$href = BV_URL.'/mng/?ca_id='.$row['catecode'];

		$str = $str." <i class=\"ionicons ion-ios-arrow-right\"></i> "."<a href='{$href}'>{$row['catename']}</a>";
	}

	return $str;
}
?>

<div class="prod_wrap">
  <h2 class="pg_tit">
    <span><?php echo $ca['catename']; ?></span>
    <p class="pg_nav">HOME<?php echo get_move_pc($ca_id); ?></p>
  </h2>
  <div id="" class="sub_tree">
    <fieldset class="sch_frm">
      <form name="fsearch" id="fsearch" method="post" onsubmit="return fsearch_submit(this);" autocomplete="off" class="f_between">
        <div class="msg_sch_left">
          <span>
            <a href="/mng/shop/orderinquiry.php">이전상품주문</a> /
            <a href="/mng/" class="f_now">주문가능상품</a>
          </span>
        </div>
        <div class="msg_sch_right">
          <span>
            <a href="/mng/?paytype=2" class="<?php echo $paytype == "2"?"f_now":"" ?>">일반배송</a>
            <a href="/mng/?paytype=1" class="<?php echo $paytype == "1"?"f_now":"" ?>">정기배송</a>
          </span>
          <span>
          <input type="hidden" name="hash_token" value="<?php echo BV_HASH_TOKEN; ?>">
          <input type="text" name="stx" class="" maxlength="20" placeholder="검색어를 입력해주세요">
          <button type="submit" class="sch_submit fa fa-search" value="검색"></button>
          </span>
        </div>
        </form>
        <script>
          function fsearch_submit(f){
            if(!f.stx.value){
              alert('검색어를 입력하세요.');
              return false;
            }
            return true;
          }
        </script>
    </fieldset>
  </div>

  <?php
  $cgy = get_category_head_image($ca_id);
  echo $cgy['headimg']; // 분류별 상단이미지

  // echo tree_category_pc($ca_id); // 하위분류
  ?>
  <!-- <ul class="sub_tree">
    <li style="width:20%" class= "<?php //echo $ca_id == "001"?"active":"" ?>"><a href="https://juinjang.kr/mng/?ca_id=001">농수산</a></li>
    <li style="width:20%" class= "<?php //echo $ca_id == "002"?"active":"" ?>"><a href="https://juinjang.kr/mng/?ca_id=002">축산(육가공)</a></li>
    <li style="width:20%" class= "<?php //echo $ca_id == "003"?"active":"" ?>"><a href="https://juinjang.kr/mng/?ca_id=003">위생/주방용품</a></li>
    <li style="width:20%" class= "<?php //echo $ca_id == "004"?"active":"" ?>"><a href="https://juinjang.kr/mng/?ca_id=004">종합식자재</a></li>
    <li style="width:20%" class= "<?php //echo $ca_id == "005"?"active":"" ?>"><a href="https://juinjang.kr/mng/?ca_id=005">수미안 전용관</a></li>
    <li style="width:20%" class= "<?php //echo $ca_id == "006"?"active":"" ?>"><a href="https://juinjang.kr/mng/?ca_id=006">회원 전용관</a></li>
  </ul> -->

  <div class="tab_sort">
    <span class="total">전체상품 <b class="fc_90" id="total"><?php echo number_format($total_count); ?></b>개</span>
    <ul>
      <?php echo $sort_str; // 탭메뉴 ?>
    </ul>
    <!-- <select id="page_rows" onchange="location='<?php //echo "{$_SERVER['SCRIPT_NAME']}?{$qstr3}";?>&page_rows='+this.value;">
      <?php //echo option_selected(($mod*5),  $page_rows, '5줄 정렬'); ?>
      <?php //echo option_selected(($mod*10), $page_rows, '10줄 정렬'); ?>
      <?php //echo option_selected(($mod*15), $page_rows, '15줄 정렬'); ?>
    </select> -->
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
        $option_item = get_item_options2($row['index_no'], $row['opt_subject']);
      ?>
        <li id="pr_item<?php echo $row['index_no'];?>" class="pr_item">
          <input type="hidden" name="pr_id" value="<?php echo $row['index_no'];?>">
          <input type="hidden" class="io_stock" value="<?php echo $row['stock_qty']; ?>">

          <a href="<?php echo $it_href;?>" class="it_li_top">
            <dl>
              <dt>
                <?php echo $it_image; ?>
                <?php
                  switch ($row['sc_type']) {
                    case '1':
                      $scType = "택배";
                      break;
                    case '4':
                      $scType = "차량";
                      break;

                    default:
                      $scType ="택배";
                      break;
                  }
                  echo "<span style='background-color: black;color: white;position: absolute;top: 0;right: 0;'>$scType</span>";
                ?>
              </dt>
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
          <input type="hidden" name="io_stoce[]" class="io_stock" value="${stock}">

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
        let optInfo = opt.io_value.split(','); // 옵션 분할
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
            <input type="hidden" class="gs_price" name="gs_price[]" value="${price2}">

            <input type="hidden" name="gs_name[${itid}][]" value="${name}">
            <input type="hidden" name="io_type[${itid}][]" value="0">
            <input type="hidden" name="io_id[${itid}][]" value="${opt.io_id}">
            <input type="hidden" name="io_value[${itid}][]" value="${optval}" class="gs_optInfo">
            <input type="hidden" name-"io_price[]" class="io_price" value="${opt.io_price}">
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
    $(".prod_list").on('click', qtyMinusBtn, function(){
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
    $(".prod_list").on('click', qtyPlusBtn, function(){
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
      let itemName = $tgItem.find('.pname').text();
      let itemQty = parseInt($tgItem.find('.qty-input').val());
      let itemStock = parseInt($tgItem.find('.io_stock').val());
      let itemPriceText = $tgItem.find('.mpr').text();
      let itemPrice = reNumber(itemPriceText);
      let itemOpt = "";
      let itemValue = "";
      let optId = "";

      let price, stock, amt = 0;

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
          let selectedIndex = $(this).prop('selectedIndex');

          if(index == 0) {
            optId = selectedIndex;
          } else {
            optId = optId+"_"+selectedIndex;
          }



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

          itemValue = option;
        });

        price = info[1];
        stock = info[2];
        amt = info[3];

        itemOpt = {
          io_id : id,
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


      // option 값도 같이 체크하는 작업 필요 _20240411_SY

      let gsIdValues = $('input[name^="gs_id"]').map(function() {
        return $(this).val(); // 각 요소의 값 반환
      }).get();
      if (gsIdValues . includes(itemId)) {
        alert("같은 상품이 담겨 있습니다.");
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

    $(".prod_list").on('keyup', qtyInputs, function(){
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
</div>
