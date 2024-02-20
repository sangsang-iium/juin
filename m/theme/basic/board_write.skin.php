<?php
if(!defined("_BLUEVATION_")) exit; // 개별 페이지 접근 불가
?>
<div id="contents">

	<form name="fwrite" id="fwrite" method="post" action="<?php echo $form_action_url; ?>" onsubmit="return fwrite_submit(this);" autocomplete="off">
		<input type="hidden" name="w" value="<?php echo $w; ?>">
		<input type="hidden" name="boardid" value="<?php echo $boardid; ?>">
		<input type="hidden" name="index_no" value="<?php echo $index_no; ?>">
		<input type="hidden" name="page" value="<?php echo $page; ?>">
		<input type="hidden" name="token" value="<?php echo $token; ?>">

		<div class="form-notice-wrap">
			<div class="container">

				<!-- <div class="m_bo_wrap">
					<table class="tbl03">
					<colgroup>
						<col style="width:70px">
						<col style="width:auto">
					</colgroup>
					<tbody>
					<tr>
						<th>이름</th>
						<td>
							<?php
							if($is_member) {
								echo $write['writer_s'];
								echo "<input type='hidden' name='writer_s' value='$write[writer_s]'>";
							} else {
								echo "<input type='text' name='writer_s' value='$write[writer_s]' style='width:150px;'>";
							}
							?>
						</td>
					</tr>
					<?php if(!$is_member && $w != 'r') { ?>
					<tr>
						<th>비밀번호</th>
						<td><input type="password" name="passwd" style="width:150px;"></td>
					</tr>
					<?php } ?>
					<?php if($board['use_category'] == '1') { ?>
					<tr>
						<th>분류</th>
						<td>
							<select name="ca_name" style="width:100%;">
							<option value="">선택하세요</option>
							<?php echo get_category_option($board['usecate']); ?>
							</select>
							<?php if($w == 'u' || $w == 'r') { ?>
							<script>document.fwrite.ca_name.value='<?php echo $write[ca_name]; ?>';</script>
							<?php } ?>
						</td>
					</tr>
					<?php } ?>
					<?php
					$option = "";
					$option_hidden = "";
					if(is_admin()) {
						$checked = '';
						if($write['btype']=='1') { $checked = ' checked'; }
						$option .= '<input type="checkbox" name="btype" value="1" id="ids_btype" class="css-checkbox lrg"'.$checked.'><label for="ids_btype" class="css-label padr10">공지사항</label>';

						$checked = '';
						if($write['issecret']=='Y') { $checked = ' checked'; }
						$option .= '<input type="checkbox" name="issecret" value="Y" id="ids_issecret" class="css-checkbox lrg"'.$checked.'><label for="ids_issecret" class="css-label padr10">비밀글</label>';
					} else {
						switch($board['use_secret']) {
							case '0':
								$option_hidden .= '<input type="hidden" name="issecret" value="N">';
								break;
							case '1':
								$checked = '';
								if($write['issecret']=='Y') { $checked = ' checked'; }
								$option .= '<input type="checkbox" name="issecret" value="Y" id="ids_issecret" class="css-checkbox lrg"'.$checked.'> <label for="ids_issecret" class="css-label padr10">비밀글</label>';
								break;
							case '2':
								$option_hidden .= '<input type="hidden" name="issecret" value="Y">';
								break;
						}
					}

					echo $option_hidden;
					if($option) {
					?>
					<tr>
						<th>옵 션</th>
						<td><?php echo $option; ?></td>
					</tr>
					<?php } ?>
					<tr>
						<th>제목</th>
						<td><input type="text" name="subject" value="<?php echo $write['subject']; ?>" class="wfull"></td>
					</tr>
					<tr style="border-bottom:none">
						<th>내용</th>
						<td><textarea name="memo" rows="10" class="wfull"><?php echo $write['memo']; ?></textarea></td>
					</tr>
					</tbody>
					</table>
				</div> -->

				<div class="form-row">
					<div class="form-head">
						<p class="title">이름<b>*</b></p>
					</div>
					<div class="form-body">
						<?php
						if($is_member) {
							echo "<input type='text' name='writer_s' value='$write[writer_s]' class='frm-input' readonly>";
						} else {
							echo "<input type='text' name='writer_s' value='$write[writer_s]' class='frm-input'>";
						}
						?>
					</div>
				</div>

				<?php if(!$is_member && $w != 'r') { ?>
				<div class="form-row">
					<div class="form-head">
						<p class="title">비밀번호<b>*</b></p>
					</div>
					<div class="form-body">
						<input type="password" name="passwd" class="frm-input">
					</div>
				</div>
				<?php } ?>

				<?php if($board['use_category'] == '1') { ?>
				<div class="form-row">
					<div class="form-head">
						<p class="title">분류<b>*</b></p>
					</div>
					<div class="form-body">
						<select name="ca_name" class="frm-select">
						<option value="">선택하세요</option>
						<?php echo get_category_option($board['usecate']); ?>
						</select>
						<?php if($w == 'u' || $w == 'r') { ?>
						<script>document.fwrite.ca_name.value='<?php echo $write[ca_name]; ?>';</script>
						<?php } ?>
					</div>
				</div>
				<?php } ?>

				<?php
				$option = "";
				$option_hidden = "";
				if(is_admin()) {
					$checked = '';
					if($write['btype']=='1') { $checked = ' checked'; }
					$option .= '<div class="frm-choice">';
					$option .= '<input type="checkbox" name="btype" value="1" id="ids_btype" '.$checked.'><label for="ids_btype">공지사항</label>';
					$option .= '</div>';

					$checked = '';
					if($write['issecret']=='Y') { $checked = ' checked'; }
					$option .= '<div class="frm-choice">';
					$option .= '<input type="checkbox" name="issecret" value="Y" id="ids_issecret" '.$checked.'><label for="ids_issecret">비밀글</label>';
					$option .= '</div>';
				} else {
					switch($board['use_secret']) {
						case '0':
							$option_hidden .= '<input type="hidden" name="issecret" value="N">';
							break;
						case '1':
							$checked = '';
							if($write['issecret']=='Y') { $checked = ' checked'; }
							$option .= '<div class="frm-choice">';
							$option .= '<input type="checkbox" name="issecret" value="Y" id="ids_issecret" '.$checked.'> <label for="ids_issecret">비밀글</label>';
							$option .= '</div>';
							break;
						case '2':
							$option_hidden .= '<input type="hidden" name="issecret" value="Y">';
							break;
					}
				}

				echo $option_hidden;
				if($option) {
				?>
				<div class="form-row">
					<div class="form-head">
						<p class="title">옵션</p>
					</div>
					<div class="form-body">
						<div class="flex gap">
							<?php echo $option; ?>
						</div>
					</div>
				</div>
				<?php } ?>

				<div class="form-row">
					<div class="form-head">
						<p class="title">제목<b>*</b></p>
					</div>
					<div class="form-body">
						<input type="text" name="subject" value="<?php echo $write['subject']; ?>" class="frm-input" placeholder="제목을 입력해주세요.">
					</div>
				</div>

				<div class="form-row">
					<div class="form-head">
						<p class="title">내용<b>*</b></p>
					</div>
					<div class="form-body">
						<textarea name="memo" rows="10" class="frm-txtar w-per100" placeholder="내용을 입력해주세요."><?php echo $write['memo']; ?></textarea>
					</div>
				</div>

				<div class="cp-btnbar">
					<div class="container">
						<div class="cp-btnbar__btns">
							<input type="submit" value="확인" class="ui-btn round stBlack">
							<!-- <?php if($w == 'u' || $w == 'r') { ?>
							<a href="<?php echo BV_MBBS_URL; ?>/board_list.php?<?php echo $qstr1; ?>" class="btn_medium bx-white">목록</a>
							<?php } else { ?>
							<a href="javascript:history.go(-1);" class="btn_medium bx-white">취소</a>
							<?php } ?> -->
						</div>
					</div>
				</div>

			</div>
		</div>
	</form>

</div>

<!-- Footer 숨김 -->
<style>
	#footer {display: none;}
</style>

<script>
function fwrite_submit(f) {
	<?php if(!$is_member) { ?>
	if(!f.writer_s.value) {
		alert('이름을 입력하세요.');
		f.writer_s.focus();
		return false;
	}
	<?php } ?>
	<?php if(!$is_member && $w != 'r') { ?>
	if(!f.passwd.value) {
		alert('비밀번호를 입력하세요.');
		f.passwd.focus();
		return false;
	}
	<?php } ?>

	<?php if($board['use_category'] == '1') { ?>
	if(!f.ca_name.value) {
		alert('분류를 선택하세요.');
		f.ca_name.focus();
		return false;
	}
	<?php } ?>

	if(!f.subject.value) {
		alert('제목을 입력하세요.');
		f.subject.focus();
		return false;
	}

    return true;
}
</script>
