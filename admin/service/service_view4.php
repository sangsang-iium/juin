<?php
if (!defined('_BLUEVATION_')) {
  exit;
}

if (is_numeric($idx)) {
  $sql = "SELECT * FROM iu_service WHERE idx = '{$idx}'";
  $row = sql_fetch($sql);
  if (!$row['idx']) {
    alert("존재하지 않습니다.");
  }
}

$qstr .= "&b_type=" . $b_type . "&page=" . $page;
?>

<h5 class="htag_title">노무</h5>
<p class="gap20"></p>
<div class="tbl_frm01">
	<table>
	<colgroup>
		<col width="220px">
		<col>
	</colgroup>
	<tbody>
	<tr>
		<th scope="row">성명</th>
		<td><?php echo $row['c_name']?></td>
	</tr>
	<tr>
		<th scope="row">생년월일</th>
		<td><?php echo $row['bc_birth'] ?></td>
	</tr>
	<tr>
		<th scope="row">자택 주소</th>
		<td><?php echo $row['b_addr_zip'].' '.$row['b_addr_1'].' '.$row['b_addr_2'].' '.$row['b_addr_3'] ?></td>
	</tr>
	<tr>
		<th scope="row">업소 주소</th>
		<td><?php echo $row['b_addr_zip20'].' '.$row['b_addr_21'].' '.$row['b_addr_22'].' '.$row['b_addr_23'] ?></td>
	</tr>
	<tr>
		<th scope="row">상호</th>
		<td><?php echo $row['b_name'] ?></td>
	</tr>
	<tr>
		<th scope="row">전화번호</th>
		<td><?php echo $row['b_tel'] ?></td>
	</tr>
	<tr>
		<th scope="row">대표자 휴대전화</th>
		<td><?php echo $row['b_phone'] ?></td>
	</tr>
	<tr>
		<th scope="row">결제방법</th>
		<td><?php echo $row['b_paymethod'] ?></td>
	</tr>
	<tr>
		<th scope="row">은행</th>
		<td><?php echo $row['b_bank'] ?></td>
	</tr>
	<tr>
		<th scope="row">계좌번호</th>
		<td><?php echo $row['b_account_num'] ?></td>
	</tr>
	<tr>
		<th scope="row">예금주</th>
		<td><?php echo $row['b_account_name'] ?></td>
	</tr>
	<tr>
		<th scope="row">생년월일</th>
		<td><?php echo $row['bc_birth2'] ?></td>
	</tr>
	<tr>
		<th scope="row">회원과의 관계</th>
		<td><?php echo $row['bc_relation'] ?></td>
	</tr>
	<tr>
		<th scope="row">카드사</th>
		<td><?php echo $row['bc_card_com'] ?></td>
	</tr>
	<tr>
		<th scope="row">카드번호</th>
		<td><?php echo $row['bc_card_num'] ?></td>
	</tr>
	<tr>
		<th scope="row">카드유효기간</th>
		<td><?php echo $row['bc_card_cvc'] ?></td>
	</tr>
	<tr>
		<th scope="row">계약구좌</th>
		<td><?php echo $row['bc_acc'] ?></td>
	</tr>
	<tr>
		<th scope="row">이체일자</th>
		<td><?php echo $row['bc_acc'] ?></td>
	</tr>
	<tr>
		<th scope="row">신청인</th>
		<td><?php echo $row['bc_applicant'] ?></td>
	</tr>
	<tr>
		<th scope="row">서명</th>
		<td>
			<img src="<?php echo $row['b_sign'] ?>" alt="" style="height: 200px;">
		</td>
	</tr>
	<tr>
		<th scope="row">소개자(직원) 정보</th>
		<td>
			<?php
				$sql_sf = "SELECT * FROM shop_manager WHERE `id` = '{$row['b_staff']}'";
				$row_sf = sql_fetch($sql_sf);

				if ($row_sf['index_no']) {
					echo $row_sf['name'];
				} else {
					echo "-";
				}
			?>
		</td>
	</tr>

	</tbody>
	</table>
</div>
<div class="btn_wrap mart30">
	<a href="<?php echo BV_ADMIN_URL . '/service.php?code=list' . $qstr; ?>" class="btn_list bg_type1">
        <span>목록</span>
    </a>
</div>
