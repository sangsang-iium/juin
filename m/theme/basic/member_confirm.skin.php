<?php
if(!defined('_BLUEVATION_')) exit; // 개별 페이지 접근 불가
?>

<!-- 회원 비밀번호 확인 시작 { -->
<div id="contents" class="sub-contents mbConfirm">
  <div class="container">
    <p class="mb_confirm_txt"><strong>비밀번호를 한번 더 입력해주세요.</strong></p>
    <p class="mb_confirm_txt">정보를 안전하게 보호하기 위해 비밀번호를 한번 더 확인합니다.</p>

    <form name="fmemberconfirm" action="<?php echo $url; ?>" onsubmit="return fmemberconfirm_submit(this);" method="post">
      <input type="hidden" name="mb_id" value="<?php echo $member['id']; ?>">
      <input type="hidden" name="w" value="u">

      <fieldset class="mbConfirm-fieldset">
        <label for="confirm_mb_password" class="sound_only">비밀번호<strong class="sound_only">필수</strong></label>
        <input type="password" name="mb_password" id="confirm_mb_password" required class="frm-input w-per100" size="15" maxLength="20" placeholder="비밀번호를 입력해주세요">

        <input type="submit" value="확인" id="btn_submit" class="ui-btn stBlack round100">
      </fieldset>
    </form>
  </div>
</div>

<script>
function fmemberconfirm_submit(f)
{
  document.getElementById("btn_submit").disabled = true;
  return true;
}
</script>
<!-- } 회원 비밀번호 확인 끝 -->
