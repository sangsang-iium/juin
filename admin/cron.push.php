<?php
include_once "/home/juin/www/common.php";
error_reporting(E_ALL);
ini_set("display_errors", 1);

// 쿠폰 만료 푸시 _20240704_SY

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
  $fcm_token    = $unUsedCoupon_row['fcm_token'];

  // 테스트용 토큰
  // $fcm_token = "dSkWHH6bQ5eq5YWrDuTENF:APA91bF_KsOmrAV_RQv8Q4ajRJdFYFHxRu64Bb-eBoZzdzsAOK2Hlt-sotlNC0CO10GbX5Z7QkZW4adsdAL0B5lptT72syieIQGZ7V_WcfG05gLaOvyjY69OLPp3tnT7Cm8UXG9GKQdG";

  if($cp_inv_type == '1' ||  $expiry_date != '9999999999'){
  
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