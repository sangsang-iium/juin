<?php
if (!defined('_BLUEVATION_')) {
  exit;
}
// 개별 페이지 접근 불가

function reviewImg($index_no) {
  $sql = " SELECT index_no, thumbnail FROM shop_goods_review_img WHERE review_id = '{$index_no}' ORDER BY index_no ASC ";
  $res  = sql_query($sql);
  $reviewImgArr = array();
  while ($reviewRow = sql_fetch_array($res)) {
    $reviewImgArr[] = $reviewRow;
  }

  return $reviewImgArr;
}

function reviewTotalImg($gs_id) {
  // 최대 30개 이미지만 노출 처리 이미지 노출 갯수 변경 가능
  $limit = 30;
  $sql = " SELECT thumbnail FROM shop_goods_review_img WHERE gs_id = '{$gs_id}' ORDER BY index_no DESC ";
  $sql .= " LIMIT {$limit} ";
  $res  = sql_query($sql);
  $reviewImgArr = array();
  while ($reviewRow = sql_fetch_array($res)) {
    $reviewImgArr[] = $reviewRow;
  }

  return $reviewImgArr;
}

function reviewOptionCheck($od_no) {
  $sql = " SELECT * FROM shop_cart WHERE od_no = '{$od_no}' ";
  $res  = sql_fetch($sql);

  $rw = get_order($res['od_no']);
  $gs = unserialize($rw['od_goods']);

  $optionArr = array();
  if($res['ct_option'] != get_text($gs['gname'])){

    $optionArr = explode("/",$res['ct_option']);

  }

  return $optionArr;
}

function reviewGoodOption($index_no) {
  $sql = " SELECT opt_subject FROM shop_goods WHERE index_no = '{$index_no}' ";
  $res  = sql_fetch($sql);

  $optionArr = explode(",",$res['opt_subject']);

  return $optionArr;
}

function reviewImgCheck($review_id, $step) {
  $sql = " SELECT thumbnail FROM shop_goods_review_img WHERE review_id = '{$review_id}' AND step = '{$step}' ";
  $res  = sql_fetch($sql);

  return $res['thumbnail'];
}

function reviewImgDelete($review_id) {
  $sql = " SELECT thumbnail FROM shop_goods_review_img WHERE review_id = '{$review_id}' ";
  $res  = sql_query($sql);
  while ($reviewRow = sql_fetch_array($res)) {
    $upl_dir = BV_DATA_PATH."/review";
    $reviewImgUrl = $upl_dir."/".$reviewRow['thumbnail'];
    unlink($reviewImgUrl);
  }

  $deleteSql = " DELETE FROM shop_goods_review_img WHERE review_id = '{$review_id}' ";
  sql_query($deleteSql);
}

function get_paging_popup($write_pages, $cur_page, $total_page, $url, $add="") {
  if (!$cur_page) $cur_page = 1;
  if (!$total_page) $total_page = 1;
  if ($total_page < 2) return '';

  $url = preg_replace('#(&|\?)page=[0-9]*#', '', $url);
  $url .= (strpos($url, '?') === false ? '?' : '&') . 'page=';

  $str = '';
  if ($cur_page > 1) {
      $str .= "<a href=\"javascript:void(0);\" onclick=\"changePage(1)\" class=\"pg_page pg_start\">처음</a>" . PHP_EOL;
  } else {
      $str .= "<span class=\"pg_start\">처음</span>" . PHP_EOL;
  }

  $start_page = max(1, $cur_page - floor($write_pages / 2));
  $end_page = min($total_page, $start_page + $write_pages - 1);

  if ($end_page - $start_page < $write_pages - 1) {
      $start_page = max(1, $end_page - $write_pages + 1);
  }

  if ($cur_page > 1) {
      $str .= "<a href=\"javascript:void(0);\" onclick=\"changePage(" . ($cur_page - 1) . ")\" class=\"pg_page pg_prev\">이전</a>" . PHP_EOL;
  } else {
      $str .= "<span class=\"pg_prev\">이전</span>" . PHP_EOL;
  }

  if ($total_page > 1) {
      for ($k = $start_page; $k <= $end_page; $k++) {
          if ($cur_page != $k) {
              $str .= "<a href=\"javascript:void(0);\" onclick=\"changePage($k)\" class=\"pg_page\">$k<span class=\"sound_only\">페이지</span></a>" . PHP_EOL;
          } else {
              $str .= "<span class=\"sound_only\">열린</span><strong class=\"pg_current\">$k</strong><span class=\"sound_only\">페이지</span>" . PHP_EOL;
          }
      }
  }

  if ($cur_page < $total_page) {
      $str .= "<a href=\"javascript:void(0);\" onclick=\"changePage(" . ($cur_page + 1) . ")\" class=\"pg_page pg_next\">다음</a>" . PHP_EOL;
  } else {
      $str .= "<span class=\"pg_next\">다음</span>" . PHP_EOL;
  }

  if ($cur_page < $total_page) {
      $str .= "<a href=\"javascript:void(0);\" onclick=\"changePage($total_page)\" class=\"pg_page pg_end\">맨끝</a>" . PHP_EOL;
  } else {
      $str .= "<span class=\"pg_end\">맨끝</span>" . PHP_EOL;
  }

  return "<nav class=\"pg_wrap\"><span class=\"pg\">{$str}</span></nav>";
}

