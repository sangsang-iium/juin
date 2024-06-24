<?php // 지회/지부 관리 _20240516_SY
if(!defined('_BLUEVATION_')) exit;

$form_title = "지부 등록";
if($w == 'u') {
  $form_title = "지부 수정";
}

$sql_common = " FROM kfia_office ";
$sql_search = " WHERE (1) ";

if($w == 'u') {
  $sql_search .= " AND office_idx = '{$idx}' ";
}

$branch_sel = " b.branch_idx, b.branch_code, b.branch_name, c.areacode, c.areaname ";
$slq_join = " LEFT JOIN ( SELECT DISTINCT {$branch_sel} FROM kfia_branch b
                            LEFT JOIN area c
                              ON (b.area_idx = c.areacode)
                           GROUP BY branch_code         
                        ) AS region
                     ON (a.branch_code = region.branch_code) ";


$sql = " SELECT * {$sql_common} a {$slq_join} {$sql_search} ";
$result = sql_fetch($sql);

$query_string = "code=$code$qstr";
$q1 = $query_string;
$q2 = $query_string."&page=$page";

$region_sel = "SELECT areacode, areaname FROM area GROUP BY areacode";
$region_res = sql_query($region_sel);
// $regionArr = array('서울', '부산', '대구', '인천', '광주', '대전', '울산', '강원', '경기', '경남', '경북', '전남', '전북', '제주', '충남', '충북');

$auth_sql = " SELECT * FROM authorization";
$auth_res = sql_query($auth_sql);
?>

<form name="fchapter" id="fregisterform" action="./config/chapterupdate.php" onsubmit="return fregisterform_submit(this);" method="POST" autocomplete="off">
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
    <th scope="row"><label for="office_code">지부코드</label><span>(*)</span></th>
    <td>
        <div class="write_address">
            <div class="file_wrap address">
                <input type="text" name="office_code" id="office_code" value="<?php echo ($w == '') ? '' : $result['office_code']; ?>" required class="frm_input required" onkeyup="getId()" <?php echo ($w == 'u') ? "disabled" : "" ?> >
                <a type="button" class="btn_file" onclick="duplication_chk()">중복확인</a>
                <!-- <button type="button" class="btn_small" onclick="duplication_chk()">중복확인</button> -->
            </div>
        </div>
    </td>
  </tr>
  <!-- 권한 추가 _20240608_SY -->
  <tr>
    <th scope="row"><label for="auth_idx">권한</label><span>(*)</span></th>
    <td>
        <div class="chk_select">
            <select name="auth_idx" id="auth_idx">
              <?php while($authArr = sql_fetch_array($auth_res)) { ?>
                <option value="<?php echo $authArr['auth_idx']; ?>" <?php echo ($result['auth_idx'] == $authArr['auth_idx']) ? "selected" : "" ?> ><?php echo $authArr['auth_title'] ?></option>
              <?php } ?>
            </select>
        </div>
    </td>
  </tr>
	<tr>
		<th scope="row"><label for="areacode">지역</label><span>(*)</span></th>
    <td>
        <div class="chk_select">
            <select name="areacode" id="areacode" onchange="getBranch(this.value)">
              <option value=''>지역선택</option>
              <?php while ($regionArr = sql_fetch_array($region_res)) { 
                if($regionArr['areacode'] !== '0') {?>
                <option value="<?php echo $regionArr['areacode']?>" <?php echo ($w == 'u' && $result['areacode'] == $regionArr['areacode']) ? "selected" : "" ?> ><?php echo $regionArr['areaname'] ?></option>
              <?php }} ?>
            </select>
        </div>
    </td>
  </tr>
  <tr>
    <th scope="row"><label for="branch_code">지회명</label><span>(*)</span></th>
    <td>
        <div class="chk_select">
            <select name="branch_code" id="branch_code">
                <option value=''>지회선택</option>
                <?php // 지회 목록 _20240516_SY
                if($w != '' && !empty($result['branch_code'])) {
                    // $region2_sel = " SELECT * FROM kfia_branch WHERE area_idx = '{$result['areacode']}' ";
                    // $region2_res = sql_query($region2_sel);
                    $re2_where = " WHERE (1) AND area_idx = '{$result['areacode']}' ";
                    $re2_res   = getRegionFunc("branch", $re2_where);
                    foreach ($re2_res as $key => $val) { ?>
                    <option value="<?php echo $val['branch_code']?>" <?php echo ($w == 'u' && $val['branch_code'] == $result['branch_code']) ? "selected" : "" ?> ><?php echo $val['branch_name'] ?></option>
                <?php } } ?>
            </select>
        </div>
    </td>
  </tr>
  <tr>
    <th scope="row"><label for="office_name">지부명</label><span>(*)</span></th>
    <td><input type="text" name="office_name" id="office_name" value="<?php echo ($w == '') ? '' : $result['office_name']; ?>" required itemname="지부명" class="frm_input required"></td>
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
  let id = document.querySelector("input[name=office_code]").value
  
  $.ajax({
    url  : "/admin/ajax.branchId_chk.php",
    type : "POST",
    data : { 
      type : "kfia_office",
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

// 지회 SELECT BOX
function getBranch(e) {
  
  $.ajax({
    url: '/admin/ajax.gruopdepth.php',
    type: 'POST',
    data: { 
      depthNum: 3,
      depthValue: e
    },
    success: function(res) {

      let reg = JSON.parse(res);

      let branch_code = $("#branch_code");
      branch_code.empty();

      let defaultOption = $('<option>');
      defaultOption.val("");
      defaultOption.text("지회선택");
      branch_code.append(defaultOption);

      for (var i = 0; i < reg.length; i++) {
        var option = $('<option>');
        option.val(reg[i].code);
        option.text(reg[i].region);
        branch_code.append(option);
      }
    },
    error: function(xhr, status, error) {
      console.log('요청 실패: ' + error);
    }
  })
  
}

// Submit Check _20240516_SY
function fregisterform_submit(f)
{
  // 지역 Seleted
  const regionSelect = f.areacode;
  const regionOption = regionSelect.options[regionSelect.selectedIndex];
  const regionValue = regionOption.value;
  
  // 지회 Seleted
  const chapterSelect = f.branch_code;
  const chapterOption = chapterSelect.options[chapterSelect.selectedIndex];
  const chapterValue = chapterOption.value;

  if(f.office_code.value.length < 1 ) {
    alert("지부코드를 입력해 주십시오.");
    f.office_code.focus();
    return false;
  }

  if(sessionStorage.getItem('id_duChk') == 'false') {
    alert("지부코드 중복확인을 해 주십시오.");
    f.office_code.focus();
    return false;   
  }

  if(regionValue.length < 1) {
    alert("지역을 선택해 주십시오.");
    f.areacode.focus();
    return false;   
  }

  if(chapterValue.length < 1) {
    alert("지회명를 선택해 주십시오.");
    f.branch_code.focus();
    return false;   
  }

  if(f.office_name.value.length < 1) {
    alert("지부명을 입력하여 주십시오.");
    f.office_name.focus();
    return false;   
  }
  
    return true;
}
</script>