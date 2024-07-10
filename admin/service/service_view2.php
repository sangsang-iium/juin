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

<h5 class="htag_title">신한카드 신용</h5>
<p class="gap20"></p>
<div class="tbl_frm01">
	<table>
	<colgroup>
		<col width="220px">
		<col>
	</colgroup>
	<tbody>
	<tr>
		<th scope="row">신청구분</th>
		<td>
			<?php
				foreach ($SIN_GB as $idx => $val) {
					if ($row['bc_gubun'] == $idx) {
						$bc_gubun = $val;
						break;
					}
				}
				echo $bc_gubun;
				?>
		</td>
	</tr>
	<tr>
		<th scope="row">신청카드</th>
		<td>
			<?php
				foreach ($SIN_CARD as $idx => $val) {
					if ($row['bc_card'] == $idx) {
						$bc_card = $val;
						break;
					}
				}
				echo $bc_card;
				?>
		</td>
	</tr>
	<tr>
		<th scope="row">할인유형</th>
		<td>
			<?php
				foreach ($SIN_SALE as $idx => $val) {
					if ($row['bc_sale'] == $idx) {
						$bc_sale = $val;
						break;
					}
				}
				echo $bc_sale;
				?>
		</td>
	</tr>
	<tr>
		<th scope="row">성명</th>
		<td><?php echo $row['c_name'] ?></td>
	</tr>
	<tr>
		<th scope="row">생년월일</th>
		<td><?php echo $row['bc_birth'] ?></td>
	</tr>
	<tr>
		<th scope="row">사업자등록번호</th>
		<td><?php echo $row['b_num'] ?></td>
	</tr>
	<tr>
		<th scope="row">휴대폰</th>
		<td><?php echo $row['b_phone'] ?></td>
	</tr>
	<tr>
		<th scope="row">통화가능시간</th>
		<td>
			<?php
				$b_times = explode("||", $row['bc_able']);
				$b_time  = $b_times[0] . '시 부터 ~ ' . $b_times[1] . '시 까지';
				echo $b_time;
				?>
		</td>
	</tr>
	<tr>
		<th scope="row">담당직원</th>
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
