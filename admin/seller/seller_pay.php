<?php
if(!defined('_BLUEVATION_')) exit;

if(!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $fr_date)) $fr_date = '';
if(!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $to_date)) $to_date = '';


$query_string = "code=$code$qstr";
$q1 = $query_string;
$q2 = $query_string."&page=$page";

$sql_common = " from shop_order a, shop_seller b ";
$sql_search = " where a.seller_id = b.seller_code
				  and left(a.seller_id,3)='AP-'
				  and a.dan IN(5,8)
				  and a.sellerpay_yes = '0'
				  and a.user_ok = '1' ";

if($sfl && $stx) {
    if($sfl == 'all') {
		$allColumns = array("b.company_name" , "b.seller_code" , "b.mb_id");
		$sql_search .= allSearchSql($allColumns,$stx);
	} else {
        $sql_search .= " and $sfl like '%$stx%' ";
    }
}


// 주문일 검색 수정 _20240513_SY
$time = time();
$bf_month = date("Y-m-d",strtotime("-1 month", $time));
$now_date = date("Y-m-d");
if($fr_date && $to_date) {
  $sql_search .= " and left(a.od_time,10) between '$fr_date' and '$to_date' ";
}
if(!isset($_GET['fr_date']) && !isset($_GET['to_date'])) {
	$sql_search .= " and left(a.od_time,10) between '$bf_month' and '$now_date' ";
}

// 주문상태 검색조건 추가 _20240509_SY
if(isset($od_status))		 $qstr .= "&od_status=$od_status";
if(is_numeric($od_status))
	$sql_search .= " AND dan = '$od_status' ";


$sql_order = " group by a.seller_id order by a.index_no desc ";

