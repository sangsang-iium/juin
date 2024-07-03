<?php
if(!defined('_BLUEVATION_')) exit;

$pg_title = "업체 정보관리";
include_once("./admin_head.sub.php");
?>

<form name="fregform" method="post" action="./seller_info_update.php">
<input type="hidden" name="token" value="">

<h5 class="htag_title marb20">사업자 정보</h5>
<div class="tbl_frm01">
	<table>
	<colgroup>
		<col width="220px">
		<col>
		<col width="220px">
		<col>
	</colgroup>
	<tr>
		<th scope="row">업체코드</th>
		<td><?php echo $seller['seller_code']; ?></td>
		<th scope="row">제공상품</th>
		<td><input type="text" name="seller_item" value="<?php echo $seller['seller_item']; ?>" required itemname="제공상품" class="required frm_input" size="30"></td>
	</tr>
	<tr>
		<th scope="row">업체(법인)명</th>
		<td><input type="text" name="company_name" value="<?php echo $seller['company_name']; ?>" required itemname="업체(법인)명" class="required frm_input" size="30"></td>
		<th scope="row">대표자명</th>
		<td><input type="text" name="company_owner" value="<?php echo $seller['company_owner']; ?>" required itemname="대표자명" class="required frm_input" size="30"></td>
	</tr>
	<tr>
		<th scope="row">사업자등록번호</th>
		<td colspan="3"><input type="text" name="company_saupja_no" value="<?php echo $seller['company_saupja_no']; ?>" required itemname="사업자등록번호" class="required frm_input" size="30"></td>
	</tr>
	<tr>
        <th scope="row">업태</th>
		<td><input type="text" name="company_item" value="<?php echo $seller['company_item']; ?>" required itemname="업태" class="required frm_input" size="30"></td>
		<th scope="row">종목</th>
		<td><input type="text" name="company_service" value="<?php echo $seller['company_service']; ?>" required itemname="종목" class="required frm_input" size="30"></td>
	</tr>
	<tr>
		<th scope="row">전화번호</th>
		<td><input type="text" name="company_tel" value="<?php echo $seller['company_tel']; ?>" required itemname="전화번호" class="required frm_input" size="30"></td>
		<th scope="row">팩스번호</th>
		<td><input type="text" name="company_fax" value="<?php echo $seller['company_fax']; ?>" class="frm_input" size="30"></td>
	</tr>
	<tr>
		<th scope="row">사업장주소</th>
		<td colspan="3">
            <div class="write_address">
                <div class="file_wrap address">
                    <input type="text" name="company_zip" value="<?php echo $seller['company_zip']; ?>" class="frm_input filename" size="8" maxlength="5" readonly>
                    <a href="javascript:win_zip('fregform', 'company_zip', 'company_addr1', 'company_addr2', 'company_addr3', 'company_addr_jibeon');" class="btn_file">주소검색</a>
                </div>
                <div class="addressMore">
                    <input type="text" name="company_addr1" value="<?php echo $seller['company_addr1']; ?>" class="frm_input" size="60"> 
                    <label for="" class="hide">기본주소</label>
                    <input type="text" name="company_addr2" value="<?php echo $seller['company_addr2']; ?>" class="frm_input" size="60">
                    <label for="" class="hide">상세주소</label>
                </div>
                <div class="mart5">
                    <input type="text" name="company_addr3" value="<?php echo $seller['company_addr3']; ?>" class="frm_input" size="60">
                    <label for="" class="hide">참고항목</label>
                    <input type="hidden" name="company_addr_jibeon" value="<?php echo $seller['company_addr_jibeon']; ?>">
                </div>
            </div>
		</td>
	</tr>
	<tr>
		<th scope="row">홈페이지</th>
		<td colspan="3">
			<input type="text" name="company_hompage" value="<?php echo $seller['company_hompage']; ?>" class="frm_input" size="30">
			<?php echo help('http://를 포함하여 입력하세요'); ?>
		</td>
	</tr>
	</tbody>
	</table>
</div>

<!-- 차량배송 최소 금액 설정 20240605 jjh -->
<h5 class="htag_title marb20 mart50">차량배송 최소 금액 설정</h5>
<div class="tbl_frm01">
	<table>
		<colgroup>
			<col class="w140">
			<col>
		</colgroup>
		<tbody>
		<tr>
			<th scope="row">차량배송 최소금액</th>
			<td>
				<input type="text" name="min_delivery" value="<?php echo $seller['min_delivery']; ?>" class="frm_input" size="30">
				<?php echo help("초기 설정값은 50,000원 입니다."); ?>
			</td>
		</tr>
		</tbody>
	</table>
</div>

