<?php
if (!defined('_BLUEVATION_')) {
  exit;
}

$ao = " OR ";
$sql_region = "";
$sql_extra = "";

if (!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $fr_date)) {
  $fr_date = '';
}

if (!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $to_date)) {
  $to_date = '';
}

$query_string = "code=$code$qstr";
$q1           = $query_string;
$q2           = $query_string . "&page=$page";

$sql_common = " from shop_member AS mm";
$sql_search = " where mm.id <> 'admin' ";
// manager join 추가 _20240531_SY
$sql_join = " LEFT JOIN shop_manager AS mn
                     ON (mm.ju_manager = mn.index_no) ";


// Search > AliasFunc 추가 _20240610_SY
function addAliasFunc($column)
{
  if (strpos($column, '.') !== false) {
    return $column; // 이미 별칭이 붙어 있는 경우 그대로 반환
  }
  if ($column == 'ju_manager') {
    $alias = "mn.name";
  } else {
    $alias = "mm.$column";
  }
  return "$alias";
}


if ($sst) {
  $gradeColumn = addAliasFunc("grade");
  $sql_search .= " AND $gradeColumn = '$sst'";
}

if($os){
  if($os == "Windows"){
    $sql_search .= " AND mb_agent = '{$os}'";
  } else if($os == 'all') {
    $sql_search .= "";
  } else {
    $sql_search .= " AND mb_agent != 'Windows'";
  }
} else {
  $os = "all";
}


// 기간검색
$sptColumn = addAliasFunc($spt);
if ($fr_date && $to_date) {
  $sql_search .= " and {$sptColumn} between '$fr_date 00:00:00' and '$to_date 23:59:59' ";
} else if ($fr_date && !$to_date) {
  $sql_search .= " and {$sptColumn} between '$fr_date 00:00:00' and '$fr_date 23:59:59' ";
} else if (!$fr_date && $to_date) {
  $sql_search .= " and {$sptColumn} between '$to_date 00:00:00' and '$to_date 23:59:59' ";
}

// 탈퇴 검색

if($ssd) {
  switch($ssd) {
    case "휴업":
      $ssd_code = "02";
      break;
    case "폐업":
      $ssd_code = "03";
      break;
  }
  if($ssd == '탈퇴') {
    $sql_search .= " and mm.intercept_date <> '' ";  
  } else if($ssd == 'all') {
    $sql_search .= "";
  } else {
    $sql_search .= " and mm.ju_closed = '{$ssd_code}' ";  
  }
} else {
  $ssd = "all";
}

if (!$orderby) {
  $filed = "mm.name";
  $sod   = "asc";
} else {
  $sod = $orderby;
}

/* ------------------------------------------------------------------------------------- _20240717_SY
    * 지회/지부 권한 관려 수정
   ------------------------------------------------------------------------------------- */
if ($_SESSION['ss_mn_id'] && $_SESSION['ss_mn_id'] != "admin") {
  if($member['ju_region2'] != "00400") {
    $belong_list = getBelongList($_SESSION['ss_mn_id'], "mm.ju_manager");
    $sql_region .= $belong_list;
    if($member['grade'] > 2) {
      $sql_region .= " AND mm.grade >= 8 ";
    }
  }
}



if ($sfl && $stx) {
  if($sfl == 'all') {

    $allColumns = array("mm.ju_restaurant" , "mm.ju_b_num" , "mm.name" , "mm.cellphone" , "mm.id" , "mn.name");
    $i = 0;
    $sql_search .= " AND (";
    foreach ($allColumns as $columnVal) {
      if($i != 0) $sql_search .= " OR ";
      $sql_search .= " INSTR( LOWER($columnVal) , LOWER('$stx') ) ";
      $i++;
    }

    $branch_where = " WHERE (1) AND b.branch_name LIKE '%$stx%' ";
    $branch_data = getRegionFunc("branch",$branch_where);
    $b_sql = "";
    for($i=0; $i<count($branch_data); $i++) {
      $values[] = "'" . $branch_data[$i]['branch_code'] . "'";
    }
    if (!empty($values)) {
      $b_sql = implode(", ", $values);
      $sql_search .= " OR mm.ju_region2 IN ( $b_sql ) ";
    } 

    $office_where = " WHERE (1) AND a.office_name LIKE '%$stx%' ";
    $office_data = getRegionFunc("office",$office_where);
    $s_sql = "";
    for($i=0; $i<count($office_data); $i++) {
      $values[] = "'" . $office_data[$i]['office_code'] . "'";
    }
    if (!empty($values)) {
      $s_sql = implode(", ", $values);
      $sql_search .= " OR mm.ju_region3 IN ( $s_sql ) ";
    } 

    $sql_search .= ") ";
    $sql_region = "";

  } else if ($sfl == "branch") { 
    $branch_where = " WHERE (1) AND b.branch_name LIKE '%$stx%' ";
    $branch_data = getRegionFunc("branch",$branch_where);
    $b_sql = "";
    for($i=0; $i<count($branch_data); $i++) {
      $values[] = "'" . $branch_data[$i]['branch_code'] . "'";
    }
    if (!empty($values)) {
      $b_sql = implode(", ", $values);
      $sql_search .= " AND mm.ju_region2 IN ( $b_sql ) ";
    }

    $sql_region = "";
  } else if ($sfl == "office") { 
    $office_where = " WHERE (1) AND a.office_name LIKE '%$stx%' ";
    $office_data = getRegionFunc("office",$office_where);
    $s_sql = "";
    for($i=0; $i<count($office_data); $i++) {
      $values[] = "'" . $office_data[$i]['office_code'] . "'";
    }
    if (!empty($values)) {
      $s_sql = implode(", ", $values);
      $sql_search .= " AND mm.ju_region3 IN ( $s_sql ) ";
    } 
    
    $sql_region = "";

  } else {
    $sflColumn = addAliasFunc($sfl);
    $sql_search .= " AND {$sflColumn} like '%$stx%' ";
    $sql_region = "";
  }

  $ao = " AND ";
}


