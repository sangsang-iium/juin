<?php
include_once('./_common.php');
include_once(BV_SHOP_PATH.'/settle_naverpay.inc.php');
include_once(BV_LIB_PATH.'/naverpay.lib.php');

$pattern = '#[/\'\"%=*\#\(\)\|\+\&\!\$~\{\}\[\]`;:\?\^\,]#';

$is_collect = false;    //착불체크 변수 초기화
$is_prepay = false;     //선불체크 변수 초기화
$is_cart = false;       //장바구니 체크 변수 초기화

if($_POST['naverpay_form'] == 'cart.php') {
    if(!count($_POST['ct_chk']))
        return_error2json('구매하실 상품을 하나이상 선택해 주십시오.');

    $fldcnt = count($_POST['gs_id']);
    $items = array();

    for($i=0; $i<$fldcnt; $i++) {
        $ct_chk = $_POST['ct_chk'][$i];

        if(!$ct_chk)
            continue;

        $gs_id = preg_replace($pattern, '', $_POST['gs_id'][$i]);

        // 장바구니 상품
        $sql = " select * 
				   from shop_cart 
				  where gs_id = '$gs_id' 
				    and ct_direct = '$set_cart_id' 
					and ct_select = '0' 
				  order by index_no asc ";
        $result = sql_query($sql);

        for($k=0; $row=sql_fetch_array($result); $k++) {
            $_POST['io_id'][$gs_id][] = $row['io_id'];
            $_POST['io_type'][$gs_id][] = $row['io_type'];
            $_POST['ct_qty'][$gs_id][] = $row['ct_qty'];
            $_POST['io_value'][$gs_id][] = $row['ct_option'];
            $_POST['ct_send_cost'][$gs_id][] = $row['ct_send_cost'];

            $is_free = false;   //무료 인지 체크 변수 초기화			

			// 합계금액 계산
			$sql = " select SUM(IF(io_type = 1, (io_price * ct_qty),((io_price + ct_price) * ct_qty))) as price
						from shop_cart
					   where gs_id = '$row[gs_id]'
						 and ct_direct = '$set_cart_id'
						 and ct_select = '0'";
			$sum = sql_fetch($sql);

			$gs = get_goods($row['gs_id']);
			
			if($gs['use_aff'])
				$sr = get_partner($gs['mb_id']);
			else
				$sr = get_seller_cd($gs['mb_id']);

			$sendcost = get_sendcost_amt2($row['gs_id'], $sum['price']);

			if($sendcost == 0)
				$is_free = true;

            if( !$is_free && !$row['ct_send_cost'] ){  //무료가 아니며 선불인 경우
                $is_prepay = true;
            } else if( !$is_free && $row['ct_send_cost'] == 1 ){   //무료가 아니며 착불인 경우
                $is_collect = true;
            }
        }

        if($k > 0)
            $items[] = $gs_id;
    }

    $is_cart = true;
    $_POST['gs_id'] = $items;
}

//착불인 상품과 선불인 상품을 주문할수 없게 하려면
/*
if( $is_cart && $is_prepay && $is_collect ){
    return_error2json("배송비 착불인 상품과 선불인 상품을 동시에 주문할수 없습니다.\n\n장바구니에서 착불 또는 선불 중 한가지를 선택하여 상품들을 주문해 주세요.");
}
*/

$count = count($_POST['gs_id']);
if($count < 1)
    return_error2json('구매하실 상품을 선택하여 주십시오.');

$itm_ids     = array();
$sel_options = array();
$sup_options = array();

if($_POST['naverpay_form'] == 'view.php')
    $back_uri = '/view.php?index_no='.$_POST['gs_id'][0];
else if($_POST['naverpay_form'] == 'cart.php')
    $back_uri = '/cart.php';
else
    $back_uri = '';

define('NAVERPAY_BACK_URL', BV_SHOP_URL.$back_uri);

