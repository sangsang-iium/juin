<?php
if(!defined('_BLUEVATION_')) exit;

if($w == 'u') {
	$pl = sql_fetch("select * from shop_goods_live where index_no = '{$index_no}' ");
	if(!$pl['index_no'])
		alert('자료가 존재하지 않습니다.');
}

$frm_submit = '<div class="btn_confirm">
	<input type="submit" value="저장" class="btn_large" accesskey="s">
	<a href="./goods.php?code=live'.$qstr.'&page='.$page.'" class="btn_large bx-white">목록</a>'.PHP_EOL;
if($w == 'u') {
	$frm_submit .= '<a href="./goods.php?code=live_form" class="btn_large bx-red">추가</a>'.PHP_EOL;
}
$frm_submit .= '</div>';

if($pl['live_time']) {
	$liveTimeArr = json_decode($pl['live_time'], true);
}

?>

<form name="fregform" method="post" action="./goods/goods_live_form_update.php" enctype="MULTIPART/FORM-DATA">
<input type="hidden" name="w" value="<?php echo $w; ?>">
<input type="hidden" name="sfl" value="<?php echo $sfl; ?>">
<input type="hidden" name="stx" value="<?php echo $stx; ?>">
<input type="hidden" name="page" value="<?php echo $page; ?>">
<input type="hidden" name="index_no" value="<?php echo $index_no; ?>">

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
					foreach ($liveTimeArr as $liveTimeVal) {
						if($liveTimeVal['live_date'] == $dateVal['weekval']) {
							$liveTimeChecked[$dateVal['weekval']]['checked'] = ' checked';
							$liveTimeChecked[$dateVal['weekval']]['live_start_time'] = $liveTimeVal['live_start_time'];
							$liveTimeChecked[$dateVal['weekval']]['live_end_time'] = $liveTimeVal['live_end_time'];
						}
					}
			?>
				<div>
					<label for="live_mon"><?php echo $dateVal['weekname'] ?></label>
					<input type="checkbox" name="<?php echo $dateVal['weekval'] ?>_live" id="<?php echo $dateVal['weekval'] ?>_live" value="Y" <?php echo $liveTimeChecked[$dateVal['weekval']]['checked']; ?> >
					<input type="text" name="<?php echo $dateVal['weekval'] ?>_start_time" value="<?php echo $liveTimeChecked[$dateVal['weekval']]['live_start_time'] ?>" id="<?php echo $dateVal['weekval'] ?>_start_time" class="frm_input w80" maxlength="10">
					~
					<input type="text" name="<?php echo $dateVal['weekval'] ?>_end_time" value="<?php echo $liveTimeChecked[$dateVal['weekval']]['live_end_time'] ?>" id="<?php echo $dateVal['weekval'] ?>_end_time" class="frm_input w80" maxlength="10">
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

<script>
	$(document).ready(function() {
		$('#mon_start_time ,#tues_start_time ,#wednes_start_time ,#thurs_start_time ,#fri_start_time ,#satur_start_time ,#sun_start_time , #mon_end_time , #tues_end_time , #wednes_end_time , #thurs_end_time , #fri_end_time , #satur_end_time , #sun_end_time  ').on('focus', function() {
			$(this).val('');
		}).on('input', function() {
			var inputValue = $(this).val().replace(/\D/g, '');
			var formattedTime = formatTime(inputValue);
			$(this).val(formattedTime);
		}).on('keydown', function(event) {
			if (event.key === 'Backspace' && $(this).val().length === 3 && $(this).val().includes(':')) {
			$(this).val($(this).val().slice(0, 2));
			}
		});
	});

	function formatTime(time) {
		if (time === '') {
			return '';
		}
		if (isNaN(time)) {
			return '';
		}
		if (time.length !== 4) {
			if (time.length === 1) {
				return time;
			} else if (time.length === 2) {
				return time + ':';
			} else if (time.length === 3) {
				return time.slice(0, 2) + ':' + time.slice(2);
			} else {
				return '';
			}
		}
		var hours = time.slice(0, 2);
		var minutes = time.slice(2, 4);
		return hours + ':' + minutes;
	}
</script>