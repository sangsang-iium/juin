<?php // 담당지 관리 _20240521_SY
if (!defined('_BLUEVATION_')) exit;


$sql_common = " FROM shop_manager ";
$sql_search = " WHERE (1) ";
$sql_join = " LEFT JOIN authorization AS auth 
                     ON (mn.auth_idx = auth.auth_idx) 
              LEFT JOIN ( SELECT kf.*, area.areaname, area.areacode
                            FROM kfia_region AS kf 
                       LEFT JOIN ( SELECT areacode, areaname FROM area GROUP BY areacode) AS area 
                              ON kf.kf_region1 = area.areacode
                         ) AS kfa 
                     ON mn.ju_region_code = kfa.kf_code ";

$query_string = "code=$code$qstr";
$q1 = $query_string;
$q2 = $query_string . "&page=$page";


if ($sfl && $stx) {
  if($sfl == "auth_idx") {
    $sql_search .= " and mn.$sfl like '%$stx%' ";
  } else {
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

$sql = " SELECT mn.*, auth.*, kfa.* {$sql_common} AS mn {$sql_join} {$sql_search} LIMIT {$from_record}, {$rows} ";
$result = sql_query($sql);

// <input type="submit" name="act_button" value="선택수정" class="btn_lsmall bx-white" onclick="document.pressed=this.value">
$btn_frmline = <<<EOF
<input type="submit" name="act_button" value="선택삭제" class="btn_lsmall bx-white" onclick="document.pressed=this.value">
<a href="./config.php?code=manager_register_form" class="fr btn_lsmall red"><i class="ionicons ion-android-add"></i> 담당자추가</a>
EOF;
?>

<h2>담당자검색</h2>
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
            <select name="sfl">
              <?php echo option_selected('id', $sfl, '아이디'); ?>
              <?php echo option_selected('areaname', $sfl, '지역'); ?>
              <?php echo option_selected('kf_region2', $sfl, '지회'); ?>
              <?php echo option_selected('kf_region3', $sfl, '지부'); ?>
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

<form name="fmanagerlist" id="fmanagerlist" method="post" action="./config/manager_list_update.php" onsubmit="return fmanagerlist_submit(this);">
  <input type="hidden" name="q1" value="<?php echo $q1; ?>">
  <input type="hidden" name="page" value="<?php echo $page; ?>">

  <div class="local_ov mart30">
    총 담당자수 : <b class="fc_red"><?php echo number_format($total_count); ?></b>명
  </div>
  <div class="local_frm01">
    <?php echo $btn_frmline; ?>
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
        <col class="w100">
      </colgroup>
      <thead>
        <tr>
          <th scope="col"><input type="checkbox" name="chkall" value="1" onclick="check_all(this.form);"></th>
          <th scope="col"><?php echo subject_sort_link('id',         $q2); ?>아이디</a></th>
          <th scope="col"><?php echo subject_sort_link('name',       $q2); ?>이름</a></th>
          <th scope="col"><?php echo subject_sort_link('areaname',   $q2); ?>지역</a></th>
          <th scope="col"><?php echo subject_sort_link('kf_region2', $q2); ?>지회명</a></th>
          <th scope="col"><?php echo subject_sort_link('kf_region3', $q2); ?>지부명</a></th>
          <th scope="col"><?php echo subject_sort_link('reg_time',   $q2); ?>등록일</th>
          <th scope="col">관리</th>
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
          <td><?php echo $row['kf_region2'] ?></td>
          <td><?php echo $row['kf_region3'] ?></td>
          <td><?php echo substr($row['reg_time'], 0, 10) ?></td>
          <td>
            <a href="/admin/config.php?code=manager_register_form&amp;w=u&amp;idx=<?php echo $row['index_no'] ?>" class="btn_small blue">수정</a>
            <!-- <a href="/admin/config/branchupdate.php?w=d" class="btn_small">삭제</a> -->
          </td>
        </tr>
      <?php
      }
      if ($i == 0)
        echo '<tbody><tr><td colspan="7" class="empty_table">자료가 없습니다.</td></tr>';
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