// 회원 등급 정보
function memberGradeList(){
  $sql = " SELECT gb_no, gb_name FROM shop_member_grade WHERE gb_no != 1 AND gb_name !='' ";
  $res  = sql_query($sql);
  $memberGradeArr = array();
  while ($row = sql_fetch_array($res)) {
    $memberGradeArr[] = $row;
  }

  return $memberGradeArr;

}

// 메인 화면 라이브존 리스트
function mainLiveList() {
  $sql = " SELECT * FROM shop_goods_live ";

  $res  = sql_query($sql);
  $liveListArr = array();
  $i = 0;
  while ($row = sql_fetch_array($res)) {
    $liveListArr[$i] = $row;
    $liveListArr[$i]['live'] = json_decode($row['live_time'],true);
    $i ++;
  }

  return $liveListArr;
}


// 메인화면 라이브존 시간 표시
function liveTime($liveTime, $liveDate) {
  $currentDate = time();

  $liveDayMap = ['sun' => 0, 'mon' => 1, 'tues' => 2, 'wednes' => 3, 'thurs' => 4, 'fri' => 5, 'satur' => 6];
  $currentDayOfWeek = date('w', $currentDate);
  $liveDayOfWeek = $liveDayMap[$liveDate];

  $dayDiff = $currentDayOfWeek - $liveDayOfWeek;
  if ($dayDiff < 0) {
      $dayDiff += 7;
  }

  $liveDate = strtotime("-{$dayDiff} days", $currentDate);

  $timeHour = (int)substr($liveTime, 0, 2);
  $timeMinute = substr($liveTime, 3, 2);

  $ampm = ($timeHour < 12) ? "오전" : "오후";

  if ($timeHour >= 1 && $timeHour < 12) {
      $liveStartTime = $timeHour . ':' . $timeMinute;
  } elseif ($timeHour >= 12) {
      if ($timeHour > 12) {
          $liveStartTime = ($timeHour - 12) . ':' . $timeMinute;
      } else {
          $liveStartTime = $timeHour . ':' . $timeMinute;
      }
  } else {
      $liveStartTime = $timeHour . ':' . $timeMinute;
  }

  return date('m/d', $liveDate) . " " . $ampm . " " . $liveStartTime;
}

function ymdhisToYmd($date) {
  if(!$date) {
    return '';
  } else {
    return date('Y-m-d',strtotime($date));
  }
}

function ymdhisToHi($date) {
  if(!$date) {
    return '';
  } else {
    return date('H:i',strtotime($date));
  }
}

function ymdhisToYmdhi($date) {
  if(!$date) {
    return '';
  } else {
    return date('Y-m-d H:i',strtotime($date));
  }
}

function raffleEventDate($raffle_index) {
  $sql = " SELECT event_start_date, event_end_date FROM shop_goods_raffle WHERE index_no = '$raffle_index' ";
  $res = sql_fetch($sql);

  $eventDateArr = array();
  $eventDateArr['event_start_date'] = date('Y.m.d',strtotime($res['event_start_date']));
  $eventDateArr['event_end_date'] = date('Y.m.d',strtotime($res['event_end_date']));

  return $eventDateArr;
}


