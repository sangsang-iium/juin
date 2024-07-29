<?php
define('_NEWWIN_', true);
include_once('./_common.php');
include_once('./_head.php');
include_once(BV_ADMIN_PATH."/admin_access.php");

$tb['title'] = "공급사판매내역";
include_once(BV_ADMIN_PATH."/admin_head.php");

$sr = get_seller($mb_id, 'seller_code');

if(!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $fr_date)) $fr_date = '';
if(!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $to_date)) $to_date = '';

if(isset($order_idx))		 $qstr .= "&order_idx=$order_idx";


$query_string = "mb_id=$mb_id$qstr";
$q1 = $query_string;
$q2 = $query_string."&page=$page";

$sql_common = " from shop_order ";

$where = array();
$where[] = " dan != '0' and seller_id = '{$sr['seller_code']}' ";

if($order_idx)
	$where[] = " index_no IN ({$order_idx}) ";

if($where) {
    $sql_search = ' where '.implode(' and ', $where);
}

$sql_group = " group by od_id ";
$sql_order = " order by index_no desc ";

// 테이블의 전체 레코드수만 얻음
$sql = " select od_id {$sql_common} {$sql_search} {$sql_group} ";
$result = sql_query($sql);
$total_count = sql_num_rows($result);

$rows = 30;
$total_page = ceil($total_count / $rows); // 전체 페이지 계산
if($page == "") { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함
$num = $total_count - (($page-1)*$rows);

$sql = " select * {$sql_common} {$sql_search} {$sql_group} {$sql_order} limit {$from_record}, {$rows} ";
$result = sql_query($sql);

$tot_orderprice  = 0; // 총 결제금액
$sql = " select od_id {$sql_common} {$sql_search} {$sql_group} {$sql_order} ";
$res = sql_query($sql);
while($row=sql_fetch_array($res)) {
	$amount = get_order_spay($row['od_id']);
	$tot_orderprice += $amount['buyprice'];
}

include_once(BV_PLUGIN_PATH.'/jquery-ui/datepicker.php');
?>

<div id="sellerorder_pop" class="new_win">
	<h1><?php echo $tb['title']; ?></h1>

	<section class="new_win_desc marb50">

	<div class="tbl_head01">
		<table id="sodr_list">
		<colgroup>
			<col class="w50">
			<col class="w150">
			<col class="w50">
			<col class="w50">
			<col class="w50">
			<col class="w90">
			<col class="w50">
			<col class="w90">
			<col class="w90">
			<col class="w90">
			<col class="w90">
			<col class="w90">
			<col class="w90">
		</colgroup>
		<thead>
		<tr>
			<th scope="col">번호</th>
			<th scope="col">주문번호</th>
			<th scope="col" colspan="2">주문상품</th>
			<th scope="col">과세설정</th>
			<th scope="col">주문상태</th>
			<th scope="col">정산</th>
			<th scope="col">매입가</th>
			<th scope="col">수수료(정액)</th>
			<th scope="col">수수료(정률)</th>
			<th scope="col">총주문액</th>
			<th scope="col">결제방법</th>
			<th scope="col">주문자명</th>
		</tr>
		</thead>
		<tbody>
		<?php
		for($i=0; $row=sql_fetch_array($result); $i++) {
			$bg = 'list'.($i%2);

			$amount = get_order_spay($row['od_id']);
			$sodr = get_order_list($row, $amount);

			// $sql = " select * {$sql_common} {$sql_search} and od_id = '{$row['od_id']}' order by index_no ";

      // shop_seller 추가 _20240509_SY
			$sql = " SELECT a.*, b.income_type, b.income_per_type, b.income_price, b.income_per
                 FROM shop_order a, shop_seller b 
                WHERE a.seller_id = b.seller_code
                  AND dan != '0' 
                  AND seller_id = '{$sr['seller_code']}' 
                  AND a.index_no IN ({$order_idx}) 
                  AND od_id = '{$row['od_id']}' 
                  GROUP BY a.index_no 
                  ORDER BY a.index_no ";
      
			$res = sql_query($sql);
			$rowspan = sql_num_rows($res);
			for($k=0; $row2=sql_fetch_array($res); $k++) {
				$gs = unserialize($row2['od_goods']);
        $supply_price   = 0;
        $income_price   = 0;
        $income_percent = 0;
        if($gs['supply_type'] == '2') {
          if($row2['income_type'] == '1') {
            switch($row2['income_per_type']) {
              case '1':
                $income_percent = $row2['goods_price'] * ($row2['income_per'] / 100);
                break;

              default :
                $income_price = $row2['income_price'];
                break;
            }
          } else {
            $income_price = $row['income_price'];
            $income_percent = $row2['goods_price'] * ($row['income_per'] / 100);
          }
        }
        // 매입가 
        if($gs['supply_type'] == '0') {
          $supply_price = $row2['supply_price'];
        }
        // 수수료
        if($gs['supply_type'] == '1') {
          switch($gs['income_per_type']) {
            case '0':
              $income_price = $row2['supply_price'];
              break;
            case '1':
              $income_percent = $row2['supply_price'];
              break;
            default:
              $income_price = $row2['supply_price'];
              break;
          }
        }

        // 과세 _20240724_SY
        $notax = "";
        switch($gs['notax']) {
          case '1':
            $notax = "과세";
            break;
          case '0':
            $notax = "면세";
            break;

          default:
            $notax = "과세";
            break;
        }
		?>
		<tr class="<?php echo $bg; ?>">
			<?php if($k == 0) { ?>
			<td rowspan="<?php echo $rowspan; ?>"><?php echo $num--; ?></td>
			<td rowspan="<?php echo $rowspan; ?>">
				<a href="<?php echo BV_ADMIN_URL; ?>/pop_orderform.php?od_id=<?php echo $row['od_id']; ?>" onclick="win_open(this,'pop_orderform','1200','800','yes');return false;" class="fc_197"><?php echo $row['od_id']; ?></a><br>
				<?php echo substr($row['od_time'],2,14); ?> (<?php echo get_yoil($row['od_time']); ?>)
			</td>
			<?php } ?>
			<td class="td_img"><a href="<?php echo BV_SHOP_URL; ?>/view.php?index_no=<?php echo $row2['gs_id']; ?>" target="_blank"><?php echo get_od_image($row['od_id'], $gs['simg1'], 30, 30); ?></a></td>
			<td class="td_itname"><a href="<?php echo BV_ADMIN_URL; ?>/goods.php?code=form&w=u&gs_id=<?php echo $row2['gs_id']; ?>" target="_blank"><?php echo get_text($gs['gname']); ?></a></td>
			<td><?php echo $notax; ?></td>
			<td><?php echo $gw_status[$row2['dan']]; ?></td>
			<td><?php echo $row2['sellerpay_yes']?'완료':'대기'; ?></td>
			<td class="tar"><?php echo number_format($supply_price); ?></td>
			<td class="tar"><?php echo number_format($income_price); ?></td>
			<td class="tar"><?php echo number_format($income_percent); ?></td>
			<?php if($k == 0) { ?>
			<td rowspan="<?php echo $rowspan; ?>" class="td_price"><?php echo $sodr['disp_price']; ?></td>
			<td rowspan="<?php echo $rowspan; ?>"><?php echo $sodr['disp_paytype']; ?></td>
			<td rowspan="<?php echo $rowspan; ?>">
				<?php echo $sodr['disp_od_name']; ?>
				<?php echo $sodr['disp_mb_id']; ?>
			</td>
			<?php } ?>
		<?php
			}
		}
		sql_free_result($result);
		if($i==0)
			echo '<tr><td colspan="15" class="empty_table">자료가 없습니다.</td></tr>';
		?>
		</tbody>
		</table>
	</div>

	<?php
	echo get_paging($config['write_pages'], $page, $total_page, $_SERVER['SCRIPT_NAME'].'?'.$q1.'&page=');
	?>
	</section>
</div>

<script>
$(function(){
    $("#fr_date, #to_date").datepicker({ changeMonth: true, changeYear: true, dateFormat: "yy-mm-dd", showButtonPanel: true, yearRange: "c-99:c+99", maxDate: "+0d" });
});
</script>

<?php
include_once(BV_ADMIN_PATH."/admin_tail.sub.php");
?>