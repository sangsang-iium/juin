<?php
include_once("./_common.php");
include_once(BV_MPATH."/_head.php"); // 상단
include_once(BV_PATH.'/include/topMenu.php');
?>

<div id="contents" class="sub-contents usedWrite">
<form name="fqaform" id="fqaform" method="post" action="https://juinjang.kr/m/bbs/qna_write.php" onsubmit="return fqaform_submit(this);" autocomplete="off" enctype="MULTIPART/FORM-DATA">
		<input type="hidden" name="mode" value="w">
		<input type="hidden" name="token" value="1abbc7902772993918e33cd86f3c31c2">

		<div class="form-faq-wrap">
			<div class="container">
				<div class="form-row">
					<div class="form-head">
						<p class="title">유형<b>*</b></p>
					</div>
					<div class="form-body">
						<select name="" class="frm-select" required>
							<option value="">선택하세요</option>
							<option value="">팝니다</option>
              <option value="">삽니다</option>
						</select>
					</div>
				</div>
        <div class="form-row">
					<div class="form-head">
						<p class="title">판매상태<b>*</b></p>
					</div>
					<div class="form-body">
						<select name="" class="frm-select" required>
							<option value="">선택하세요</option>
							<option value="">판매중</option>
              <option value="">판매완료</option>
						</select>
					</div>
				</div>
        <div class="form-row">
					<div class="form-head">
						<p class="title">분류<b>*</b></p>
					</div>
					<div class="form-body">
						<select name="" class="frm-select" required>
							<option value="">선택하세요</option>
              <option value="">생활가전</option>
              <option value="">가구</option>
              <option value="">주방용품</option>
              <option value="">여성의류</option>
              <option value="">남성의류</option>
              <option value="">뷰티</option>
              <option value="">유아용품</option>
              <option value="">가방</option>
              <option value="">디지털</option>
              <option value="">스포츠</option>
						</select>
					</div>
				</div>
				<div class="form-row">
					<div class="form-head">
						<p class="title">제목<b>*</b></p>
					</div>
					<div class="form-body">
						<input type="text" name="subject" required class="frm-input" placeholder="제목을 입력해주세요.">
					</div>
				</div>
				<div class="form-row">
					<div class="form-head">
						<p class="title">설명<b>*</b></p>
					</div>
					<div class="form-body">
						<textarea name="memo" required="" rows="7" required class="frm-txtar w-per100" placeholder="내용을 입력해주세요."></textarea>
					</div>
				</div>
				<div class="form-row">
					<div class="form-head">
						<p class="title">대표이미지</p>
					</div>
					<div class="form-body">
						<div class="img-upload">
							<div class="img-upload-list">
								<!-- input[type=file] : .img-upload-input -->
								<div class="img-upload-item">
									<span class="img-upload-delete">삭제</span>
									<input type="file" name="imgUpload1" id="imgUpload1" class="">
									<label for="imgUpload1" class="img-upload-view"></label>
								</div>
							</div>
						</div>
					</div>
				</div>
        <div class="form-row">
					<div class="form-head">
						<p class="title">상세이미지</p>
					</div>
					<div class="form-body">
						<div class="img-upload">
							<div class="img-upload-list">
								<!-- input[type=file] : .img-upload-input -->
								<div class="img-upload-item">
									<span class="img-upload-delete">삭제</span>
									<input type="file" name="imgUpload2" id="imgUpload2" class="">
									<label for="imgUpload2" class="img-upload-view"></label>
								</div>
								<div class="img-upload-item">
									<span class="img-upload-delete">삭제</span>
									<input type="file" name="imgUpload3" id="imgUpload3" class="">
									<label for="imgUpload3" class="img-upload-view"></label>
								</div>
								<div class="img-upload-item">
									<span class="img-upload-delete">삭제</span>
									<input type="file" name="imgUpload4" id="imgUpload4" class="">
									<label for="imgUpload4" class="img-upload-view"></label>
								</div>
								<div class="img-upload-item">
									<span class="img-upload-delete">삭제</span>
									<input type="file" name="imgUpload5" id="imgUpload5" class="">
									<label for="imgUpload5" class="img-upload-view"></label>
								</div>
								<div class="img-upload-item">
									<span class="img-upload-delete">삭제</span>
									<input type="file" name="imgUpload6" id="imgUpload6" class="">
									<label for="imgUpload6" class="img-upload-view"></label>
								</div>
							</div>
						</div>
					</div>
				</div>


				<div class="cp-btnbar">
					<div class="container">
						<div class="cp-btnbar__btns">
							<input type="submit" value="등록하기" class="ui-btn round stBlack">
						</div>
					</div>
				</div>

			</div>
		</div>
	</form>
</div>

<?php
include_once(BV_MPATH."/_tail.php"); // 하단
?>