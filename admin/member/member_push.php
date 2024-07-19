<?php
if (!defined('_BLUEVATION_')) {
  exit;
}

if (!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $fr_date)) {
  $fr_date = '';
}

if (!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $to_date)) {
  $to_date = '';
}

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

<form name="pushlist" id="pushlist" method="post" action="./member/member_push_update.php" onsubmit="return fpushlist_submit(this);">
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
        <col class="w150">
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
          <th scope="col">관리</th>
        </tr>
      </thead>
      <tbody class="list">
        <tr class="">
          <td>
            <input type="hidden" name="push_id[0]" value="5413">
            <input type="checkbox" name="chk[]" value="0">
          </td>
          <td>1</td>
          <td>Push 알람 제목이 나타납니다.</td>
          <td>00</td>
          <td>관리자 A</td>
          <td>2024-04-01 00:00:00</td>
          <td>2024-04-01 00:00:00</td>
          <td>
            <div class="btn_wrap">
              <a href="./member.php?code=push_form" class="btn_fix bg_type2">
                <span>수정</span>
              </a>
            </div>
          </td>
        </tr>
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