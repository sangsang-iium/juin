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
              <input type="text" class="frm-input w-per100" value="<?php echo $mn_num ?>" placeholder="사업자등록번호를 입력해주세요.">
            </div>
          </div>
          <!-- } row -->
          <!-- row { -->
          <div class="form-row">
            <div class="form-head">
              <p class="title">사업장명<b>*</b></p>
            </div>
            <div class="form-body">
              <input type="text" class="frm-input w-per100" value="<?php echo $mn_store ?>" placeholder="사업장명를 입력해주세요.">
            </div>
          </div>
          <!-- } row -->
          <!-- row { -->
          <div class="form-row">
            <div class="form-head">
              <p class="title">대표자명<b>*</b></p>
            </div>
            <div class="form-body">
              <input type="text" class="frm-input w-per100" value="<?php echo $mn_ju_name ?>" placeholder="대표자명를 입력해주세요.">
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
              <input type="tel" name="mb_zip" value="<?php echo $mn_zip ?>" id="reg_mb_zip" required="" class="frm-input address-input_1" size="8" maxlength="5" placeholder="우편번호">
              <button type="button" class="ui-btn st3" onclick="execDaumPostcode()">주소검색</button>
              <input type="text" name="mb_addr1" value="<?php echo $mn_addr1 ?>" id="reg_mb_addr1" required="" class="frm-input address-input_2 frm_address" size="60" placeholder="기본주소" autocapitalize="off">
              <label for="reg_mb_addr1" class="sound_only">기본주소</label>
              <input type="text" name="mb_addr2" value="<?php echo $mn_addr2 ?>" id="reg_mb_addr2" class="frm-input address-input_3 frm_address" size="60" placeholder="상세주소" autocapitalize="off">
              <label for="reg_mb_addr2" class="sound_only">상세주소</label>
              <input type="text" name="mb_addr3" value="<?php echo $mn_addr3 ?>" id="reg_mb_addr3" class="frm-input address-input_4 frm_address" size="60" placeholder="참고항목" readonly="readonly" autocapitalize="off">
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
              <input type="text" class="frm-input" value="<?php echo $tele_phone[0] ?>">
              <span class="hyphen">-</span>
              <input type="text" class="frm-input" value="<?php echo $tele_phone[1] ?>">
              <span class="hyphen">-</span>
              <input type="text" class="frm-input" value="<?php echo $tele_phone[2] ?>">
            </div>
          </div>
          <!-- } row -->
          <!-- row { -->
          <div class="form-row">
            <div class="form-head">
              <p class="title">대표자 휴대전화<b>*</b></p>
            </div>
            <div class="form-body phone">
              <input type="text" class="frm-input" value="<?php echo $cell_phone[0] ?>">
              <span class="hyphen">-</span>
              <input type="text" class="frm-input" value="<?php echo $cell_phone[1] ?>">
              <span class="hyphen">-</span>
              <input type="text" class="frm-input" value="<?php echo $cell_phone[2] ?>">
            </div>
          </div>
          <!-- } row -->
          <!-- row { -->
          <div class="form-row">
            <div class="form-head">
              <p class="title">상담내용</p>
            </div>
            <div class="form-body">
              <textarea name="" id="" class="frm-input" placeholder="상담내용을 입력해주세요."></textarea>
            </div>
          </div>
          <!-- } row -->
          <!-- row { -->
          <div class="form-row">
            <div class="form-head">
              <p class="title">상담(담당) 희망자</p>
            </div>
            <div class="form-body">
              <input type="text" class="frm-input w-per100" placeholder="상담 희망자를 입력해주세요.">
            </div>
          </div>
          <!-- } row -->
          <!-- row { -->
          <div class="form-row">
            <div class="form-head">
              <p class="title">비밀번호<b>*</b></p>
            </div>
            <div class="form-body">
              <input type="text" class="frm-input w-per100" placeholder="비밀번호를 입력해주세요.">
            </div>
          </div>
          <!-- } row -->
          <!-- row { -->
          <div class="form-row">
            <div class="form-head">
              <p class="title">소개자(직원) 정보<b>*</b></p>
            </div>
            <div class="form-body">
              <input type="text" class="frm-input w-per100" value="<?php echo $mn_id ?>" placeholder="소개자를 입력해주세요.">
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
        <button class="ui-btn round stBlack" onclick="javascript:alert('신청이 완료 되었습니다.')">신청완료</button>
      </div>

    </div>
  </div>
</div>

<?php
include_once(BV_MPATH."/_tail.php"); // 하단
?>