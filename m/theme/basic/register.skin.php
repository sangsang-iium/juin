<?php
if(!defined("_BLUEVATION_")) exit; // 개별 페이지 접근 불가
?>

<div id="contents" class="sub-contents joinAgree">
	<div class="joinAgree-wrap">
		<div class="container">
			<div class="joinAgree-head">
				<p>회원가입을 위해 <br/><b>서비스 이용 약관에 동의</b>해 주세요.</p>
			</div>
			<div class="joinAgree-body">
				<form  name="fregister" id="fregister" action="<?php echo $register_action_url; ?>" onsubmit="return fregister_submit(this);" method="POST" autocomplete="off">
          
          <!-- 일반 & 사업자 구분 _20240228_SY -->
          <input type="hidden" name="reg_type" value="<?php echo $_GET['type']?>">

					<?php if($default['de_sns_login_use']) { ?>
					<div class="sns_box">
						<h3 class="fr_tit">SNS 계정으로 가입</h3>
						<p>
							<?php if($default['de_naver_appid'] && $default['de_naver_secret']) { ?>
							<?php echo get_login_oauth('naver', 1); ?>
							<?php } ?>
							<?php if($default['de_facebook_appid'] && $default['de_facebook_secret']) { ?>
							<?php echo get_login_oauth('facebook', 1); ?>
							<?php } ?>
							<?php if($default['de_kakao_rest_apikey']) { ?>
							<?php echo get_login_oauth('kakao', 1); ?>
							<?php } ?>
						</p>
					</div>
					<?php } ?>

          <div class="joinAgree-check-all frm-choice">
						<input type="checkbox" name="chk_all" value="1" id="chk_all" class="css-checkbox">
						<label for="chk_all">모든 약관을 확인하고 전체 동의합니다.</label>
          </div>
          <div class="joinAgree-list">
            <div class="joinAgree-row">
              <div class="joinAgree-row-head arcodianBtn">
                <div class="joinAgree-check frm-choice">
									<input name="agree" type="checkbox" value="1" id="agree11" class="css-checkbox">
									<label for="agree11">[필수] 회원가입 약관 동의하기</label>
                </div>
              </div>
              <div class="joinAgree-row-body">
                <textarea><?php echo nl2br($config['shop_provision']); ?></textarea>
              </div>
            </div>
            <div class="joinAgree-row">
              <div class="joinAgree-row-head arcodianBtn">
                <div class="joinAgree-check frm-choice">
									<input name="agree2" type="checkbox" value="1" id="agree21" class="css-checkbox">
									<label for="agree21">[필수] 개인정보 수집 및 이용 동의하기</label>
                </div>
              </div>
              <div class="joinAgree-row-body">
                <textarea><?php echo nl2br($config['shop_private']); ?></textarea>
              </div>
            </div>
          </div>
          
          <?php if ($_SERVER['REMOTE_ADDR']=="106.247.231.170") { ?>
          <?php if($_GET['type'] == '1') { ?>
          <!-- 사업자 회원가입일 경우 노출 { -->
          <div class="joinDetail-box type2">
            <div class="joinDetail-body">
              <div class="form-row">
                <div class="form-head">
                  <p class="title">사업자 정보 조회<b>*</b></p>
                </div>
                <div class="form-body">
                  <input type="tel" name="b_no" id="b_no" class="frm-input w-per100" value="" placeholder="***-**-*****" maxlength="12" readonly="">
                  <div class="joinDetail-btn-box joinDetail-btn-box3">
                    <button type="button" class="ui-btn st3" onclick="getKFIAMember()">중앙회원조회</button>
                    <button type="button" class="ui-btn st3" onclick="chkDuBnum()">중복확인</button>
                    <button type="button" class="ui-btn st3" onclick="chkClosed()">휴/폐업조회</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- } 사업자 회원가입일 경우 노출 -->
          <?php } ?>
          <?php } ?>

					<div class="cp-btnbar">
						<div class="container">
							<div class="cp-btnbar__btns">
								<input type="submit" value="본인인증" class="ui-btn round stBlack">
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<script>
function fregister_submit(f)
{
	if(!f.agree.checked) {
		alert("회원가입 약관 내용에 동의하셔야 회원가입 하실 수 있습니다.");
		f.agree.focus();
		return false;
	}

	if(!f.agree2.checked) {
		alert("개인정보 수집 및 이용 내용에 동의하셔야 회원가입 하실 수 있습니다.");
		f.agree2.focus();
		return false;
	}

	return true;
}

jQuery(function($){
	// 모두선택
	$("input[name=chk_all]").click(function() {
		if ($(this).prop('checked')) {
			$("input[name^=agree]").prop('checked', true);
		} else {
			$("input[name^=agree]").prop("checked", false);
		}
	});

	$("input[name^=agree]").click(function() {
		$("input[name=chk_all]").prop("checked", false);
	});
});
</script>
