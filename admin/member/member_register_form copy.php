<?php
if(!defined('_BLUEVATION_')) exit;
?>

<script src="<?php echo BV_JS_URL; ?>/jquery.register_form.js"></script>

<form name="fregisterform" id="fregisterform" action="./member/member_register_form_update.php" onsubmit="return fregisterform_submit(this);" method="post" autocomplete="off">
<input type="hidden" name="token" value="">

<h2>사이트 이용정보 입력</h2>
<div class="tbl_frm01">
	<table>
	<colgroup>
		<col class="w180">
		<col>
	</colgroup>
	<tbody>
	<tr>
		<th scope="row"><label for="reg_mb_id">아이디</label></th>
		<td>
			<input type="text" name="mb_id" id="reg_mb_id" required class="frm_input required" size="20" maxlength="20">
			<span id="msg_mb_id"></span>
			<?php echo help('영문자, 숫자, _ 만 입력 가능. 최소 3자이상 입력하세요.'); ?>
		</td>
	</tr>
	<tr>
		<th scope="row"><label for="reg_mb_password">비밀번호</label></th>
		<td><input type="password" name="mb_password" id="reg_mb_password" required class="frm_input required" size="20" maxlength="20"> 4자 이상의 영문 및 숫자</td>
	</tr>
	<tr>
		<th scope="row"><label for="reg_mb_password_re">비밀번호 확인</label></th>
		<td><input type="password" name="mb_password_re" id="reg_mb_password_re" required class="frm_input required" size="20" maxlength="20"></td>
	</tr>
	</tbody>
	</table>
</div>

<h2 class="mart30">개인정보 입력</h2>
<div class="tbl_frm01">
	<table>
	<colgroup>
		<col class="w180">
		<col>
	</colgroup>
	<tbody>
	<tr>
		<th scope="row"><label for="reg_mb_name">이름(실명)</label></th>
		<td><input type="text" name="mb_name" id="reg_mb_name" required class="frm_input required" size="20"></td>
	</tr>
	<tr>
		<th scope="row"><label for="reg_mb_tel">전화번호</label></th>
		<td><input type="text" name="mb_tel" id="reg_mb_tel" class="frm_input" size="20" maxlength="20"></td>
	</tr>
	<tr>
		<th scope="row"><label for="reg_mb_hp">휴대폰번호</label></th>
		<td>
			<input type="text" name="mb_hp" id="reg_mb_hp" class="frm_input" size="20" maxlength="20">
			<span class="frm_info">
				<label><input type="checkbox" name="mb_sms" value="Y" checked="checked"> 휴대폰 문자메세지를 받겠습니다.</label>
			</span>
		</td>
	</tr>
	<tr>
		<th scope="row"><label for="reg_mb_email">E-mail</label></th>
		<td>
			<input type="text" name="mb_email" id="reg_mb_email" required class="frm_input required" size="40" maxlength="100">
			<span class="frm_info">
				<label><input type="checkbox" name="mb_mailling" value="Y" id="reg_mb_mailling" checked="checked"> 정보 메일을 받겠습니다.</label>
			</span>
		</td>
	</tr>
    <tr>
        <th scope="row">본인확인방법</th>
        <td>
            <input type="radio" name="mb_certify_case" value="ipin" id="mb_certify_ipin">
            <label for="mb_certify_ipin">아이핀</label>
            <input type="radio" name="mb_certify_case" value="hp" id="mb_certify_hp">
            <label for="mb_certify_hp">휴대폰</label>
        </td>
    </tr>
    <tr>
        <th scope="row">본인확인</th>
        <td>
            <input type="radio" name="mb_certify" value="1" id="mb_certify_yes">
            <label for="mb_certify_yes">예</label>
            <input type="radio" name="mb_certify" value="" id="mb_certify_no" checked="checked">
            <label for="mb_certify_no">아니오</label>
        </td>
	</tr>
  <tr>
      <th scope="row">성인인증</th>
      <td>
          <input type="radio" name="mb_adult" value="1" id="mb_adult_yes">
          <label for="mb_adult_yes">예</label>
          <input type="radio" name="mb_adult" value="0" id="mb_adult_no" checked="checked">
          <label for="mb_adult_no">아니오</label>
      </td>
  </tr>
  <tr>
    <th scope="row">레벨</th>
    <td>
      <?php echo get_member_select("mb_grade", $mb['grade']); ?>
    </td>
  </tr>
	<tr>
		<th scope="row">주소</th>
		<td>
			<label for="reg_mb_zip" class="sound_only">우편번호</label>
			<input type="text" name="mb_zip" id="reg_mb_zip" class="frm_input" size="8" maxlength="5">
			<button type="button" class="btn_small" onclick="win_zip('fregisterform', 'mb_zip', 'mb_addr1', 'mb_addr2', 'mb_addr3', 'mb_addr_jibeon');">주소검색</button><br>
			<input type="text" name="mb_addr1" id="reg_mb_addr1" class="frm_input frm_address" size="60">
			<label for="reg_mb_addr1">기본주소</label><br>
			<input type="text" name="mb_addr2" id="reg_mb_addr2" class="frm_input frm_address" size="60">
			<label for="reg_mb_addr2">상세주소</label><br>
			<input type="text" name="mb_addr3" id="reg_mb_addr3" class="frm_input frm_address" size="60" readonly="readonly">
			<label for="reg_mb_addr3">참고항목</label>
			<input type="hidden" name="mb_addr_jibeon" value="">
		</td>
	</tr>
	<tr>
		<th scope="row"><label for="reg_mb_recommend">추천인</label></th>
		<td><input type="text" name="mb_recommend" value="admin" id="reg_mb_recommend" required class="frm_input required"></td>
	</tr>
	</tbody>
	</table>
