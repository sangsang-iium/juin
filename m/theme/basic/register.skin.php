<?php
if(!defined("_BLUEVATION_")) exit; // 개별 페이지 접근 불가
?>
<!-- 본인인증 _20240531_SY -->
<?php if($config['cf_cert_use'] && ($config['cf_cert_ipin'] || $config['cf_cert_hp'])) { ?>
<script src="<?php echo BV_JS_URL; ?>/certify.js?v=<?php echo BV_JS_VER; ?>"></script>
<?php } ?>

<div id="contents" class="sub-contents joinAgree">
	<div class="joinAgree-wrap">
		<div class="container">
			<div class="joinAgree-head">
				<p>회원가입을 위해 <br/><b>서비스 이용 약관에 동의</b>해 주세요.</p>
			</div>
			<div class="joinAgree-body">
				<form  name="fregisterform" id="fregisterform" action="<?php echo $register_action_url; ?>" onsubmit="return fregisterform_submit(this);" method="POST" autocomplete="off">
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
                <textarea><?php echo preg_replace("/\\\/", "", $config['shop_provision']); //nl2br($config['shop_provision']); ?></textarea>
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
                <textarea><?php echo preg_replace("/\\\/", "", $config['shop_private']); //nl2br($config['shop_private']); ?></textarea>
              </div>
            </div>
          </div>

          <?php if($_GET['type'] == '1') { ?>
          <!-- 사업자 회원가입일 경우 노출 { -->
          <input type="hidden" name="w" value="<?php echo $w; ?>">
          <input type="hidden" name="cert_type" value="<?php echo $member['mb_certify']; ?>">
          <input type="hidden" name="chk_cb_res" value="0" id="chk_cb_res">
          <input type="hidden" name="chk_bn_res" value="0" id="chk_bn_res">

          <div class="joinDetail-box type2">
            <div class="joinDetail-body">
              <div class="form-row">
                <div class="form-head">
                  <p class="title">사업자 정보 조회<b>*</b></p>
                </div>
                <div class="form-body input-button id-confirm">
                  <input type="tel" name="b_no" id="b_no" class="frm-input" value="" placeholder="숫자만 입력" maxlength="10" >
                  <button type="button" class="ui-btn st3" onclick="getKFIAMember()">조회</button>
                </div>
              </div>
            </div>
          </div>
          <!-- } 사업자 회원가입일 경우 노출 -->
          <?php } ?>

					<div class="cp-btnbar">
						<div class="container">
							<div class="cp-btnbar__btns">
								<input type="submit" value="약관동의" class="ui-btn round stBlack">
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>


<!-- 주소값 (위도/경도) 가져오기 _20240612_SY -->
<script type="text/javascript" src="https://dapi.kakao.com/v2/maps/sdk.js?appkey=<?php echo $default['de_kakao_js_apikey'] ?>&libraries=services"></script>
<?php echo BV_POSTCODE_JS ?>
<script>

// 사업자번호 중복체크 _20240531_SY
function chkDuBnum(kfiaMsg) {
  b_num = document.querySelector('#b_no').value;

  if(b_num.length > 0) {
    $.ajax({
        url: bv_url+"/m/bbs/ajax.duplication_check.php",
        type: "POST",
        data: { "b_num" : b_num },
        dataType: "JSON",
        success: function(data) {
          if(data.res > 0 ) {
            $('#chk_bn_res').val('0');
            alert(kfiaMsg+"\n이미 등록된 사업자등록번호입니다");
            return false;
          } else {
            // alert("가입 가능한 사업자등록번호입니다");
            $('#chk_bn_res').val('1');
            chkClosed(kfiaMsg, "가입여부 : 가입 가능한 사업자등록번호입니다");
          }
        }
    });
  } else {
    alert("사업자등록번호가 존재하지 않습니다.")
    return false;
  }
}


// 휴/폐업 조회 _20240531_SY
let b_num = '';
function chkClosed(kfiaMsg, bNumMsg) {
  b_num = document.querySelector('#b_no').value;

  let b_stt_cd = "";
  let end_dt   = "";
  let mgs = "";

  if(b_num.length > 0) {
    $.ajax({
        url: bv_url+"/m/bbs/ajax.closed_check.php",
        type: "POST",
        data: { "b_num" : b_num },
        dataType: "JSON",
        success: function(res) {
          console.log(res);
          // API 값 호출 _20240318_SY
          // 휴/폐업 가입불가 _20240612_SY
          if (res.hasOwnProperty('match_cnt') && res.data[0].b_stt_cd == '01') {
            $('#chk_cb_res').val(res.data[0].b_stt_cd);
            msg = res.data[0].b_stt;
            alert(kfiaMsg+"\n"+bNumMsg+"\n"+"휴/폐업 여부 : "+msg);
          } else {
            switch (res.data[0].b_stt_cd) {
              case "" :
                $('#chk_cb_res').val('0');
                msg = res.data[0].tax_type;
                break;
                default : 
                $('#chk_cb_res').val(res.data[0].b_stt_cd);
                msg = res.data[0].b_stt;
                break;
            } 
            alert(kfiaMsg+"\n"+bNumMsg+"\n"+"휴/폐업 여부 : "+msg);
            return false;
          }
        }
    });
  } else {
    alert("사업자등록번호가 존재하지 않습니다.")
    return false;
  }
}


