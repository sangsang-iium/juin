<?php
if(!defined('_BLUEVATION_')) exit;
?>

<h2 class="pg_title">
	<div class="inner">
		<dl class="txt_bx">
			<dt><?php echo $default['de_pname_7']; ?></dt>
			<dd>특별한 <?php echo $default['de_pname_7']; ?> 상품을 만나보세요</dd>
		</dl>
	</div>
</h2>
<ul class="plan">
	<?php
	$sql = "select * from shop_goods_plan where mb_id IN('admin','$pt_id') and pl_use = '1' ";
	$res = sql_query($sql);
	for($i=0; $row=sql_fetch_array($res); $i++) {
		$href = BV_SHOP_URL.'/planlist.php?pl_no='.$row['pl_no'];
		$bimg = BV_DATA_PATH.'/plan/'.$row['pl_limg'];
		if(is_file($bimg) && $row['pl_limg']) {
			$pl_limgurl = rpc($bimg, BV_PATH, BV_URL);
		} else {
			$pl_limgurl = BV_IMG_URL.'/plan_noimg.gif';
		}
	?>
	<li>
		<a href="<?php echo $href; ?>">
		<p class="plan_img"><img src="<?php echo $pl_limgurl; ?>"></p>
		<p class="plan_tit"><?php echo $row['pl_name']; ?></p>
		</a>
	</li>
	<?php } ?>
</ul>
