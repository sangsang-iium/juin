<?php // 담당자 관리 _20240521_SY
if(!defined('_BLUEVATION_')) exit;

$form_title = "담당직원 등록";
if($w == 'u') {
  $form_title = "담당직원 수정";
}

$sql_common = " FROM shop_manager ";
$sql_search = " WHERE (1) ";

if($w == 'u') {
  $sql_search .= " AND index_no = '{$idx}' ";
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

<form name="fregisterform" id="fregisterform" action="./config/managerupdate.php" onsubmit="return fregisterform_submit(this);" method="POST" autocomplete="off">
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
    <th scope="row"><label for="manager_id">아이디</label><span>(*)</span></th>
    <td>
        <div class="write_address">
            <div class="file_wrap address">
                <input type="text" name="manager_id" id="manager_id" value="<?php echo ($w == '') ? '' : $result['id']; ?>" required class="frm_input required" onkeyup="getId()" <?php echo ($w == 'u') ? "disabled" : "" ?> >
                <?php if($w == '') { ?>
                  <a class="btn_file" onclick="duplication_chk()">중복확인</a>
                  <!-- <button type="button" class="btn_small" onclick="duplication_chk()">중복확인</button> -->
                <?php } ?>
            </div>
        </div>
    </td>
  </tr>
  <tr>
    <th scope="row"><label for="manager_pw">비밀번호</label><span>(*)</span></th>
    <td>
      <input type="password" name="manager_pw" id="manager_pw" value="" <?php echo ($w == '') ? 'required' : '' ?> class="frm_input w300">
    </td>
  </tr>
  <tr>
    <th scope="row"><label for="manager_name">이름</label><span>(*)</span></th>
    <td>
      <input type="text" name="manager_name" id="manager_name" value="<?php echo ($w == '') ? '' : $result['name']; ?>" <?php echo ($w == '') ? 'required' : '' ?> class="frm_input w300">
    </td>
  </tr>
	<tr>
		<th scope="row"><label for="ju_region1">지역</label><span>(*)</span></th>
    <td>
        <div class="chk_select w300">
            <select name="ju_region1" id="ju_region1" onchange="getBranch(this.value)">
              <option value=''>지역선택</option>
              <?php while ($regionArr = sql_fetch_array($region_res)) { ?>
                <option value="<?php echo $regionArr['areacode']?>" <?php echo ($w == 'u' && $result['ju_region1'] == $regionArr['areacode']) ? "selected" : "" ?> ><?php echo $regionArr['areaname'] ?></option>
              <?php } ?>
            </select>
        </div>
    </td>
  </tr>
  <tr>
    <th scope="row"><label for="ju_region2">지회명</label><span>(*)</span></th>
    <td>
        <div class="chk_select w300">
            <select name="ju_region2" id="ju_region2" onchange="getChapter(this.value)">
              <option value=''>지회선택</option>
              <?php
                if($w != '' && !empty($result['ju_region2'])) {
                  $re2_where = " WHERE (1) AND areacode = '{$result['ju_region1']}' ";
                  $re2_res   = getRegionFunc("branch", $re2_where);
                  foreach ($re2_res as $key => $val) { ?>
                    <option value="<?php echo $val['branch_code'] ?>" <?php echo ($w == 'u' && $val['branch_code'] == $result['ju_region2']) ? "selected" : "" ?> ><?php echo $val['branch_name'] ?></option>
              <?php } } ?>
            </select>
        </div>
    </td>
  </tr>
  <tr>
    <th scope="row"><label for="ju_region3">지부명</label><span>(*)</span></th>
    <td>
        <div class="chk_select w300">
            <select name="ju_region3" id="ju_region3">
              <option value=''>지부선택</option>
              <?php
                if($w != '' && !empty($result['ju_region3'])) {
                  $re3_where = " WHERE (1) AND areacode = '{$result['ju_region1']}' AND b.branch_code = '{$result['ju_region2']}' ";
                  $re3_res   = getRegionFunc("office", $re3_where);
                  foreach ($re3_res as $key => $val) { ?>
                    <option value="<?php echo $val['office_code'] ?>" <?php echo ($w == 'u' && $val['office_code'] == $result['ju_region3']) ? "selected" : "" ?> ><?php echo $val['office_name'] ?></option>
              <?php } } ?>
            </select>
        </div>
    </td>
  </tr>
  
	</tbody>
	</table>
</div>
<div class="btn_confirm">
	<input type="submit" value="저장" id="btn_submit" class="btn_medium red" accesskey="s">
</div>
</form>

<script>
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
  let id = document.querySelector("input[name=manager_id]").value
  
  $.ajax({
    url  : "/admin/ajax.branchId_chk.php",
    type : "POST",
    data : { 
      type : "manager",
      id : id 
    },
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

      let ju_region2 = $("#ju_region2");
      ju_region2.empty();

      let defaultOption = $('<option>');
      defaultOption.val("");
      defaultOption.text("지회선택");
      ju_region2.append(defaultOption);
      
      
      let ju_region3 = $("#ju_region3");
      ju_region3.empty();

      let defaultOption2 = $('<option>');
      defaultOption2.val("");
      defaultOption2.text("지회선택");
      ju_region3.append(defaultOption2);
      

      for (var i = 0; i < reg.length; i++) {
        if(reg[i].region != "") {
          var option = $('<option>');
          option.val(reg[i].code);
          option.text(reg[i].region);
          ju_region2.append(option);
        }
      }
    },
    error: function(xhr, status, error) {
      console.log('요청 실패: ' + error);
    }
  })
  
}


// 지부 SELECT BOX _20240531_SY
function getChapter(e) {
console.log(e)  
  $.ajax({
    url: '/admin/ajax.gruopdepth.php',
    type: 'POST',
    data: { 
      depthNum: 4,
      depthValue: e
    },
    success: function(res) {

      let reg = JSON.parse(res);

      let ju_region3 = $("#ju_region3");
      ju_region3.empty();

      let defaultOption = $('<option>');
      defaultOption.val("");
      defaultOption.text("지부선택");
      ju_region3.append(defaultOption);

      for (var i = 0; i < reg.length; i++) {
        if(reg[i].region != "") {
          var option = $('<option>');
          option.val(reg[i].code);
          option.text(reg[i].region);
          ju_region3.append(option);
        }
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
  const regionSelect = f.ju_region1;
  const regionOption = regionSelect.options[regionSelect.selectedIndex];
  const regionValue = regionOption.value;
  
  // 지회 Seleted
  const chapterSelect = f.ju_region2;
  const chapterOption = chapterSelect.options[chapterSelect.selectedIndex];
  const chapterValue = chapterOption.value;

  if(w == '' && f.manager_id.value.length < 1 ) {
    alert("아이디를 입력해 주십시오.");
    f.manager_id.focus();
    return false;
  }

  if(w == '' && sessionStorage.getItem('id_duChk') == 'false') {
    alert("아이디 중복확인을 해 주십시오.");
    f.manager_id.focus();
    return false;   
  }

  if(regionValue.length < 1) {
    alert("지역을 선택해 주십시오.");
    f.ju_region1.focus();
    return false;   
  }

  // if(chapterValue.length < 1) {
  //   alert("지회명를 선택해 주십시오.");
  //   f.kf_region2.focus();
  //   return false;   
  // }

  // if(f.kf_region3.value.length < 1) {
  //   alert("지부명을 입력하여 주십시오.");
  //   f.kf_region3.focus();
  //   return false;   
  // }
  
    return true;
}
</script>