/* ------------------------------------------------------------------------------------- _20240726_SY
  * 지회/지부 마스터 이상일 경우 본인 소속 사업장도 조회
 ------------------------------------------------------------------------------------- */
 if ($_SESSION['ss_mn_id'] && $_SESSION['ss_mn_id'] != "admin") {
  if($member['ju_region2'] != "00400" && $member['grade'] < 3 ) {
    $office_chk_sel = " SELECT COUNT(*) as cnt FROM kfia_branch WHERE branch_code = '{$member['ju_region3']}' ";
    $office_chk_res = sql_fetch($office_chk_sel);
    if($office_chk_res['cnt'] < 1) {
      $sql_extra .= " {$ao} mm.ju_region3 = '{$member['ju_region3']}' ";
    } else {
      $sql_extra .= " {$ao} mm.ju_region2 = '{$member['ju_region2']}' ";
    }
  }
}


$sql_order = " order by $filed $sod ";


// 테이블의 전체 레코드수만 얻음
$sql         = " select count(*) as cnt $sql_common {$sql_join} $sql_search {$sql_region} {$sql_extra} ";
$row         = sql_fetch($sql);
$total_count = $row['cnt'];

$rows       = 30;
$total_page = ceil($total_count / $rows); // 전체 페이지 계산
if ($page == "") {
  $page = 1;
}             // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows;       // 시작 열을 구함
// $num         = $total_count - (($page - 1) * $rows);
$num = (($page - 1) * $rows)+1;

$sql    = " select mm.*, mn.name AS mn_name, mn.id AS mn_id, mn.index_no AS mn_idx $sql_common {$sql_join} $sql_search {$sql_region} {$sql_extra} $sql_order limit $from_record, $rows ";
$result = sql_query($sql);


$is_intro = false;
$colspan  = 11;
if ($config['cert_admin_yes']) {
  $is_intro = true;
  $colspan++;
}

$btn_frmline = <<<EOF
<a href="./member.php?code=mail_list" class="btn_lsmall bx-white">전체메일발송</a>
<a href="./sms/sms_member.php" onclick="win_open(this,'pop_sms','245','360','no');return false" class="btn_lsmall bx-white">전체문자발송</a>
<a href="./member/member_list_excel.php?$q1" class="btn_lsmall bx-white"><i class="fa fa-file-excel-o"></i> 엑셀저장</a>
<a href="./member.php?code=register_form" class="fr btn_lsmall red"><i class="ionicons ion-android-add"></i> 회원추가</a>
EOF;

include_once BV_PLUGIN_PATH . '/jquery-ui/datepicker.php';
?>

