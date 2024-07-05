<?php
include_once("./_common.php");
include_once(BV_MPATH."/_head.php"); // 상단

// 담당자 정보 및 기본정보 추가 _20240627_SY
$mn_id = "";
$mn_name = "";
$mn_num = "";
if($is_member) {
  $mn_sel = " SELECT mm.*, mn.id AS mn_id FROM shop_member mm
           LEFT JOIN shop_manager mn
                  ON (mm.ju_manager = mn.index_no)
               WHERE mm.id = '{$member['id']}'; ";
  $mn_row = sql_fetch($mn_sel);
  $mn_id    = $mn_row['mn_id'];
  $mn_name  = $mn_row['name'];
  $mn_num   = $mn_row['ju_b_num'];
  $mn_store = $mn_row['ju_restaurant'];
  $mn_ju_name = $mn_row['ju_name'];
  $mn_zip = $mn_row['zip'];
  $mn_addr1 = $mn_row['addr1'];
  $mn_addr2 = $mn_row['addr2'];
  $mn_addr3 = $mn_row['addr3'];
  $cell_phone = explode("-", $mn_row['cellphone']);
  $tele_phone = explode("-", $mn_row['telephone']);
}
?>

<div id="contents" class="sub-contents">
  <div class="joinDetail-wrap apply-write-wrap">
    <div class="container">
      <form action="./apply_update.php" method="POST" autocomplete="off" enctype="multipart/form-data" onsubmit="return apply_service_submit(this);">
      <input type="hidden" name="b_type" value="3">
      <div class="joinDetail-box">
        <div class="joinDetail-head">
          <p class="joinDetail-title center">노무 제휴</p>
        </div>
        <div class="joinDetail-body">
          <!-- row { -->
          <div class="form-row">
            <div class="form-head">
              <p class="title">사업자등록번호<b>*</b></p>
            </div>
            <div class="form-body">
              <input type="text" name="b_num" class="frm-input w-per100" required value="<?php echo $mn_num ?>" placeholder="사업자등록번호를 입력해주세요.">
            </div>
          </div>
          <!-- } row -->
          <!-- row { -->
          <div class="form-row">
            <div class="form-head">
              <p class="title">사업장명<b>*</b></p>
            </div>
            <div class="form-body">
              <input type="text" name="b_name" class="frm-input w-per100" required value="<?php echo $mn_store ?>" placeholder="사업장명를 입력해주세요.">
            </div>
          </div>
          <!-- } row -->
          <!-- row { -->
          <div class="form-row">
            <div class="form-head">
              <p class="title">대표자명<b>*</b></p>
            </div>
            <div class="form-body">
              <input type="text" name="c_name" class="frm-input w-per100" required value="<?php echo $mn_ju_name ?>" placeholder="대표자명를 입력해주세요.">
            </div>
          </div>
          <!-- } row -->
          <!-- row { -->
          <div class="form-row">
            <div class="form-head">
              <p class="title">사업장 주소</p>
            </div>
            <div class="form-body address">
              <label for="reg_mb_zip" class="sound_only">우편번호</label>
              <input type="tel" name="b_addr_zip" value="<?php echo $mn_zip ?>" id="reg_mb_zip" required="required" class="frm-input address-input_1" size="8" maxlength="5" placeholder="우편번호">
              <button type="button" class="ui-btn st3" onclick="execDaumPostcode()">주소검색</button>
              <input type="text" name="b_addr_1" value="<?php echo $mn_addr1 ?>" id="reg_mb_addr1" required="" class="frm-input address-input_2 frm_address" size="60" placeholder="기본주소" autocapitalize="off">
              <label for="reg_mb_addr1" class="sound_only">기본주소</label>
              <input type="text" name="b_addr_2" value="<?php echo $mn_addr2 ?>" id="reg_mb_addr2" class="frm-input address-input_3 frm_address" size="60" placeholder="상세주소" autocapitalize="off">
              <label for="reg_mb_addr2" class="sound_only">상세주소</label>
              <input type="text" name="b_addr_3" value="<?php echo $mn_addr3 ?>" id="reg_mb_addr3" class="frm-input address-input_4 frm_address" size="60" placeholder="참고항목" readonly="readonly" autocapitalize="off">
              <label for="reg_mb_addr3" class="sound_only">참고항목</label>
              <input type="hidden" name="mb_addr_jibeon" value="">
            </div>
          </div>
          <!-- } row -->
          <!-- row { -->
          <div class="form-row">
            <div class="form-head">
              <p class="title">사업장 전화번호</p>
            </div>
            <div class="form-body phone">
              <input type="text" name="b_tel[]" class="frm-input" value="<?php echo $tele_phone[0] ?>">
              <span class="hyphen">-</span>
              <input type="text" name="b_tel[]" class="frm-input" value="<?php echo $tele_phone[1] ?>">
              <span class="hyphen">-</span>
              <input type="text" name="b_tel[]" class="frm-input" value="<?php echo $tele_phone[2] ?>">
            </div>
          </div>
          <!-- } row -->
          <!-- row { -->
          <div class="form-row">
            <div class="form-head">
              <p class="title">대표자 휴대전화<b>*</b></p>
            </div>
            <div class="form-body phone">
              <input type="text" name="b_phone[]" class="frm-input" required value="<?php echo $cell_phone[0] ?>">
              <span class="hyphen">-</span>
              <input type="text" name="b_phone[]" class="frm-input" required value="<?php echo $cell_phone[1] ?>">
              <span class="hyphen">-</span>
              <input type="text" name="b_phone[]" class="frm-input" required value="<?php echo $cell_phone[2] ?>">
            </div>
          </div>
          <!-- } row -->
          <!-- row { -->
          <div class="form-row">
            <div class="form-head">
              <p class="title">상담내용</p>
            </div>
            <div class="form-body">
              <textarea name="b_contents" id="b_contents" class="frm-input" placeholder="상담내용을 입력해주세요."></textarea>
            </div>
          </div>
          <!-- } row -->
          <!-- row { -->
          <div class="form-row">
            <div class="form-head">
              <p class="title">상담(담당) 희망자</p>
            </div>
            <div class="form-body">
              <input type="text" name="b_hope" class="frm-input w-per100" placeholder="상담 희망자를 입력해주세요.">
            </div>
          </div>
          <!-- } row -->
          <!-- row { -->
          <div class="form-row">
            <div class="form-head">
              <p class="title">비밀번호<b>*</b></p>
            </div>
            <div class="form-body">
              <input type="text" name="b_pw" class="frm-input w-per100" required placeholder="비밀번호를 입력해주세요.">
            </div>
          </div>
          <!-- } row -->
          <!-- row { -->
          <div class="form-row">
            <div class="form-head">
              <p class="title">소개자(직원) 정보<b>*</b></p>
            </div>
            <div class="form-body">
              <input type="text" name="b_staff" class="frm-input w-per100" required value="<?php echo $mn_id ?>" placeholder="소개자를 입력해주세요.">
            </div>
          </div>
          <!-- } row -->
        </div>
      </div>
      <!-- <div class="joinAgree-list">
        <div class="joinAgree-row">
          <div class="joinAgree-row-head arcodianBtn">
            <div class="joinAgree-check frm-choice">
              <input name="agree" type="checkbox" value="1" id="agree11" class="css-checkbox">
              <label for="agree11">개인정보 수집·이용 동의 (필수)</label>
            </div>
          </div>
          <div class="joinAgree-row-body">
            <textarea>