function get_raffle_ahead($it_img, $it_img_del)
{
	if(!trim($it_img)) return;

	if(preg_match("/^(http[s]?:\/\/)/", $it_img) == true)
		$file_url = $it_img;
	else
		$file_url = BV_DATA_URL."/raffle/".$it_img;

	$str  = "<a href='{$file_url}' target='_blank' class='btn_small bx-white marr7'>미리보기</a> <label class='marr7'><input type='checkbox' name='{$it_img_del}' value='{$it_img}'>삭제</label>";

	return $str;
}


function get_raffle_detail_ahead($it_img)
{
	if(!trim($it_img)) return;

	if(preg_match("/^(http[s]?:\/\/)/", $it_img) == true)
		$file_url = $it_img;
	else
		$file_url = BV_DATA_URL."/raffle/".$it_img;

	$str  = "<a href='{$file_url}' target='_blank' class='btn_small bx-white marr7'>미리보기</a> <label class='marr7'>";

	return $str;
}


function raffleWinnerNumber($index_no) {
  $sql = " SELECT count(*) as cnt FROM shop_goods_raffle_log WHERE raffle_index = '$index_no' ";
  $res = sql_fetch($sql);
  $winnerNumber = $res['cnt'];

  return $winnerNumber;
}


function raffleList() {
  $nowDate = date('Y-m-d H:i:s');
  $sql = " SELECT * FROM shop_goods_raffle WHERE event_start_date <= '$nowDate' AND event_end_date >= '$nowDate' ";
  $res  = sql_query($sql);
  $list = array();
  while ($rows = sql_fetch_array($res)) {
    $list[] = $rows;
  }

  return $list;
}

function raffleEndList() {
  $nowDate = date('Y-m-d H:i:s');
  $sql = " SELECT * FROM shop_goods_raffle WHERE event_end_date <= '$nowDate' ";
  $res  = sql_query($sql);
  $list = array();
  while ($rows = sql_fetch_array($res)) {
    $list[] = $rows;
  }

  return $list;
}

function raffleDetail($index_no) {
  $sql = " SELECT * FROM shop_goods_raffle WHERE index_no = '$index_no' ";
  $res = sql_fetch($sql);

  return $res;
}

function get_raffle_img($it_img)
{
	if(!trim($it_img)) return;

	if(preg_match("/^(http[s]?:\/\/)/", $it_img) == true)
		$file_url = $it_img;
	else
		$file_url = BV_DATA_URL."/raffle/".$it_img;

	$str  = "<img src=\"".$file_url."\" alt=\"\">";

	return $str;
}

function get_raffle_detail_img($it_img)
{
	if(!trim($it_img)) return;

	if(preg_match("/^(http[s]?:\/\/)/", $it_img) == true)
		$file_url = $it_img;
	else
		$file_url = BV_DATA_URL."/raffle/".$it_img;

	$str  = "<img src=\"".$file_url."\" class=\"fitCover\" alt=\"\">";

	return $str;
}

function raffleEntryCheck($index_no,$entry,$entry_number) {
  $raffleLimit = false;
  if($entry == 0) {
    $nowNum = raffleWinnerNumber($index_no);
    $limitNum = $entry_number;
    if($limitNum >= $nowNum) {
      $raffleLimit = true;
    }
  } else {
    // else 추가 _20240805_SY
    $raffleLimit = true;
  }

  return $raffleLimit;
}

function rafflePrizeCheck($index_no) {
  global $member;
  if($member['id']) {
    $sql = " SELECT count(*) as cnt FROM shop_goods_raffle_log WHERE raffle_index = '$index_no' AND mb_id = '{$member['id']}' ";
    $res = sql_fetch($sql);
    if($res['cnt'] > 0) {
      $check = false;
    } else {
      $check = true;
    }
  } else {
    $check = true;
  }

  return $check;
}


function get_raffle_list_img($it_img)
{
	if(!trim($it_img)) return;

	if(preg_match("/^(http[s]?:\/\/)/", $it_img) == true)
		$file_url = $it_img;
	else
		$file_url = BV_DATA_URL."/raffle/".$it_img;

	$str  = "<img src=\"".$file_url."\" alt=\"\" style=\"width:140px;height:140px;\">";

	return $str;
}

function raffleEventDateCheck($event_end_date,$prize_date) {
  $raffleEndCheck = 0;
  $nowDate = new DateTime();
  $eventEndDate = new DateTime($event_end_date);
  $prizeEndDate = new DateTime($prize_date);
  if($nowDate < $eventEndDate) {
    $raffleEndCheck = 1;
  } else if($nowDate >= $eventEndDate && $nowDate < $prizeEndDate) {
    $raffleEndCheck = 2;
  } else if($nowDate >= $prizeEndDate) {
    $raffleEndCheck = 3;
  }

  return $raffleEndCheck;
}

