<?php //권한관리 _20240522_SY
if (!defined('_BLUEVATION_')) exit;

$form_title = "권한관리 등록";
if ($w == 'u') {
  $form_title = "권한관리 수정";
}

$sql_common = " FROM authorization ";
$sql_search = " WHERE (1) ";

if ($w == 'u') {
  $sql_search .= " AND auth_idx = '{$idx}' ";
}

$sql = " SELECT * {$sql_common} {$sql_search} ";
$result = sql_fetch($sql);

$query_string = "code=$code$qstr";
$q1 = $query_string;
$q2 = $query_string . "&page=$page";


// 모든 상수를 가져옴
$constants = get_defined_constants(true);

// 사용자 정의 상수만 필터링
$user_constants = $constants['user'];

// 패턴에 맞는 상수를 저장할 배열 초기화
$admin_menus = [];

// 패턴에 맞는 상수를 찾고 배열에 추가
foreach ($user_constants as $key => $value) {
  if (preg_match('/^ADMIN_MENU([1-9]|1[0-2])$/', $key)) {
    $admin_menus[$key] = $value;
  }
}

?>

<form name="fmanager" id="fregisterform" action="./config/authupdate.php" onsubmit="return fregisterform_submit(this);" method="POST" autocomplete="off">
  <input type="hidden" name="q1" value="<?php echo $q1; ?>">
  <input type="hidden" name="page" value="<?php echo $page; ?>">
  <input type="hidden" name="w" value="<?php echo $w ?>">
  <?php if ($w != '') { ?>
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
          <th scope="row"><label for="auth_title"></label><span>명칭(*)</span></th>
          <td>
            <input type="text" name="auth_title" id="auth_title" value="" required class="frm_input required">
          </td>
        </tr>

      </tbody>
    </table>
  </div>
  <h2>카테고리 목록</h2>
  <div class="tbl_head01">
    <table id="testTable">
      <colgroup>
        <col>
        <col class="">
      </colgroup>
      <thead>
        <tr>
          <th scope="col">카테고리</th>
          <th scope="col">접속권한</th>
        </tr>
      </thead>
      <?php $keys = array_keys($admin_menus);
      for ($i = 0; $i < count($keys); $i++) {
        if ($i == 1) continue;
        $key = $keys[$i];
        $value = $admin_menus[$key];
      ?>
        <tr class="<?php echo $bg; ?>">
          <td><?php echo $value ?></td>
          <td>
            <input type="hidden" name="auth_cate[<?php echo $i; ?>]" value="<?php echo $key; ?>">
            <input type="checkbox" name="auth[]" value="<?php echo $i; ?>">
          </td>
        </tr>
      <?php  }
      if (count($keys) == 0)
        echo '<tbody><tr><td colspan="2" class="empty_table">자료가 없습니다.</td></tr>';
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
    // $.fn.rowspan = function(colIdx, isStats) {
    //   return this.each(function() {
    //     var that;
    //     $('tr', this).each(function(row) {
    //       $('td:eq(' + colIdx + ')', this).filter(':visible').each(function(col) {

    //         if ($(this).html() == $(that).html() &&
    //           (!isStats ||
    //             isStats && $(this).prev().html() == $(that).prev().html()
    //           )
    //         ) {
    //           rowspan = $(that).attr("rowspan") || 1;
    //           rowspan = Number(rowspan) + 1;

    //           $(that).attr("rowspan", rowspan);

    //           // do your action for the colspan cell here            
    //           $(this).hide();

    //           //$(this).remove(); 
    //           // do your action for the old cell here

    //         } else {
    //           that = this;
    //         }

    //         // set the that if not already set
    //         that = (that == null) ? this : that;
    //       });
    //     });
    //   });
    // };

    // $('#testTable').rowspan(0);
  </script>

  </tbody>
  </table>
  </div>
  <div class="btn_confirm">
    <input type="submit" value="저장" class="btn_medium red" accesskey="s">
  </div>
</form>