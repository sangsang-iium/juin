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
  switch (date('w')) {
    case '1': $nowW = 'mon'; break;
    case '2': $nowW = 'tues'; break;
    case '3': $nowW = 'wednes'; break;
    case '4': $nowW = 'thurs'; break;
    case '5': $nowW = 'fri'; break;
    case '6': $nowW = 'satur'; break;
    case '0': $nowW = 'sun'; break;
  }

  $nowTime = date('H:i:s');

  $sql = "SELECT *
  FROM shop_goods_live
  WHERE JSON_CONTAINS(live_time, JSON_OBJECT('live_date', '{$nowW}'))
    AND (
      (
        TIME(JSON_UNQUOTE(JSON_EXTRACT(live_time, '$[0].live_start_time'))) <= '{$nowTime}'
        AND TIME(JSON_UNQUOTE(JSON_EXTRACT(live_time, '$[0].live_end_time'))) > '{$nowTime}'
      )
      OR
      (
        TIME(JSON_UNQUOTE(JSON_EXTRACT(live_time, '$[1].live_start_time'))) <= '{$nowTime}'
        AND TIME(JSON_UNQUOTE(JSON_EXTRACT(live_time, '$[1].live_end_time'))) > '{$nowTime}'
      )
      OR
      (
        TIME(JSON_UNQUOTE(JSON_EXTRACT(live_time, '$[2].live_start_time'))) <= '{$nowTime}'
        AND TIME(JSON_UNQUOTE(JSON_EXTRACT(live_time, '$[2].live_end_time'))) > '{$nowTime}'
      )
    );";

    $res  = sql_query($sql);
    $liveListArr = array();
    while ($row = sql_fetch_array($res)) {
      $liveTimeArr = json_decode($row['live_time'],true);
      $liveTime = array_filter($liveTimeArr, function($item) {
        return $item['live_date'] === 'mon';
      });
      $row['liveTime'] = array_values($liveTime)[0];
      $liveListArr[] = $row;
    }

    return $liveListArr;
}

// 메인화면 라이브존 시간 표시
function liveTime($liveTime) {
  $liveStartTime = "";
  $timeHour = intval(date('H', strtotime($liveTime)));
  $ampm = ($timeHour < 12) ? "오전" : "오후";
  
  if ($timeHour >= 1 && $timeHour < 12) {
    $liveStartTime = date('h:i', strtotime($liveTime));
  } elseif ($timeHour >= 12) {
      if ($timeHour > 12) {
          $liveStartTime = date('g:i', strtotime($liveTime));
      } else {
          $liveStartTime = date('h:i', strtotime($liveTime));
      }
  } else {
      $liveStartTime = date('H:i', strtotime($liveTime));
  }

  return date('m/d')." ".$ampm." ".$liveStartTime;
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