function get_raffle_img_src($it_img) {

	if(preg_match("/^(http[s]?:\/\/)/", $it_img) == true)
		$file_url = $it_img;
	else
		$file_url = BV_DATA_URL."/raffle/".$it_img;

	// $str  = "<img src=\"".$file_url."\" alt=\"\" style=\"width:140px;height:140px;\">";

	return $file_url;
}

function getRaffleLogIdxno($index_no) {
  global $member;

  $sql = " SELECT index_no FROM shop_goods_raffle_log WHERE raffle_index = '$index_no' AND mb_id = '{$member['id']}' ";
  $res  = sql_fetch($sql);

  return $res['index_no'];
}

function raffleOrder($raffle_index, $index_no) {
  $sql = " UPDATE shop_goods_raffle_log SET `order` = 'Y' WHERE raffle_index = '$raffle_index' AND index_no = '$index_no' ";
  sql_query($sql);
}


// 고객이 주문/배송조회를 위해 보관해 둔다.
function raffle_save_goods_data($gs_id, $odrno, $od_id, $shop_table = "shop_order")
{
	if(!$gs_id || !$odrno || !$od_id)
		return;

  $gs_id = preg_replace('/000000$/', '', $gs_id);

	$sql = " select * from shop_goods_raffle where index_no = '$gs_id' ";
	$cp = sql_fetch($sql);

	$data = serialize($cp);

	// 상품정보를 주문서에 업데이트한다.
	$sql = " update {$shop_table} set od_goods = '$data' where index_no = '$odrno' ";
	sql_query($sql);

	$ymd_dir = BV_DATA_PATH.'/order/'.date('ym', time());
	$upl_dir = $ymd_dir.'/'.$od_id; // 저장될 위치

	// 년도별로 따로 저장
	if(!is_dir($ymd_dir)) {
		@mkdir($ymd_dir, BV_DIR_PERMISSION);
		@chmod($ymd_dir, BV_DIR_PERMISSION);
	}

	// 주문번호별로 따로 저장
	if(!is_dir($upl_dir)) {
		@mkdir($upl_dir, BV_DIR_PERMISSION);
		@chmod($upl_dir, BV_DIR_PERMISSION);
	}

	if(preg_match("/^(http[s]?:\/\/)/", $cp['simg1']) == false)
	{
		$file = BV_DATA_URL.'/raffle/'.$cp['simg1'];
		if(is_file($file) && $cp['simg1']) {
			$file_url = $upl_dir.'/'.$cp['simg1'];
			@copy($file, $file_url);
			@chmod($file_url, BV_FILE_PERMISSION);
		}
	}
}


function orderRaffleCheck($od_id) {
  $sql = " SELECT raffle FROM shop_cart WHERE od_id = '$od_id' ";
  $res = sql_fetch($sql);
  if($res['raffle'] == 1) {
    return true;
  } else {
    return false;
  }
}

function orderRaffleImg($it_img) {

  if(!trim($it_img)) return;

	if(preg_match("/^(http[s]?:\/\/)/", $it_img) == true)
		$file_url = $it_img;
	else
		$file_url = BV_DATA_URL."/raffle/".$it_img;

	$str  = "<img src=\"".$file_url."\" width=\"30\" height=\"30\">";

	return $str;
}


function allSearchSql($columns , $stx) {
  $i = 0;
  $sql = " AND (";
  foreach ($columns as $columnVal) {
    if($i != 0) $sql .= " OR ";
    $sql .= " INSTR( LOWER($columnVal) , LOWER('$stx') ) ";
    $i++;
  }

  $sql .= ") ";

  return $sql;
}

// $etc 추가 _20240801_SY
function allSearchSqlArr($columns , $stx, $etc="") {
  $i = 0;
  $sql = " (";
  foreach ($columns as $columnVal) {
    if($i != 0) $sql .= " OR ";
    $sql .= " INSTR( LOWER($columnVal) , LOWER('$stx') ) ";
    $i++;
  }

  $sql .= $etc;

  $sql .= ") ";

  return $sql;
}




