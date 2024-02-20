<?php
if(!defined("_BLUEVATION_")) exit; // 개별 페이지 접근 불가
?>

<div id="sod_review">
	<p id="sod_fin_no">
		<strong>총 <?php echo number_format($total_count); ?>개</strong>의 구매후기가 있습니다.
	</p>
	<?php
	if(!$total_count) {
		echo "<p class=\"empty_list\">구매후기가 없습니다.</p>";
	} else {
	?>
	<table>
	<colgroup>
		<col width="80px">
		<col>
	</colgroup>
	<tbody>
	<?php
	for($i=0; $row=sql_fetch_array($result); $i++) {
		$href = BV_MSHOP_URL.'/view.php?gs_id='.$row['gs_id'];
		$gs = get_goods($row['gs_id'], 'gname, simg1');

		$wr_star = $gw_star[$row['score']];
		$wr_id   = substr($row['mb_id'],0,3).str_repeat("*",strlen($row['mb_id']) - 3);
		$wr_time = substr($row['reg_time'],0,10);
	?>
	<tr>
		<td class="image"><a href="<?php echo $href; ?>"><?php echo get_it_image($row['gs_id'], $gs['simg1'], 80, 80); ?></a></td>
		<td class="gname">
			<p><a href="<?php echo $href; ?>" target="_blank"><?php echo cut_str($gs['gname'], 55); ?></a></p>
			<p class="mart3 fc_999"><?php echo cut_str($row['memo'], 100); ?></p>
			<p class="mart5"><span class="fc_255"><?php echo $wr_star; ?></span><span class="fc_999"> / <?php echo $wr_id; ?> / <?php echo $wr_time; ?></span></p>
		</td>
	</tr>
	<?php } ?>
	</tbody>
	</table>

	<?php
	echo get_paging($config['mobile_pages'], $page, $total_page, $_SERVER['SCRIPT_NAME'].'?page=');
	?>
	<?php } ?>
</div>