</div>

<!-- 매장 정보 입력 추가 _20240507_SY -->
<!-- <h2 class="mart30">매장정보 입력</h2>
<div class="tbl_frm01">
  <table>
    <colgroup>
          <col class="w180">
          <col>
    </colgroup>
    <tbody>
      <tr>
        <th scope="row">매장유무</th>
        <td>
          <input type="radio" name="store_chk" value="1" id="store_chk_true">
          <label for="store_chk_true">유</label>
          <input type="radio" name="store_chk" value="0" id="store_chk_false" checked="checked">
          <label for="store_chk_false">무</label>
        </td>
      </tr>
    </tbody>
  </table>
</div> -->

<!-- <div class="tbl_frm01" id="store_info" style="display: none;">
	<table>
    <colgroup>
      <col class="w180">
      <col>
    </colgroup>
    <tbody>
      <tr>
        <th scope="row"><label for="ju_restaurant">상호(법인명)</label></th>
        <td><input type="text" name="ju_restaurant" id="ju_restaurant" required class="frm_input required" size="20"></td>
      </tr>
      <tr>
        <th scope="row"><label for="ju_member">대표자명</label></th>
        <td><input type="text" name="ju_member" id="ju_member" class="frm_input" size="20" maxlength="20"></td>
      </tr>
      <tr>
        <th scope="row"><label for="ju_b_num">사업자번호</label></th>
        <td>
          <input type="text" name="ju_b_num" id="ju_b_num" class="frm_input" size="20" maxlength="20">
          <button type="button" class="btn_small" onclick="">중앙회원조회</button>
          <button type="button" class="btn_small" onclick="">중복확인</button>
          <button type="button" class="btn_small" onclick="">휴/폐업조회</button><br>
        </td>
      </tr>
      <tr>
        <th scope="row"><label for="">사업장 연락처</label></th>
        <td>
          <input type="text" name="" id="" class="frm_input" size="20" maxlength="20">	
        </td>
      </tr>
      <tr>
        <th scope="row"><label for="">대표자 연락처</label></th>
        <td>
          <input type="text" name="" id="" class="frm_input" size="20" maxlength="20">	
        </td>
      </tr>
      <tr>
        <th scope="row">사업장 주소</th>
        <td>
          <label for="" class="sound_only">우편번호</label>
          <input type="text" name="" id="" class="frm_input" size="8" maxlength="5">
          <button type="button" class="btn_small" onclick="win_zip('fregisterform', '', '', '', '', '');">주소검색</button><br>
          <input type="text" name="" id="" class="frm_input frm_address" size="60">
          <label for="">기본주소</label><br>
          <input type="text" name="" id="" class="frm_input frm_address" size="60">
          <label for="">상세주소</label><br>
          <input type="text" name="" id="" class="frm_input frm_address" size="60" readonly="readonly">
          <label for="">참고항목</label>
          <input type="hidden" name="" value="">
        </td>
      </tr>
      <tr>
        <th scope="row"><label for="">지회/지부</label></th>
        <td>
					<select name="ju_region2" id="ju_region2">
						<option value="">지회 선택</option>
						<?php
						$depth1 = juinGroupInfo(1);
						for ($d = 0; $d < count($depth1); $d++) { ?>
							<option value="<?php echo $depth1[$d]['region'] ?>"><?php echo $depth1[$d]['region'] ?></option>
						<?php	}
						?>
					</select>
					<select name="ju_region3" id="ju_region3">
						<?php 
              $depth2 = juinGroupInfo(2); 
              for($ds= 0; $ds < count($depth2); $ds++) { ?>
                <option value="<?php echo $depth2[$ds]['region']?>"><?php echo $depth2[$ds]['region'] ?></option>
            <?php } ?>
					</select>
        </td>
      </tr>
      <tr>
        <th scope="row"><label for="">업태</label></th>
        <td><input type="text" name="" value="" id="" required class="frm_input required"></td>
      </tr>
      <tr>
        <th scope="row"><label for="">업종</label></th>
        <td><input type="text" name="" value="" id="" required class="frm_input required"></td>
      </tr>
    </tbody>
	</table>
