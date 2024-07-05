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


//  오늘 날짜
$timestamp = strtotime("Now");
$now = date("Y-m-d", $timestamp);

// 미사용 쿠폰
$unUsedCoupon_sel = " SELECT cp.*, mm.fcm_token, 
                        CASE 
                            WHEN cp.cp_inv_type = '1' THEN DATE_ADD(cp.cp_wdate, INTERVAL cp.cp_inv_day DAY)
                            ELSE cp.cp_inv_edate
                        END AS expiration_date
                        FROM shop_coupon_log AS cp
                  LEFT JOIN shop_member AS mm ON (cp.mb_id = mm.id)
                      WHERE cp.mb_use='0' 
                        AND ( 	
                              (cp.cp_inv_type='0' AND (cp.cp_inv_edate = '9999999999' OR cp.cp_inv_edate > CURDATE() ) ) OR 
                              (cp.cp_inv_type='1' AND DATE_ADD(cp.cp_wdate, INTERVAL cp.cp_inv_day DAY) > NOW()) 
                            ) ";
$unUsedCoupon_res = sql_query($unUsedCoupon_sel);

while($unUsedCoupon_row = sql_fetch_array($unUsedCoupon_res)) {
  $cp_inv_type  = $unUsedCoupon_row['cp_inv_type'];
  $expiry_date  = $unUsedCoupon_row['expiration_date'];
  $cp_inv_edate = $unUsedCoupon_row['cp_inv_edate'];
  // $fcm_token    = $unUsedCoupon_row['fcm_token'];

  // 테스트용 토큰
  $fcm_token = "eQWmi-2FT8eL5C_SPtGi0E:APA91bGUA5K1gYAcmTY1Pz-Yn6BJn65OpmAsCT_RUDLpZ3wNPPzg10qbanZXcAdPOQ42uX7kpVs0Yvx_oQ5wNYay9nxlZSeNgL2ViRpVFefMHjGxCUnPW47rAwvYrxOKG7l9x-ZfESBA";

  if($cp_inv_type == '1' ||  $cp_inv_edate != '9999999999'){
  
    // 만료일 1달 전, 1주일 전 날짜 계산
    $beforeMonths = date("Y-m-d", strtotime($expiry_date . " -1 months"));
    $beforeWeeks = date("Y-m-d", strtotime($expiry_date . " -7 days"));
    $limit_date  = substr($expiry_date, 0, 10);

    // 만료 1달 전
    if ($now >= $beforeMonths && $now < date("Y-m-d", strtotime($beforeMonths . " +1 day"))) {
      $message = [
        'token' => $fcm_token,
        'title' => '쿠폰 만료 알림',
        'body' => "보유하신 \"{$unUsedCoupon_row['cp_subject']}\" 쿠폰 만료일이 1달 남았습니다."
      ];
      $response = sendFCMMessage($message);
    }

    // 만료 일주일 전
    if ($now >= $beforeWeeks && $now < date("Y-m-d", strtotime($beforeWeeks . " +1 day"))) {
      $message = [
        'token' => $fcm_token,
        'title' => '쿠폰 만료 알림',
        'body' => "보유하신 \"{$unUsedCoupon_row['cp_subject']}\" 쿠폰 만료일이 일주일 남았습니다."
      ];
      $response = sendFCMMessage($message);
    }

    // 만료 하루 전
    if ($now == date("Y-m-d", strtotime($limit_date. " -1 day"))) {
      $message = [
        'token' => $fcm_token,
        'title' => '쿠폰 만료 알림',
        'body' => "보유하신 \"{$unUsedCoupon_row['cp_subject']}\" 쿠폰 만료일이 하루 남았습니다."
      ];
      $response = sendFCMMessage($message);
    }
  } 
  
}
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
                <a href="/admin/config/authupdate.php?w=d&amp;idx=<?php echo $row['auth_idx']?>" class="btn_del bg_type2" onclick="del_btn(event)"><span>삭제</span></a>
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