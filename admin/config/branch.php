<?php // 지회/지부 관리 _20240423_SY
if(!defined('_BLUEVATION_')) exit;


$sql_common = " FROM kfia_region ";
$sql_search = " WHERE (1) ";

// 검색 추가 _20240513_SY
if($sfl && $stx) {
  $sql_search .= " and $sfl like '%$stx%' ";
}


$total_sel = " SELECT COUNT(*) as cnt {$sql_common} {$sql_search} ";
$total_row = sql_fetch($total_sel);
$total_count = $total_row['cnt'];


$rows = 10;
$total_page = ceil($total_count / $rows);
if($page == "") {
  $page = 1;
}
$from_record = ($page - 1) * $rows;

$sql = " SELECT * {$sql_common} {$sql_search} LIMIT {$from_record}, {$rows} ";
$result = sql_query($sql);


$query_string = "code=$code$qstr";
$q1 = $query_string;
$q2 = $query_string."&page=$page";

$btn_frmline = <<<EOF
<input type="submit" name="act_button" value="선택수정" class="btn_lsmall bx-white" onclick="document.pressed=this.value">
<input type="submit" name="act_button" value="선택삭제" class="btn_lsmall bx-white" onclick="document.pressed=this.value">
EOF;

?>
<?php if($_SERVER['REMOTE_ADDR'] == '106.247.231.170') { ?>
<!-- // 버튼 & 검색 추가 _20240513_SY -->
<div>
  <a href="" class="btn_small">지회관리</a>
  <a href="" class="btn_small">지부관리</a>
</div>

<h2>지회검색</h2>
<form name="fsearch" id="fsearch" method="get">
<input type="hidden" name="code" value="<?php echo $code; ?>">
<div class="tbl_frm01">
	<table>
	<colgroup>
		<col class="w100">
		<col>
	</colgroup>
	<tbody>
	<tr>
		<th scope="row">검색어</th>
		<td>
			<select name="sfl">
				<?php echo option_selected('kf_region1', $sfl, '지역명'); ?>
				<?php echo option_selected('kf_region2', $sfl, '지회명'); ?>
				<?php echo option_selected('kf_region3', $sfl, '지부명'); ?>
			</select>
			<input type="text" name="stx" value="<?php echo $stx; ?>" class="frm_input" size="30">
		</td>
	</tr>
	</tbody>
	</table>
</div>
<div class="btn_confirm">
	<input type="submit" value="검색" class="btn_medium">
	<input type="button" value="초기화" id="frmRest" class="btn_medium grey">
</div>
</form>
<?php } ?>

<form name="fbranchlist" id="fbranchlist" method="post" action="./config/branch_update.php" onsubmit="return fbranchlist_submit(this);">
<input type="hidden" name="q1" value="<?php echo $q1; ?>">
<input type="hidden" name="page" value="<?php echo $page; ?>">

<div class="tbl_head01 local_ov mart30">
	<table>
	<colgroup>
		<!-- <col class="w50"> -->
		<col>
		<col>
		<col>
		<col>
	</colgroup>
	<thead>
	<tr>
		<!-- <th scope="col"><input type="checkbox" name="chkall" value="1" onclick="check_all(this.form);"></th> -->
		<th scope="col"><?php echo subject_sort_link('kf_region1',$q2); ?>지역</a></th>
		<th scope="col"><?php echo subject_sort_link('kf_region2',$q2); ?>지회명</a></th>
		<th scope="col"><?php echo subject_sort_link('kf_region3',$q2); ?>지부명</a></th>
		<th scope="col"></th>
	</tr>
	</thead>
	<?php
	for($i=0; $row=sql_fetch_array($result); $i++) {
		if($i==0)
			echo '<tbody class="list">'.PHP_EOL;

		$bg = 'list'.($i%2);
	?>
	<tr class="<?php echo $bg; ?>">
		<!-- <td>			
			<input type="hidden" name="is_id[<?php echo $i; ?>]" value="<?php echo $row['is_id']; ?>">
			<input type="checkbox" name="chk[]" value="<?php echo $i; ?>">
		</td> -->
		<td><?php echo $row['kf_region1'] ?></td>
		<td><?php echo $row['kf_region2'] ?></td>
		<td><?php echo $row['kf_region3'] ?></td>
		<td></td>
	</tr>
	<?php 
	}
	if($i==0)
		echo '<tbody><tr><td colspan="5" class="empty_table">자료가 없습니다.</td></tr>';
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

<form name="fbranch2" action="./config/branchlistupdate.php" method="post" autocomplete="off">
<input type="hidden" name="q1" value="<?php echo $q1; ?>">
<input type="hidden" name="page" value="<?php echo $page; ?>">
<input type="hidden" name="act_button" value="추가">
<h2>지회/지부 등록</h2>
<div class="tbl_frm01">
	<table>
	<colgroup>
		<col class="w140">
		<col>
	</colgroup>
	<tbody>
	<tr>
		<th scope="row"><label for="">지역</label></th>
    <td><input type="text" name="" id="" required itemname="지역" class="frm_input required"></td>
		<th scope="row"><label for="">지회명</label></th>
    <td><input type="text" name="" id="" required itemname="지회명" class="frm_input required"></td>
		<th scope="row"><label for="">지부명</label></th>
    <td><input type="text" name="" id="" required itemname="지역명" class="frm_input required"></td>
  </tr>
  <tr>
    <th scope="row">우편번호</th>
    <td><input type="text" name="" id ="" class="frm_input"></td>
    <th>주소</th>
    <td colspan=3><input type="text" name="" id ="" class="frm_input" size="70"></td>
  </tr>
  
	</tbody>
	</table>
</div>
<div class="btn_confirm">
	<input type="submit" value="추가" class="btn_medium red" accesskey="s">
</div>
</form>

<div class="information">
	<h4>도움말</h4>
	<div class="content">
		<div class="desc02">
			<p></p>
			<p></p>
			<p class="fc_red"></p>
		</div>
	 </div>
</div>

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