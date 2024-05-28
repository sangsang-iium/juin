<?php //권한관리 _20240522_SY
if(!defined('_BLUEVATION_')) exit;

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


/* 테스트 { */

function t1($svc_class, $subject)
{
	if(get_cookie("ck_{$svc_class}")) {
		$svc_class .= ' menu_close';
	}

	return '<dt class="'.$svc_class.' menu_toggle">'.$subject.'</dt>';
}

function t2($svc_class, $subject, $url, $menu_cnt='')
{
	global $pg_title2;

	if(get_cookie("ck_{$svc_class}")) {
		$svc_class .= ' menu_close';
	}

	if($pg_title2 == $subject)
		$svc_class .= ' active';

	$current_class = '';
	$count_class = '';
	if(is_numeric($menu_cnt)) {
		if($menu_cnt > 0)
			$current_class = ' class="snb_air"';
		$count_class = '<em'.$current_class.'>'.$menu_cnt.'</em>';
	}

	return '<dd class="'.$svc_class.'"><a href="'.$url.'">'.$subject.$count_class.'</a></dd>';
}

function getMenuTab ($menuName, $memberID, $retunHTML) {
  // shop_member 인지 shop_manager인지 구분
  // member랑 manager랑 같은 id 있을 수 있으니까 세션도 체크해야 할까
  // 세션 체크한다고 되나

  $member_sql = " SELECT COUNT(*) as cnt FROM shop_manager WHERE id = '{$memberID}' ";
  $member_res = sql_fetch($member_sql);
  $member_cnt = $member_res['cnt'];

  if($member_cnt < 1) {
    return $retunHTML;
  } else {
    $member_sql = " SELECT * FROM shop_manager a
                 LEFT JOIN authorization b
                        ON a.auth_idx = b.auth_idx
                     WHERE a.id = '{$memberID}'
                  ";
    $member_res = sql_fetch($member_sql);
    $member_authStr = $member_res['auth_menu'];
    $member_authArr = explode(",", $member_authStr);
    
    foreach ($member_authArr as $key => $item) {
      if (strpos($item, $menuName) !== false) {
        $member_auth = explode("||",$member_authArr[$key]);
        if(strstr($member_auth[1], 'r')){
          return $retunHTML;
          break;
        } 
      } else {
        continue;
      }
    }
  }
}

// echo getMenuTab("ADMIN_MENU1", "manager", t1('m10', '회원관리'));
// echo getMenuTab("ADMIN_MENU1_01", "manager", t2('m10', ADMIN_MENU1_01, BV_ADMIN_URL.'/member.php?code=list'));
// echo getMenuTab("ADMIN_MENU1_02", "manager", t2('m10', ADMIN_MENU1_02, BV_ADMIN_URL.'/member.php?code=level_form'));

/* } 테스트  */

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
      <?php
      $TEST = TEST;
      for ($i = 1; $i <= count($TEST); $i++) {
        $key = "TEST{$i}";
      ?>
          <tr class="<?php echo $bg; ?>">
            <td><?php echo $TEST[$key] ?></td>
            <td>			
              <input type="hidden" name="auth_cate[<?php echo $i; ?>]" value="<?php echo $key; ?>">
              <input type="checkbox" name="auth[]" value="<?php echo $i; ?>">
            </td>
          </tr>
      <?php  }
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