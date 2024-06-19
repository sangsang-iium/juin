<?php
if (!defined('_BLUEVATION_')) exit;
?>
<form name="fregform" method="post" onsubmit="return fregform_submit(this);">
  <input type="hidden" name="token" value="">

  <?php // 회원 개인정보 입력 _20240613_SY
  // if ($_SERVER['REMOTE_ADDR'] == '106.247.231.170') { ?>
    <!-- <form name="fregisterform" id="fregisterform" action="./member/member_register_form_update.php" onsubmit="return fregisterform_submit(this);" method="post" autocomplete="off" enctype="MULTIPART/FORM-DATA"> -->
    <input type="hidden" name="token" value="">
    <input type="hidden" name="mb_certify_case" value="hp" id="mb_certify_hp">
    <input type="hidden" name="mb_certify" value="" id="mb_certify_no">
    <input type="hidden" name="mb_adult" value="0" id="mb_adult_no">
    <input type="hidden" name="mb_recommend" value="admin" id="reg_mb_recommend">
    <input type="hidden" name="mb_grade" value="2" id="mb_grade">
    <input type="hidden" name="mb_sms" value="Y">
    <input type="hidden" name="mb_mailling" value="N" id="reg_mb_mailling">

    <h5 class="htag_title">회원 정보 입력</h5>
    <div class="board_table mart20">
      <table>
        <colgroup>
          <col class="w180">
          <col>
        </colgroup>
        <tbody>
          <tr>
            <th scope="row"><label for="reg_mb_id">아이디</label></th>
            <td>
                <div class="write_address">
                    <div class="file_wrap address">
                        <input type="text" name="mb_id" id="reg_mb_id" required class="frm_input required" size="20" maxlength="20">
                        <span id="msg_mb_id"></span>
                        <button type="button" class="btn_file ui-btn st3" onclick="chk_id()">중복확인</button>
                    </div>
                    <?php echo help('영문자, 숫자, _ 만 입력 가능. 최소 3자이상 입력하세요.'); ?>
                </div>
            </td>
          </tr>
          <tr>
            <th scope="row"><label for="reg_mb_password">비밀번호</label></th>
            <td>
              <input type="password" name="mb_password" id="reg_mb_password" required class="frm_input required w400 marr10" size="20" maxlength="20">
              <?php echo help('4자 이상의 영문 및 숫자'); ?>
            </td>
          </tr>
          <tr>
            <th scope="row"><label for="reg_mb_password_re">비밀번호 확인</label></th>
            <td>
              <input type="password" name="mb_password_re" id="reg_mb_password_re" required class="frm_input required w400" size="20" maxlength="20">
              <p id="password-message" class="reg-message"></p>
            </td>
          </tr>
          <tr>
            <th scope="row"><label for="reg_mb_name">이름(실명)</label></th>
            <td><input type="text" name="mb_name" id="reg_mb_name" required class="frm_input required w400" size="20"></td>
          </tr>
          <tr>
            <th scope="row"><label for="reg_mb_hp">휴대폰번호</label></th>
            <td>
              <input type="text" name="mb_hp" id="reg_mb_hp" class="frm_input w400" size="20" maxlength="20" placeholder="예) 000-0000-0000">
            </td>
          </tr>
          <tr>
            <th scope="row">주소</th>
            <td>
              <div class="write_address">
                <div class="file_wrap address">
                  <label for="reg_mb_zip" class="sound_only">우편번호</label>
                  <input type="text" name="mb_zip" id="reg_mb_zip" class="frm_input" size="8" maxlength="5" placeholder="우편번호">
                  <button type="button" class="btn_file" onclick="win_zip('fregform', 'mb_zip', 'mb_addr1', 'mb_addr2', 'mb_addr3', 'mb_addr_jibeon');">주소검색</button>
                </div>
                <div class="">
                  <input type="text" name="mb_addr1" id="reg_mb_addr1" class="frm_input frm_address" size="60" placeholder="기본주소">
                  <label for="reg_mb_addr1" class="hide">기본주소</label>
                  <input type="text" name="mb_addr2" id="reg_mb_addr2" class="frm_input frm_address" size="60" placeholder="상세주소">
                  <label for="reg_mb_addr2" class="hide">상세주소</label>
                  <input type="hidden" name="mb_addr_jibeon" value="">
                  <input type="text" name="mb_addr3" id="reg_mb_addr3" class="frm_input frm_address" size="60" readonly="readonly" placeholder="참고항목">
                  <label for="reg_mb_addr3" class="hide">참고항목</label>
                </div>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- <div class="board_btns tac mart20">
    <div class="btn_wrap">
      <input type="submit" value="회원등록" id="btn_submit" class="btn_acc" accesskey="s">
    </div>
  </div> -->

    <!-- </form> -->

  <?php //} ?>

  <p class="gap50" id="Binfo"></p>
  <h5 class="htag_title">사업자 정보</h5>
  <p class="gap20"></p>
  <div class="tbl_frm01">
    <table class="tablef">
      <colgroup>
        <col class="w140">
        <col>
        <col class="w140">
        <col>
      </colgroup>
      <tbody>
        <!-- <tr>
		<th scope="row">회원선택</th>
		<td colspan="3">
      <div class="write_address">
        <div class="file_wrap address">
          <input type="text" name="mb_id" class="required frm_input w200" readonly value="">
          <a href="./seller/seller_reglist.php" onclick="win_open(this,'seller_reglist','550','500','1'); return false" class="btn_file">선택</a>
        </div>
      </div>
		</td>
	</tr> -->
        <tr>
          <th scope="row">공급사명</th>
          <td><input type="text" name="company_name" required itemname="공급사명" class="required frm_input" size="30"></td>
          <th scope="row">제공상품</th>
          <td><input type="text" name="seller_item" required itemname="제공상품" class="required frm_input" size="30" placeholder="예) 가전제품"></td>
        </tr>
        <tr>
          <th scope="row">대표자명</th>
          <td><input type="text" name="company_owner" required itemname="대표자명" class="required frm_input" size="30"></td>
          <th scope="row">사업자등록번호</th>
          <td><input type="text" name="company_saupja_no" class="frm_input" size="30" placeholder="예) 000-00-00000"></td>
        </tr>
        <tr>
          <th scope="row">업태</th>
          <td><input type="text" name="company_item" class="frm_input" size="30" placeholder="예) 서비스업"></td>
          <th scope="row">종목</th>
          <td><input type="text" name="company_service" class="frm_input" size="30" placeholder="예) 전자상거래업"></td>
        </tr>
        <tr>
          <th scope="row">전화번호</th>
          <td><input type="text" name="company_tel" class="frm_input" size="30" placeholder="예) 02-1234-5678"></td>
          <th scope="row">팩스번호</th>
          <td><input type="text" name="company_fax" class="frm_input" size="30" placeholder="예) 02-1234-5678"></td>
        </tr>
        <tr>
          <th scope="row">사업장주소</th>
          <td colspan="3">
            <div class="write_address">
              <div class="file_wrap address">
                <label for="reg_company_zip" class="sound_only">우편번호</label>
                <input type="text" name="company_zip" id="reg_company_zip" class="frm_input" size="8" maxlength="5" placeholder="우편번호">
                <button type="button" class="btn_file" onclick="win_zip('fregform', 'company_zip', 'company_addr1', 'company_addr2', 'company_addr3', 'company_addr_jibeon');">주소검색</button>
              </div>
              <div class="">
                <input type="text" name="company_addr1" id="reg_company_addr1" class="frm_input frm_address" size="60" placeholder="기본주소">
                <label for="reg_company_addr1" class="hide">기본주소</label>
                <input type="text" name="company_addr2" id="reg_company_addr2" class="frm_input frm_address" size="60" placeholder="상세주소">
                <label for="reg_company_addr2" class="hide">상세주소</label>
                <input type="hidden" name="company_addr_jibeon" value="">
                <input type="text" name="company_addr3" id="reg_company_addr3" class="frm_input frm_address" size="60" readonly="readonly" placeholder="참고항목">
                <label for="reg_company_addr3" class="hide">참고항목</label>
              </div>
            </div>
          </td>
        </tr>
        <tr>
          <th scope="row">홈페이지</th>
          <td colspan="3"><input type="text" name="company_hompage" class="frm_input" size="30" placeholder="http://"></td>
        </tr>
      </tbody>
    </table>
  </div>

  <!-- 정산방식 추가 _20240508_SY -->
  <p class="gap50"></p>
  <h5 class="htag_title">정산방식</h5>
  <p class="gap20"></p>
  <div class="tbl_frm01">
    <table>
      <colgroup>
        <col class="w180">
        <col>
      </colgroup>
      <tbody>
        <tr>
          <th scope="row">정산방식</th>
          <td>
            <ul class="radio_group">
              <li class="radios">
                <input type="radio" name="income_type" value="0" id="income_type1" checked>
                <label for="income_type1" class="marr10">매입가 정산 지급 <b class="income_type1"></b> </label>
              </li>
              <li class="radios">
                <input type="radio" name="income_type" value="1" id="income_type2">
                <label for="income_type2" class="marr10">수수료 정산 지급 <b class="income_type2"></b></label>
              </li>
            </ul>
          </td>
        </tr>
        <tr class="incomePer_tr">
          <th scope="row">지급방식</th>
          <td>
            <input type="radio" name="incomePer_type" value="0" id="incomePer_type1" checked>
            <label for="incomePer_type1" class="marr10">정액지급<b class="incomePer_type1"></b> </label>
            <input type="radio" name="incomePer_type" value="1" id="incomePer_type2">
            <label for="incomePer_type2" class="marr10">정률지급<b class="incomePer_type2"></b> </label>
          </td>
        </tr>
        <tr class="incomePer_tr" id="incomePer_sub1">
          <th scope="row">정액지급</th>
          <td>
            <input type="text" name="income_price" id="income_price" value="" class="frm_input w80" onkeyup="addComma(this);"> 원
          </td>
        </tr>
        <tr class="incomePer_tr" id="incomePer_sub2">
          <th scope="row">정률지급</th>
          <td>
            <input type="text" name="income_per" id="income_per" value="" class="frm_input w80" onkeyup="addComma(this);"> %
          </td>
        </tr>
      </tbody>
    </table>
  </div>
  <p class="gap50"></p>
  <h5 class="htag_title">정산계좌 정보</h5>
  <p class="gap20"></p>
  <div class="tbl_frm01">
    <table class="tablef">
      <colgroup>
        <col class="w140">
        <col>
      </colgroup>
      <tbody>
        <tr>
          <th scope="row">은행명</th>
          <td><input type="text" name="bank_name" class="frm_input" size="30"></td>
        </tr>
        <tr>
          <th scope="row">계좌번호</th>
          <td><input type="text" name="bank_account" class="frm_input" size="30"></td>
        </tr>
        <tr>
          <th scope="row">예금주명</th>
          <td><input type="text" name="bank_holder" class="frm_input" size="30"></td>
        </tr>
        <!-- 정산일 추가 _20240402_SY -->
        <tr>
          <th scope="row">정산일</th>
          <td><input type="text" name="settle" class="frm_input" size="30"></td>
        </tr>
      </tbody>
    </table>
  </div>

  <p class="gap50"></p>
  <h5 class="htag_title">담당자 정보</h5>
  <p class="gap20"></p>
  <div class="tbl_frm01">
    <table class="tablef">
      <colgroup>
        <col class="w140">
        <col>
      </colgroup>
      <tbody>
        <tr>
          <th scope="row">담당자명</th>
          <td><input type="text" name="info_name" class="frm_input" size="30"></td>
        </tr>
        <tr>
          <th scope="row">담당자 핸드폰</th>
          <td><input type="text" name="info_tel" class="frm_input" size="30"></td>
        </tr>
        <tr>
          <th scope="row">담당자 이메일</th>
          <td><input type="text" name="info_email" class="frm_input" size="30"></td>
        </tr>
      </tbody>
    </table>
  </div>

  <div class="btn_confirm">
    <input type="submit" value="저장" id="btn_submit" class="btn_large" accesskey="s">
  </div>
