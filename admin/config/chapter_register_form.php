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

<form name="fchapter" id="fregisterform" action="./config/chapterupdate.php" onsubmit="return fregisterform_submit(this);" method="POST" autocomplete="off">
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
    <th scope="row"><label for="chapter_id">아이디</label><span>(*)</span></th>
    <td>
      <input type="text" name="chapter_id" id="chapter_id" value="<?php echo ($w == '') ? '' : $result['kf_code']; ?>" required class="frm_input required" onkeyup="getId()" <?php echo ($w == 'u') ? "disabled" : "" ?> >
      <button type="button" class="btn_small" onclick="duplication_chk()">중복확인</button>
    </td>
  </tr>
	<tr>
		<th scope="row"><label for="kf_region1">지역</label><span>(*)</span></th>
    <td>
      <select name="kf_region1" id="kf_region1" onchange="getBranch(this.value)">
        <option value=''>지역선택</option>
        <?php foreach ($regionArr as $key => $val) { ?>
          <option value="<?php echo $val?>" <?php echo ($w == 'u' && $result['kf_region1'] == $val) ? "selected" : "" ?> ><?php echo $val ?></option>
        <?php } ?>
      </select>
    </td>
  </tr>
  <tr>
    <th scope="row"><label for="kf_region2">지회명</label><span>(*)</span></th>
    <td>
      <select name="kf_region2" id="kf_region2">
        <option value=''>지회선택</option>
        <?php // 지회 목록 _20240516_SY
          if($w != '' && !empty($result['kf_region2'])) {
            $region2_sel = " SELECT * {$sql_common} WHERE kf_region1 = '{$result['kf_region1']}' AND kf_region3 = '' ";
            $region2_res = sql_query($region2_sel);
            while ($region2_row = sql_fetch_array($region2_res)) { ?>
              <option value="<?php echo $region2_row['kf_region2']?>" <?php echo ($w == 'u' && $region2_row['kf_region2'] == $result['kf_region2']) ? "selected" : "" ?> ><?php echo $region2_row['kf_region2'] ?></option>
        <?php } } ?>
      </select>
    </td>
  </tr>
  <tr>
    <th scope="row"><label for="kf_region3">지부명</label><span>(*)</span></th>
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
  let id = document.querySelector("input[name=chapter_id]").value
  
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

      let kf_region2 = $("#kf_region2");
      kf_region2.empty();

      let defaultOption = $('<option>');
      defaultOption.val("");
      defaultOption.text("지회선택");
      kf_region2.append(defaultOption);

      for (var i = 0; i < reg.length; i++) {
        var option = $('<option>');
        option.val(reg[i].region);
        option.text(reg[i].region);
        kf_region2.append(option);
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
  const regionSelect = f.kf_region1;
  const regionOption = regionSelect.options[regionSelect.selectedIndex];
  const regionValue = regionOption.value;
  
  // 지회 Seleted
  const chapterSelect = f.kf_region2;
  const chapterOption = chapterSelect.options[chapterSelect.selectedIndex];
  const chapterValue = chapterOption.value;

  if(f.chapter_id.value.length < 1 ) {
    alert("아이디를 입력해 주십시오.");
    f.chapter_id.focus();
    return false;
  }

  if(sessionStorage.getItem('id_duChk') == 'false') {
    alert("아이디 중복확인을 해 주십시오.");
    f.chapter_id.focus();
    return false;   
  }

  if(regionValue.length < 1) {
    alert("지역을 선택해 주십시오.");
    f.kf_region1.focus();
    return false;   
  }

  if(chapterValue.length < 1) {
    alert("지회명를 선택해 주십시오.");
    f.kf_region2.focus();
    return false;   
  }

  if(f.kf_region3.value.length < 1) {
    alert("지부명을 입력하여 주십시오.");
    f.kf_region3.focus();
    return false;   
  }
  
    return true;
}
</script>