/* ------------------------------------------------------------------------------------- _20240714_SY
  * 관리자 INDEX 데이터 연동 작업
/* ------------------------------------------------------------------------------------- */

function getIndexDataFunc($table, $orderBy='wdate') {
  $data = array();

  $sel = " SELECT * FROM {$table} ORDER BY {$orderBy} DESC LIMIT 5 ";
  $res = sql_query($sel);
  $cnt = sql_num_rows($res);


  if($cnt > 0 ) {
    while ($row = sql_fetch_array($res)) {
      $data[] = $row;
    }
  } else {
    $data = "";
  }

  return $data;
}


function getNewGoodsFunc() {
  $data = array();

  $sel = " SELECT * FROM shop_goods ORDER BY reg_time DESC LIMIT 5 ";
  $res = sql_query($sel);
  $cnt = sql_num_rows($res);


  if($cnt > 0 ) {
    while ($row = sql_fetch_array($res)) {
      $data[] = $row;
    }
  } else {
    $data = "";
  }

  return $data;
}

function maskingText($text, $maxLength) {
  if (mb_strlen($text) > $maxLength) {
      return mb_substr($text, 0, $maxLength) . '...';
  }
  return $text;
}



/**
 * *지회 지부 데이터 Function
 * Parameter
 * @param string $managerInfo managerID
 * @param string $alias       mn.ju_manager 정보
 */
function getBelongList($managerInfo, $alias, $addWhere="") {

  $sql_search = "";

  $mn_sel = " SELECT * FROM shop_manager WHERE id = '{$managerInfo}' ";
  $mn_row = sql_fetch($mn_sel);

  $andQuery = "";
  $office_chk_sel = " SELECT COUNT(*) as cnt FROM kfia_branch WHERE branch_code = '{$mn_row['ju_region3']}' ";
  $office_chk_res = sql_fetch($office_chk_sel);
  if($office_chk_res['cnt'] < 1) {
    $andQuery = " AND ju_region3 = '{$mn_row['ju_region3']}' ";
  } 


  if($mn_row['grade'] < 3) {
    $b_master_sql = " SELECT index_no, id, `name`, grade, ju_region1, ju_region2, ju_region3
                        FROM shop_manager
                        WHERE ju_region2 = '{$mn_row['ju_region2']}'
                        {$andQuery}
                        {$addWhere}
                          AND grade > {$mn_row['grade']}
                    ";
    $b_master_res = sql_query($b_master_sql);
    $addIn = "";
    while($b_master_row = sql_fetch_array($b_master_res)) {
      $addIn .= ", '" . $b_master_row['index_no'] . "'";
    }
    $sql_search .= " AND {$alias} IN ('{$mn_row['index_no']}' $addIn ) ";
  } else {
    $sql_search .= " AND {$alias} = '{$mn_row['index_no']}' ";
  }

  return $sql_search;
}



/**
 * *외식가족 공제회 직원 및 admin 용 통계 Function
 * Parameter
 * @param string $branch    branch_code
 * @param string $office    office_code
 * @param string $addQuery  추가 WHERE절
 */
function forStatisticsFunc($branch, $office, $addQuery="") {

  $sql_search = "";

  $andQuery = "";
  if(!empty($branch)) {
    $andQuery .= " AND ju_region2 = '{$branch}' ";
  }
  if(!empty($office)) {
    $office_chk_sel = " SELECT COUNT(*) as cnt FROM kfia_branch WHERE branch_code = '{$office}' ";
    $office_chk_res = sql_fetch($office_chk_sel);
    // if($office_chk_res['cnt'] < 1) {
      $andQuery .= " AND ju_region3 = '{$office}' ";
    // }
  }
    $b_master_sql = " SELECT index_no, id, `name`, grade, ju_region1, ju_region2, ju_region3
                        FROM shop_manager
                        WHERE (1)
                        AND grade > 1
                        {$andQuery}
                        {$addQuery}
                    ";
    $b_master_res = sql_query($b_master_sql);
    $addIn = "";
    while($b_master_row = sql_fetch_array($b_master_res)) {
      $values[] = "'" . $b_master_row['index_no'] . "'";
    }
    if (!empty($values)) {
      $addIn = implode(", ", $values);
      $sql_search .= " AND ju_manager IN ( $addIn ) ";
    } 
  

  return $sql_search;
}


