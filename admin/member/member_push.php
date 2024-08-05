<?php
if (!defined('_BLUEVATION_')) {
  exit;
}

$query_string = "code=$code$qstr";
$q1 = $query_string;
$q2 = $query_string . "&page=$page";

$sql_search = "";

if (!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $fr_date)) {
  $fr_date = '';
}

if (!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $to_date)) {
  $to_date = '';
}

// 기간검색
if ($fr_date && $to_date) {
  $sql_search .= " AND senddate BETWEEN '$fr_date 00:00:00' AND '$to_date 23:59:59' ";
} else if ($fr_date && !$to_date) {
  $sql_search .= " AND senddate BETWEEN '$fr_date 00:00:00' AND '$fr_date 23:59:59' ";
} else if (!$fr_date && $to_date) {
  $sql_search .= " AND senddate BETWEEN '$to_date 00:00:00' AND '$to_date 23:59:59' ";
}

if ($sfl && $stx) {
  if($sfl == "all") {
    $allColumns = array("p_title");
    $sql_search .= allSearchSql($allColumns, $stx);
  }
}


// 테이블의 전체 레코드수만 얻음
$cnt_sql     = " SELECT COUNT(*) AS cnt FROM iu_push WHERE (1) {$sql_search} ";
$cnt_row     = sql_fetch($cnt_sql);
$total_count = $cnt_row['cnt'];
$rows       = 30;
$total_page = ceil($total_count / $rows); // 전체 페이지 계산
if ($page == "") {
  $page = 1;
}             // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows;       // 시작 열을 구함
// $num         = $total_count - (($page - 1) * $rows);
$num = (($page - 1) * $rows)+1;

$push_sel = " SELECT * FROM iu_push WHERE (1) {$sql_search} limit $from_record, $rows";
$push_res = sql_query($push_sel);


include_once BV_PLUGIN_PATH . '/jquery-ui/datepicker.php';
?>

<h5 class="htag_title">기본검색</h5>
<p class="gap20"></p>
<form name="fsearch" id="fsearch" method="get">
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
                  <option value="all">전체</option>
                </select>
              </div>
              <input type="text" name="stx" value="" class="frm_input" size="30">
            </div>
          </td>
        </tr>
        <tr>
          <th scope="row">발송 기간</th>
          <td>
            <div class="tel_input">
              <div class="chk_select w200">
                <select name="spt">
                  <option value="all">전체</option>
                </select>
              </div>
              <?php echo get_search_date("fr_date", "to_date", $fr_date, $to_date); ?>
            </div>
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

<form name="pushlist" id="pushlist" method="post" action="./member/member_push_list_update.php" onsubmit="return fpushlist_submit(this);">
  <input type="hidden" name="q1" value="<?php echo $q1; ?>">
  <input type="hidden" name="page" value="<?php echo $page; ?>">
  <div class="local_frm01 mart30">
    <?php //echo $btn_frmline; ?>
    <input type="submit" name="act_button" value="선택삭제" class="btn_lsmall bx-white" onclick="document.pressed=this.value">
    <a href="./member.php?code=push_form" class="fr btn_lsmall red"><i class="ionicons ion-android-add"></i> Push 등록</a>
  </div>
  <div class="board_list">
    <table class="list01">
      <colgroup>
        <col class="w50">
        <col class="w50">
        <col>
        <col class="w100">
        <col class="w150">
        <col class="w200">
        <col class="w200">
        <!-- <col class="w150"> -->
      </colgroup>
      <thead>
        <tr>
          <th scope="col">
            <input type="checkbox" name="chkall" value="1" onclick="check_all(this.form);">
          </th>
          <th scope="col">번호</th>
          <th scope="col">제목</th>
          <th scope="col">발송 수</th>
          <th scope="col">발송자</th>
          <th scope="col">등록일시</th>
          <th scope="col">발송일시</th>
          <!-- <th scope="col">관리</th> -->
        </tr>
      </thead>
      <tbody class="list">
        <?php for($i=0; $push_row=sql_fetch_array($push_res); $i++) { 
          $sender_info = get_member($push_row['p_sender']);
          $sender = "";
          if(!empty($push_row['p_sender'])) {
            $sender = "{$sender_info['name']} ({$sender_info['id']})";
          }
        ?>
        <tr class="">
          <td>
            <input type="hidden" name="push_id[<?php echo $i ?>]" value="<?php echo $push_row['idx'] ?>">
            <input type="checkbox" name="chk[]" value="<?php echo $i; ?>">
          </td>
          <td><?php echo $num ?></td>
          <td><?php echo $push_row['p_title'] ?></td>
          <td><?php echo (int)$push_row['p_cnt'] ?></td>
          <td><?php echo $sender ?></td>
          <td><?php echo substr($push_row['wdate'], 0, 16) ?></td>
          <td><?php echo substr($push_row['senddate'], 0, 16) ?></td>
          <!-- <td>
            <div class="btn_wrap">
              <a href="./member.php?code=push_form" class="btn_fix bg_type2">
                <span>수정</span>
              </a>
            </div>
          </td> -->
        </tr>
        <?php $num++; } ?>
      </tbody>
    </table>
  </div>
  <div class="local_frm02">
    <?php //echo $btn_frmline; ?>
  </div>
</form>

<?php
// echo get_paging($config['write_pages'], $page, $total_page, $_SERVER['SCRIPT_NAME'].'?'.$q1.'&page=');
?>

<script>
  function fpushlist_submit(f)
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

    // 날짜 검색 : TODAY MAX값으로 인식 (maxDate: "+0d")를 삭제하면 MAX값 해제
    $("#fr_date,#to_date").datepicker({ changeMonth: true, changeYear: true, dateFormat: "yy-mm-dd", showButtonPanel: true, yearRange: "c-99:c+99", maxDate: "+0d" });
  });
</script>