<?php
include_once("./_common.php");
include_once(BV_MPATH."/_head.php"); // 상단

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
  $mn_jibeon = $mn_row['addr_jibeon'];
  $cell_phone = explode("-", $mn_row['cellphone']);
  $tele_phone = explode("-", $mn_row['telephone']);
}
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/signature_pad/1.5.3/signature_pad.min.js"></script>
<div id="contents" class="sub-contents">
  <div class="joinDetail-wrap apply-write-wrap">
    <div class="container">
      <form action="./apply_update.php" method="POST" autocomplete="off" enctype="multipart/form-data" onsubmit="return apply_service_submit(this);">
      <input type="hidden" name="mb_id" value="<?php echo $member['id']?>">
    <input type="hidden" name="b_type" value="4">
    <input type="hidden" name="sign1" id="sign1" value="">
    <div class="joinDetail-box">
      <div class="joinDetail-body">
          <div class="joinDetail-head">
            <p class="joinDetail-title center">신청자 정보</p>
          </div>
           <!-- row { -->
          <div class="form-row">
            <div class="form-head">
              <p class="title">성명<b>*</b></p>
            </div>
            <div class="form-body">
              <input type="text" name="c_name" class="frm-input w-per100" required value="<?php echo $mn_name ?>" placeholder="성명를 입력해주세요.">
            </div>
          </div>
          <!-- } row -->
          <!-- row { -->
          <div class="form-row">
            <div class="form-head">
              <p class="title">생년월일</p>
            </div>
            <div class="form-body">
              <input type="text" name="bc_birth" class="frm-input w-per100" placeholder="생년월일을 입력해주세요.">
            </div>
          </div>
          <!-- } row -->
          <!-- row { -->
          <div class="form-row">
            <div class="form-head">
              <p class="title">자택 주소</p>
            </div>
            <div class="form-body address">
              <label for="reg_mb_zip" class="sound_only">우편번호</label>
              <input type="tel" name="b_addr_zip" value="<?php echo $mn_zip ?>" id="reg_mb_zip" required="" class="frm-input address-input_1" size="8" maxlength="5" placeholder="우편번호" readonly>
              <button type="button" class="ui-btn st3" onclick="execDaumPostcode()">주소검색</button>
              <input type="text" name="b_addr_1" value="<?php echo $mn_addr1 ?>" id="reg_mb_addr1" required="" class="frm-input address-input_2 frm_address" size="60" placeholder="기본주소" autocapitalize="off" readonly>
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
              <p class="title">업소 주소</p>
            </div>
            <div class="form-body address">
              <label for="reg_mb_zip20" class="sound_only">우편번호</label>
              <input type="tel" name="b_addr_zip20" value="<?php echo $mn_zip ?>" id="reg_mb_zip20" required="" class="frm-input address-input_1" size="8" maxlength="5" placeholder="우편번호" readonly>
              <button type="button" class="ui-btn st3" onclick="execDaumPostcode1()">주소검색</button>
              <input type="text" name="b_addr_21" value="<?php echo $mn_addr1 ?>" id="reg_mb_addr21" required="" class="frm-input address-input_2 frm_address" size="60" placeholder="기본주소" autocapitalize="off" readonly>
              <label for="reg_mb_addr21" class="sound_only">기본주소</label>
              <input type="text" name="b_addr_22" value="<?php echo $mn_addr2 ?>" id="reg_mb_addr22" class="frm-input address-input_3 frm_address" size="60" placeholder="상세주소" autocapitalize="off">
              <label for="reg_mb_addr22" class="sound_only">상세주소</label>
              <input type="text" name="b_addr_23" value="<?php echo $mn_addr3 ?>" id="reg_mb_addr23" class="frm-input address-input_4 frm_address" size="60" placeholder="참고항목" readonly="readonly" autocapitalize="off">
              <label for="reg_mb_addr23" class="sound_only">참고항목</label>
              <input type="hidden" name="mb_addr_jibeon" value="">
            </div>
          </div>
          <!-- } row -->
          <!-- row { -->
          <div class="form-row">
            <div class="form-head">
              <p class="title">상호<b>*</b></p>
            </div>
            <div class="form-body">
              <input type="text" name="b_name" class="frm-input w-per100" required value="<?php echo $mn_store ?>" placeholder="사업장명를 입력해주세요.">
            </div>
          </div>
          <!-- } row -->
             <!-- row { -->
          <div class="form-row">
            <div class="form-head">
              <p class="title">전화번호</p>
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
              <p class="title">휴대전화<b>*</b></p>
            </div>
            <div class="form-body phone">
              <input type="text" name="b_phone[]" required class="frm-input" value="<?php echo $cell_phone[0] ?>">
              <span class="hyphen">-</span>
              <input type="text" name="b_phone[]" required class="frm-input" value="<?php echo $cell_phone[1] ?>">
              <span class="hyphen">-</span>
              <input type="text" name="b_phone[]" required class="frm-input" value="<?php echo $cell_phone[2] ?>">
            </div>
          </div>
          <!-- } row -->
          <!-- row { -->
          <div class="form-row">
            <div class="form-head">
              <p class="title">결제방법<b>*</b></p>
            </div>
            <div class="form-body">
              <div class="check-wr" data-group="b_paymethod">
                <div class="frm-choice">
                  <input type="checkbox" name="b_paymethod" id="chk4" value="자동이체" class="single-checkbox">
                  <label for="chk4">자동이체</label>
                </div>
                <div class="frm-choice">
                  <input type="checkbox" name="b_paymethod" id="chk5" value="카드결제" class="single-checkbox">
                  <label for="chk5">카드결제</label>
                </div>
              </div>
            </div>
          </div>
          <!-- } row -->

          <div class="joinDetail-head">
            <p class="joinDetail-title center">납부자 정보</p>
          </div>
          <!-- row { -->
          <div class="form-row">
            <div class="form-head">
              <p class="title">은행</p>
            </div>
            <div class="form-body">
              <input type="text" name="b_bank" class="frm-input w-per100" placeholder="은행명을 입력해주세요.">
            </div>
          </div>
          <!-- } row -->
          <!-- row { -->
          <div class="form-row">
            <div class="form-head">
              <p class="title">계좌번호</p>
            </div>
            <div class="form-body">
              <input type="text" name="b_account_num" class="frm-input w-per100" placeholder="계좌번호를 입력해주세요.">
            </div>
          </div>
          <!-- } row -->
          <!-- row { -->
          <div class="form-row">
            <div class="form-head">
              <p class="title">예금주</p>
            </div>
            <div class="form-body">
              <input type="text" name="b_account_name" class="frm-input w-per100" placeholder="예금주를 입력해주세요.">
            </div>
          </div>
          <!-- } row -->

                    <!-- row { -->
          <div class="form-row">
            <div class="form-head">
              <p class="title">생년월일</p>
            </div>
            <div class="form-body">
              <input type="text" name="bc_birth2" class="frm-input w-per100" placeholder="생년월일을 입력해주세요.">
            </div>
          </div>
          <!-- } row -->
          <!-- row { -->
          <div class="form-row">
            <div class="form-head">
              <p class="title">회원과의 관계</p>
            </div>
            <div class="form-body">
              <input type="text" name="bc_relation" class="frm-input w-per100" placeholder="회원과의 관계를 입력해주세요.">
            </div>
          </div>
          <!-- } row -->
          <!-- row { -->
          <div class="form-row">
            <div class="form-head">
              <p class="title">카드사</p>
            </div>
            <div class="form-body">
              <input type="text" name="bc_card_com" class="frm-input w-per100" placeholder="카드사를 입력해주세요.">
            </div>
          </div>
          <!-- } row -->
          <!-- row { -->
          <div class="form-row">
            <div class="form-head">
              <p class="title">카드번호</p>
            </div>
            <div class="form-body">
              <input type="text" name="bc_card_num" class="frm-input w-per100" placeholder="카드번호를 입력해주세요.">
            </div>
          </div>
          <!-- } row -->
          <!-- row { -->
          <div class="form-row">
            <div class="form-head">
              <p class="title">카드유효기간</p>
            </div>
            <div class="form-body">
              <input type="text" name="bc_card_cvc" class="frm-input w-per100" placeholder="카드유효기간을 입력해주세요.">
            </div>
          </div>
          <!-- } row -->
          <!-- row { -->
          <div class="form-row">
            <div class="form-head">
              <p class="title">계약구좌</p>
            </div>
            <div class="form-body">
              <input type="text" name="bc_acc" class="frm-input w-per100" placeholder="계약구좌를 입력해주세요.">
            </div>
          </div>
          <!-- } row -->
          <!-- row { -->
          <div class="form-row">
            <div class="form-head">
              <p class="title">이체일자</p>
            </div>
            <div class="form-body">
              <div class="check-wr" data-group="bc_acc_date">
                <div class="frm-choice">
                  <input type="checkbox" name="bc_acc_date" id="bc_acc_date1" value="5" class="single-checkbox">
                  <label for="bc_acc_date1">5</label>
                </div>
                <div class="frm-choice">
                  <input type="checkbox" name="bc_acc_date" id="bc_acc_date2" value="10" class="single-checkbox">
                  <label for="bc_acc_date2">10</label>
                </div>
                <div class="frm-choice">
                  <input type="checkbox" name="bc_acc_date" id="bc_acc_date3" value="15" class="single-checkbox">
                  <label for="bc_acc_date3">15</label>
                </div>
                <div class="frm-choice">
                  <input type="checkbox" name="bc_acc_date" id="bc_acc_date4" value="20" class="single-checkbox">
                  <label for="bc_acc_date4">20</label>
                </div>
                <div class="frm-choice">
                  <input type="checkbox" name="bc_acc_date" id="bc_acc_date5" value="25" class="single-checkbox">
                  <label for="bc_acc_date5">25</label>
                </div>

              </div>
            </div>
          </div>
          <!-- } row -->
             <!-- row { -->
          <div class="form-row">
            <div class="form-head">
              <p class="title">신청인</p>
            </div>
            <div class="form-body">
              <input type="text" name="bc_applicant" class="frm-input w-per100" placeholder="신청인을 입력해주세요.">
            </div>
          </div>
          <!-- } row -->
             <!-- row { -->
          <div class="form-row">
            <div class="form-head">
              <p class="title">서명</p>
            </div>
            <div class="form-body">
              <div class="mypage-product-regi__tb__li--right">
                <div class="mypage-product-regi__tb__sign">
                  <canvas id="signature" style="width:80%; height: 200px; border:1px solid #333; margin:0 auto; display:block;"></canvas>
                </div>
              </div>
            </div>
            <button id="clear" type="button">지우기</button>
          </div>
          <!-- } row -->
        </div>
      </div>

      <div class="joinAgree-list">
        <div class="joinAgree-row">
          <div class="joinAgree-row-head arcodianBtn">
            <div class="joinAgree-check frm-choice">
              <input name="b_agree" type="checkbox" value="0" id="b_agree" class="css-checkbox">
              <label for="b_agree">개인정보제공 동의</label>
            </div>
          </div>
          <div class="joinAgree-row-body">
            <textarea>
