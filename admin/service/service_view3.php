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
		<th scope="row">사업자번호</th>
		<td><?php echo $row['b_num']?></td>
	</tr>
	<tr>
		<th scope="row">사업장명</th>
		<td><?php echo $row['b_name'] ?></td>
	</tr>
	<tr>
		<th scope="row">사업장 주소</th>
		<td><?php echo $row['b_addr_zip'].' '.$row['b_addr_1'].' '.$row['b_addr_2'].' '.$row['b_addr_3'] ?></td>
	</tr>
	<tr>
		<th scope="row">사업장 전화번호</th>
		<td><?php echo $row['b_tel'] ?></td>
	</tr>
	<tr>
		<th scope="row">대표자 휴대전화</th>
		<td><?php echo $row['b_phone'] ?></td>
	</tr>
	<tr>
		<th scope="row">상담내용</th>
		<td><textarea name="" id="" readonly><?php echo $row['b_contents'] ?></textarea></td>
	</tr>
	<tr>
		<th scope="row">상담(담당) 희망자</th>
		<td><?php echo $row['b_hope'] ?></td>
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
