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

<form name="fbranch2" action="./config/branchupdate.php" method="post" autocomplete="off">
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
    <th scope="row"><label for="">아이디</label></th>
    <td>
      <input type="text" name="branch_id" class="frm_input required">
      <button type="button" class="btn_small" onclick="duplication_chk()">중복확인</button>
    </td>
  </tr>
	<tr>
		<th scope="row"><label for="">지역</label></th>
    <td>
      <select name="kf_region1" id="">
        <option>지역선택</option>
        <option value='서울'>서울</option>
        <option value='부상'>부산</option>
        <option value='대구'>대구</option>
        <option value='인천'>인천</option>
        <option value='광주'>광주</option>
        <option value='대전'>대전</option>
        <option value='울산'>울산</option>
        <option value='강원'>강원</option>
        <option value='경기'>경기</option>
        <option value='경남'>경남</option>
        <option value='경북'>경북</option>
        <option value='전남'>전남</option>
        <option value='전북'>전북</option>
        <option value='제주'>제주</option>
        <option value='충남'>충남</option>
        <option value='충북'>충북</option>
      </select>
    </td>
  </tr>
  <tr>
    <th scope="row"><label for="">지회명</label></th>
    <td><input type="text" name="" id="" required itemname="지회명" class="frm_input required"></td>
  </tr>
  
	</tbody>
	</table>
</div>
<div class="btn_confirm">
	<input type="submit" value="추가" class="btn_medium red" accesskey="s">
</div>
</form>

<script>
// ID 중복확인 _20240514_SY
function duplication_chk() {
  let id = document.querySelector("input[name=branch_id]").value
  
  $.ajax({
    url  : "/admin/ajax.branchId_chk.php",
    type : "POST",
    data : { id : id },
    success : function(res) {
      console.log(res)
    },
    error: function(xhr, status, error) {
      console.log('요청 실패: ' + error);
    }
  })
}

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