<?php // 지회/지부 관리 _20240423_SY
if(!defined('_BLUEVATION_')) exit;


$sql_common = " FROM kfia_region ";
$sql_search = " WHERE (1) ";

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