<h5 class="htag_title">기본검색</h5>
<p class="gap20"></p>
<form name="fsearch" id="fsearch" method="get" autocomplete=off>
  <input type="hidden" name="code" value="<?php echo $code; ?>">
  <div class="board_table">
    <table>
      <colgroup>
        <col style="width:220px;">
        <col style="width:auto">
      </colgroup>
      <tbody>
        <tr>
          <th scope="row">검색어</th>
          <td>
            <div class="tel_input">
              <div class="chk_select w200">
                <select name="sfl">
                  <?php echo option_selected('all', $sfl, '전체'); ?>
                  <?php echo option_selected('ju_restaurant', $sfl, '상호명'); ?>
                  <?php echo option_selected('ju_b_num', $sfl, '사업자번호'); ?>
                  <?php echo option_selected('name', $sfl, '대표자명'); ?>
                  <?php echo option_selected('cellphone', $sfl, '연락처'); ?>
                  <?php echo option_selected('id', $sfl, '아이디'); ?>
                  <?php echo option_selected('ju_manager', $sfl, '담당직원'); ?>
                  <?php echo option_selected('branch', $sfl, '지회'); ?>
                  <?php echo option_selected('office', $sfl, '지부'); ?>
                </select>
              </div>
              <input type="text" name="stx" value="<?php echo $stx; ?>" class="frm_input" size="30">
            </div>
          </td>
        </tr>
        <tr>
          <th scope="row" >기간검색</th>
          <td>
            <div class="tel_input">
              <div class="chk_select w200">
                <select name="spt">
                  <?php echo option_selected('reg_time', $spt, "가입날짜"); ?>
                  <?php echo option_selected('today_login', $spt, "최근접속"); ?>
                </select>
              </div>
              <?php echo get_search_date("fr_date", "to_date", $fr_date, $to_date); ?>
            </div>
          </td>
        </tr>
        <tr>
          <th scope="row">등급검색</th>
          <td>
            <div class="radio_group">
              <?php echo get_search_level('sst', $sst, 2, 9); ?>
            </div>
          </td>
        </tr>
        <tr>
          <th scope="row">휴/폐업,탈퇴 검색</th>
          <td>
            <ul class="radio_group">
              <li class="radios"><input type="radio" name="ssd" value="all" id="ssd0" <?php echo $ssd=="all"?"checked":"" ?> ><label for="ssd0">전체</label></li>
              <li class="radios"><input type="radio" name="ssd" value="휴업" id="ssd3" <?php echo $ssd=="휴업"?"checked":"" ?> ><label for="ssd3">휴업</label></li>
              <li class="radios"><input type="radio" name="ssd" value="폐업" id="ssd2" <?php echo $ssd=="폐업"?"checked":"" ?> ><label for="ssd2">폐업</label></li>
              <li class="radios"><input type="radio" name="ssd" value="탈퇴" id="ssd1" <?php echo $ssd=="탈퇴"?"checked":"" ?> ><label for="ssd1">탈퇴</label></li>
            </ul>

          </td>
        </tr>
        <tr>
          <th scope="row">가입경로</th>
          <td>
            <ul class="radio_group">
              <li class="radios"><input type="radio" name="os" value="all" id="os0" <?php echo $os=="all"?"checked":"" ?>><label for="os0">전체</label></li>
              <li class="radios"><input type="radio" name="os" value="Mobile" id="os1" <?php echo $os=="Mobile"?"checked":"" ?>><label for="os1">모바일</label></li>
              <li class="radios"><input type="radio" name="os" value="Windows" id="os2" <?php echo $os=="Windows"?"checked":"" ?>><label for="os2">웹</label></li>
            </ul>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
  <div class="board_btns tac mart20">
    <div class="btn_wrap">
      <input type="submit" value="검색" class="btn_acc marr10">
      <input type="button" value="초기화" id="frmRest" class="btn_cen">
    </div>
  </div>
</form>

<div class="local_ov mart30 fs18">
  총 회원수 : <b class="fc_red"><?php echo number_format($total_count); ?></b>명
</div>
<div class="local_frm01">
  <?php echo $btn_frmline; ?>