// 테이블의 전체 레코드수만 얻음
$sql = " select count(DISTINCT a.seller_id) as cnt $sql_common $sql_search ";
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = 30;
$total_page = ceil($total_count / $rows); // 전체 페이지 계산
if($page == "") { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함
$num = $total_count - (($page-1)*$rows);

// sellerTable > income 내용 추가 _20240509_SY
$add_seller_income = " ,b.income_type, b.income_per_type, b.income_price, b.income_per ";

// b.settle 추가 _20240402_SY
$sql = " select a.*, b.mb_id, b.company_name, b.settle $add_seller_income $sql_common $sql_search $sql_order limit $from_record, $rows ";
$result = sql_query($sql);

include_once(BV_PLUGIN_PATH.'/jquery-ui/datepicker.php');

$btn_frmline = <<<EOF
<input type="submit" name="act_button" value="선택정산" class="btn_lsmall bx-white" onclick="document.pressed=this.value">
<a href="./seller/seller_pay_excel.php?$q1" class="btn_lsmall bx-white"><i class="fa fa-file-excel-o"></i> 엑셀저장</a>
EOF;
?>

<div class="btn_wrap tal">
    <a href="./seller.php?code=pay" class="link_type1 marr10">
        <span>미정산내역</span>
    </a>
    <a href="./seller.php?code=pay_history" class="link_type2">
        <span>정산완료내역</span>
    </a>
</div>

<p class="gap50"></p>
<h5 class="htag_title">기본검색</h5>
<p class="gap20"></p>
<form name="fsearch" id="fsearch" method="get">
<input type="hidden" name="code" value="<?php echo $code; ?>">
<div class="board_table">
	<table>
	<colgroup>
		<col style="width:220px;">
		<col style="width:auto">
	</colgroup>
	<tbody>
	<tr>
		<th scope="row">검색어</th>
		<td>
            <div class="tel_input">
                <div class="chk_select w200">
                    <select name="sfl">
                        <?php echo option_selected('all', $sfl, '전체'); ?>
                        <?php echo option_selected('b.company_name', $sfl, '공급사명'); ?>
                        <?php echo option_selected('b.seller_code', $sfl, '업체코드'); ?>
                        <?php echo option_selected('b.mb_id', $sfl, '아이디'); ?>
                    </select>
                </div>
                <input type="text" name="stx" value="<?php echo $stx; ?>" class="frm_input" size="30">
            </div>
		</td>
	</tr>
	<tr>
		<th scope="row">주문일</th>
		<td>
            <div class="tel_input">
                <?php if(!isset($_GET['fr_date']) && !isset($_GET['$to_date'])) {
                    echo get_search_date("fr_date", "to_date", $bf_month, $now_date);
                } else {
                    echo get_search_date("fr_date", "to_date", $fr_date, $to_date);
                } ?>
            </div>
		</td>
	</tr>
  <tr>
    <th scope="row">주문상태</th>
    <td>
        <div class="radio_group">
            <?php echo radio_checked('od_status', $od_status,  '', '전체'); ?>
            <?php echo radio_checked('od_status', $od_status, '1', $gw_status[1]); ?>
            <?php echo radio_checked('od_status', $od_status, '2', $gw_status[2]); ?>
            <?php echo radio_checked('od_status', $od_status, '3', $gw_status[3]); ?>
            <?php echo radio_checked('od_status', $od_status, '4', $gw_status[4]); ?>
            <?php echo radio_checked('od_status', $od_status, '5', $gw_status[5]); ?>
        </div>
    </td>
  </tr>
	</tbody>
	</table>
</div>
<div class="btn_confirm">
	<input type="submit" value="검색" class="btn_medium">
	<input type="button" value="초기화" id="frmRest" class="btn_medium grey">
</div>
</form>

<form name="forderlist" id="forderlist" method="post" action="./seller/seller_pay_update.php" onsubmit="return forderlist_submit(this);">
<input type="hidden" name="q1" value="<?php echo $q1; ?>">
<input type="hidden" name="page" value="<?php echo $page; ?>">

<div class="local_ov mart30 fs18">
	전체 : <b class="fc_red"><?php echo number_format($total_count); ?></b> 건 조회
</div>
<div class="local_frm01">
	<?php echo $btn_frmline; ?>
</div>
<div class="tbl_head01">
	<table>
        <thead>
            <tr>
                <th scope="col"><input type="checkbox" name="chkall" value="1" onclick="check_all(this.form);"></th>
                <th scope="col">번호</th>
                <th scope="col">업체코드</th>
                <th scope="col">공급사명</th>
                <th scope="col" class="th_bg">총건수</th>
                <th scope="col" class="th_bg">주문금액</th>
                <th scope="col" class="th_bg">포인트결제</th>
                <th scope="col" class="th_bg">쿠폰할인</th>
                <th scope="col" class="th_bg">배송비</th>
                <th scope="col" class="th_bg">매입가</th>
                <th scope="col" class="th_bg">수수료(정액)</th>
                <th scope="col" class="th_bg">수수료(정률)</th>
                <th scope="col" class="th_bg">정산총액</th>
                <th scope="col">본사마진</th>
                <th scope="col">정산일</th>
                <th scope="col">내역</th>
            </tr>
        </thead>
        <tbody>
            <?php
            for($i=0; $row=sql_fetch_array($result); $i++) {
                $bg = 'list'.($i%2);

                $tot_price	    = 0;
                $tot_point	    = 0;
                $tot_coupon	    = 0;
                $tot_baesong    = 0;
                $tot_supply	    = 0;
                $tot_seller	    = 0;
                $tot_partner    = 0;
                $tot_admin	    = 0;
            $income_price   = 0;
            $income_percent = 0;

                $order_idx	 = array();
                $order_arr	 = array();

            // if($row['settle'] >= 1) {
            //   $add_between = " AND od_time
            //                BETWEEN CONCAT(YEAR(CURDATE() - INTERVAL 1 MONTH), '-', MONTH(CURDATE() - INTERVAL 1 MONTH), '-', {$row['settle']})
            //                    AND LAST_DAY(CURDATE()) ";
            // } else {
            //   $add_between = " AND od_time
            //                BETWEEN CONCAT(YEAR(CURDATE() - INTERVAL 1 MONTH), '-', MONTH(CURDATE() - INTERVAL 1 MONTH), '-', {$row['settle']})
            //                    AND CONCAT(YEAR(CURDATE()), '-', MONTH(CURDATE()), '-', {$row['settle']} - 1) ";
            // }

                $sql2 = " select *
                            from shop_order
                        where seller_id = '{$row['seller_id']}'
                            and dan IN(5,8)
                            and sellerpay_yes = '0'
                            and user_ok = '1'
                ";
                if($fr_date && $to_date) {
                    $sql2 .= " and left(od_time,10) between '$fr_date' and '$to_date' ";
                } else {
            // $sql2 .= "  AND DATE(od_time) BETWEEN DATE_SUB(CURDATE(), INTERVAL 1 MONTH) AND CURDATE() ";
            }

                $res2 = sql_query($sql2);
                while($row2 = sql_fetch_array($res2)) {
                    $psql = " select SUM(pp_pay) as sum_pay
                                from shop_partner_pay
                            where pp_rel_table = 'sale'
                                and pp_rel_id = '{$row2['od_no']}'
                                and pp_rel_action = '{$row2['od_id']}' ";
                    $psum = sql_fetch($psql);

                    $tot_point   += (int)$row2['use_point']; // 포인트결제
                    $tot_supply  += (int)$row2['supply_price']; // 공급가
                    $tot_price   += (int)$row2['goods_price']; // 판매가
                    $tot_baesong += (int)$row2['baesong_price']; // 배송비
                    $tot_coupon  += (int)$row2['coupon_price']; // 쿠폰할인
                    $tot_partner += (int)$psum['sum_pay']; // 가맹점수수료
                    $order_idx[] = $row2['index_no'];
                    $order_arr['od_id'] = $row2['od_id'];

            // 정산액 view 테스트 中 _20240502_SY
            $od_goods_array = unserialize($row2['od_goods']);
            $od_supply_type = $od_goods_array['supply_type'];
            $od_supply_sub = $od_goods_array['income_per_type'];

            // 정산방식구분 _ 20240509_SY
            // 업체 설정
            if($od_supply_type == '2') {
                $income_price += $row['income_price'];
                $income_percent += $row2['goods_price'] * ($row['income_per'] / 100);
            }
            // 매입가
            if($od_supply_type == '0') {
                $supply_price += $row2['supply_price'];
            }
            // 수수료
            if($od_supply_type == '1') {
                switch($od_supply_sub) {
                case '0':
                    $income_price += $row2['supply_price'];
                    break;
                case '1':
                    $income_percent += $row2['supply_price'];
                    break;
                default:
                    $income_price += $row2['supply_price'];
                    break;
                }
            }
                };

                /*
                // 반품.환불건에 포함된 배송비도 합산
                foreach($order_arr as $key) {
                    $sql3 = " select baesong_price
                                from shop_order
                            where seller_id = '{$row['seller_id']}'
                                and dan IN(7,9)
                                and sellerpay_yes = '0'
                                and od_id = '$key' ";
                    $res3 = sql_query($sql3);
                    while($row3 = sql_fetch_array($res3)) {
                        $tot_baesong += (int)$row3['baesong_price']; // 배송비
                    }
                }
                */

                $temp_idx = implode(',', $order_idx);

                // 정산액 = (공급가합 + 배송비)
                $tot_seller = ($tot_supply + $tot_baesong);

                // 본사마진 = (판매가 - 공급가 - 가맹점수수료 - 포인트결제 - 쿠폰할인)
                $tot_admin = ($tot_price - $tot_supply - $tot_partner - $tot_point - $tot_coupon);

            // 총 합계 _20240503_SY
            $sum_price += $tot_price;
            $sum_supply_price += $supply_price;
            $sum_income_price += $income_price;
            $sum_income_per += $income_percent;
            $sum_seller += $tot_seller;
            $sum_admin += $tot_admin;
            $sum_count +=  count($order_idx);

            ?>
            <tr class="<?php echo $bg; ?>">
                <td>
                    <input type="hidden" name="mb_id[<?php echo $i; ?>]" value="<?php echo $row['mb_id']; ?>">
                    <input type="hidden" name="order_idx[<?php echo $i; ?>]" value="<?php echo $temp_idx; ?>">
                    <input type="hidden" name="tot_price[<?php echo $i; ?>]" value="<?php echo $tot_price; ?>">
                    <input type="hidden" name="tot_point[<?php echo $i; ?>]" value="<?php echo $tot_point; ?>">
                    <input type="hidden" name="tot_coupon[<?php echo $i; ?>]" value="<?php echo $tot_coupon; ?>">
                    <input type="hidden" name="tot_baesong[<?php echo $i; ?>]" value="<?php echo $tot_baesong; ?>">
                    <input type="hidden" name="tot_supply[<?php echo $i; ?>]" value="<?php echo $supply_price; ?>">
                    <input type="hidden" name="tot_seller[<?php echo $i; ?>]" value="<?php echo $tot_seller; ?>">
                    <input type="hidden" name="tot_partner[<?php echo $i; ?>]" value="<?php echo $tot_partner; ?>">
                    <input type="hidden" name="tot_income[<?php echo $i; ?>]" value="<?php echo $income_price; ?>">
                    <input type="hidden" name="tot_income2[<?php echo $i; ?>]" value="<?php echo $income_percent; ?>">
                    <input type="hidden" name="tot_admin[<?php echo $i; ?>]" value="<?php echo $tot_admin; ?>">
                    <input type="checkbox" name="chk[]" value="<?php echo $i; ?>">
                </td>
                <td><?php echo $num--;?></td>
                <td><?php echo get_sideview($row['mb_id'], $row['seller_id']); ?></td>
                <td><?php echo $row['company_name']; ?></td>
                <td><?php echo count($order_idx); ?></td>
                <td class="tar"><?php echo number_format($tot_price); ?></td>
                <td class="tar"><?php echo number_format($tot_point); ?></td>
                <td class="tar"><?php echo number_format($tot_coupon); ?></td>
                <td class="tar"><?php echo number_format($tot_baesong); ?></td>
                <td class="tar"><?php echo number_format($supply_price); ?></td>
                <td class="tar"><?php echo number_format($income_price); ?></td>
                <td class="tar"><?php echo number_format($income_percent); ?></td>
                <td class="tar fc_00f bold"><?php echo number_format($tot_seller); ?></td>
                <td class="tar fc_red bold"><?php echo number_format($tot_admin); ?></td>
                <td class="tar"><?php echo $row['settle'] ?>일</td>
                <td>
                    <div class="btn_wrap">
                        <a href="<?php echo BV_ADMIN_URL; ?>/pop_sellerorder.php?mb_id=<?php echo $row['mb_id']; ?>&order_idx=<?php echo $temp_idx; ?>" onclick="win_open(this,'pop_sellerorder','1200','600','yes');return false;" class="detail">
                            <span>내역</span>
                        </a>
                    </div>
                </td>
             </tr>
        <?php
        }
        if($i==0)
            echo '<tr><td colspan="16" class="empty_table">자료가 없습니다.</td></tr>';
        ?>
        </tbody>
	</table>
</div>
<div class="local_frm02">
	<?php echo $btn_frmline; ?>
</div>
</form>

<!-- 합계 _20240502_SY -->

    <p class="gap50"></p>
    <h5 class="htag_title">합계</h5>
    <p class="gap20"></p>
    <div class="tbl_head01">
        <table>
        <colgroup>
            <col class="">
            <col class="">
            <col class="">
            <col class="">
            <col class="">
            <col class="">
            <col class="">
        </colgroup>
        <thead>
            <tr>
            <th scope="col">총 건수</th>
            <th scope="col">총 주문금액</th>
            <th scope="col">매입가 총액</th>
            <th scope="col">수수료(정액) 총액</th>
            <th scope="col">수수료(정률) 총액</th>
            <th scope="col">정산 총액</th>
            <th scope="col">본사마진 총액</th>
            </tr>
        </thead>
        <tbody>
            <tr>
            <td><?php echo $sum_count; ?></td>
            <td><?php echo number_format($sum_price) . "원"; ?></td>
            <td><?php echo number_format($sum_supply_price) . "원"; ?></td>
            <td><?php echo number_format($sum_income_price) . "원";?></td>
            <td><?php echo number_format($sum_income_per) . "원"; ?></td>
            <td><?php echo number_format($sum_seller) . "원"; ?></td>
            <td><?php echo number_format($sum_admin) . "원"; ?></td>        </tr>
        </tbody>
        </table>
    </div>


<?php
echo get_paging($config['write_pages'], $page, $total_page, $_SERVER['SCRIPT_NAME'].'?'.$q1.'&page=');
?>

<script>
function forderlist_submit(f)
{
    if(!is_checked("chk[]")) {
        alert(document.pressed+" 하실 항목을 하나 이상 선택하세요.");
        return false;
    }

    if(document.pressed == "선택정산") {
        if(!confirm("선택한 자료를 정산하시겠습니까?")) {
            return false;
        }
    }

    return true;
}

$(function(){
	// 날짜 검색 : TODAY MAX값으로 인식 (maxDate: "+0d")를 삭제하면 MAX값 해제
	$("#fr_date,#to_date").datepicker({ changeMonth: true, changeYear: true, dateFormat: "yy-mm-dd", showButtonPanel: true, yearRange: "c-99:c+99", maxDate: "+0d" });
});
</script>