1. 개인정보 수집 및 이용에 관한 사항
2. 개인정보 제3자 제공동의에 관한 사항
3. 개인(신용) 정보의 조회 및 이용에 관한 사항
4. 개인정보처리의 위탁에 관한 사항
5. 개인정보의 선택적인 수집 및 이용에 관한 사항
6. 개인정보의 선택적인 제3자 제공에 관한 사항
            </textarea>
          </div>
        </div>
      </div>
      <div class="joinAgree-list">
        <div class="joinAgree-row">
          <div class="joinAgree-row-head arcodianBtn">
            <div class="joinAgree-check frm-choice">
              <input name="b_agree1" type="checkbox" value="0" id="b_agree1" class="css-checkbox">
              <label for="b_agree1">계약의 주요내용</label>
            </div>
          </div>
          <div class="joinAgree-row-body">
            <textarea>
1 회사의 상호, 전화번호, 주소, 대표자의 이름 등 안내
2 가입한 상품의 종류, 구성, 금액, 월납입금, 납입회차 등 상품 전반에 대한 내용
3 장례행사 시 제공되는 서비스 내용
4 서비스 제공 등에 대한 불만 및 회원과 당사의 분쟁 처리에 관한 내용
5 청약의 철회 및 계약의 해지, 고지의무 등 가입자의 권리와 의무
6 회원약관 전문(상조서비스의 이용, 계약의 해지 및 환급금 등)
7 계약의 중도해지 시, 해약환급금 환급일에 대한 설명
8 소비자피해 보상보험계약 체결 사실 및 관련사항
  - 지급의무자 : 상조보증공제조합(2024년 1월 현재)
  - 계약기간 : 계약 체결일로부터 1년 단위로 갱신됨
  - 소비자피해보상금 : 회원 실납입금액의 50%
  - 지급사유 : 폐업, 당좌거래의 정지, 등록취소, 파산선고, 회생절차개시의 결정
            </textarea>
          </div>
        </div>
      </div>

      <div class="apply-write-btn-wr">
        <button class="ui-btn round stBlack">신청완료</button>
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
<style>
  #post_wrap2 {
    display: none;
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    z-index: 510;
    width: 95%;
    max-width: 95%;
    height: 300px;
    max-height: 90vh;
    border: 1px solid;
    transition: .1s;
  }
