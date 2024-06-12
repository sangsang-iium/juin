<?php
if(!defined('_BLUEVATION_')) exit;
?>

<form name="fregform" method="post" action="./config/ipaccess_update.php">
<input type="hidden" name="token" value="">

<h5 class="htag_title">접속 제한 / 차단 IP 설정</h5>
<p class="gap20"></p>
<div class="tbl_frm01">
	<table>
	<colgroup>
		<col width="220px">
		<col>
	</colgroup>
	<tbody>
	<tr>
		<th scope="row">현재 접속 IP</th>
		<td><strong><?php echo $_SERVER['REMOTE_ADDR']; ?></strong></td>
	</tr>
	<tr>
		<th scope="row"><label for="possible_ip">접근 가능 IP</label></th>
		<td>
			<textarea name="possible_ip" id="possible_ip" class="frm_textbox wfull" rows="5"><?php echo $config['possible_ip']; ?></textarea>
            <ul class="cnt_list step02 mart10">
                <li>입력된 IP의 컴퓨터만 접근할 수 있음. 123.123.+ 도 입력 가능. (엔터로 구분)</li>
            </ul>
			<?php /* echo help('입력된 IP의 컴퓨터만 접근할 수 있음. 123.123.+ 도 입력 가능. (엔터로 구분)'); */ ?>
		</td>
	</tr>
	<tr>
		<th scope="row"><label for="intercept_ip">접근 차단 IP</label></th>
		<td>
			<textarea name="intercept_ip" id="intercept_ip" class="frm_textbox wfull" rows="5"><?php echo $config['intercept_ip']; ?></textarea>
            <ul class="cnt_list step02 mart10">
                <li>입력된 IP의 컴퓨터는 접근할 수 없음. 123.123.+ 도 입력 가능. (엔터로 구분)</li>
            </ul>
			<?php /* echo help('입력된 IP의 컴퓨터는 접근할 수 없음. 123.123.+ 도 입력 가능. (엔터로 구분)'); */ ?>
		</td>
	</tr>
	</tbody>
	</table>
</div>

<div class="btn_confirm">
	<input type="submit" value="저장" class="btn_large" accesskey="s">
</div>
</form>
<div class="text_box btn_type mart50">
    <h5 class="tit">도움말</h5>
    <ul class="cnt_list step01">
        <li>
            IP등록시 <span class="fc_084">123.+</span> 를 입력하셨다면 첫번째 항목에 해당하는 IP 주소는 접근 및 차단 됩니다.
            <span class="marl10 fc_084">예)</span> 123.456.789.22
        </li>
        <li>테스트를 위해 접근 차단 IP 입력란에 최고관리자 IP주소를 입력하시면 절대 안됩니다.</li>
        <li>유동적으로 변경되는 IP를 등록시 접속이 제한되실 수 있으니 참고하시기 바랍니다.</li>
    </ul>
</div>
<!-- <div class="information">
	<h4>도움말</h4>
	<div class="content">
		<div class="desc02">
			<p>ㆍIP등록시 <em>123.+</em> 를 입력하셨다면 첫번째 항목에 해당하는 IP 주소는 접근 및 차단 됩니다. 
			예) <em>123</em>.456.789.225</p>
			<p>ㆍ테스트를 위해 접근 차단 IP 입력란에 최고관리자 IP주소를 입력하시면 절대 안됩니다.</p>
			<p>ㆍ유동적으로 변경되는 IP를 등록시 접속이 제한되실 수 있으니 참고하시기 바랍니다.</p>
		</div>
	 </div>
</div> -->
