<?php
if(!defined("_BLUEVATION_")) exit; // 개별 페이지 접근 불가
?>
<!-- 본인인증 추가 _20240705_SY -->
<script src="<?php echo BV_JS_URL; ?>/jquery.register_form.js"></script>
<?php if ($config['cf_cert_use'] && ($config['cf_cert_ipin'] || $config['cf_cert_hp'])) { ?>
  <script src="<?php echo BV_JS_URL; ?>/certify.js?v=<?php echo BV_JS_VER; ?>"></script>
<?php } ?>

<form name="fregisterform" action="<?php echo $form_action_url ?>" method="post" autocomplete="off" onsubmit="return false">
<input type="hidden" name="token" value="<?php echo $token; ?>">
<input type="hidden" name="cert_type" value="<?php echo $member['mb_certify']; ?>">
<input type="hidden" name="cert_no" value="">
<input type="hidden" name="chk_hp" value="">

<div id="contents" class="sub-contents userLost passwordLost">
	<div class="passwordLost-wrap">
		<div class="container">
			<p class="passwordLost-text">
				회원가입 시 등록하신 이름과 휴대번호를 입력해 주세요.<br>
				본인인증을 통해 일부 아이디 정보를 확인 할 수 있습니다.
			</p>
      <form action="">
        <div class="form-row">
          <div class="form-head">
            <p class="title"><label for="reg_name">이름</label><b>*</b></p>
          </div>
          <div class="form-body">
            <input type="text" name="find_name" id="reg_name" required class="frm-input w-per100" placeholder="이름을 입력해주세요">
          </div>
        </div>
        <div class="form-row">
          <div class="form-head">
            <p class="title"><label for="reg_hp">핸드폰번호</label><b>*</b></p>
          </div>
          <div class="form-body phone">
            <input type="tel" name="find_hp[]" value="" id="reg_hp" required="" class="frm-input" size="20" maxlength="3" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
            <span class="hyphen">-</span>
            <input type="tel" name="find_hp[]" value="" class="frm-input" maxlength="4" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
            <span class="hyphen">-</span>
            <input type="tel" name="find_hp[]" value="" class="frm-input" maxlength="4" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
          </div>
        </div>
      </form>
		</div>
	</div>
	<div class="userLost-btnbar">
		<div class="container">
			<div class="cp-btnbar__btns">
				<!-- <input type="submit" value="본인인증" id="btn_submit" class="ui-btn round stBlack"> -->
        <button type="submit" id="win_hp_cert" class="ui-btn round stBlack">본인인증</button>
			</div>
		</div>
	</div>
</div>
</form>


<!-- 본인인증 추가 _20240705_SY -->
<script>
  $(function() {
    <?php if ($config['cf_cert_use'] && $config['cf_cert_hp']) { ?>
      // 휴대폰인증
      $("#win_hp_cert").click(function() {
        if (!cert_confirm())
          return false;

        <?php
        switch ($config['cf_cert_hp']) {
          case 'kcb':
            $cert_url = BV_OKNAME_URL . '/hpcert1.php';
            $cert_type = 'kcb-hp';
            break;
          case 'kcp':
            $cert_url = BV_KCPCERT_URL . '/kcpcert_form.php';
            $cert_type = 'kcp-hp';
            break;
          case 'lg':
            $cert_url = BV_LGXPAY_URL . '/AuthOnlyReq.php';
            $cert_type = 'lg-hp';
            break;
          default:
            echo 'alert("기본환경설정에서 휴대폰 본인인증 설정을 해주십시오");';
            echo 'return false;';
            break;
        }
        ?>

        certify_win_open("<?php echo $cert_type; ?>", "<?php echo $cert_url; ?>");
        return;
      });
    <?php } ?>
  });
  // 부모 창에서 메시지 수신
  window.addEventListener("message", function(event) {
    const allowedOrigin = "<?php echo $_SERVER['HTTP_HOST']; ?>";
    const eventOrigin = event.origin.replace(/^https?:\/\//, ''); // 프로토콜 제거

    if (eventOrigin !== allowedOrigin) {
        // 도메인을 확인하여 보안 유지
        return;
    }

    const certData = event.data;
    console.log("Received data from child:", certData.message);

    if (certData.message === "인증완료") {
      const form = document.querySelector('form[name="fregisterform"]');
      
      form.submit();
        
    }
  });
</script> 
