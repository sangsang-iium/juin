<?php
if(!defined('_BLUEVATION_')) exit;
?>

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
		<th scope="row">입점서비스 사용</th>
		<td>
            <div class="radio_group">
                <label><input type="radio" name="seller_reg_yes" value="1"<?php echo ($config['seller_reg_yes']==1)?' checked':''; ?>> 사용함</label>
                <label><input type="radio" name="seller_reg_yes" value="0"<?php echo ($config['seller_reg_yes']==0)?' checked':''; ?>> 사용안함</label>
            </div>
		</td>
	</tr>
	<tr>
		<th scope="row">신규상품등록 진열</th>
		<td>
            <div class="radio_group">
                <label><input type="radio" name="seller_reg_auto" value="1"<?php echo ($config['seller_reg_auto']==1)?' checked':''; ?>> 관리자 승인</label>
                <label><input type="radio" name="seller_reg_auto" value="0"<?php echo ($config['seller_reg_auto']==0)?' checked':''; ?>> 등록시 바로 승인</label>
            </div>
		</td>
	</tr>
	<tr>
		<th scope="row">기존상품수정 진열</th>
		<td>
            <div class="radio_group">
                <label><input type="radio" name="seller_mod_auto" value="1"<?php echo ($config['seller_mod_auto']==1)?' checked':''; ?>> 관리자 승인</label>
                <label><input type="radio" name="seller_mod_auto" value="0"<?php echo ($config['seller_mod_auto']==0)?' checked':''; ?>> 수정시 바로 승인</label>
            </div>
		</td>
	</tr>	
	</tbody>
	</table>
</div>

<!-- 주석처리 _20240604_SY
<h2>가입설정</h2>
<div class="tbl_frm01">
	<table class="tablef">
	<colgroup>
		<col class="w180">
		<col>
	</colgroup>
	<tbody>
	<tr>
		<th scope="row">입점 가입약관</th>
		<td><textarea name="seller_reg_agree" class="frm_textbox wfull" rows="7"><?php echo preg_replace("/\\\/", "", $config['seller_reg_agree']); ?></textarea></td>
	</tr>	
	<tr>
		<th scope="row">PC 입점 이용안내</th>
		<td>
			<?php echo editor_html('seller_reg_guide', get_text(stripslashes($config['seller_reg_guide']), 0)); ?>	
		</td>
	</tr>
	<tr>
		<th scope="row">모바일 입점 이용안내</th>
		<td>
			<?php echo editor_html('seller_reg_mobile_guide', get_text(stripslashes($config['seller_reg_mobile_guide']), 0)); ?>	
		</td>
	</tr>
	</tbody>
	</table>
</div>
-->
<!-- 주석에 따른 input 추가 _20240604_SY -->
<input type="hidden" name="seller_reg_agree" value="<?php echo preg_replace("/\\\/", "", $config['seller_reg_agree']); ?>">
<input type="hidden" name="seller_reg_guide" value="<?php echo $config['seller_reg_guide']; ?>">
<input type="hidden" name="seller_reg_mobile_guide" value="<?php echo $config['seller_reg_mobile_guide']; ?>">

<div class="btn_confirm">
	<input type="submit" value="저장" class="btn_large" accesskey="s">
</div>
</form>

<script>
function fregform_submit(f) {
	<?php echo get_editor_js('seller_reg_guide'); ?>
	<?php echo get_editor_js('seller_reg_mobile_guide'); ?>

	f.action = "./config/supply_update.php";
    return true;
}
</script>
