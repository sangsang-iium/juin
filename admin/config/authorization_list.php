<?php // 권한 관리 _20240521_SY
if (!defined('_BLUEVATION_')) exit;


$sql_common = " FROM authorization ";
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

$btn_frmline = <<<EOF
<input type="submit" name="act_button" value="선택삭제" class="btn_lsmall bx-white" onclick="document.pressed=this.value">
<a href="./config.php?code=authorization_register_form" class="fr btn_lsmall red"><i class="ionicons ion-android-add"></i> 권한추가</a>
EOF;
?>

<h5 class="htag_title">권한목록</h5>
<p class="gap20"></p>
<form name="fmanagerlist" id="fmanagerlist" method="post" action="./config/authorization_list_update.php" onsubmit="return fmanagerlist_submit(this);">
  <input type="hidden" name="q1" value="<?php echo $q1; ?>">
  <input type="hidden" name="page" value="<?php echo $page; ?>">

  <div class="local_frm01">
    <?php echo $btn_frmline; ?>
  </div>
  <div class="tbl_head01">
    <table>
      <colgroup>
        <col class="w50">
        <col>
        <col>
        <col class="w300">
      </colgroup>
      <thead>
        <tr>
          <th scope="col"><input type="checkbox" name="chkall" value="1" onclick="check_all(this.form);"></th>
          <th scope="col"><?php echo subject_sort_link('auth_title', $q2); ?>권한이름</a></th>
          <th scope="col">열람 가능 카테고리</a></th>
          <th scope="col">관리</th>
        </tr>
      </thead>
      <?php
      for ($i = 0; $row = sql_fetch_array($result); $i++) {
        if ($i == 0)
          echo '<tbody class="list">' . PHP_EOL;

        $bg = 'list' . ($i % 2);

        $adm_menu = explode(",",$row['auth_menu']);
        $last_val = end($adm_menu);
      ?>
        <tr class="<?php echo $bg; ?>">
          <td>
            <input type="hidden" name="idx[<?php echo $i; ?>]" value="<?php echo $row['auth_idx']; ?>">
            <input type="checkbox" name="chk[]" value="<?php echo $i; ?>">
          </td>
          <td><?php echo $row['auth_title'] ?></td>
          <td>
            <?php foreach($adm_menu as $key => $val) { 
              echo constant($val);
              
              if($last_val !== $val)
              echo ", ";

            } ?>
          </td>
          <td>
            <div class="btn_wrap">
                <a href="/admin/config.php?code=authorization_register_form&amp;w=u&amp;idx=<?php echo $row['auth_idx'] ?>" class="btn_fix bg_type1"><span>수정</span></a>
                <a href="/admin/config/authupdate.php?w=d&amp;idx=<?php echo $row['auth_idx']?>" class="btn_del bg_type2"><span>삭제</span></a>
            </div>
          </td>
        </tr>
      <?php }
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