// 외식업중앙회원 조회하기 _20240531_SY
var chkKFIA = false;
function getKFIAMember() {
  const form = $('#fregisterform');
  let inputNum = document.querySelector('#b_no').value;

  if(inputNum.length > 0) {
    $.ajax({
      url: bv_url + "/m/bbs/ajax.KFIA_info.php",
      type: "POST",
      data: { "b_num": inputNum },
      dataType: "JSON",
      success: function(res) {
        if(res.data == null) {
          alert('사업자 정보 조회 실패');
          chkKFIA = false;
          return false;
        } else {
          Object.entries(res.data).forEach(([key, value]) => {
            form.append(`<input type="hidden" name="${key}" value="${value}">`);
          }); 
          console.log(res.data)

          // 위도/경도 값 & Kakao맵 Api 로드 _20240612_SY
          if (typeof kakao !== 'undefined' && kakao.maps && kakao.maps.services && kakao.maps.services.Geocoder) {
            var geocoder = new kakao.maps.services.Geocoder();
            var address = res.data.DORO_ADDRESS.trim();
            
            geocoder.addressSearch(address, function(result, status) {
              if (status === kakao.maps.services.Status.OK) {
                form.append(`<input type="hidden" name="ju_lat" value="${result[0].y}">`);
                form.append(`<input type="hidden" name="ju_lng" value="${result[0].x}">`);
              } else {
                console.error('Geocoder failed due to: ' + status);
              }
            });
          } else {
            console.error('Kakao maps script not loaded properly.');
          }

          chkKFIA = true;
          chkDuBnum(`조회 성공 : ${res.data.MEMBER_NAME}`);
        }
      }
    });
  } else {
    alert("사업자 번호를 입력하여 주십시오.");
    return false;
  }
}

function telPass() {
  <?php if($config['cf_cert_use'] && $config['cf_cert_hp']) { ?>

    if(!cert_confirm())
      return false;

    <?php
    switch($config['cf_cert_hp']) {
      case 'kcb':
        $cert_url = BV_OKNAME_URL.'/hpcert1.php';
        $cert_type = 'kcb-hp';
        break;
      case 'kcp':
        $cert_url = BV_KCPCERT_URL.'/kcpcert_form.php';
        $cert_type = 'kcp-hp';
        break;
      case 'lg':
        $cert_url = BV_LGXPAY_URL.'/AuthOnlyReq.php';
        $cert_type = 'lg-hp';
        break;
      default:
        echo 'alert("기본환경설정에서 휴대폰 본인인증 설정을 해주십시오");';
        echo 'return false;';
        break;
    }
    ?>

    certify_win_open("<?php echo $cert_type; ?>", "<?php echo $cert_url; ?>");
    return ;
  <?php } ?>
}


function fregisterform_submit(f)
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

  // 중앙회원조회 _20240328_SY
  if(f.w.value == "") {
    if(chkKFIA == false) {
      alert('중앙회 회원이 아닐 경우 일반회원으로 가입하여 주십시오.')
      f.b_no.focus();
      return false;
    }
  }

  // 사업자번호 중복체크 _20240318_SY
  if((f.w.value == "") || (f.w.value == "u" && f.chk_bn_res.defaultValue != f.chk_bn_res.value)) {
    if(f.chk_bn_res.value == "0") {
      alert('이미 등록된 사업자등록번호입니다.');
      f.b_no.select();
      return false;
    };
  }

  // 휴/폐업 검사 _20240612_SY
  if((f.w.value == "") || (f.w.value == "u" && f.chk_cb_res.defaultValue != f.chk_cb_res.value)) {
    if(f.chk_cb_res.value != '01') {
      // 휴/폐업일때 어떤 작업 필요한지 확인 필요
      alert('휴/폐업/국세청미등록 사업자는 일반회원으로 가입하여 주십시오.');
      f.b_no.select();
      return false;
    };
  }

  // 휴대폰인증 _20240531_SY
  // telPass();
  // Session 체크 필요

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