for($i=0; $i<$count; $i++) {
    $gs_id = preg_replace($pattern, '', $_POST['gs_id'][$i]);
    $opt_count = count($_POST['io_id'][$gs_id]);

    if($opt_count && $_POST['io_type'][$gs_id][0] != 0)
        return_error2json('상품의 주문옵션을 선택해 주십시오.');

    for($k=0; $k<$opt_count; $k++) {
        if($_POST['ct_qty'][$gs_id][$k] < 1)
            return_error2json('수량은 1 이상 입력해 주십시오.');
    }

    // 상품정보
    $sql = " select * from shop_goods where index_no = '$gs_id' ";
    $gs = sql_fetch($sql);
    if(!$gs['index_no'])
        return_error2json('상품정보가 존재하지 않습니다.');

    if($gs['isopen'] > 1 || $gs['shop_state'] || $gs['price_msg'])
        return_error2json($gs['gname'].' 는(은) 구매할 수 없는 상품입니다.');

	if($gs['odr_min']) // 최소구매수량
		$odr_min = (int)$gs['odr_min'];
	else
		$odr_min = 1;

	if($gs['odr_max']) // 최대구매수량
		$odr_max = (int)$gs['odr_max'];
	else
		$odr_max = 0;

    // 최소, 최대 수량 체크
    if($odr_min || $odr_max) {
        $sum_qty = 0;
        for($k=0; $k<$opt_count; $k++) {
            if($_POST['io_type'][$gs_id][$k] == 0)
                $sum_qty += $_POST['ct_qty'][$gs_id][$k];
        }

        if($odr_min > 0 && $sum_qty < $odr_min)
            return_error2json($gs['gname'].'의 주문옵션 개수 총합 '.number_format($odr_min).'개 이상 주문해 주십시오.');

        if($odr_max > 0 && $sum_qty > $odr_max)
            return_error2json($gs['gname'].'의 주문옵션 개수 총합 '.number_format($odr_max).'개 이하로 주문해 주십시오.');
    }

    // 옵션정보를 얻어서 배열에 저장
    $opt_list = array();
    $sql = " select * from shop_goods_option where gs_id = '$gs_id' order by io_no asc ";
    $result = sql_query($sql);
    $lst_count = 0;
    for($k=0; $row=sql_fetch_array($result); $k++) {
        $opt_list[$row['io_type']][$row['io_id']]['id'] = $row['io_id'];
        $opt_list[$row['io_type']][$row['io_id']]['use'] = $row['io_use'];
        $opt_list[$row['io_type']][$row['io_id']]['price'] = $row['io_price'];
        $opt_list[$row['io_type']][$row['io_id']]['stock'] = $row['io_stock_qty'];

        // 주문옵션 개수
        if(!$row['io_type'])
            $lst_count++;
    }

    //--------------------------------------------------------
    //  재고 검사
    //--------------------------------------------------------
    for($k=0; $k<$opt_count; $k++) {
        $io_id = preg_replace(BV_OPTION_ID_FILTER, '', trim(stripslashes($_POST['io_id'][$gs_id][$k])));
        $io_type = (int) $_POST['io_type'][$gs_id][$k];
        $io_value = $_POST['io_value'][$gs_id][$k];
       
        // 재고 구함
        $ct_qty = (int) $_POST['ct_qty'][$gs_id][$k];
        if(!$io_id)
            $it_stock_qty = get_it_stock_qty($gs_id);
        else
            $it_stock_qty = get_option_stock_qty($gs_id, $io_id, $io_type);

        if($ct_qty > $it_stock_qty)
        {
            return_error2json($io_value." 의 재고수량이 부족합니다.\\n\\n현재 재고수량 : " . number_format($it_stock_qty) . " 개");
        }
    }
    //--------------------------------------------------------

    $itm_ids[] = $gs_id;

    for($k=0; $k<$opt_count; $k++) {
        $io_id = preg_replace(BV_OPTION_ID_FILTER, '', trim(stripslashes($_POST['io_id'][$gs_id][$k])));
        $io_type = (int) $_POST['io_type'][$gs_id][$k];
        $io_value = $_POST['io_value'][$gs_id][$k];

        // 주문옵션정보가 존재하는데 선택된 옵션이 없으면 건너뜀
        if($lst_count && $io_id == '')
            continue;

        // 구매할 수 없는 옵션은 건너뜀
        if($io_id && !$opt_list[$io_type][$io_id]['use'])
            continue;

        $io_price = $opt_list[$io_type][$io_id]['price'];
        $ct_qty = (int) $_POST['ct_qty'][$gs_id][$k];

        $it_price = get_sale_price($gs_id);

        // 구매가격이 음수인지 체크
        if($io_type) {
            if((int)$io_price <= 0)
                return_error2json('구매금액이 음수 또는 0원인 상품은 구매할 수 없습니다.');
        } else {
            if((int)$it_price + (int)$io_price <= 0)
                return_error2json('구매금액이 음수 또는 0원인 상품은 구매할 수 없습니다.');
        }

        if( $is_cart && !empty($_POST['ct_send_cost'][$gs_id][$k]) ){
            $ct_send_cost = $_POST['ct_send_cost'][$gs_id][$k];
        } else {
            // 배송비결제
            if($gs['sc_type'] == 1)
                $ct_send_cost = 2; // 무료
            else if($gs['sc_type'] > 1 && $gs['sc_method'] == 1)
                $ct_send_cost = 1; // 착불
        }

        // 조건부 무료배송시 착불일 경우 ( 야수님이 알려주심 )
        if($gs['sc_type'] === 2 && $ct_send_cost === 1 && ((int)$io_price + (int)$it_price) * $ct_qty >= $gs['sc_minimum'] ){
            $ct_send_cost = 2; // 무료
        }

        // 옵션정보배열에 저장
        $options[$gs_id][] = array(
            'option'    => get_text(stripslashes($io_value)),
            'price'     => $io_price,
            'qty'       => $ct_qty,
            'send_cost' => $ct_send_cost,
            'type'      => $io_type,
            'io_id'     => $io_id
        );
    }
}