</div> -->
<div class="btn_confirm">
	<input type="submit" value="저장" id="btn_submit" class="btn_large" accesskey="s">
</div>
</form>

<script>

$('input[name=store_chk]').click(function() {
  
  let chk_value = this.value;
  if(chk_value == '1') {
    $('#store_info').show();
  } else {
    $('#store_info').hide();
  }
})

$(document).ready(function() {
  $('#ju_region2').change(function() {
    var depth2 = $(this).val(); // 선택된 값 가져오기

    // Ajax 요청 보내기
    $.ajax({
      url: '/admin/ajax.gruopdepth.php', // 데이터를 처리할 서버 측 파일의 경로
      type: 'POST', // 요청 방식 (POST 또는 GET)
      data: { 
        depthNum: '2',
        depthValue: depth2
      }, // 서버로 전송할 데이터
      success: function(res) {
        // var reg = JSON.parse(res); // JSON 형식의 응답을 JavaScript 객체로 파싱

        var ju_region3 = $("#ju_region3");
        ju_region3.empty(); // 기존 옵션 모두 제거

        var defaultOption = $('<option>'); // 새로운 옵션 요소 생성
        defaultOption.val(""); // 옵션의 값 설정
        defaultOption.text("지부 선택"); // 옵션의 텍스트 설정
        ju_region3.append(defaultOption); // ju_region3에 옵션 추가

        for (var i = 0; i < reg.length; i++) {
            var option = $('<option>'); // 새로운 옵션 요소 생성
            option.val(reg[i].region); // 옵션의 값 설정
            option.text(reg[i].region); // 옵션의 텍스트 설정
            ju_region3.append(option); // ju_region3에 옵션 추가

            if (reg[i].region === '<?php echo $mb['ju_region3']; ?>') {
                option.prop('selected', true); // 선택 상태 설정
            }
        }
      },
      error: function(xhr, status, error) {
        console.log('요청 실패: ' + error);
      }
    });
  });
});

function fregisterform_submit(f)
{
	// 회원아이디 검사
	var msg = reg_mb_id_check();
	if(msg) {
		alert(msg);
		f.mb_id.select();
		return false;
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

	/*
	var pattern = /([^가-힣\x20])/i;
	if(pattern.test(f.mb_name.value)) {
		alert("이름은 한글로 입력하십시오.");
		f.mb_name.select();
		return false;
	}
	*/

	// E-mail 검사
	var msg = reg_mb_email_check();
	if(msg) {
		alert(msg);
		f.reg_mb_email.select();
		return false;
	}

	if(typeof(f.mb_recommend) != "undefined" && f.mb_recommend.value) {
		if(f.mb_id.value == f.mb_recommend.value) {
			alert("본인을 추천할 수 없습니다.");
			f.mb_recommend.focus();
			return false;
		}

		var msg = reg_mb_recommend_check();
		if(msg) {
			alert(msg);
			f.mb_recommend.select();
			return false;
		}
	}


	//document.getElementById("btn_submit").disabled = "disabled";

    return true;
}
</script>