<!-- 정산방식 추가 _20240508_SY -->
<h5 class="htag_title marb20 mart50">정산방식</h5>
<div class="tbl_frm01">
  <table>
    <colgroup>
      <col width="220px">
      <col>
    </colgroup>
    <tbody>
      <tr>
        <th scope="row">정산방식</th>
        <td>
            <ul class="radio_group">
                <li class="radios">
                    <input type="radio" name="income_type" value="0" id="income_type1" <?php echo get_checked('0', $seller['income_type']); ?>>
                    <label for="income_type1" class="marr10">매입가 정산 지급</label>
                </li>
                <li class="radios">
                    <input type="radio" name="income_type" value="1" id="income_type2"<?php echo get_checked('1', $seller['income_type']); ?> >
                    <label for="income_type2" class="marr10">수수료 정산 지급</label>
                </li>
            </ul>
        </td>
      </tr>
      <?php
        if($seller['income_type'] == 0) {
          $display = "display: none;";
        }
      ?>
      <tr class="incomePer_tr" style="<?php echo $display ?>">
        <th scope="row">지급방식</th>
        <td>
        <ul class="radio_group">
                <li class="radios">
                    <input type="radio" name="incomePer_type" value="0" id="incomePer_type1" <?php echo get_checked('0', $seller['income_per_type']); ?>>
                    <label for="incomePer_type1" class="marr10">정액지급<b class="incomePer_type1"></b> </label>
                </li>
                <li class="radios">
                    <input type="radio" name="incomePer_type" value="1" id="incomePer_type2" <?php echo get_checked('1', $seller['income_per_type']); ?>>
                    <label for="incomePer_type2" class="marr10">정률지급<b class="incomePer_type2"></b> </label>
                </li>
            </ul>
        </td>
      </tr>
      <tr class="incomePer_tr" id="incomePer_sub1" style="<?php echo ($seller['income_per_type'] == 1) ? 'display:none;' : '' ?>">
        <th scope="row">정액지급</th>
        <td>
          <input type="text" name="income_price" id="income_price" value="<?php echo number_format($seller['income_price']); ?>" class="frm_input w80" onkeyup="addComma(this);"> 원
        </td>
      </tr>
      <tr class="incomePer_tr" id="incomePer_sub2" style="<?php echo ($seller['income_per_type'] == 0) ? 'display:none;' : '' ?>">
        <th scope="row">정률지급</th>
        <td>
          <input type="text" name="income_per" id="income_per" value="<?php echo $seller['income_per'] > 0 ? $seller['income_per'] : 0 ?>" class="frm_input w80" onkeyup="addComma(this);"> %
        </td>
      </tr>
    </tbody>
  </table>
</div>

<h5 class="htag_title marb20 mart50">정산계좌 정보</h5>
<div class="tbl_frm01">
	<table>
	<colgroup>
		<col width="220px">
		<col>
	</colgroup>
	<tbody>
	<tr>
		<th scope="row">은행명</th>
		<td><input type="text" name="bank_name" value="<?php echo $seller['bank_name']; ?>" class="frm_input" size="30"></td>
	</tr>
	<tr>
		<th scope="row">계좌번호</th>
		<td><input type="text" name="bank_account" value="<?php echo $seller['bank_account']; ?>" class="frm_input" size="30"></td>
	</tr>
	<tr>
		<th scope="row">예금주명</th>
		<td><input type="text" name="bank_holder" value="<?php echo $seller['bank_holder']; ?>" class="frm_input" size="30"></td>
	</tr>
  <!-- 정산일 추가 _20240402_SY -->
	<tr>
		<th scope="row">정산일</th>
		<td><input type="text" name="settle" value="<?php echo $seller['settle']; ?>" class="frm_input" size="30"></td>
	</tr>
	</tbody>
	</table>
</div>

<h5 class="htag_title marb20 mart50">담당자 정보</h5>
<div class="tbl_frm01">
	<table>
	<colgroup>
		<col width="220px">
		<col>
	</colgroup>
	<tbody>
	<tr>
		<th scope="row">담당자명</th>
		<td><input type="text" name="info_name" value="<?php echo $seller['info_name']; ?>" required itemname="담당자명"class="required frm_input" size="30"></td>
	</tr>
	<tr>
		<th scope="row">담당자 핸드폰</th>
		<td><input type="text" name="info_tel" value="<?php echo $seller['info_tel']; ?>" required itemname="담당자 핸드폰" class="required frm_input" size="30"></td>
	</tr>
	<tr>
		<th scope="row">담당자 이메일</th>
		<td><input type="text" name="info_email" value="<?php echo $seller['info_email']; ?>" required email itemname="담당자 이메일" class="required frm_input" size="30"></td>
	</tr>
	</table>
	</td>
</tr>
</table>
</div>

<div class="btn_confirm">
	<input type="submit" value="저장" class="btn_large" accesskey="s">
</div>
</form>

<script>
// 정산방식 추가 _20240508_SY

function stringNumberToInt(stringNumber){
    return parseFloat(stringNumber.replace(/,/g , ''));
}

$(function() {

  if ($('#income_type1').is(':checked')) {
    $('.incomePer_tr').hide();
    $('#incomePer_sub2').hide();
    $('#incomePer_sub1').hide();
  }

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
</script>

<?php
include_once("./admin_tail.sub.php");
?>