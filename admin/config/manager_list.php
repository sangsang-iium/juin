<?php // 담당지 관리 _20240521_SY
if (!defined('_BLUEVATION_')) exit;

$sql_common = " FROM shop_manager ";
$sql_search = " WHERE (1) AND grade > 1 AND id <> 'admin'";
$sql_join = " LEFT JOIN ( SELECT kfb.*, area.areaname, area.areacode
                            FROM kfia_branch AS kfb
                       LEFT JOIN ( SELECT areacode, areaname FROM area GROUP BY areacode) AS area 
                              ON kfb.area_idx = area.areacode
                         ) AS kf
                     ON mn.ju_region2 = kf.branch_code
              LEFT JOIN kfia_office AS kfo
 			               ON mn.ju_region3 = office_code ";

$query_string = "code=$code$qstr";
$q1 = $query_string;
$q2 = $query_string . "&page=$page";


if ($sfl && $stx) {
  if($sfl == "auth_idx") {
    // 권한 삭제 시 sql 수정 _20240608_SY -> 수정 _20240620_SY
    // $sql_join .= " LEFT JOIN authorization AS auth 
		// 	                    ON (kf.auth_idx = auth.auth_idx) ";
    // $sql_search .= " and kf.$sfl like '%$stx%' ";
    $sql_search .= " AND mn.ju_region3 IN ( SELECT office_code FROM kfia_office WHERE {$sfl} = '{$stx}') ";
    $auth_row = sql_fetch(" SELECT * FROM authorization WHERE auth_idx='$stx' ");
    $stx = $auth_row['auth_title'];
  } else if($sfl == 'all') {
    $allColumns = array("id","areaname","branch_name","office_name","name");
    $sql_search .= allSearchSql($allColumns,$stx);
  }  else {
    $sql_search .= " and $sfl like '%$stx%' ";
  }
}

if (!$orderby) {
  $filed = "";
  $sod   = "";
} else {
  $sod = $orderby;
}
$sql_order = " ORDER BY $filed $sod ";


$total_sel = " SELECT COUNT(*) as cnt {$sql_common} AS mn {$sql_join} {$sql_search} ";
$total_row = sql_fetch($total_sel);
$total_count = $total_row['cnt'];

$rows = 10;
$total_page = ceil($total_count / $rows);
if ($page == "") {
  $page = 1;
}
$from_record = ($page - 1) * $rows;

$sql = " SELECT mn.*, kf.*, kfo.* {$sql_common} AS mn {$sql_join} {$sql_search} LIMIT {$from_record}, {$rows} ";
$result = sql_query($sql);

// <input type="submit" name="act_button" value="선택수정" class="btn_lsmall bx-white" onclick="document.pressed=this.value">
$btn_frmline = <<<EOF
<input type="submit" name="act_button" value="선택삭제" class="btn_lsmall bx-white" onclick="document.pressed=this.value">
<a href="./config.php?code=manager_register_form" class="fr btn_lsmall red"><i class="ionicons ion-android-add"></i> 담당직원추가</a>
EOF;
?>

<h5 class="htag_title">담당직원검색</h5>
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
                        <?php echo option_selected('all', $sfl, '전체'); ?>
                        <?php echo option_selected('id',          $sfl, '아이디'); ?>
                        <?php echo option_selected('areaname',    $sfl, '지역'); ?>
                        <?php echo option_selected('branch_name', $sfl, '지회'); ?>
                        <?php echo option_selected('office_name', $sfl, '지부'); ?>
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

<form name="fmanagerlist" id="fmanagerlist" method="post" action="./config/manager_list_update.php" onsubmit="return fmanagerlist_submit(this);">
  <input type="hidden" name="q1" value="<?php echo $q1; ?>">
  <input type="hidden" name="page" value="<?php echo $page; ?>">

  <div class="local_ov mart30">
    총 담당직원수 : <b class="fc_red"><?php echo number_format($total_count); ?></b>명
  </div>
  <div class="local_frm01">
    <?php echo $member['id'] == "admin" ? $btn_frmline : ""; ?>
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
        <?php if($member['id'] == "admin") { ?>
          <col class="w300">
        <?php } ?>
      </colgroup>
      <thead>
        <tr>
          <th scope="col"><input type="checkbox" name="chkall" value="1" onclick="check_all(this.form);"></th>
          <th scope="col"><?php echo subject_sort_link('id',         $q2); ?>아이디</a></th>
          <th scope="col"><?php echo subject_sort_link('name',       $q2); ?>이름</a></th>
          <th scope="col"><?php echo subject_sort_link('areaname',   $q2); ?>지역</a></th>
          <th scope="col"><?php echo subject_sort_link('branch_name',$q2); ?>지회명</a></th>
          <th scope="col"><?php echo subject_sort_link('office_name',$q2); ?>지부명</a></th>
          <th scope="col"><?php echo subject_sort_link('reg_time',   $q2); ?>등록일</th>
          <?php if($member['id'] == "admin") { ?>
            <th scope="col">관리</th>
          <?php } ?>
        </tr>
      </thead>
      <?php
      for ($i = 0; $row = sql_fetch_array($result); $i++) {
        if ($i == 0)
          echo '<tbody class="list">' . PHP_EOL;

        $bg = 'list' . ($i % 2);
      ?>
        <tr class="<?php echo $bg; ?>">
          <td>
            <input type="hidden" name="index_no[<?php echo $i; ?>]" value="<?php echo $row['index_no']; ?>">
            <input type="checkbox" name="chk[]" value="<?php echo $i; ?>">
          </td>
          <td><?php echo $row['id'] ?></td>
          <td><?php echo $row['name'] ?></td>
          <td><?php echo $row['areaname'] ?></td>
          <td><?php echo $row['branch_name'] ?></td>
          <td><?php echo $row['office_name'] ?></td>
          <td><?php echo substr($row['reg_time'], 0, 10) ?></td>
          <?php if($member['id'] == "admin") { ?>
          <td>
            <div class="btn_wrap">
                <a href="/admin/config.php?code=manager_register_form&amp;w=u&amp;idx=<?php echo $row['index_no'] ?>" class="btn_fix bg_type1"><span>수정</span></a>
                <a href="/admin/config/managerupdate.php?w=d&amp;idx=<?php echo $row['index_no'] ?>" class="btn_del bg_type2" onclick="del_btn(event)"><span>삭제</span></a>
            </div>
          </td>
          <?php } ?>
        </tr>
      <?php
      }
      if ($i == 0)
        echo '<tbody><tr><td colspan="8" class="empty_table">자료가 없습니다.</td></tr>';
      ?>
      </tbody>
    </table>
  </div>
</form>

<?php
echo get_paging($config['write_pages'], $page, $total_page, $_SERVER['SCRIPT_NAME'] . '?' . $q1 . '&page=');
?>

<script>
  sessionStorage.removeItem("id_duChk");
  
  // 개별삭제 Token추가 _20240620_SY
  function del_btn(e) {
    e.preventDefault();
    
    var token = get_ajax_token();
    var target = e.target.closest('a');
    var href = target.getAttribute('href');
    var url = href + "&token=" + token;

    window.location.href = url; 
  };

  function fmanagerlist_submit(f) {
    if (!is_checked("chk[]")) {
      alert(document.pressed + " 하실 항목을 하나 이상 선택하세요.");
      return false;
    }

    if (document.pressed == "선택삭제") {
      if (!confirm("선택한 자료를 정말 삭제하시겠습니까?")) {
        return false;
      }
    }

    return true;
  }
</script>