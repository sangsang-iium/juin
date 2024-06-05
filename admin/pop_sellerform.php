<?php
define('_NEWWIN_', true);
include_once('./_common.php');
include_once('./_head.php');
include_once(BV_ADMIN_PATH."/admin_access.php");

$tb['title'] = "공급사정보수정";
include_once(BV_ADMIN_PATH."/admin_head.php");

$mb = get_member($mb_id);
$sr = get_seller($mb_id);
?>

<form name="fsellerform" id="fsellerform" action="./pop_sellerformupdate.php" method="post">
<input type="hidden" name="mb_id" value="<?php echo $mb_id; ?>">
<input type="hidden" name="seller_code" value="<?php echo $sr['seller_code']; ?>">

<div id="sellerform_pop" class="new_win">
	<h1><?php echo $tb['title']; ?></h1>

	<section class="new_win_desc marb50">

	<?php echo mb_pg_anchor($mb_id); ?>
    <p class="gap40"></p>
	<h5 class="htag_title">사업자정보</h5>
    <p class="gap20"></p>
	<div class="tbl_frm01">
		<table class="tablef">
		<colgroup>
			<col class="w130">
			<col>
			<col class="w130">
			<col>
		</colgroup>
		<tbody>
		<tr>
			<th scope="row">입점 승인상태</th>
			<td>
                <div class="radio_group">
                    <?php echo radio_checked('state', $sr['state'], '1', '승인'); ?>
                    <?php echo radio_checked('state', $sr['state'], '0', '대기'); ?>
                </div>
			</td>
			<th scope="row">전체 상품진열</th>
			<td>
                <div class="radio_group">
                    <?php echo radio_checked('seller_open', $sr['seller_open'], '1', '진열'); ?>
                    <?php echo radio_checked('seller_open', $sr['seller_open'], '2', '품절'); ?>
                    <?php echo radio_checked('seller_open', $sr['seller_open'], '3', '단종'); ?>
                    <?php echo radio_checked('seller_open', $sr['seller_open'], '4', '중지'); ?>
                </div>
			</td>
		</tr>
		<tr>
			<th scope="row">공급사명</th>
			<td><input type="text" name="company_name" value="<?php echo $sr['company_name']; ?>" class="frm_input" size="30"></td>
			<th scope="row">제공상품</th>
			<td><input type="text" name="seller_item" value="<?php echo $sr['seller_item']; ?>" class="frm_input" size="30"></td>
		</tr>
		<tr>
			<th scope="row">대표자명</th>
			<td><input type="text" name="company_owner" value="<?php echo $sr['company_owner']; ?>" class="frm_input" size="30"></td>
			<th scope="row">사업자등록번호</th>
			<td><input type="text" name="company_saupja_no" value="<?php echo $sr['company_saupja_no']; ?>" class="frm_input" size="30"></td>
		</tr>
		<tr>
			<th scope="row">업태</th>
			<td><input type="text" name="company_item" value="<?php echo $sr['company_item']; ?>" class="frm_input" size="30"></td>
			<th scope="row">종목</th>
			<td><input type="text" name="company_service" value="<?php echo $sr['company_service']; ?>" class="frm_input" size="30"></td>
		</tr>
		<tr>
			<th scope="row">전화번호</th>
			<td><input type="text" name="company_tel" value="<?php echo $sr['company_tel']; ?>" class="frm_input" size="30"></td>
			<th scope="row">팩스번호</th>
			<td><input type="text" name="company_fax" value="<?php echo $sr['company_fax']; ?>" class="frm_input" size="30"></td>
		</tr>
		<tr>
			<th scope="row">사업장주소</th>
			<td colspan="3">
                <div class="write_address">
                    <div class="file_wrap address">
                        <input type="text" name="company_zip" value="<?php echo $sr['company_zip']; ?>" class="frm_input" size="8" maxlength="5"> 
                        <a href="javascript:win_zip('fsellerform', 'company_zip', 'company_addr1', 'company_addr2', 'company_addr3', 'company_addr_jibeon');" class="btn_file">주소검색</a>
                    </div>
                    <div class="addressMore">
                        <!-- 기본주소 -->
                        <input type="text" name="company_addr1" value="<?php echo $sr['company_addr1']; ?>" class="frm_input frm_address" size="60"> 
                        <!-- 상세주소 -->
                        <input type="text" name="company_addr2" value="<?php echo $sr['company_addr2']; ?>" class="frm_input frm_address" size="60">
                    </div>
                    <input type="text" name="company_addr3" value="<?php echo $sr['company_addr3']; ?>" class="frm_input frm_address" size="60">
                    <input type="hidden" name="company_addr_jibeon" value="<?php echo $sr['company_addr_jibeon']; ?>">
                </div>
			</td>
		</tr>
		<tr>
			<th scope="row">홈페이지</th>
			<td colspan="3"><input type="text" name="company_hompage" value="<?php echo $sr['company_hompage']; ?>" class="frm_input" size="40" placeholder="http://"></td>
		</tr>
		<tr>
			<th scope="row">전달사항</th>
			<td colspan="3"><textarea name="memo" class="frm_textbox wfull"><?php echo $sr['memo']; ?></textarea></td>
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
                    <input type="radio" name="income_type" value="0" id="income_type1" <?php echo get_checked('0', $sr['income_type']); ?>>
                    <label for="income_type1" class="marr10">매입가 정산 지급</label>
                </li>
                <li class="radios">
                    <input type="radio" name="income_type" value="1" id="income_type2"<?php echo get_checked('1', $sr['income_type']); ?> >
                    <label for="income_type2" class="marr10">수수료 정산 지급</label>
                </li>
            </ul>
        </td>
      </tr>
      <?php
        if($sr['income_type'] == 0) {
          $display = "display: none;";
        }
      ?>
      <tr class="incomePer_tr" style="<?php echo $display ?>">
        <th scope="row">지급방식</th>
        <td>
          <input type="radio" name="incomePer_type" value="0" id="incomePer_type1" <?php echo get_checked('0', $sr['income_per_type']); ?>>
          <label for="incomePer_type1" class="marr10">정액지급<b class="incomePer_type1"></b> </label>
          <input type="radio" name="incomePer_type" value="1" id="incomePer_type2" <?php echo get_checked('1', $sr['income_per_type']); ?>>
          <label for="incomePer_type2" class="marr10">정률지급<b class="incomePer_type2"></b> </label>
        </td>
      </tr>
      <tr class="incomePer_tr" id="incomePer_sub1" style="<?php echo ($sr['income_per_type'] == 1) ? 'display:none;' : '' ?>">
        <th scope="row">정액지급</th>
        <td>
          <input type="text" name="income_price" id="income_price" value="<?php echo number_format($sr['income_price']); ?>" class="frm_input w80" onkeyup="addComma(this);"> 원
        </td>
      </tr>
      <tr class="incomePer_tr" id="incomePer_sub2" style="<?php echo ($sr['income_per_type'] == 0) ? 'display:none;' : '' ?>">
        <th scope="row">정률지급</th>
        <td>
          <input type="text" name="income_per" id="income_per" value="<?php echo $sr['income_per'] > 0 ? $sr['income_per'] : 0 ?>" class="frm_input w80" onkeyup="addComma(this);"> %
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
			<col class="w130">
			<col>
		</colgroup>
		<tbody>
		<tr>
			<th scope="row">은행명</th>
			<td><input type="text" name="bank_name" value="<?php echo $sr['bank_name']; ?>" class="frm_input" size="30"></td>
		</tr>
		<tr>
			<th scope="row">계좌번호</th>
			<td><input type="text" name="bank_account" value="<?php echo $sr['bank_account']; ?>" class="frm_input" size="30"></td>
		</tr>
		<tr>
			<th scope="row">예금주명</th>
			<td><input type="text" name="bank_holder" value="<?php echo $sr['bank_holder']; ?>" class="frm_input" size="30"></td>
		</tr>
    <tr class="pt_pay_fld">
      <th scope="row" class="th_bg fc_00f">정산일</th>
      <td>
        <input type="text" name="ju_settle" value="<?php echo $sr['settle']?>" class="frm_input" size="30" placeholder="정산일">
        <?php echo help('매달 입력하신 날짜에 수수료 정산하실 수 있습니다. 숫자만 입력해주세요. ex) 15(◯), 15일(X) 월요일(X)'); ?>
      </td>
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
			<col class="w130">
			<col>
		</colgroup>
		<tbody>
		<tr>
			<th scope="row">담당자명</th>
			<td><input type="text" name="info_name" value="<?php echo $sr['info_name']; ?>" class="frm_input" size="30"></td>
		</tr>
		<tr>
			<th scope="row">담당자 핸드폰</th>
			<td><input type="text" name="info_tel" value="<?php echo $sr['info_tel']; ?>" class="frm_input" size="30"></td>
		</tr>
		<tr>
			<th scope="row">담당자 이메일</th>
			<td><input type="text" name="info_email" value="<?php echo $sr['info_email']; ?>" class="frm_input" size="30"></td>
		</tr>
		</tbody>
		</table>
	</div>
	<div class="btn_confirm">
		<input type="submit" value="저장" class="btn_medium" accesskey="s">
		<button type="button" class="btn_medium bx-white" onclick="window.close();">닫기</button>
	</div>
	</section>
</div>
</form>

<script>
// 정산방식 추가 _20240508_SY
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
include_once(BV_ADMIN_PATH."/admin_tail.sub.php");
?>