</style>
<div id="post_wrap2" >
  <img src="/src/img/post_close.png" id="btnFoldWrap"
    style="cursor:pointer;position:absolute;right:0px;top:-1px;z-index:1" onclick="foldDaumPostcode1()"
    alt="접기 버튼">
</div>
<script src="/js/postcode.v2.js"></script>
<script>
   document.querySelectorAll('.check-wr').forEach(group => {
    group.addEventListener('change', function(e) {
      if (e.target.classList.contains('single-checkbox')) {
        const checkboxes = group.querySelectorAll('.single-checkbox');
        checkboxes.forEach(checkbox => {
          if (checkbox !== e.target) {
            checkbox.checked = false;
          }
        });
      }
    });
  });
  /** 우편번호 찾기 */
var element_wrap0 = document.getElementById('post_wrap');
function foldDaumPostcode() {
  // iframe을 넣은 element를 안보이게 한다.
  element_wrap0.style.display = 'none';
}

var element_wrap1 = document.getElementById('post_wrap2');
function foldDaumPostcode1() {
  // iframe을 넣은 element를 안보이게 한다.
  element_wrap1.style.display = 'none';
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
function execDaumPostcode1() {
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
      document.getElementById('reg_mb_zip20').value = data.zonecode;
      document.getElementById("reg_mb_addr21").value = addr;
      // 커서를 상세주소 필드로 이동한다.
      document.getElementById("reg_mb_addr22").focus();

      // iframe을 넣은 element를 안보이게 한다.
      // (autoClose:false 기능을 이용한다면, 아래 코드를 제거해야 화면에서 사라지지 않는다.)
      element_wrap0.style.display = 'none';

      // 우편번호 찾기 화면이 보이기 이전으로 scroll 위치를 되돌린다.
      document.body.scrollTop = currentScroll;
    },
    // 우편번호 찾기 화면 크기가 조정되었을때 실행할 코드를 작성하는 부분. iframe을 넣은 element의 높이값을 조정한다.
    onresize: function (size) {
      element_wrap1.style.height = size.height + 'px';
    },
    width: '100%',
    height: '100%'
  }).embed(element_wrap1);
  element_wrap1.style.display = 'block';
}

