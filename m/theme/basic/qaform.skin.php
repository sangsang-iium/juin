<?php
if(!defined("_BLUEVATION_")) exit; // 개별 페이지 접근 불가
?>

<div id="sit_qa_write">
	<form name="fitemqa" id="fitemqa" method="post" action="<?php echo $form_action_url; ?>" onsubmit="return fitemqa_submit(this);">
    <input type="hidden" name="w" value="<?php echo $w; ?>">
    <input type="hidden" name="mb_id" value="<?php echo $member['id']; ?>">
    <input type="hidden" name="gs_id" value="<?php echo $gs_id; ?>">	
    <input type="hidden" name="gs_use_aff" value="<?php echo $gs['use_aff']; ?>">
    <input type="hidden" name="seller_id" value="<?php echo $gs['mb_id']; ?>">	
    <input type="hidden" name="token" value="<?php echo $token; ?>">
    <input type="hidden" name="iq_id" value="<?php echo $iq_id; ?>">

    <div class="pop-qa_form">
      <div class="form-row mb5">
        <div class="frm-choice">
          <input type="checkbox" name="iq_secret" value="1" id="iq_secret" <?php echo get_checked($iq_secret, '1'); ?>>
          <label for="iq_secret">비밀글</label>
        </div>
      </div>
      <div class="form-row">
        <div class="form-head">
          <p class="title">문의유형<b>*</b></p>
        </div>
        <div class="form-body">
          <select name="iq_ty" required class="frm-select">
            <option value=""<?php echo get_selected($iq_ty, ""); ?>>문의유형(선택)</option>
            <option value="상품"<?php echo get_selected($iq_ty, "상품"); ?>>상품</option>
            <option value="배송"<?php echo get_selected($iq_ty, "배송"); ?>>배송</option>
            <option value="반품/환불/취소"<?php echo get_selected($iq_ty, "반품/환불/취소"); ?>>반품/환불/취소</option>
            <option value="교환/변경"<?php echo get_selected($iq_ty, "교환/변경"); ?>>교환/변경</option>
            <option value="기타"<?php echo get_selected($iq_ty, "기타"); ?>>기타</option>
          </select>
        </div>
      </div>
      <div class="form-row"  style="display:none">
        <div class="form-head">
          <p class="title">성명<b>*</b></p>
        </div>
        <div class="form-body">
          <input type="text" name="iq_name" value="<?php echo get_text($iq_name); ?>" id="iq_name"   class="frm-input w-per100">
        </div>
      </div>
      <div class="form-row"  style="display:none">
        <div class="form-head">
          <p class="title">이메일</p>
        </div>
        <div class="form-body">
          <input type="text" name="iq_email" value="<?php echo get_text($iq_email); ?>" id="iq_email" class="frm-input w-per100">
        </div>
      </div>
      <div class="form-row"  style="display:none">
        <div class="form-head">
          <p class="title">핸드폰</p>
        </div>
        <div class="form-body">
          <input type="text" name="iq_hp" value="<?php echo get_text($iq_hp); ?>" id="iq_hp" class="frm-input w-per100">
        </div>
      </div>
      <div class="form-row">
        <div class="form-head">
          <p class="title">제목<b>*</b></p>
        </div>
        <div class="form-body">
          <input type="text" name="iq_subject" value="<?php echo get_text($iq_subject); ?>" id="iq_subject" required class="frm-input w-per100" minlength="2" maxlength="250">
        </div>
      </div>
      <div class="form-row">
        <div class="form-head">
          <p class="title">질문<b>*</b></p>
        </div>
        <div class="form-body">
          <textarea name="iq_question" required class="frm-txtar w-per100"><?php echo $iq_question; ?></textarea>
        </div>
      </div>
    </div>

    <div class="btn_confirm btn_confirm_2">
      <input type="submit" value="등록하기" class="ui-btn round stBlack">
    </div>
  </form>
</div>

<script>
function fitemqa_submit(f)
{
    return true;
}
</script>