</form>

<script>
// 아이디 중복체크 _20240614_SY
var chkId = false;
function chk_id() {
  let idFocus = document.querySelector('#reg_mb_id');
  let getId   = document.querySelector('#reg_mb_id').value;


  if(getId.length > 2) {
    $.ajax({
      url: bv_url+"/m/bbs/ajax.register_chkId.php",
      type: "POST",
      data: { "id" : getId },
      dataType: "JSON",
      success: function(data) {
        sessionStorage.setItem("chkId", data.res );
        sessionStorage.setItem("ID", getId );

        if(data.res == 'pass') {
          alert('사용가능한 아이디 입니다.');
          chkId = true;
        } else if(data.res == "reject") {
          alert('사용할 수 없는 아이디입니다.');
          chkId = false;
          idFocus.focus();
          return false;
        }
      }
    });
  } else {
    alert('회원아이디는 최소 3글자 이상 입력하세요.')
    return false;
  }
}

// 비밀번호 확인 일치여부 _20240614_SY
$('#reg_mb_password_re').on('input', function() {
  // 비밀번호와 비밀번호 확인 입력란의 값을 가져오기
  var password = $('#reg_mb_password').val();
  var confirmPassword = $('#reg_mb_password_re').val();

  // 메시지 표시 요소
  var messageElement = $('#password-message');

  // 비밀번호 입력란이 비어 있는지 확인
  if (!password) {
      messageElement.text('비밀번호를 입력하세요.');
  }
  // 비밀번호와 비밀번호 확인 입력란의 값이 일치하는지 확인
  else if (password !== confirmPassword) {
      messageElement.text('비밀번호가 일치하지 않습니다.');
  }
  // 비밀번호가 일치하는 경우
  else {
      messageElement.text('');
  }
});


  // 정산방식 추가 _20240508_SY
  function stringNumberToInt(stringNumber) {
    return parseFloat(stringNumber.replace(/,/g, ''));
  }

  $(function() {
    $('.incomePer_tr').hide();

    $('#income_type2').change(function() {
      $('.incomePer_tr').show();
      if ($('#incomePer_type1').is(':checked')) {
        $('#incomePer_sub2').hide();
      } else {
        $('#incomePer_sub1').hide();
      }
    });

    $('#income_type1').change(function() {
      $('.incomePer_tr').hide();
      if ($('#incomePer_type1').is(':checked')) {
        $('#incomePer_sub2').hide();
      } else {
        $('#incomePer_sub1').hide();
      }
    });

    $('#incomePer_type1').change(function() {
      $('#incomePer_sub1').show();
      $('#incomePer_sub2').hide();
    })
    $('#incomePer_type2').change(function() {
      $('#incomePer_sub1').hide();
      $('#incomePer_sub2').show();
    })
  });


  function fregform_submit(f) {

    // 회원아이디 중복확인 여부
    let ss_Id     = sessionStorage.getItem("ID");
    let ss_Id_chk = sessionStorage.getItem("chkId");

    if(chkId == false) {
      alert("아이디 중복을 확인해 주십시오.");
      f.mb_id.focus();
      return false;
    }

    // 세션 추가
    if(chkId == true) {
      if(ss_Id != f.reg_mb_id.value) {
        alert("아이디 중복을 확인해 주십시오");
        f.mb_id.focus();
        return false;
      }
    }

    if(f.mb_password.value.length < 4) {
      alert("비밀번호를 4글자 이상 입력하십시오.");
      f.mb_password.focus();
      return false;
    }

    if(f.mb_password.value != f.mb_password_re.value) {
      alert("비밀번호가 같지 않습니다.");
      f.mb_password_re.focus();
      return false;
    }

    if(f.mb_password.value.length > 0) {
      if(f.mb_password_re.value.length < 4) {
        alert("비밀번호를 4글자 이상 입력하십시오.");
        f.mb_password_re.focus();
        return false;
      }
    }

    // 이름 검사
    if(f.mb_name.value.length < 1) {
      alert("이름을 입력하십시오.");
      f.mb_name.focus();
      return false;
    }


    if (confirm("등록 하시겠습니까?") == false)
      return false;

    document.getElementById("btn_submit").disabled = "disabled";

    f.action = "./seller/seller_register_update.php";
    return true;
  }
</script>