<?php
if(!defined('_BLUEVATION_')) exit;
?>

<!-- <form name="fregform" method="post" action="./config/register_update.php"> -->
<form name="fregform" method="post" onsubmit="return fregform_submit(this);">
<input type="hidden" name="token" value="">

<h5 class="htag_title">기본설정</h5>
<p class="gap20"></p>
<div class="tbl_frm01">
	<table>
	<colgroup>
		<col width="220px">
		<col>
	</colgroup>
	<tbody>
	<tr>
		<th scope="row">회원가입시 포인트</th>
		<td>
			<input type="text" name="register_point" value="<?php echo number_format($config['register_point']); ?>" class="frm_input w80" onkeyup="addComma(this);"> 원
		</td>
	</tr>
	<tr>
		<th scope="row">추천인 포인트</th>
		<td>
			<input type="text" name="partner_point" value="<?php echo number_format($config['partner_point']); ?>" class="frm_input w80" onkeyup="addComma(this);"> 원
		</td>
	</tr>
	<tr>
		<th scope="row">핸드폰 입력</th>
		<td>
            <ul class="radio_group">
                <li class="checks">
                    <input id="register_use_hp" type="checkbox" name="register_use_hp" value="1"<?php echo $config['register_use_hp']?' checked':''; ?>>
                    <label for="register_use_hp">보이기</label>
                </li>
                <li class="checks">
                    <input id="register_req_hp" type="checkbox" name="register_req_hp" value="1"<?php echo $config['register_req_hp']?' checked':''; ?>> <label for="register_req_hp">필수입력</label>
                </li>
            </ul>
		</td>
	</tr>
	<tr>
		<th scope="row">전화번호 입력</th>
		<td>
            <ul class="radio_group">
                <li class="checks">
                    <input id="register_use_tel" type="checkbox" name="register_use_tel" value="1"<?php echo $config['register_use_tel']?' checked':''; ?>> <label for="register_use_tel">보이기</label>
                </li>
                <li class="checks">
                    <input id="register_req_tel" type="checkbox" name="register_req_tel" value="1"<?php echo $config['register_req_tel']?' checked':''; ?>> <label for="register_req_tel">필수입력</label>
                </li>
            </ul>
		</td>
	</tr>
	<tr>
		<th scope="row">주소 입력</th>
		<td class="td_label">
            <ul class="radio_group">
                <li class="checks">
                    <input id="register_use_addr" type="checkbox" name="register_use_addr" value="1"<?php echo $config['register_use_addr']?' checked':''; ?>> <label for="register_use_addr">보이기</label>
                </li>
                <li class="checks">
                    <input id="register_req_addr" type="checkbox" name="register_req_addr" value="1"<?php echo $config['register_req_addr']?' checked':''; ?>> <label for="register_req_addr">필수입력</label>
                </li>
            </ul>
			
		</td>
	</tr>
	<tr>
		<th scope="row">가입불가 ID</th>
		<td>
			<textarea name="prohibit_id" class="frm_textbox wfull" rows="3"><?php echo $config['prohibit_id']; ?></textarea>
			<?php echo help('입력된 단어가 포함된 내용은 회원아이디로 사용할 수 없습니다. 단어와 단어 사이는 , 로 구분합니다.'); ?>
		</td>
	</tr>
	<tr>
		<th scope="row">가입불가 E-mail</th>
		<td>
			<textarea name="prohibit_email" class="frm_textbox wfull" rows="3"><?php echo $config['prohibit_email']; ?></textarea>
			<?php echo help('hanmail.net과 같은 메일 주소는 입력을 못합니다. 엔터로 구분합니다.'); ?>
		</td>
	</tr>
	</tbody>
	</table>
</div>

<p class="gap50"></p>
<h5 class="htag_title">약관 설정</h5>
<p class="gap20"></p>
<div class="tbl_frm01">
	<table>
	<colgroup>
		<col class="w180">
		<col>
	</colgroup>
	<tbody>
	<tr>
		<th scope="row">회원가입약관<br>(회원가입 시)</th>
		<td><textarea name="shop_provision" class="frm_textbox wfull" rows="7"><?php echo preg_replace("/\\\/", "", $config['shop_provision']); ?></textarea></td>
	</tr>
	<tr>
		<th scope="row">개인정보 수집 및 이용<br>(회원가입 시)</th>
		<td><textarea name="shop_private" class="frm_textbox wfull" rows="7"><?php echo preg_replace("/\\\/", "", $config['shop_private']); ?></textarea></td>
	</tr>
	<tr>
		<th scope="row">개인정보처리방침</th>
    <!-- <td><textarea name="shop_policy" class="frm_textbox wfull" rows="7"><?php //echo preg_replace("/\\\/", "", $config['shop_policy']); ?></textarea></td> -->
    <td>
      <?php echo editor_html('shop_policy', get_text(stripslashes($config['shop_policy']), 0)); ?>	
    </td>
	</tr>
	</tbody>
	</table>
</div>

<div class="btn_confirm">
	<input type="submit" value="저장" class="btn_large" accesskey="s">
</div>
</form>

<script>
function fregform_submit(f) {
	<?php echo get_editor_js('shop_policy'); ?>

	f.action = "./config/register_update.php";
    return true;
}
</script>