$order = new naverpay_register($options, $ct_send_cost);
$query = $order->query();
$totalPrice = $order->total_price;

//echo $query.'<br>'.PHP_EOL;

$nc_sock = @fsockopen($req_addr, $req_port, $errno, $errstr);
if ($nc_sock) {
    fwrite($nc_sock, $buy_req_url."\r\n" );
    fwrite($nc_sock, "Host: ".$req_host.":".$req_port."\r\n" );
    fwrite($nc_sock, "Content-type: application/x-www-form-urlencoded; charset=utf-8\r\n");
    fwrite($nc_sock, "Content-length: ".strlen($query)."\r\n");
    fwrite($nc_sock, "Accept: */*\r\n");
    fwrite($nc_sock, "\r\n");
    fwrite($nc_sock, $query."\r\n");
    fwrite($nc_sock, "\r\n");

    // get header
    while(!feof($nc_sock)) {
        $header=fgets($nc_sock,4096);
        if($header=="\r\n") {
            break;
        } else {
            $headers .= $header;
        }
    }
    // get body
    while(!feof($nc_sock)) {
        $bodys.=fgets($nc_sock,4096);
    }

    fclose($nc_sock);

    $resultCode = substr($headers,9,3);
    if ($resultCode == 200) {
        // success
        $orderId = $bodys;
    } else {
        // fail
        return_error2json($bodys);
    }
} else {
    //echo "$errstr ($errno)<br>\n";
    return_error2json($errstr ($errno));
    exit(-1);
    //에러처리
}

if($resultCode == 200)
    die(json_encode(array('error'=>'', 'ORDER_ID'=>$orderId, 'SHOP_ID'=>$default['de_naverpay_mid'], 'TOTAL_PRICE'=>$totalPrice)));
?>