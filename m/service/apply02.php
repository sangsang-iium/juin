<?php
include_once("./_common.php");
include_once(BV_MPATH."/_head.php"); // 상단

// 담당자 정보 추가 _20240626_SY & 기본정보 추가 _20240627_SY
$mn_id = "";
$mn_name = "";
$mn_num = "";
if($is_member) {
  $mn_sel = " SELECT mm.*, mn.id AS mn_id FROM shop_member mm
           LEFT JOIN shop_manager mn
                  ON (mm.ju_manager = mn.index_no)
               WHERE mm.id = '{$member['id']}'; ";
  $mn_row = sql_fetch($mn_sel);
  $mn_id   = $mn_row['mn_id'];
  $mn_name = $mn_row['name'];
  $mn_num  = $mn_row['ju_b_num'];
  $cell_phone = explode("-", $mn_row['cellphone']);
}
?>

<div id="contents" class="sub-contents">
  <div class="joinDetail-wrap apply-write-wrap">
    <div class="container">
      <form action="./apply_update.php" method="POST" autocomplete="off" enctype="multipart/form-data" onsubmit="return apply_service_submit(event);">
      <input type="hidden" name="mb_id" value="<?php echo $member['id']?>">
      <input type="hidden" name="b_type" value="1">
      <div class="joinDetail-box">
        <div class="joinDetail-head">
          <p class="joinDetail-title center">외식가족공제 신한카드 S-Choice MyShop 체크</p>
          <p class="joinDetail-text">
            고객님의 간단한 인적사항을 남겨주시면 신한카드 상담원이 전화 드려 카드신청을 도와드립니다.
          </p>
        </div>
        <div class="joinDetail-body">
          <!-- row { -->
          <div class="form-row">
            <div class="form-head">
              <p class="title">신청구분</p>
            </div>
            <div class="form-body">
              <div class="check-wr" data-group="bc_gubun">
                <div class="frm-choice">
                  <input type="checkbox" name="bc_gubun" id="chk1" value="0" class="single-checkbox">
                  <label for="chk1">사업자용</label>
                </div>
                <div class="frm-choice">
                  <input type="checkbox" name="bc_gubun" id="chk2" value="1" class="single-checkbox">
                  <label for="chk2">종사자용</label>
                </div>
                <div class="frm-choice">
                  <input type="checkbox" name="bc_gubun" id="chk3" value="2" class="single-checkbox">
                  <label for="chk3">사업자용(사업자등록증 미발급)</label>
                </div>
              </div>
            </div>
          </div>
          <!-- } row -->
          <!-- row { -->
          <div class="form-row">
            <div class="form-head">
              <p class="title">신청카드</p>
            </div>
            <div class="form-body">
              <div class="check-wr" data-group="bc_card">
                <div class="frm-choice">
                  <input type="checkbox" name="bc_card" id="chk4" value="1" class="single-checkbox">
                  <label for="chk4">VISA</label>
                </div>
                <div class="frm-choice">
                  <input type="checkbox" name="bc_card" id="chk5" value="2" class="single-checkbox">
                  <label for="chk5">국내전용</label>
                </div>
              </div>
            </div>
          </div>
          <!-- } row -->
          <!-- row { -->
          <div class="form-row">
            <div class="form-head">
              <p class="title">할인유형</p>
            </div>
            <div class="form-body">
              <div class="check-wr" data-group="bc_sale">
                <div class="frm-choice">
                  <input type="checkbox" name="bc_sale" id="chk6" value="0" class="single-checkbox">
                  <label for="chk6">쇼핑</label>
                </div>
                <div class="frm-choice">
                  <input type="checkbox" name="bc_sale" id="chk7" value="1" class="single-checkbox">
                  <label for="chk7">교통</label>
                </div>
                <div class="frm-choice">
                  <input type="checkbox" name="bc_sale" id="chk8" value="2" class="single-checkbox">
                  <label for="chk8">커피</label>
                </div>
              </div>
            </div>
          </div>
          <!-- } row -->
          <!-- row { -->
          <div class="form-row">
            <div class="form-head">
              <p class="title">성명</p>
            </div>
            <div class="form-body">
              <input type="text" name="c_name" class="frm-input w-per100" required value="<?php echo $mn_name ?>" placeholder="성명을 입력해주세요.">
            </div>
          </div>
          <!-- } row -->
          <!-- row { -->
          <div class="form-row">
            <div class="form-head">
              <p class="title">생년월일</p>
            </div>
            <div class="form-body">
              <input type="text" name="bc_birth" class="frm-input w-per100" required placeholder="생년월일을 입력해주세요.">
            </div>
          </div>
          <!-- } row -->
          <!-- row { -->
          <div class="form-row">
            <div class="form-head">
              <p class="title">사업자등록번호</p>
            </div>
            <div class="form-body">
              <input type="text" name="b_num" class="frm-input w-per100" value="<?php echo $mn_num ?>" required placeholder="사업자등록번호를 입력해주세요.">
            </div>
          </div>
          <!-- } row -->
          <!-- row { -->
          <div class="form-row">
            <div class="form-head">
              <p class="title">휴대폰<b>*</b></p>
            </div>
            <div class="form-body phone">
              <input type="text" name="b_phone[]" required class="frm-input" value="<?php echo $cell_phone[0] ?>">
              <span class="hyphen">-</span>
              <input type="text" name="b_phone[]" required class="frm-input" value="<?php echo $cell_phone[1] ?>">
              <span class="hyphen">-</span>
              <input type="text" name="b_phone[]" required class="frm-input" value="<?php echo $cell_phone[2]?>">
            </div>
          </div>
          <!-- } row -->
          <!-- row { -->
          <div class="form-row">
            <div class="form-head">
              <p class="title">통화가능시간</p>
            </div>
            <div class="form-body time">
              <select name="bc_able[]" id="" class="frm-select" required>
                <option value="">선택</option>
                <option value="9">9시</option>
                <option value="10">10시</option>
                <option value="11">11시</option>
                <option value="12">12시</option>
                <option value="13">13시</option>
                <option value="14">14시</option>
                <option value="15">15시</option>
                <option value="16">16시</option>
                <option value="17">17시</option>
                <option value="18">18시</option>
              </select>
              <span class="hyphen">~</span>
              <select name="bc_able[]" id="" class="frm-select" required>
                <option value="">선택</option>
                <option value="9">9시</option>
                <option value="10">10시</option>
                <option value="11">11시</option>
                <option value="12">12시</option>
                <option value="13">13시</option>
                <option value="14">14시</option>
                <option value="15">15시</option>
                <option value="16">16시</option>
                <option value="17">17시</option>
                <option value="18">18시</option>
              </select>
            </div>
          </div>
          <!-- } row -->
          <!-- row { -->
          <div class="form-row">
            <div class="form-head">
              <p class="title">담당직원</p>
            </div>
            <div class="form-body">
              <input type="text" name="b_staff" class="frm-input w-per100" value="<?php echo $mn_id ?>" placeholder="담당직원의 사번을 입력하여주세요." required>
            </div>
          </div>
          <!-- } row -->
        </div>
      </div>

      <div class="joinAgree-list">
        <div class="joinAgree-row">
          <div class="joinAgree-row-head arcodianBtn">
            <div class="joinAgree-check frm-choice">
              <input name="b_agree" type="checkbox" value="0" id="b_agree" class="css-checkbox">
              <label for="b_agree">개인정보 수집·이용 동의 (필수)</label>
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
      </div>

      <div class="apply-write-btn-wr">
        <button class="ui-btn round stBlack">신청완료</button>
      </div>
      </form>
    </div>
  </div>
</div>
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
  function apply_service_submit(event) {
    const groups = document.querySelectorAll('.check-wr');
    let valid = true;

    groups.forEach(group => {
      const checkboxes = group.querySelectorAll('.single-checkbox');
      let isChecked = false;

      checkboxes.forEach(checkbox => {
        if (checkbox.checked) {
          isChecked = true;
        }
      });

      if (!isChecked) {
        valid = false;
      }
    });

    if (!valid) {
      alert('선택박스를 선택해주세요.');
      return false;
    }
    return true;
  }
</script>

<?php
include_once(BV_MPATH."/_tail.php"); // 하단
?>