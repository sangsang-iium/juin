<?php // 지회 관리 _20240513_SY
if(!defined('_BLUEVATION_')) exit;

// 지회 Table 변경 _20240608_SY
$sql_common = " FROM kfia_branch ";
$sql_search = " WHERE (1) ";

$query_string = "code=$code$qstr";
$q1 = $query_string;
$q2 = $query_string."&page=$page";

// 검색 & group & order 추가 _20240513_SY
if($sfl && $stx) {
  $sql_search .= " and $sfl like '%$stx%' ";
}
$sql_group .= " GROUP BY branch_code";
if (!$orderby) {
  $filed = "branch_idx ";
  $sod   = "ASC";
} else {
  $sod = $orderby;
}
$sql_order = " ORDER BY $filed $sod ";


// total_sel 수정 _20240513_SY
$total_sel = " SELECT * {$sql_common} a LEFT JOIN area b ON (a.area_idx = b.areacode) {$sql_search} {$sql_group}";
$total_row = sql_query($total_sel);
// $total_count = $total_row['cnt'];
$total_count = sql_num_rows($total_row);

$rows = 10;
$total_page = ceil($total_count / $rows);
if($page == "") {
  $page = 1;
}
$from_record = ($page - 1) * $rows;

$sql = " SELECT * {$sql_common} a LEFT JOIN area b ON (a.area_idx = b.areacode)
        {$sql_search} {$sql_group} {$sql_order} 
          LIMIT {$from_record}, {$rows} ";
$result = sql_query($sql);

// <input type="submit" name="act_button" value="선택수정" class="btn_lsmall bx-white" onclick="document.pressed=this.value">
$btn_frmline = <<<EOF
<input type="submit" name="act_button" value="선택삭제" class="btn_lsmall bx-white" onclick="document.pressed=this.value">
<a href="./config.php?code=branch_register_form" class="fr btn_lsmall red"><i class="ionicons ion-android-add"></i> 지회추가</a>
EOF;

?>

<!-- // 버튼 & 검색 추가 _20240513_SY -->
<div>
  <a href="./config.php?code=branch" class="btn_small">지회관리</a>
  <a href="./config.php?code=chapter" class="btn_small">지부관리</a>
</div>

<h2>지회검색</h2>
<form name="fsearch" id="fsearch" method="get">
<input type="hidden" name="code" value="<?php echo $code; ?>">
<div class="tbl_frm01">
	<table>
	<colgroup>
		<col class="w100">
		<col>
		<col>
	</colgroup>
	<tbody>
	<tr>
		<th scope="row">검색어</th>
		<td>
			<select name="sfl">
        <?php echo option_selected('branch_name', $sfl, '지회명'); ?>
				<?php echo option_selected('areaname',    $sfl, '지역명'); ?>
				<?php echo option_selected('branch_code', $sfl, '지회코드'); ?>
			</select>
			<input type="text" name="stx" value="<?php echo $stx; ?>" class="frm_input" size="30">
		</td>
	</tr>
	</tbody>
	</table>
</div>
<div class="btn_confirm">
	<input type="submit" value="검색" class="btn_medium">
  <a href="<?php echo BV_ADMIN_URL."/config.php?code=".$code ?>" id="frmRest" class="btn_medium grey">초기화</a>
</div>
</form>

<form name="fbranchlist" id="fbranchlist" method="post" action="./config/branch_list_update.php" onsubmit="return fbranchlist_submit(this);">
<input type="hidden" name="q1" value="<?php echo $q1; ?>">
<input type="hidden" name="page" value="<?php echo $page; ?>">

<div class="local_ov mart30">
	총 지회 수 : <b class="fc_red"><?php echo number_format($total_count); ?></b> 개
</div>
<div class="local_frm01">
	<?php echo $btn_frmline; ?>
</div>
<div class="tbl_head01">
	<table>
	<colgroup>
		<col class="w50">
		<col>
		<col>
		<col>
		<col class="w150">
		<col class="w150">
		<col class="w100">
	</colgroup>
	<thead>
	<tr>
		<th scope="col"><input type="checkbox" name="chkall" value="1" onclick="check_all(this.form);"></th>
		<th scope="col"><?php echo subject_sort_link('branch_code', $q2); ?>지회코드</a></th>
		<th scope="col"><?php echo subject_sort_link('area_idx',    $q2); ?>지역</a></th>
		<th scope="col"><?php echo subject_sort_link('branch_name', $q2); ?>지회명</a></th>
		<th scope="col"><?php echo subject_sort_link('branch_wdate',$q2); ?>등록일</th>
		<th scope="col"><?php echo subject_sort_link('branch_udate',$q2); ?>수정일</th>
		<th scope="col">관리</th>
	</tr>
	</thead>
	<?php
	for($i=0; $row=sql_fetch_array($result); $i++) {
		if($i==0)
			echo '<tbody class="list">'.PHP_EOL;

		$bg = 'list'.($i%2);
	?>
	<tr class="<?php echo $bg; ?>">
		<td>			
			<input type="hidden" name="branch_idx[<?php echo $i; ?>]" value="<?php echo $row['branch_idx']; ?>">
			<input type="checkbox" name="chk[]" value="<?php echo $i; ?>">
		</td>
    <td><?php echo $row['branch_code'] ?></td>
		<td><?php echo $row['areaname'] ?></td>
		<td><?php echo $row['branch_name'] ?></td>
		<td><?php echo substr($row['branch_wdate'],0, 11) ?></td>
		<td><?php echo substr($row['branch_udate'],0, 11) ?></td>
		<td>
      <a href="/admin/config.php?code=branch_register_form&amp;w=u&amp;idx=<?php echo $row['branch_idx']?>" class="btn_small blue">수정</a>
      <!-- <a href="/admin/config/branchupdate.php?w=d" class="btn_small">삭제</a> -->
    </td>
	</tr>
	<?php 
	}
	if($i==0)
		echo '<tbody><tr><td colspan="7" class="empty_table">자료가 없습니다.</td></tr>';
	?>
	</tbody>
	</table>
</div>
<!-- <div class="local_frm02">
	<?php //echo $btn_frmline; ?>
</div> -->
</form>

<?php
echo get_paging($config['write_pages'], $page, $total_page, $_SERVER['SCRIPT_NAME'].'?'.$q1.'&page=');
?>

<script>
// 추가 _20240516_SY
sessionStorage.removeItem("id_duChk");


function fbranchlist_submit(f)
{
    if(!is_checked("chk[]")) {
        alert(document.pressed+" 하실 항목을 하나 이상 선택하세요.");
        return false;
    }

    if(document.pressed == "선택삭제") {
        if(!confirm("선택한 자료를 정말 삭제하시겠습니까?")) {
            return false;
        }
    }

    return true;
}
</script>