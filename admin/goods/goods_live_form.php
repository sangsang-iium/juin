<?php
if(!defined('_BLUEVATION_')) exit;

if($w == '') {
	$pl['pl_use'] = 1;
} else if($w == 'u') {
	$pl = sql_fetch("select * from shop_goods_live where index_no = '{$pl_no}' ");
	if(!$pl['pl_no'])
		alert('자료가 존재하지 않습니다.');
}

$frm_submit = '<div class="btn_confirm">
	<input type="submit" value="저장" class="btn_large" accesskey="s">
	<a href="./goods.php?code=live'.$qstr.'&page='.$page.'" class="btn_large bx-white">목록</a>'.PHP_EOL;
if($w == 'u') {
	$frm_submit .= '<a href="./goods.php?code=live_form" class="btn_large bx-red">추가</a>'.PHP_EOL;
}
$frm_submit .= '</div>';

include_once(BV_PLUGIN_PATH.'/jquery-ui/datepicker.php');

?>

<form name="fregform" method="post" action="./goods/goods_live_form_update.php" enctype="MULTIPART/FORM-DATA">
<input type="hidden" name="w" value="<?php echo $w; ?>">
<input type="hidden" name="sfl" value="<?php echo $sfl; ?>">
<input type="hidden" name="stx" value="<?php echo $stx; ?>">
<input type="hidden" name="page" value="<?php echo $page; ?>">
<input type="hidden" name="pl_no" value="<?php echo $pl_no; ?>">

<div class="tbl_frm02">
	<table>
	<colgroup>
		<col class="w140">
		<col>
	</colgroup>
	<tbody>
	<tr>
		<th scope="row">라이브 타이틀</th>
		<td><input type="text" name="title" value="<?php echo $pl['title']; ?>" required itemname="라이브 타이틀" class="frm_input required" size="50"></td>
	</tr>
	<tr>
		<th scope="row">라이브 시간</th>
		<td>
			<?php 
				$dateArr = array(
					array('weekname'=>'월','weekval'=>'mon'),
					array('weekname'=>'화','weekval'=>'tues'),
					array('weekname'=>'수','weekval'=>'wednes'),
					array('weekname'=>'목','weekval'=>'thurs'),
					array('weekname'=>'금','weekval'=>'fri'),
					array('weekname'=>'토','weekval'=>'satur'),
					array('weekname'=>'일','weekval'=>'sun'),
				);
				foreach ($dateArr as $dateVal) {
			?>
				<div>
					<label for="live_mon"><?php echo $dateVal['weekname'] ?></label>
					<input type="checkbox" name="live_<?php echo $dateVal['weekval'] ?>" id="live_<?php echo $dateVal['weekval'] ?>" value="Y">
					<select name="start_time_<?php echo $dateVal['weekval'] ?>" id="start_time_<?php echo $dateVal['weekval'] ?>">
					<?php
						for ($hour = 0; $hour < 24; $hour++) {
							for ($minute = 0; $minute < 60; $minute += 5) {
								$display_hour = str_pad($hour, 2, '0', STR_PAD_LEFT);
								$display_minute = str_pad($minute, 2, '0', STR_PAD_LEFT);
								$time = "$display_hour:$display_minute";
								echo "<option value=\"$time\">$time</option>";
							}
						}
					?>
					</select>
					~
					<select name="end_time_<?php echo $dateVal['weekval'] ?>" id="end_time_<?php echo $dateVal['weekval'] ?>">
					<?php
						for ($hour = 0; $hour < 24; $hour++) {
							for ($minute = 0; $minute < 60; $minute += 5) {
								$display_hour = str_pad($hour, 2, '0', STR_PAD_LEFT);
								$display_minute = str_pad($minute, 2, '0', STR_PAD_LEFT);
								$time = "$display_hour:$display_minute";
								echo "<option value=\"$time\">$time</option>";
							}
						}
					?>
					</select>
				</div>
			<?php
				}
			?>
		</td>
	</tr>
	<tr>
		<th scope="row">라이브 URL</th>
		<td>
			<input type="text" name="url" value="<?php echo $pl['url']; ?>" class="frm_input" size="50">
		</td>
	</tr>
	<tr>
		<th scope="row">썸네일 이미지</th>
		<td>
			<input type="file" name="thumbnail" id="thumbnail">
			<?php
			$bimg_str = "";
			$bimg = BV_DATA_PATH.'/live/'.$pl['thumbnail'];
			if(is_file($bimg) && $pl['thumbnail']) {
				$size = @getimagesize($bimg);
				if($size[0] && $size[0] > 700)
					$width = 700;
				else
					$width = $size[0];

				$bimg = rpc($bimg, BV_PATH, BV_URL);

				echo '<input type="checkbox" name="thumbnail_del" value="'.$pl['thumbnail'].'" id="thumbnail_del"> <label for="thumbnail_del">삭제</label>';
				$bimg_str = '<img src="'.$bimg.'" width="'.$width.'">';
			}
			if($bimg_str) {
				echo '<div class="banner_or_img">'.$bimg_str.'</div>';
			}
			// echo help('사이즈(318픽셀 * 159픽셀)');
			?>
		</td>
	</tr>
	</tbody>
	</table>
</div>

<?php echo $frm_submit; ?>
</form>