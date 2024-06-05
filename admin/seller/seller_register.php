<?php
if(!defined('_BLUEVATION_')) exit;
?>

<form name="fregform" method="post" onsubmit="return fregform_submit(this);">
<input type="hidden" name="token" value="">

<p class="gap30"></p>
<h5 class="htag_title">사업자 정보</h5>
<p class="gap20"></p>
<div class="tbl_frm01">
	<table class="tablef">
	<colgroup>
		<col class="w140">
		<col>
		<col class="w140">
		<col>
	</colgroup>
	<tbody>
	<tr>
		<th scope="row">회원선택</th>
		<td colspan="3">
            <div class="write_address">
                <div class="file_wrap address">
                    <input type="text" name="mb_id" class="required frm_input w200" readonly value="">
                    <a href="./seller/seller_reglist.php" onclick="win_open(this,'seller_reglist','550','500','1'); return false" class="btn_file">선택</a>
                </div>
            </div>
		</td>
	</tr>
	<tr>
		<th scope="row">공급사명</th>
		<td><input type="text" name="company_name" required itemname="공급사명" class="required frm_input" size="30"></td>
		<th scope="row">제공상품</th>
		<td><input type="text" name="seller_item" required itemname="제공상품" class="required frm_input" size="30" placeholder="예) 가전제품"></td>
	</tr>
	<tr>
		<th scope="row">대표자명</th>
		<td><input type="text" name="company_owner" required itemname="대표자명" class="required frm_input" size="30"></td>
		<th scope="row">사업자등록번호</th>
		<td><input type="text" name="company_saupja_no" class="frm_input" size="30" placeholder="예) 000-00-00000"></td>
	</tr>
	<tr>
		<th scope="row">업태</th>
		<td><input type="text" name="company_item" class="frm_input" size="30" placeholder="예) 서비스업"></td>
		<th scope="row">종목</th>
		<td><input type="text" name="company_service" class="frm_input" size="30" placeholder="예) 전자상거래업"></td>
	</tr>
	<tr>
		<th scope="row">전화번호</th>
		<td><input type="text" name="company_tel" class="frm_input" size="30" placeholder="예) 02-1234-5678"></td>
		<th scope="row">팩스번호</th>
		<td><input type="text" name="company_fax" class="frm_input" size="30" placeholder="예) 02-1234-5678"></td>
	</tr>
	<tr>
		<th scope="row">사업장주소</th>
		<td colspan="3">
            <div class="write_address">
                <div class="file_wrap address">
                    <input type="text" name="company_zip" class="frm_input" size="8" maxlength="5"> 
                    <a href="javascript:win_zip('fregform', 'company_zip', 'company_addr1', 'company_addr2', 'company_addr3', 'company_addr_jibeon');" class="btn_file">주소검색</a>
                </div>
                <div class="addressMore mart5">
                    <input type="text" name="company_addr1" class="frm_input" size="60">
                    <input type="text" name="company_addr2" class="frm_input" size="60">
                </div>
                <div class="mart5">
                    <input type="text" name="company_addr3 mart5" class="frm_input" size="60">
                    <input type="hidden" name="company_addr_jibeon" value=""></p>
                </div>
            </div>
		</td>
	</tr>
	<tr>
		<th scope="row">홈페이지</th>
		<td colspan="3"><input type="text" name="company_hompage" class="frm_input" size="30" placeholder="http://"></td>
	</tr>
	</tbody>
	</table>
</div>