$(function() {
    var canvas = document.getElementById('signature');

    // 픽셀 비율을 고려하여 캔버스 좌표 공간을 조정합니다.
    // 모바일 장치에서 선명하게 보이도록 합니다.
    // 이것은 또한 캔버스가 지워지게 합니다.
    function resizeCanvas() {
      // 아주 이상한 이유로 100% 미만으로 축소하면,
      // 일부 브라우저는 devicePixelRatio를 1 미만으로 보고합니다.
      // 그러면 캔버스의 일부만 지워집니다.
      var ratio = Math.max(window.devicePixelRatio || 1, 1);
      canvas.width = canvas.offsetWidth * ratio;
      canvas.height = canvas.offsetHeight * ratio;
      canvas.getContext("2d").scale(ratio, ratio);
    }



    window.onresize = resizeCanvas;
    resizeCanvas();
  });

  var canvas = $("#signature")[0];
  var signature = new SignaturePad(canvas, {
    minWidth: 2,
    maxWidth: 2,
    penColor: "rgb(0, 0, 0)"
  });

  $("#clear").on("click", function() {
    signature.clear();
  });

  $("#my-return--02").on("click", function() {
   if (signature.isEmpty()) {
      alert("서명이 없습니다.");
      $('.my-pop-bg').removeClass('on');
      $('.my-pop').removeClass('on');
      return false;
    }
    var data = signature.toDataURL("image/png");
    console.log(signature)
    $('#sign1').val(data);

    return false;
  });

  function apply_service_submit(f) {
    if (signature.isEmpty()) {
      alert("서명이 없습니다.");
      return false;
    }
    var data = signature.toDataURL("image/png");
    console.log(signature)
    $('#sign1').val(data);
    return true;
  }

</script>
<?php
include_once(BV_MPATH."/_tail.php"); // 하단
?>