</div>
<div class="board_list">
  <table class="list01">
    <colgroup>
      <col class="w100">
      <col class="w250">
      <col class="w200">
      <col class="w100">
      <col class="w200">
      <col class="w300">
      <col class="w200">
      <col class="w100">
      <col class="w100">
      <col class="w50">
      <col class="w50">
      <?php if ($is_intro) { ?>
        <col class="w40">
      <?php } ?>
      <col class="w50">
    </colgroup>
    <thead>
      <tr>
        <th scope="col">번호</th>
        <th scope="col"><?php echo subject_sort_link('name', $q2); ?>회원명</a></th>
        <th scope="col"><?php echo subject_sort_link('id', $q2); ?>아이디</a></th>
        <th scope="col"><?php echo subject_sort_link('grade', $q2); ?>회원등급</a></th>
        <th scope="col"><?php echo subject_sort_link('ju_manager', $q2); ?>담당직원</a></th>
        <th scope="col">지회/지부</a></th>
        <th scope="col">핸드폰</th>
        <th scope="col"><?php echo subject_sort_link('reg_time', $q2); ?>가입일시</a></th>
        <th scope="col">구매건 수</th>
        <th scope="col"><?php echo subject_sort_link('login_sum', $q2); ?>누적 로그인</a></th>
        <th scope="col"><?php echo subject_sort_link('mb_agent', $q2); ?>접속 OS</a></th>
        <?php if ($is_intro) { ?>
          <th scope="col"><?php echo subject_sort_link('use_app', $q2); ?>인증</a></th>
        <?php } ?>
        <th scope="col"><?php echo subject_sort_link('point', $q2); ?>포인트</a></th>
      </tr>
    </thead>
    <?php
    for ($i = 0; $row = sql_fetch_array($result); $i++) {
      if ($i == 0) {
        echo '<tbody class="list">' . PHP_EOL;
      }

      $bg = 'list' . ($i % 2);
      $manager_info = "";
      if(!empty($row['ju_manager'])) {
        $manager_info = $row['mn_name'] . " ({$row['mn_id']}) ";
      }

      /* ------------------------------------------------------------------------------------- _20240716_SY
        * 상호명 노출
      /* ------------------------------------------------------------------------------------- */
      $ju_resName = "";
      if(!empty($row['ju_restaurant'])) {
        $ju_resName =  " ({$row['ju_restaurant']}) ";
      }
    ?>
      <tr class="<?php echo $bg; ?>">
        <td><?php echo $num++; ?></td>
        <td><?php echo get_sideview($row['id'], $row['name']) . $ju_resName ?></td>
        <td><?php echo $row['id']; ?></td>
        <td><?php echo get_grade($row['grade']); ?></td>
        <td><?php echo $manager_info; ?></td>
        <?php
        /* ------------------------------------------------------------------------------------- _20240716_SY
          * 지회/지부 데이터 (담당자 기준으로 출력)
        /* ------------------------------------------------------------------------------------- */
          $jibu_name = "없음";
          // if(!empty($row['mn_idx'])) {
          //   $manager_sel = " SELECT * FROM shop_manager WHERE index_no ='{$row['mn_idx']}' ";
          //   $manager_row = sql_fetch($manager_sel);

          //   $jibu_row = getRegionFunc("office", " WHERE b.branch_code = '{$manager_row['ju_region2']}' AND a.office_code = '{$manager_row['ju_region3']}'");
          //   $jibu_name = $jibu_row[0]['branch_name']. " / " .$jibu_row[0]['office_name'];
          // }

          // 사업자한테 붙은 지회/지부로 노출되도록 수정 _20240724_SY
          if(!empty($row['ju_region2']) && !empty($row['ju_region3']) ) {
            $jibu_row = getRegionFunc("office", " WHERE b.branch_code = '{$row['ju_region2']}' AND a.office_code = '{$row['ju_region3']}'");
            $jibu_name = $jibu_row[0]['branch_name']. " / " .$jibu_row[0]['office_name'];
          }
          
        ?>
        <td><?php echo $jibu_name ?></td>
        <td><?php echo replace_tel($row['cellphone']); ?></td>
        <td><?php echo $row['reg_time']; ?></td>
        <td><?php echo number_format(shop_count($row['id'])); ?></td>
        <td><?php echo number_format($row['login_sum']); ?></td>
        <!-- <td><?php echo substr($row['intercept_date'], 2, 6); ?></td> -->
        <td><?php echo $row['mb_agent'] == 'Windows'?"웹":"모바일"; ?></td>
        <?php if ($is_intro) { ?>
          <td><input type="checkbox" name="use_app" value="1" <?php echo ($row['use_app']) ? ' checked' : ''; ?> onclick="chk_use_app('<?php echo $row['id']; ?>');"></td>
        <?php } ?>
        <td class="tar"><?php echo number_format($row['point']); ?></td>
      </tr>
    <?php
    }
    if ($i == 0) {
      echo '<tbody><tr><td colspan="' . $colspan . '" class="empty_table">자료가 없습니다.</td></tr>';
    }

    ?>
    </tbody>
  </table>
</div>
<div class="local_frm02">
  <?php //echo $btn_frmline;
  ?>
</div>

<?php
echo get_paging($config['write_pages'], $page, $total_page, $_SERVER['SCRIPT_NAME'] . '?' . $q1 . '&page=');
?>

<script>
  function chk_use_app(mb_id) {
    var error = "";
    var token = get_ajax_token();
    if (!token) {
      alert("토큰 정보가 올바르지 않습니다.");
      return false;
    }

    $.ajax({
      url: bv_admin_url + "/member/member_use_app.php",
      type: "POST",
      data: {
        "mb_id": mb_id,
        "token": token
      },
      dataType: "json",
      async: false,
      cache: false,
      success: function(data, textStatus) {
        error = data.error;
      }
    });

    if (error) {
      alert(error);
      return false;
    }
  }

  $(function() {
    // 날짜 검색 : TODAY MAX값으로 인식 (maxDate: "+0d")를 삭제하면 MAX값 해제
    $("#fr_date, #to_date").datepicker({
      changeMonth: true,
      changeYear: true,
      dateFormat: "yy-mm-dd",
      showButtonPanel: true,
      yearRange: "c-99:c+99",
      maxDate: "+0d"
    });
  });
</script>