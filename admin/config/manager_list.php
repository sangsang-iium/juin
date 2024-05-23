<?php // 담당지 관리 _20240521_SY
if (!defined('_BLUEVATION_')) exit;


$sql_common = " FROM shop_manager ";
$sql_search = " WHERE (1) ";

$query_string = "code=$code$qstr";
$q1 = $query_string;
$q2 = $query_string . "&page=$page";


if ($sfl && $stx) {
  $sql_search .= " and $sfl like '%$stx%' ";
}

if (!$orderby) {
  $filed = "";
  $sod   = "";
} else {
  $sod = $orderby;
}
$sql_order = " ORDER BY $filed $sod ";


$total_sel = " SELECT COUNT(*) as cnt {$sql_common} {$sql_search} ";
$total_row = sql_fetch($total_sel);
$total_count = $total_row['cnt'];

$rows = 10;
$total_page = ceil($total_count / $rows);
if ($page == "") {
  $page = 1;
}
$from_record = ($page - 1) * $rows;

$sql = " SELECT * {$sql_common} {$sql_search} LIMIT {$from_record}, {$rows} ";
$result = sql_query($sql);

// <input type="submit" name="act_button" value="선택수정" class="btn_lsmall bx-white" onclick="document.pressed=this.value">
$btn_frmline = <<<EOF
<input type="submit" name="act_button" value="선택삭제" class="btn_lsmall bx-white" onclick="document.pressed=this.value">
<a href="./config.php?code=manager_register_form" class="fr btn_lsmall red"><i class="ionicons ion-android-add"></i> 담당자추가</a>
EOF;

?>

<!-- <div>
  <a href="./config.php?code=branch" class="btn_small">지회관리</a>
  <a href="./config.php?code=chapter" class="btn_small">지부관리</a>
</div> -->

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
              <?php echo option_selected('kf_region2', $sfl, '아이디'); ?>
              <?php echo option_selected('kf_region1', $sfl, '지회'); ?>
              <?php echo option_selected('kf_code',    $sfl, '지부'); ?>
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
        <col class="w150">
        <col class="w150">
        <col class="w150">
        <col class="w100">
      </colgroup>
      <thead>
        <tr>
          <th scope="col"><input type="checkbox" name="chkall" value="1" onclick="check_all(this.form);"></th>
          <th scope="col"><?php echo subject_sort_link('kf_code',   $q2); ?>아이디</a></th>
          <th scope="col"><?php echo subject_sort_link('kf_region1', $q2); ?>지역</a></th>
          <th scope="col"><?php echo subject_sort_link('kf_region2', $q2); ?>지회명</a></th>
          <th scope="col"><?php echo subject_sort_link('kf_region3', $q2); ?>지부명</a></th>
          <th scope="col"><?php echo subject_sort_link('kf_wdate',  $q2); ?>등록일</th>
          <th scope="col"><?php echo subject_sort_link('kf_udate',  $q2); ?>수정일</th>
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
          <td><?php echo $row['kf_code'] ?></td>
          <td><?php echo $row['kf_region1'] ?></td>
          <td><?php echo $row['kf_region2'] ?></td>
          <td><?php echo $row['kf_region3'] ?></td>
          <td><?php echo $row['kf_wdate'] ?></td>
          <td><?php echo $row['kf_udate'] ?></td>
          <td>
            <a href="/admin/config.php?code=branch_register_form&amp;w=u&amp;idx=<?php echo $row['index_no'] ?>" class="btn_small blue">수정</a>
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

  <!-- 권한관리 화면 설계 (테스트) _20240522_SY -->
  <?php if ($_SERVER['REMOTE_ADDR'] == '106.247.231.170') { ?>
    <h2>권한관리(테스트)</h2>
    <div class="tbl_head01">
      <table id="testTable">
        <colgroup>
          <col>
          <col>
          <col class="w50">
          <col class="w50">
          <col class="w50">
        </colgroup>
        <thead>
          <tr>
            <th scope="col">1 Depth</th>
            <th scope="col">2 Depth</th>
            <th scope="col">r</th>
            <th scope="col">w</th>
            <th scope="col">d</th>
          </tr>
        </thead>
        <?php
        $TEST = TEST;
        for ($i = 1; $i <= count($TEST); $i++) {
          $key = "TEST{$i}";
          foreach ($TEST[$key]['data'] as $k => $v) {
        ?>
            <tr class="<?php echo $bg; ?>">
              <td><?= $key . " ({$TEST[$key]['name']})" ?></td>
              <td><?= $k . " ({$v})" ?></td>
              <td><input type="checkbox"></td>
              <td><input type="checkbox"></td>
              <td><input type="checkbox"></td>
            </tr>
        <?php }
        }
        if ($i == 0)
          echo '<tbody><tr><td colspan="7" class="empty_table">자료가 없습니다.</td></tr>';
        ?>
        </tbody>
      </table>
    </div>
    <script>
     /* 
      * 
      * 같은 값이 있는 열을 병합함
      * 
      * 사용법 : $('#테이블 ID').rowspan(0);
      * 
      */ 
      $.fn.rowspan = function(colIdx, isStats) {
        return this.each(function() {
          var that;
          $('tr', this).each(function(row) {
            $('td:eq(' + colIdx + ')', this).filter(':visible').each(function(col) {

              if ($(this).html() == $(that).html() &&
                (!isStats ||
                  isStats && $(this).prev().html() == $(that).prev().html()
                )
              ) {
                rowspan = $(that).attr("rowspan") || 1;
                rowspan = Number(rowspan) + 1;

                $(that).attr("rowspan", rowspan);

                // do your action for the colspan cell here            
                $(this).hide();

                //$(this).remove(); 
                // do your action for the old cell here

              } else {
                that = this;
              }

              // set the that if not already set
              that = (that == null) ? this : that;
            });
          });
        });
      };

      $('#testTable').rowspan(0);
    </script>
  <?php } ?>

  
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