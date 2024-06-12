<?php // 지회/지부 관리 _20240516_SY
if(!defined('_BLUEVATION_')) exit;

$form_title = "지회 등록";
if($w == 'u') {
  $form_title = "지회 수정";
}

$sql_common = " FROM kfia_branch ";
$sql_search = " WHERE (1) ";

if($w == 'u') {
  $sql_search .= " AND branch_idx = '{$idx}' ";
}

$sql = " SELECT * {$sql_common} {$sql_search} ";
$result = sql_fetch($sql);

$query_string = "code=$code$qstr";
$q1 = $query_string;
$q2 = $query_string."&page=$page";


$region_sel = "SELECT areacode, areaname FROM area GROUP BY areacode";
$region_res = sql_query($region_sel);
// $regionArr = array('서울', '부산', '대구', '인천', '광주', '대전', '울산', '강원', '경기', '경남', '경북', '전남', '전북', '제주', '충남', '충북');

?>

<form name="fbranch2" id="fregisterform" action="./config/branchupdate.php" onsubmit="return fregisterform_submit(this);" method="POST" autocomplete="off">
<input type="hidden" name="q1" value="<?php echo $q1; ?>">
<input type="hidden" name="page" value="<?php echo $page; ?>">
<input type="hidden" name="w" value="<?php echo $w ?>">
<?php if($w != '') { ?> 
  <input type="hidden" name="idx" value="<?php echo $_GET['idx'] ?>">
<?php } ?>

<h5 class="htag_title"><?php echo $form_title ?></h5>
<p class="gap20"></p>
<div class="tbl_frm01">
	<table>
	<colgroup>
		<col width="220px">
		<col>
	</colgroup>
	<tbody>
  <tr>
    <th scope="row"><label for="branch_code">지회코드</label><span>(*)</span></th>
    <td>
        <div class="write_address">
            <div class="file_wrap address">
                <input type="text" name="branch_code" id="branch_code" value="<?php echo ($w == '') ? '' : $result['branch_code']; ?>" required class="frm_input required" onkeyup="getId()" <?php echo ($w == 'u') ? "disabled" : "" ?> >
                <a type="button" class="btn_file" onclick="duplication_chk()">중복확인</a>
                <!-- <button type="button" class="btn_small" onclick="duplication_chk()">중복확인</button> -->
            </div>
        </div>
    </td>
  </tr>
	<tr>
		<th scope="row"><label for="area_idx">지역</label><span>(*)</span></th>
    <td>
        <div class="chk_select">
            <select name="area_idx" id="area_idx">
                <option value=''>지역선택</option>
                <?php while ($regionArr = sql_fetch_array($region_res)) { ?>
                <option value="<?php echo $regionArr['areacode']?>" <?php echo ($w == 'u' && $result['area_idx'] == $regionArr['areacode']) ? "selected" : "" ?> ><?php echo $regionArr['areaname'] ?></option>
                <?php } ?>
            </select>
        </div>
    </td>
  </tr>
  <tr>
    <th scope="row"><label for="branch_name">지회명</label><span>(*)</span></th>
    <td><input type="text" name="branch_name" id="branch_name" value="<?php echo ($w == '') ? '' : $result['branch_name']; ?>" required itemname="지회명" class="frm_input required"></td>
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
  let id = document.querySelector("input[name=branch_code]").value
  
  $.ajax({
    url  : "/admin/ajax.branchId_chk.php",
    type : "POST",
    data : { 
      type : "kfia_branch",
      id : id 
    },
    success : function(res) {
      sessionStorage.setItem("id_duChk", "true");
      alert("사용가능한 코드입니다");
    },
    error: function(xhr, status, error) {
      sessionStorage.setItem("id_duChk", "false");
      alert("이미 사용중인 코드입니다");
      return false;
    }
  })
}

// Submit Check _20240516_SY
function fregisterform_submit(f)
{
  const regionSelect = f.auth_idx;
  const regionOption = regionSelect.options[regionSelect.selectedIndex];
  const regionValue = regionOption.value;

  if(f.branch_code.value.length < 1 ) {
    alert("지회코드를 입력해 주십시오.");
    f.branch_code.focus();
    return false;
  }

  if(sessionStorage.getItem('id_duChk') == 'false') {
    alert("지회코드 중복확인을 해 주십시오.");
    f.branch_code.focus();
    return false;   
  }

  if(regionValue.length < 1) {
    alert("지역을 선택해 주십시오.");
    f.area_idx.focus();
    return false;   
  }

  if(f.branch_name.value.length < 1) {
    alert("지회명을 입력하여 주십시오.");
    f.branch_name.focus();
    return false;   
  }
  
    return true;
}
</script>