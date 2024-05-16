<?php // 지회/지부 관리 _20240516_SY
if(!defined('_BLUEVATION_')) exit;

$form_title = "지회/지부 등록";
if($w == 'u') {
  $form_title = "지회/지부 수정";
}

$sql_common = " FROM kfia_region ";
$sql_search = " WHERE (1) ";

if($w == 'u') {
  $sql_search .= " AND kf_idx = '{$idx}' ";
}

$sql = " SELECT * {$sql_common} {$sql_search} ";
$result = sql_fetch($sql);

$query_string = "code=$code$qstr";
$q1 = $query_string;
$q2 = $query_string."&page=$page";

$regionArr = array('서울', '부산', '대구', '인천', '광주', '대전', '울산', '강원', '경기', '경남', '경북', '전남', '전북', '제주', '충남', '충북');

?>

<form name="fbranch2" id="fregisterform" action="./config/branchupdate.php" onsubmit="return fregisterform_submit(this);" method="POST" autocomplete="off">
<input type="hidden" name="q1" value="<?php echo $q1; ?>">
<input type="hidden" name="page" value="<?php echo $page; ?>">
<input type="hidden" name="w" value="<?php echo $w ?>">
<?php if($w != '') { ?> 
  <input type="hidden" name="idx" value="<?php echo $_GET['idx'] ?>">
<?php } ?>

<h2><?php echo $form_title ?></h2>
<div class="tbl_frm01">
	<table>
	<colgroup>
		<col class="w140">
		<col>
	</colgroup>
	<tbody>
  <tr>
    <th scope="row"><label for="branch_id">아이디</label></th>
    <td>
      <input type="text" name="branch_id" id="branch_id" value="<?php echo ($w == '') ? '' : $result['kf_code']; ?>" required class="frm_input required" onkeyup="getId()" <?php echo ($w == 'u') ? "disabled" : "" ?> >
      <button type="button" class="btn_small" onclick="duplication_chk()">중복확인</button>
    </td>
  </tr>
	<tr>
		<th scope="row"><label for="kf_region1">지역</label></th>
    <td>
      <select name="kf_region1" id="kf_region1">
        <option value=''>지역선택</option>
        <?php foreach ($regionArr as $key => $val) { ?>
          <option value="<?php echo $val?>" <?php echo ($w == 'u' && $result['kf_region1'] == $val) ? "selected" : "" ?> ><?php echo $val ?></option>
        <?php } ?>
      </select>
    </td>
  </tr>
  <tr>
    <th scope="row"><label for="kf_region2">지회명</label></th>
    <td>
      <select name="kf_region2" id="kf_region2">
        <option value=''>지회선택</option>
        <?php // 지회 목록 _20240516_SY
        $region2_sel = " SELECT * {$sql_common} {$sql_search} AND kf_region3 = '' ";
        $region2_res = sql_query($region2_sel);
        while ($region2_row = sql_fetch_array($region2_res)) { ?>
          <option value="<?php echo $region2_row['kf_region2']?>" <?php echo ($w == 'u' && $region2_row['kf_region2'] == $val) ? "selected" : "" ?> ><?php echo $region2_row['kf_region2'] ?></option>
        <?php } ?>
      </select>
    </td>
  </tr>
  <tr>
    <th scope="row"><label for="kf_region3">지부명</label></th>
    <td><input type="text" name="kf_region3" id="kf_region3" value="<?php echo ($w == '') ? '' : $result['kf_region3']; ?>" required itemname="지부명" class="frm_input required"></td>
  </tr>
  
	</tbody>
	</table>
</div>
<div class="btn_confirm">
	<input type="submit" value="저장" class="btn_medium red" accesskey="s">
</div>
</form>

<script>
// ID 중복확인 _20240516_SY
const w = document.querySelector("input[name='w']").value;
if(w == 'u') {
  sessionStorage.setItem("id_duChk", "true");
} else {
  sessionStorage.setItem("id_duChk", "false");
}

function getId() {
  sessionStorage.setItem("id_duChk", "false");
}

function duplication_chk() {
  let id = document.querySelector("input[name=branch_id]").value
  
  $.ajax({
    url  : "/admin/ajax.branchId_chk.php",
    type : "POST",
    data : { id : id },
    success : function(res) {
      sessionStorage.setItem("id_duChk", "true");
      alert("사용가능한 아이디입니다");
    },
    error: function(xhr, status, error) {
      sessionStorage.setItem("id_duChk", "false");
      alert("이미 사용중인 아이디입니다");
      return false;
    }
  })
}

// Submit Check _20240516_SY
function fregisterform_submit(f)
{
  // 지역 Seleted
  const regionSelect = f.kf_region1;
  const regionOption = regionSelect.options[regionSelect.selectedIndex];
  const regionValue = regionOption.value;
  
  // 지회 Seleted
  const branchSelect = f.kf_region2;
  const branchOption = branchSelect.options[branchSelect.selectedIndex];
  const branchValue = branchOption.value;

  if(f.branch_id.value.length < 1 ) {
    alert("아이디를 입력해 주십시오.");
    f.branch_id.focus();
    return false;
  }

  if(sessionStorage.getItem('id_duChk') == 'false') {
    alert("아이디 중복확인을 해 주십시오.");
    f.branch_id.focus();
    return false;   
  }

  if(regionValue.length < 1) {
    alert("지역을 선택해 주십시오.");
    f.kf_region1.focus();
    return false;   
  }

  if(branchValue.length < 1) {
    alert("지회명를 선택해 주십시오.");
    f.kf_region2.focus();
    return false;   
  }

  if(f.kf_region3.value.length < 1) {
    alert("지부명을 입력하여 주십시오.");
    f.kf_region3.focus();
    return false;   
  }
  
    return false;
}
</script>