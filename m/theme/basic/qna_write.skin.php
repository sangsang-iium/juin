<?php
if(!defined("_BLUEVATION_")) exit; // 개별 페이지 접근 불가
?>
<div id="contents">

	<form name="fqaform" id="fqaform" method="post" action="<?php echo $form_action_url; ?>" onsubmit="return fqaform_submit(this);" autocomplete="off">
		<input type="hidden" name="mode" value="w">
		<input type="hidden" name="token" value="<?php echo $token; ?>">

		<div class="form-faq-wrap">
			<div class="container">

				<!-- <div class="m_bo_bg">
					<div class="m_bo_wrap">
						<table class="tbl03">
						<colgroup>
							<col style="width:70px">
							<col style="width:auto">
						</colgroup>
						<tbody>
						<tr>
							<th>질문유형</th>
							<td>
								<select name="catename" required itemname="질문유형" class="wfull">
									<option value="">문의하실 유형을 선택하세요</option>
									<?php
									$sql = "select * from shop_qa_cate where isuse='Y'";
									$res = sql_query($sql);
									while($row=sql_fetch_array($res)) {	
										echo "<option value='$row[catename]'>$row[catename]</option>\n";
									}
									?>
								</select>
							</td>
						</tr>
						<tr>
							<th>제목</th>
							<td><input type="text" name="subject" required itemname="제목"></td>
						</tr>
						<tr>
							<th>질문내용</th>
							<td><textarea name="memo" required rows="7" itemname="질문내용"></textarea></td>
						</tr>
						<tr>
							<th>이메일</th>
							<td>
								<input type="text" name="email" value="<?php echo $member['email'];?>">
								<p class="mart5 fs12">
									<span class="marr10">답변 내용을 메일로 받아보시겠습니까?</span>
									<input type="checkbox" name="email_send_yes" value="1" id="email_send_yes" class="css-checkbox lrg"> <label for="email_send_yes" class="css-label">예</label>
								</p>
							</td>
						</tr>
						<tr>
							<th>휴대폰</th>
							<td>
								<input type="text" name="cellphone" value="<?php echo $member['cellphone']; ?>">
								<p class="mart5 fs12">
									<span class="marr10">답변 여부를 문자로 받아보시겠습니까?</span>
									<input type="checkbox" name="sms_send_yes" value="1" id="sms_send_yes" class="css-checkbox lrg"> <label for="sms_send_yes" class="css-label">예</label>
								</p>
							</td>
						</tr>
						</tbody>
						</table>
					</div>
					<div class="btn_confirm">
						<input type="submit" value="글쓰기" class="btn_medium">
						<a href="javascript:history.go(-1);" class="btn_medium bx-white">취소</a>
					</div>
				</div> -->

				<div class="form-row">
					<div class="form-head">
						<p class="title">질문유형<b>*</b></p>
					</div>
					<div class="form-body">
						<select name="catename" required itemname="질문유형" class="frm-select">
							<option value="">문의하실 유형을 선택하세요</option>
							<?php
							$sql = "select * from shop_qa_cate where isuse='Y'";
							$res = sql_query($sql);
							while($row=sql_fetch_array($res)) {	
								echo "<option value='$row[catename]'>$row[catename]</option>\n";
							}
							?>
						</select>
					</div>
				</div>

				<div class="form-row">
					<div class="form-head">
						<p class="title">문의제목<b>*</b></p>
					</div>
					<div class="form-body">
						<input type="text" name="subject" required itemname="문의제목" class="frm-input" placeholder="제목을 입력해주세요.">
					</div>
				</div>

				<div class="form-row">
					<div class="form-head">
						<p class="title">문의내용<b>*</b></p>
					</div>
					<div class="form-body">
						<textarea name="memo" required rows="7" itemname="문의내용" class="frm-txtar w-per100" placeholder="내용을 입력해주세요."></textarea>
					</div>
				</div>

				<div class="form-row">
					<div class="form-head">
						<p class="title">핸드폰번호<b>*</b></p>
					</div>
					<div class="form-body phone">
						<input type="text" name="" id="" class="frm-input" readonly>
						<span class="hyphen">-</span>
						<input type="text" name="" id="" class="frm-input" readonly>
						<span class="hyphen">-</span>
						<input type="text" name="" id="" class="frm-input" readonly>
						<div class="frm-choice">
							<input type="checkbox" name="sms_send_yes" value="1" id="sms_send_yes" class="css-checkbox lrg">
							<label for="sms_send_yes">답변 여부를 문자로 받아보시겠습니까?</label>
						</div>
					</div>
				</div>

				<div class="form-row">
					<div class="form-head">
						<p class="title">이메일<b>*</b></p>
					</div>
					<div class="form-body">
						<input type="text" name="" id="" class="frm-input w-per100" placeholder="이메일을 입력해주세요.">
						<div class="frm-choice">
							<input type="checkbox" name="email_send_yes" value="1" id="email_send_yes" class="css-checkbox lrg">
							<label for="email_send_yes">답변 내용을 메일로 받아보시겠습니까?</label>
						</div>
					</div>
				</div>

				<!-- 기존 이메일 / 핸드폰 번호 위의 스타일로 개발 필요 -->
				<!-- <div class="form-row">
					<div class="form-head">
						<p class="title">이메일</p>
					</div>
					<div class="form-body">
						<input type="text" name="email" value="<?php echo $member['email'];?>" class="frm-input">
						<div class="frm-choice">
							<input type="checkbox" name="email_send_yes" value="1" id="email_send_yes" class="css-checkbox lrg">
							<label for="email_send_yes">답변 내용을 메일로 받아보시겠습니까?</label>
						</div>
					</div>
				</div>

				<div class="form-row">
					<div class="form-head">
						<p class="title">휴대폰</p>
					</div>
					<div class="form-body">
						<input type="text" name="cellphone" value="<?php echo $member['cellphone']; ?>" class="frm-input">
						<div class="frm-choice">
							<input type="checkbox" name="sms_send_yes" value="1" id="sms_send_yes" class="css-checkbox lrg">
							<label for="sms_send_yes">답변 여부를 문자로 받아보시겠습니까?</label>
						</div>
					</div>
				</div> -->
				
				<div class="form-row">
					<div class="form-head">
						<p class="title">이미지등록</p>
					</div>
					<div class="form-body">
						<div class="img-upload">
							<div class="img-upload-list">
								<div class="img-upload-item">
									<span class="img-upload-delete">삭제</span>
									<input type="file" name="" id="imgUpload1" class="img-upload-input">
									<label for="imgUpload1" class="img-upload-view"></label>
								</div>
								<div class="img-upload-item">
									<span class="img-upload-delete">삭제</span>
									<input type="file" name="" id="imgUpload2" class="img-upload-input">
									<label for="imgUpload2" class="img-upload-view"></label>
								</div>
								<div class="img-upload-item">
									<span class="img-upload-delete">삭제</span>
									<input type="file" name="" id="imgUpload3" class="img-upload-input">
									<label for="imgUpload3" class="img-upload-view"></label>
								</div>
								<div class="img-upload-item">
									<span class="img-upload-delete">삭제</span>
									<input type="file" name="" id="imgUpload4" class="img-upload-input">
									<label for="imgUpload4" class="img-upload-view"></label>
								</div>
								<div class="img-upload-item">
									<span class="img-upload-delete">삭제</span>
									<input type="file" name="" id="imgUpload5" class="img-upload-input">
									<label for="imgUpload5" class="img-upload-view"></label>
								</div>
							</div>
							<p class="img-upload-desc">사진은 10MB이하의 jpg, png, gif 파일만 첨부 가능합니다.</p>
						</div>
					</div>
				</div>

				<div class="cp-btnbar">
					<div class="container">
						<div class="cp-btnbar__btns">
							<input type="submit" value="글쓰기" class="ui-btn round stBlack">
							<!-- <a href="javascript:history.go(-1);" class="btn_medium bx-white">취소</a> -->
						</div>
					</div>
				</div>

			</div>
		</div>
	</form>

</div>

<script>
function fqaform_submit(f) {
	if(confirm("등록 하시겠습니까?") == false)
		return false;

	return true;
}
</script>
