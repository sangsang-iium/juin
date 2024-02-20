<?php
include_once('./_common.php');

if(!$is_member)
    alert_close('회원만 이용하실 수 있습니다.');

$mb = get_member($mb_id);
if(!$mb['id'])
	alert_close('회원정보가 존재하지 않습니다.\\n\\n탈퇴한 회원일 수 있습니다.');

$sendmail_count = (int)get_session('ss_sendmail_count') + 1;
if($sendmail_count > 3)
    alert_close('한번 접속후 일정수의 메일만 발송할 수 있습니다.\\n\\n계속해서 메일을 보내시려면 다시 로그인 또는 접속하여 주십시오.');

$token = md5(uniqid(rand(), true));
set_session("ss_token", $token);

$tb['title'] = '메일 쓰기';
include_once(BV_PATH.'/head.sub.php');

$email_enc = new str_encrypt();
$email_dec = $email_enc->decrypt($email);

$email = get_email_address($email_dec);
if(!$email)
    alert_close('이메일이 올바르지 않습니다.');

$email = $email_enc->encrypt($email);

if(!$name)
    $name = $email;
else
    $name = get_text(stripslashes($name), true);

if(!isset($type))
    $type = 0;

$type_checked[0] = $type_checked[1] = $type_checked[2] = "";
$type_checked[$type] = 'checked';
?>

<!-- 폼메일 시작 { -->
<div id="formmail" class="new_win">
    <h1 id="win_title"><?php echo $name; ?>님께 메일보내기</h1>

    <form name="fformmail" action="./formmail_send.php" onsubmit="return fformmail_submit(this);" method="post" enctype="MULTIPART/FORM-DATA">
    <input type="hidden" name="to" value="<?php echo $email; ?>">
    <input type="hidden" name="attach" value="2">
    <input type="hidden" name="fnick" value="<?php echo get_text($member['name']); ?>">
    <input type="hidden" name="fmail" value="<?php echo $member['email']; ?>">
	<input type="hidden" name="token" value="<?php echo $token; ?>">

    <div class="tbl_frm01 tbl_wrap">
        <table>
        <tbody>
        <tr>
            <th scope="row"><label for="subject">제목<strong class="sound_only">필수</strong></label></th>
            <td><input type="text" name="subject" id="subject" required class="frm_input required" size="60"></td>
        </tr>
        <tr>
            <th scope="row">형식</th>
            <td class="td_label">
                <input type="radio" name="type" value="0" id="type_text" checked> <label for="type_text">TEXT</label>
                <input type="radio" name="type" value="1" id="type_html"> <label for="type_html">HTML</label>
                <input type="radio" name="type" value="2" id="type_both"> <label for="type_both">TEXT+HTML</label>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="content">내용<strong class="sound_only">필수</strong></label></th>
            <td><textarea name="content" id="content" required class="frm_textbox required"></textarea></td>
        </tr>
        <tr>
            <th scope="row"><label for="file1">첨부 파일 1</label></th>
            <td>
                <input type="file" name="file1" id="file1">
                <span class="frm_info">첨부 파일은 누락될 수 있으므로 메일을 보낸 후 파일이 첨부 되었는지 반드시 확인해 주시기 바랍니다.</span>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="file2">첨부 파일 2</label></th>
            <td><input type="file" name="file2" id="file2"></td>
        </tr>
        </tbody>
        </table>
    </div>

    <div class="win_btn">
        <input type="submit" value="메일발송" id="btn_submit" class="btn_lsmall">
        <button type="button" onclick="window.close();" class="btn_lsmall bx-white">창닫기</button>
    </div>

    </form>
</div>

<script>
with (document.fformmail) {
    if(typeof fname != "undefined")
        fname.focus();
    else if(typeof subject != "undefined")
        subject.focus();
}

function fformmail_submit(f)
{
    if(f.file1.value || f.file2.value) {
        // 4.00.11
        if(!confirm("첨부파일의 용량이 큰경우 전송시간이 오래 걸립니다.\n\n메일보내기가 완료되기 전에 창을 닫거나 새로고침 하지 마십시오."))
            return false;
    }

    document.getElementById('btn_submit').disabled = true;

    return true;
}
</script>
<!-- } 폼메일 끝 -->

<?php
include_once(BV_PATH.'/tail.sub.php');
?>