/** Grade SELECT Custom _20240723_SY */
function getLevelCustomFunc($grade="", $selected="") {
  $grade_str = "";
  $opt = ""; 
  if(!empty($grade)) {
    $opt .= " AND gb_no >= '$grade' ";
  }
  $grade_sel = " SELECT * FROM shop_member_grade WHERE gb_name <> '' {$opt} ORDER BY gb_no DESC ";
  $grade_res = sql_query($grade_sel);
  for($i=0; $grade_row=sql_fetch_array($grade_res); $i++)
    {
      $grade_str .= "<option value='{$grade_row['gb_no']}'";
      if($grade_row['gb_no'] == $selected)
			$grade_str .= " selected";
      $grade_str .= ">{$grade_row['gb_name']}</option>\n";
    }

  return $grade_str;
}


/** 주문관리 판매자 이름 _20240725_SY */
function get_order_seller_name($seller_id)
{
	if($seller_id == 'admin') {
		$disp_sr_id = '본사';
	} else if(substr($seller_id,0,3) == 'AP-') {
		$sr = get_seller_cd($seller_id);
		$disp_sr_id = get_sideview($sr['mb_id'], $sr['company_name']);
	} else {
		$disp_sr_id = get_sideview($seller_id, $seller_id);
	}

	return $disp_sr_id;
}


/** mng 장바구니 숫자 _20240725_SY */
function get_cart_count_for_mng($mb_id)
{
	global $set_cart_id;

	$sql = " SELECT * FROM shop_cart WHERE ct_direct='$set_cart_id' AND ct_select='0' AND mb_id = '{$mb_id}' GROUP BY gs_id ";
	$result = sql_query($sql);
	$cart_count = sql_num_rows($result);

	return (int)$cart_count;
}


/** 가입 통계 _20240805_SY */
function reg_statistics($add) {
  $sql = " SELECT 
              (SELECT kb.branch_code
                 FROM kfia_branch kb
                WHERE kb.branch_code = sm.ju_region2) AS branch,
              (SELECT ko.office_code 
                 FROM kfia_office ko 
                WHERE ko.office_code = sm.ju_region3) AS office,
                  COUNT(*) AS total,
                  COUNT(CASE WHEN sm.grade = 6 THEN 1 END) AS six,
                  COUNT(CASE WHEN sm.grade = 8 THEN 1 END) AS eight,
                  COUNT(CASE WHEN sm.grade = 9 THEN 1 END) AS nine,
                  COUNT(CASE WHEN sm.mb_agent = 'Windows' THEN 1 ELSE NULL END) AS web,
                  COUNT(CASE WHEN sm.mb_agent <> 'Windows' AND sm.mb_agent IS NOT NULL THEN 1 ELSE NULL END) AS app,
                  COUNT(CASE WHEN sm.mb_agent IS NULL THEN 1 ELSE NULL END) AS `undefined`,
                  COUNT(CASE WHEN sm.login_sum > 0 THEN 1 ELSE NULL END) AS `install`,
                  COUNT(CASE WHEN sm.login_sum = 0 THEN 1 ELSE NULL END) AS `uninstall`,
                  COUNT(CASE WHEN sm.ju_closed = '02' THEN 1 ELSE NULL END) AS `closing`,
                  COUNT(CASE WHEN sm.ju_closed = '03' THEN 1 ELSE NULL END) AS `closed`
             FROM shop_member sm 
            WHERE grade >= 6
              {$add}
         GROUP BY ju_region3 
         ORDER BY ju_region3 ";
  $res = sql_query($sql);

  $data['total_count']     = 0;
  $data['six_count']       = 0;
  $data['eight_count']     = 0;
  $data['nine_count']      = 0;
  $data['web_count']       = 0;
  $data['app_count']       = 0;
  $data['install_count']   = 0;
  $data['uninstall_count'] = 0;
  $data['closing_count']   = 0;
  $data['closed_count']    = 0;

  while($row = sql_fetch_array($res)) {
    $data['total_count']     += $row['total'];
    $data['six_count']       += $row['six'];
    $data['eight_count']     += $row['eight'];
    $data['nine_count']      += $row['nine'];
    $data['web_count']       += $row['web'];
    $data['app_count']       += $row['app'];
    $data['install_count']   += $row['install'];
    $data['uninstall_count'] += $row['uninstall'];
    $data['closing_count']   += $row['closing'];
    $data['closed_count']    += $row['closed'];
  }

  return $data;
}