1. 수집·이용 목적 : 카드 간편신청에 따른 상담원의 전화 및 카드신청 시 정보 이용
2. 수집·이용 항목 : 성명, 생년월일, 사업자등록번호, 휴대폰번호, 추천인번호
3. 수집·이용 기간 : 목적 달성(또는 통화 미연결) 후 30일 후 삭제

귀하는 본 동의를 거부할 수 있지만, 거부를 하는 경우 본 카드 간편신청은 제한될 수 있습니다.
            </textarea>
          </div>
        </div>
      </div> -->

      <div class="apply-write-btn-wr">
        <button class="ui-btn round stBlack" >신청완료</button>
      </div>
      </form>
    </div>
  </div>
</div>
<div id="post_wrap" >
  <img src="/src/img/post_close.png" id="btnFoldWrap"
    style="cursor:pointer;position:absolute;right:0px;top:-1px;z-index:1" onclick="foldDaumPostcode()"
    alt="접기 버튼">
</div>
<script src="/js/postcode.v2.js"></script>
<script>
  function apply_service_submit(f) {

    if(f.b_pw.value.length < 4) {
      alert("비밀번호를 4글자 이상 입력하십시오.");
      f.b_pw.focus();
      return false;
    }

    if(f.b_pw.value.length > 0) {
      if(f.b_pw.value.length < 4) {
        alert("비밀번호를 4글자 이상 입력하십시오.");
        f.b_pw.focus();
        return false;
      }
    }
    return true;
  }


  /** 우편번호 찾기 */
