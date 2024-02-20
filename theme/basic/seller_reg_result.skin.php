<?php
if(!defined('_BLUEVATION_')) exit;
?>

<div><img src="<?php echo BV_IMG_URL; ?>/seller_reg_result.gif"></div>

<h3 class="anc_tit mart20">사업자정보</h3>
<div class="tbl_frm01 tbl_wrap">
	<table>
	<colgroup>
		<col class="w140">
		<col>
	</colgroup>
	<tbody>
	<tr>
		<th scope="row">제공상품</th>
		<td><?php echo $seller['seller_item']; ?></td>
	</tr>
	<tr>
		<th scope="row">업체(법인)명</th>
		<td><?php echo $seller['company_name']; ?></td>
	</tr>
	<tr>
		<th scope="row">대표자명</th>
		<td><?php echo $seller['company_owner']; ?></td>
	</tr>
	<tr>
		<th scope="row">사업자등록번호</th>
		<td><?php echo $seller['company_saupja_no']; ?></td>
	</tr>
	<tr>
		<th scope="row">업태</th>
		<td><?php echo $seller['company_item']; ?></td>
	</tr>
	<tr>
		<th scope="row">종목</th>
		<td><?php echo $seller['company_service']; ?></td>
	</tr>
	<tr>
		<th scope="row">전화번호</th>
		<td><?php echo $seller['company_tel']; ?></td>
	</tr>
	<tr>
		<th scope="row">팩스번호</th>
		<td><?php echo $seller['company_fax']; ?></td>
	</tr>
	<tr>
		<th scope="row">사업장주소</th>
		<td><?php echo print_address($seller['company_addr1'], $seller['company_addr2'], $seller['company_addr3'], $seller['company_addr_jibeon']); ?></td>
	</tr>
	<?php if($seller['company_hompage']) { ?>
	<tr>
		<th scope="row">홈페이지</th>
		<td><?php echo $seller['company_hompage']; ?></td>
	</tr>
	<?php } ?>
	<?php if($seller['memo']) { ?>
	<tr>
		<th scope="row">전달사항</th>
		<td><?php echo conv_content($seller['memo'], 0); ?></td>
	</tr>
	<?php } ?>
	</tbody>
	</table>
</div>

<h3 class="anc_tit mart30">입금계좌정보</h3>
<div class="tbl_frm01 tbl_wrap">
	<table>
	<colgroup>
		<col class="w140">
		<col>
	</colgroup>
	<tbody>
	<tr>
		<th scope="row">은행명</th>
		<td><?php echo $seller['bank_name']; ?></td>
	</tr>
	<tr>
		<th scope="row">계좌번호</th>
		<td><?php echo $seller['bank_account']; ?></td>
	</tr>
	<tr>
		<th scope="row">예금주명</th>
		<td><?php echo $seller['bank_holder']; ?></td>
	</tr>
	</tbody>
	</table>
</div>

<h3 class="anc_tit mart30">담당자정보</h3>
<div class="tbl_frm01 tbl_wrap">
	<table>
	<colgroup>
		<col class="w140">
		<col>
	</colgroup>
	<tbody>
	<tr>
		<th scope="row">담당자명</th>
		<td><?php echo $seller['info_name']; ?></td>
	</tr>
	<tr>
		<th scope="row">담당자 핸드폰</th>
		<td><?php echo $seller['info_tel']; ?></td>
	</tr>
	<tr>
		<th scope="row">담당자 이메일</th>
		<td><?php echo $seller['info_email']; ?></td>
	</tr>
	</tbody>
	</table>
</div>

<div class="btn_confirm">
	<a href="<?php echo BV_URL; ?>" class="btn_large wset">확인</a>
</div>
