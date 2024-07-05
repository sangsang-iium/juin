<?php
if (!defined('_BLUEVATION_')) {
  exit;
}

if (!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $fr_date)) {
  $fr_date = '';
}

if (!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $to_date)) {
  $to_date = '';
}

if(!$b_type) {
	$b_type = "1";
}

$sql_common = " from iu_service ";
$sql_search = " where b_type = '{$b_type}' ";


$sql_order = " order by idx desc ";

// 테이블의 전체 레코드수만 얻음
$sql         = " select count(*) as cnt $sql_common $sql_search ";
$row         = sql_fetch($sql);
$total_count = $row['cnt'];

$rows       = 15;
$total_page = ceil($total_count / $rows); // 전체 페이지 계산
if ($page == "") {$page = 1;}             // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows;       // 시작 열을 구함
$num         = $total_count - (($page - 1) * $rows);

$sql    = " select * $sql_common $sql_search $sql_order limit $from_record, $rows ";
$result = sql_query($sql);

$colspan  = 12;

$btn_frmline = <<<EOF
<a href="/admin/service.php?code=list&b_type=1" class="fr btn_lsmall bx-white" style="float:left;">신한신용</a>
<a href="/admin/service.php?code=list&b_type=2" class="fr btn_lsmall bx-white" style="float:left;">신한체크</a>
<a href="/admin/service.php?code=list&b_type=3" class="fr btn_lsmall bx-white" style="float:left;">노무</a>
<a href="/admin/service.php?code=list&b_type=4" class="fr btn_lsmall bx-white" style="float:left;">상조</a>
EOF;

$q1 = "code=".$code."&b_type=".$b_type.$qstr;
$q2 = "&b_type=".$b_type.$qstr."&page=".$page;

include_once BV_PLUGIN_PATH . '/jquery-ui/datepicker.php';
?>

<h5 class="htag_title">기본검색</h5>
<p class="gap20"></p>

<div class="local_ov mart30">
	총 건수 : <b class="fc_red"><?php echo number_format($total_count); ?></b>
</div>
<div class="local_frm01">
	<?php echo $btn_frmline; ?>
</div>
<div class="tbl_head01">
	<table>
	<colgroup>
		<col class="w50">
		<col class="w50">
		<col class="w100">
		<col>
		<col class="w100">
		<col class="w100">
		<col class="w200">
		<col width="250px">
	</colgroup>
	<thead>
	<tr>
		<th scope="col"><input type="checkbox" class="allchk"></th>
		<th scope="col">No</th>
		<th scope="col">유형</th>
		<th scope="col">휴대전화</th>
		<th scope="col">성명</th>
		<th scope="col">등록자</th>
		<th scope="col">등록일시</th>
		<!-- <th scope="col">관리</th> -->
	</tr>
	</thead>
	<?php
	for ($i = 0; $row = sql_fetch_array($result); $i++) {
		switch ($b_type) {
			case '1':
				$b_type_name = "신한신용";
				break;
			case '2':
				$b_type_name = "신한체크";
				break;
			case '3':
				$b_type_name = "상조";
				break;
			case '4':
				$b_type_name = "노무";
				break;
		}
		if ($i == 0) {
			echo '<tbody class="list">' . PHP_EOL;
		}
  	    $bg = 'list' . ($i % 2);
    ?>
	<tr class="<?php echo $bg; ?>">
	    <td><input type="checkbox" class="chk" data-no="<?php echo $row['idx']; ?>"></td>
		<td><?php echo $num--; ?></td>
		<td><?php echo $b_type_name; ?></td>
		<td><?php echo $row['b_phone']; ?></td>
		<td><?php echo $row['c_name']; ?></td>
		<td><?php echo $row['mb_id']; ?></td>
		<td><?php echo $row['wdate']; ?></td>
		<!-- <td>
			<div class="btn_wrap">
					<a href="<?php echo BV_ADMIN_URL.'/service.php?code=view&idx='.$row['idx'].$q2; ?>" class="detail color_type"><span>상세보기</span></a>
			</div>
		</td> -->
	</tr>
	<?php
    }
	if ($i == 0) {
		echo '<tbody><tr><td colspan="' . $colspan . '" class="empty_table">자료가 없습니다.</td></tr>';
	}
?>
	</tbody>
	</table>
</div>

<?php
echo get_paging($config['write_pages'], $page, $total_page, $_SERVER['SCRIPT_NAME'] . '?' . $q1 . '&page=');
?>

<script>
$(document).ready(function(){
    $(".allchk").click(function(){
        if($(this).is(":checked")){
            $(".chk").prop("checked", true);
        } else {
            $(".chk").prop("checked", false);
        }
    });
});

$(function(){
	// 날짜 검색 : TODAY MAX값으로 인식 (maxDate: "+0d")를 삭제하면 MAX값 해제
	$("#fr_date, #to_date").datepicker({ changeMonth: true, changeYear: true, dateFormat: "yy-mm-dd", showButtonPanel: true, yearRange: "c-99:c+99", maxDate: "+0d" });
});
</script>