var element_wrap0 = document.getElementById('post_wrap');

function foldDaumPostcode() {
  // iframe을 넣은 element를 안보이게 한다.
  element_wrap0.style.display = 'none';
}

function execDaumPostcode() {
  var currentScroll = Math.max(document.body.scrollTop, document.documentElement.scrollTop);
  new daum.Postcode({
    oncomplete: function (data) {
      // 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분.

      // 각 주소의 노출 규칙에 따라 주소를 조합한다.
      // 내려오는 변수가 값이 없는 경우엔 공백('')값을 가지므로, 이를 참고하여 분기 한다.
      var addr = ''; // 주소 변수
      var extraAddr = ''; // 참고항목 변수

      //사용자가 선택한 주소 타입에 따라 해당 주소 값을 가져온다.
      if (data.userSelectedType === 'R') { // 사용자가 도로명 주소를 선택했을 경우
        addr = data.roadAddress;
      } else { // 사용자가 지번 주소를 선택했을 경우(J)
        addr = data.jibunAddress;
      }

      // 사용자가 선택한 주소가 도로명 타입일때 참고항목을 조합한다.
      if (data.userSelectedType === 'R') {
        // 법정동명이 있을 경우 추가한다. (법정리는 제외)
        // 법정동의 경우 마지막 문자가 "동/로/가"로 끝난다.
        if (data.bname !== '' && /[동|로|가]$/g.test(data.bname)) {
          extraAddr += data.bname;
        }
        // 건물명이 있고, 공동주택일 경우 추가한다.
        if (data.buildingName !== '' && data.apartment === 'Y') {
          extraAddr += (extraAddr !== '' ? ', ' + data.buildingName : data.buildingName);
        }
        // 표시할 참고항목이 있을 경우, 괄호까지 추가한 최종 문자열을 만든다.
        if (extraAddr !== '') {
          extraAddr = ' (' + extraAddr + ')';
        }
        // 조합된 참고항목을 해당 필드에 넣는다.
        //     document.getElementById("sample3_extraAddress").value = extraAddr;

        // } else {
        //     document.getElementById("sample3_extraAddress").value = '';
      }

      // 우편번호와 주소 정보를 해당 필드에 넣는다.
      document.getElementById('reg_mb_zip').value = data.zonecode;
      document.getElementById("reg_mb_addr1").value = addr;
      // 커서를 상세주소 필드로 이동한다.
      document.getElementById("reg_mb_addr2").focus();

      // iframe을 넣은 element를 안보이게 한다.
      // (autoClose:false 기능을 이용한다면, 아래 코드를 제거해야 화면에서 사라지지 않는다.)
      element_wrap0.style.display = 'none';

      // 우편번호 찾기 화면이 보이기 이전으로 scroll 위치를 되돌린다.
      document.body.scrollTop = currentScroll;
    },
    // 우편번호 찾기 화면 크기가 조정되었을때 실행할 코드를 작성하는 부분. iframe을 넣은 element의 높이값을 조정한다.
    onresize: function (size) {
      element_wrap0.style.height = size.height + 'px';
    },
    width: '100%',
    height: '100%'
  }).embed(element_wrap0);
  element_wrap0.style.display = 'block';
}
</script>

<?php
include_once(BV_MPATH."/_tail.php"); // 하단
?>