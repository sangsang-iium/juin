<?php // 지부 관리 _20240513_SY
if(!defined('_BLUEVATION_')) exit;


$sql_common = " FROM kfia_office ";
$sql_search = " WHERE (1) ";
// $sql_search .= " AND kf_region3 <> '' ";

$branch_sel = " b.branch_idx, b.branch_code, b.branch_name, c.areacode, c.areaname ";
$slq_join = " LEFT JOIN ( SELECT DISTINCT {$branch_sel} FROM kfia_branch b
                            LEFT JOIN area c
                              ON (b.area_idx = c.areacode)
                                 {$sql_search}
                           GROUP BY branch_code         
                        ) AS region
                     ON (a.branch_code = region.branch_code) ";

$query_string = "code=$code$qstr";
$q1 = $query_string;
$q2 = $query_string."&page=$page";

// 검색 & group & order 추가 _20240513_SY
if($sfl && $stx) {
  $sql_search .= " and $sfl like '%$stx%' ";
}
$sql_group .= " GROUP BY office_code";

if (!$orderby) {
  $filed = "office_idx ";
  $sod   = "ASC";
} else {
  $sod = $orderby;
}
$sql_order = " ORDER BY $filed $sod ";


// total_sel 수정 _20240608_SY
// $total_sel = " SELECT COUNT(*) as cnt {$sql_common} {$sql_search} ";
$total_sel = " SELECT COUNT(*) AS cnt {$sql_common} a {$slq_join} ";
$total_row = sql_fetch($total_sel);
$total_count = $total_row['cnt'];


$rows = 10;
$total_page = ceil($total_count / $rows);
if($page == "") {
  $page = 1;
}
$from_record = ($page - 1) * $rows;

$sql = " SELECT * {$sql_common} a {$slq_join} {$sql_search} {$sql_group} {$sql_order} LIMIT {$from_record}, {$rows} ";
$result = sql_query($sql);

// <input type="submit" name="act_button" value="선택수정" class="btn_lsmall bx-white" onclick="document.pressed=this.value">
$btn_frmline = <<<EOF
<input type="submit" name="act_button" value="선택삭제" class="btn_lsmall bx-white" onclick="document.pressed=this.value">
<a href="./config.php?code=chapter_register_form" class="fr btn_lsmall red"><i class="ionicons ion-android-add"></i> 지부추가</a>
EOF;
?>

<!-- // 버튼 & 검색 추가 _20240513_SY -->
<div class="btn_wrap tal">
  <a href="./config.php?code=branch" class="go"><span>지회관리</span></a>
  <a href="./config.php?code=chapter" class="go color_type"><span>지부관리</span></a>
</div>

<p class="gap50"></p>
<h5 class="htag_title">지부검색</h5>
<p class="gap20"></p>
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
            <div class="tel_input">
                <div class="chk_select w200">
                    <select name="sfl">
                        <?php echo option_selected('office_name', $sfl, '지부명'); ?>
                        <?php echo option_selected('branch_name', $sfl, '지회명'); ?>
                        <?php echo option_selected('office_code', $sfl, '지부코드'); ?>
                    </select>
                </div>
			    <input type="text" name="stx" value="<?php echo $stx; ?>" class="frm_input" size="30">
            </div>
		</td>
	</tr>
	</tbody>
	</table>
</div>

<div class="board_btns tac mart20">
        <div class="btn_wrap">
            <input type="submit" value="검색" class="btn_acc marr10">
            <a href="<?php echo BV_ADMIN_URL."/config.php?code=".$code ?>" id="frmRest" class="btn_cen">초기화</a>
        </div>
    </div>

</form>

<form name="fbranchlist" id="fbranchlist" method="post" action="./config/chapter_list_update.php" onsubmit="return fbranchlist_submit(this);">
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
		<col>
		<col class="w150">
		<col class="w150">
		<col class="w100">
	</colgroup>
	<thead>
	<tr>
		<th scope="col"><input type="checkbox" name="chkall" value="1" onclick="check_all(this.form);"></th>
		<th scope="col"><?php echo subject_sort_link('office_code', $q2); ?>지부코드</a></th>
		<th scope="col"><?php echo subject_sort_link('areaname',    $q2); ?>지역</a></th>
		<th scope="col"><?php echo subject_sort_link('branch_name', $q2); ?>지회명</a></th>
		<th scope="col"><?php echo subject_sort_link('office_name', $q2); ?>지부명</a></th>
		<th scope="col"><?php echo subject_sort_link('office_wdate',$q2); ?>등록일</th>
		<th scope="col"><?php echo subject_sort_link('office_udate',$q2); ?>수정일</th>
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
			<input type="hidden" name="office_idx[<?php echo $i; ?>]" value="<?php echo $row['office_idx']; ?>">
			<input type="checkbox" name="chk[]" value="<?php echo $i; ?>">
		</td>
    <td><?php echo $row['office_code'] ?></td>
		<td><?php echo $row['areaname'] ?></td>
		<td><?php echo $row['branch_name'] ?></td>
		<td><?php echo $row['office_name'] ?></td>
		<td><?php echo substr($row['office_wdate'], 0, 11) ?></td>
		<td><?php echo substr($row['office_udate'], 0, 11) ?></td>
		<td>
            <div class="btn_wrap">
                <a href="/admin/config.php?code=chapter_register_form&amp;w=u&amp;idx=<?php echo $row['office_idx']?>" class="btn_fix bg_type2">
                    <span>수정</span>
                </a>
            </div>
      
        </td>
	</tr>
	<?php 
	}
	if($i==0)
		echo '<tbody><tr><td colspan="8" class="empty_table">자료가 없습니다.</td></tr>';
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