<!-- 정산방식 추가 _20240508_SY -->
<p class="gap50"></p>
<h5 class="htag_title">정산방식</h5>
<p class="gap20"></p>
<div class="tbl_frm01">
  <table>
    <colgroup>
      <col class="w180">
      <col>
    </colgroup>
    <tbody>
      <tr>
        <th scope="row">정산방식</th>
        <td>
            <ul class="radio_group">
                <li class="radios">
                    <input type="radio" name="income_type" value="0" id="income_type1" checked>
                    <label for="income_type1" class="marr10">매입가 정산 지급 <b class="income_type1"></b> </label>
                </li>
                <li class="radios">
                    <input type="radio" name="income_type" value="1" id="income_type2">
                    <label for="income_type2" class="marr10">수수료 정산 지급 <b class="income_type2"></b></label>
                </li>
            </ul>
        </td>
      </tr>
      <tr class="incomePer_tr">
        <th scope="row">지급방식</th>
        <td>
          <input type="radio" name="incomePer_type" value="0" id="incomePer_type1" checked>
          <label for="incomePer_type1" class="marr10">정액지급<b class="incomePer_type1"></b> </label>
          <input type="radio" name="incomePer_type" value="1" id="incomePer_type2">
          <label for="incomePer_type2" class="marr10">정률지급<b class="incomePer_type2"></b> </label>
        </td>
      </tr>
      <tr class="incomePer_tr" id="incomePer_sub1">
        <th scope="row">정액지급</th>
        <td>
          <input type="text" name="income_price" id="income_price" value="" class="frm_input w80" onkeyup="addComma(this);"> 원
        </td>
      </tr>
      <tr class="incomePer_tr" id="incomePer_sub2">
        <th scope="row">정률지급</th>
        <td>
          <input type="text" name="income_per" id="income_per" value="" class="frm_input w80" onkeyup="addComma(this);"> %
        </td>
      </tr>
    </tbody>
  </table>
</div>
<p class="gap50"></p>
<h5 class="htag_title">정산계좌 정보</h5>
<p class="gap20"></p>
<div class="tbl_frm01">
	<table class="tablef">
	<colgroup>
		<col class="w140">
		<col>
	</colgroup>
	<tbody>
	<tr>
		<th scope="row">은행명</th>
		<td><input type="text" name="bank_name" class="frm_input" size="30"></td>
	</tr>
	<tr>
		<th scope="row">계좌번호</th>
		<td><input type="text" name="bank_account" class="frm_input" size="30"></td>
	</tr>
	<tr>
		<th scope="row">예금주명</th>
		<td><input type="text" name="bank_holder" class="frm_input" size="30"></td>
	</tr>
  <!-- 정산일 추가 _20240402_SY -->
	<tr>
		<th scope="row">정산일</th>
		<td><input type="text" name="settle" class="frm_input" size="30"></td>
	</tr>
	</tbody>
	</table>
</div>

<p class="gap50"></p>
<h5 class="htag_title">담당자 정보</h5>
<p class="gap20"></p>
<div class="tbl_frm01">
	<table class="tablef">
	<colgroup>
		<col class="w140">
		<col>
	</colgroup>
	<tbody>
	<tr>
		<th scope="row">담당자명</th>
		<td><input type="text" name="info_name" class="frm_input" size="30"></td>
	</tr>
	<tr>
		<th scope="row">담당자 핸드폰</th>
		<td><input type="text" name="info_tel" class="frm_input" size="30"></td>
	</tr>
	<tr>
		<th scope="row">담당자 이메일</th>
		<td><input type="text" name="info_email" class="frm_input" size="30"></td>
	</tr>
	</tbody>
	</table>
</div>

<div class="btn_confirm">
	<input type="submit" value="저장" id="btn_submit" class="btn_large" accesskey="s">
</div>
</form>

<script>
// 정산방식 추가 _20240508_SY

function stringNumberToInt(stringNumber){
    return parseFloat(stringNumber.replace(/,/g , ''));
}

$(function() {
  $('.incomePer_tr').hide();

  $('#income_type2').change(function() {
    $('.incomePer_tr').show();
    if ($('#incomePer_type1').is(':checked')) {
      $('#incomePer_sub2').hide();
    } else {
      $('#incomePer_sub1').hide();
    }
  });

  $('#income_type1').change(function() {
    $('.incomePer_tr').hide();
    if ($('#incomePer_type1').is(':checked')) {
      $('#incomePer_sub2').hide();
    } else {
      $('#incomePer_sub1').hide();
    }
  });

  $('#incomePer_type1').change(function() {
    $('#incomePer_sub1').show();
    $('#incomePer_sub2').hide();
  })
  $('#incomePer_type2').change(function() {
    $('#incomePer_sub1').hide();
    $('#incomePer_sub2').show();
  })
});


function fregform_submit(f) {
	if(confirm("등록 하시겠습니까?") == false)
		return false;

	document.getElementById("btn_submit").disabled = "disabled";

	f.action = "./seller/seller_register_update.php";
    return true;
}
</script>
