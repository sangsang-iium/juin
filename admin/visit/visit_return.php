<?php
if(!defined('_BLUEVATION_')) exit;

if(!$year)  $year  = BV_TIME_YEAR;
if(!$month)	$month = BV_TIME_MONTH;

$search_date = preg_replace("/([0-9]{4})([0-9]{2})/", "\\1-\\2", $year.$month);

$sql = " select COUNT(*) as cnt
		   from shop_order
		  where dan = 7
		    and left(return_date,7) = '$search_date' ";
$row = sql_fetch($sql);
$sum_count = (int)$row['cnt'];

// 가장작은 년도 구하기
$sql = " select MIN(od_time) as min_year from shop_order ";
$row = sql_fetch($sql);
$min_year = substr($row['min_year'],0,4);

if(!$min_year)
	$min_year = BV_TIME_YEAR;
?>

<h2>통계검색</h2>
<form name="fsearch" id="fsearch" method="get">
<input type="hidden" name="code" value="<?php echo $code; ?>">
<div class="tbl_frm01">
	<table>
	<colgroup>
		<col class="w120">
		<col>
	</colgroup>
	<tbody>
	<tr>
		<th scope="row">기간검색</th>
		<td>
			<select name="year">
				<?php
				for($i=$min_year; $i<=BV_TIME_YEAR; $i++) {
					echo "<option value=\"{$i}\"".get_selected($year, $i).">{$i}년</option>\n";
				}
				?>
			</select>
			<select name="month">
				<?php
				for($i=1;$i<=12;$i++) {
					$k = sprintf('%02d',$i);
					echo "<option value=\"{$k}\"".get_selected($month, $k).">{$k}월</option>\n";
				}
				?>
			</select>
			<input type="submit" value="검색" class="btn_small">
		</td>
	</tr>
	</tbody>
	</table>
</div>
</form>

<div class="local_ov mart20">
	<strong>총 반품건수 : <?php echo number_format($sum_count); ?>건</strong>
</div>
<div class="tbl_head01">
	<table>
	<colgroup>
		<col class="w100">
		<col>
		<col class="w60">
		<col class="w90">
		<col class="w90">
	</colgroup>
	<thead>
	<tr>
		<th scope="col">날짜</th>
		<th scope="col">그래프</th>
		<th scope="col">비율%</th>
		<th scope="col">반품상품수</th>
		<th scope="col">주문액</th>
	</tr>
	</thead>
	<tbody class="list">
	<?php
	$tot_count = 0;
	$tot_price = 0;

	if(!$sum_count) $sum_count = 1;

	for($i=1;$i<=31;$i++) {
		$day = sprintf("%02d", $i);
		$date = preg_replace("/([0-9]{4})([0-9]{2})([0-9]{2})/", "\\1-\\2-\\3", $year.$month.$day);

		$sql = " select COUNT(*) as cnt,
						SUM(goods_price + baesong_price) as price
				   from shop_order
				  where dan = 7
					and left(return_date,10) = '$date' ";
		$sum = sql_fetch($sql);

		$rate = ((int)$sum['cnt'] / $sum_count * 100);
		$s_rate = number_format($rate, 1);

		$tot_count += (int)$sum['cnt'];
		$tot_price += (int)$sum['price'];

		$bg = 'list'.($i%2);
	?>
	<tr class="<?php echo $bg; ?>">
		<td><?php echo $date; ?></td>
		<td><div class="graph"><span class="bar" style="width:<?php echo $s_rate; ?>%"></span></div></td>
		<td><?php echo $s_rate; ?></td>
		<td><?php echo number_format($sum['cnt']); ?></td>
		<td class="tar"><?php echo number_format($sum['price']); ?></td>
	</tr>
	<?php
		// 오늘날짜와 같다면 중지
		if($date == BV_TIME_YMD) break;
	}
	?>
	</tbody>
	<tfoot>
	<tr>
		<td colspan="2">합계</td>
		<td>100</td>
		<td><?php echo number_format($tot_count); ?></td>
		<td class="tar"><?php echo number_format($tot_price); ?></td>
	</tr>
	</tfoot>
	</table>
</div>
