<?php
if(!defined('_BLUEVATION_')) exit;

if(!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $fr_date)) $fr_date = '';
if(!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $to_date)) $to_date = '';

$query_string = "code=$code$qstr";
$q1 = $query_string;
$q2 = $query_string."&page=$page";

$sql_common = " from shop_seller_cal a, shop_seller b ";
$sql_search = " where a.mb_id = b.mb_id ";
$sql_order  = " order by a.index_no desc ";

if($sfl && $stx) {
    $sql_search .= " and $sfl like '%$stx%' ";
}

// 기간검색
if($fr_date && $to_date)
    $sql_search .= " and a.reg_time between '$fr_date 00:00:00' and '$to_date 23:59:59' ";
else if($fr_date && !$to_date)
	$sql_search .= " and a.reg_time between '$fr_date 00:00:00' and '$fr_date 23:59:59' ";
else if(!$fr_date && $to_date)
	$sql_search .= " and a.reg_time between '$to_date 00:00:00' and '$to_date 23:59:59' ";

// 기간검색 기본값 1달 추가 _20240513_SY
$time = time();
$bf_month = date("Y-m-d",strtotime("-1 month", $time));
$now_date = date("Y-m-d");
if(!isset($_GET['fr_date']) && !isset($_GET['to_date'])) {
  $sql_search .= " and a.reg_time between '$bf_month 00:00:00' and '$now_date 23:59:59' ";
}


// 테이블의 전체 레코드수만 얻음
$sql = " select count(*) as cnt $sql_common $sql_search ";
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = 30;
$total_page = ceil($total_count / $rows); // 전체 페이지 계산
if($page == "") { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함
$num = $total_count - (($page-1)*$rows);

// sellerTable > income 내용 추가 _20240509_SY
$add_seller_income = " ,b.income_type, b.income_per_type, b.income_price, b.income_per ";

$sql = " select a.*, b.seller_code, b.company_name
      $add_seller_income
			$sql_common
			$sql_search
			$sql_order
			limit $from_record, $rows ";
$result = sql_query($sql);

include_once(BV_PLUGIN_PATH.'/jquery-ui/datepicker.php');

$btn_frmline = <<<EOF
<input type="submit" name="act_button" value="선택삭제" class="btn_lsmall bx-white" onclick="document.pressed=this.value">
<a href="./seller/seller_pay_history_excel.php?$q1" class="btn_lsmall bx-white"><i class="fa fa-file-excel-o"></i> 엑셀저장</a>
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
                        <?php echo option_selected('b.company_name', $sfl, '공급사명'); ?>
                        <?php echo option_selected('b.seller_code', $sfl, '업체코드'); ?>
                        <?php echo option_selected('a.mb_id', $sfl, '아이디'); ?>
                    </select>
                </div>
                <input type="text" name="stx" value="<?php echo $stx; ?>" class="frm_input" size="30">
            </div>
		</td>
	</tr>
	<tr>
		<th scope="row">정산일</th>
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
	</tbody>
	</table>
</div>
<div class="btn_confirm">
	<input type="submit" value="검색" class="btn_medium">
	<input type="button" value="초기화" id="frmRest" class="btn_medium grey">
</div>
</form>

<form name="forderlist" id="forderlist" method="post" action="./seller/seller_pay_delete.php" onsubmit="return forderlist_submit(this);">
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
		<th scope="col">일시</th>
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
		<th scope="col">내역</th>
	</tr>
	</thead>
	<tbody>
	<?php
	for($i=0; $row=sql_fetch_array($result); $i++) {
		$order_idx = explode(',', $row['order_idx']);
		$bg = 'list'.($i%2);

    // 총 합계 _20240510_SY
    $sum_price += $row['tot_price'];
    $sum_supply_price += $row['tot_supply'];
    $sum_income_price += $row['tot_income'];
    $sum_income_per += $row['tot_income2'];
    $sum_seller += $row['tot_seller'];
    $sum_admin += $row['tot_admin'];
    $sum_count +=  count($order_idx);
	?>
	<tr class="<?php echo $bg; ?>">
		<td>
			<input type="hidden" name="index_no[<?php echo $i; ?>]" value="<?php echo $row['index_no']; ?>">
			<input type="hidden" name="order_idx[<?php echo $i; ?>]" value="<?php echo $row['order_idx']; ?>">
			<input type="checkbox" name="chk[]" value="<?php echo $i; ?>">
		</td>
		<td><?php echo $num--; ?></td>
		<td class="tal"><?php echo get_sideview($row['mb_id'], $row['seller_code']); ?></td>
		<td class="tal"><?php echo $row['company_name']; ?></td>
		<td><?php echo $row['reg_time']; ?></td>
		<td><?php echo count($order_idx); ?></td>
		<td class="tar"><?php echo number_format($row['tot_price']); ?></td>
		<td class="tar"><?php echo number_format($row['tot_point']); ?></td>
		<td class="tar"><?php echo number_format($row['tot_coupon']); ?></td>
		<td class="tar"><?php echo number_format($row['tot_baesong']); ?></td>
		<td class="tar"><?php echo number_format($row['tot_supply']); ?></td>
		<td class="tar"><?php echo number_format($row['tot_income']); ?></td>
		<td class="tar"><?php echo number_format($row['tot_income2']); ?></td>
		<td class="tar fc_00f bold"><?php echo number_format($row['tot_seller']); ?></td>
		<td class="tar fc_red bold"><?php echo number_format($row['tot_admin']); ?></td>
		<td><a href="<?php echo BV_ADMIN_URL; ?>/pop_sellerorder.php?mb_id=<?php echo $row['mb_id']; ?>&order_idx=<?php echo $row['order_idx']; ?>" onclick="win_open(this,'pop_sellerorder','1200','600','yes');return false;" class="btn_small">내역</a></td>
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

<!-- 합계 _20240509_SY -->
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

    if(document.pressed == "선택삭제") {
        if(!confirm("선택한 자료를 정말 삭제하시겠습니까?")) {
            return false;
        }
    }

    return true;
}

$(function(){
	// 날짜 검색 : TODAY MAX값으로 인식 (maxDate: "+0d")를 삭제하면 MAX값 해제
	$("#fr_date, #to_date").datepicker({ changeMonth: true, changeYear: true, dateFormat: "yy-mm-dd", showButtonPanel: true, yearRange: "c-99:c+99", maxDate: "+0d" });
});
</script>
