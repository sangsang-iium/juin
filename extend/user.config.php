<?php
if (!defined('_BLUEVATION_')) {
  exit;
}
// 개별 페이지 접근 불가
class CallApi {

  private $apiKey;
  private $apiKeyName = 'serviceKey';

/**
 * 키 설정
 * @param stirng $apiKey 사용할 키
 */
  public function setApiKey($apiKey) {
    $this->apiKey = $apiKey;
  }

  /**
   * 키 이름 설정
   * @param stirng $apiKeyName 사용할 키 이름
   */
  public function setApiKeyName($apiKeyName) {
    $this->apiKeyParamName = $apiKeyName;
  }

  /**
   * 데이터 바인딩
   * @param array $params get 또는 post 사용될 데이터
   */
  public function buildQueryParams($params) {
    if (!empty($this->apiKey) && !isset($params[$this->apiKeyParamName])) {
      $params[$this->apiKeyParamName] = $this->apiKey;
    }

    return http_build_query($params);
  }

  /**
   * 옵션 설정
   * @param  string $method      get, post
   * @param  string $url         endpoint 주소
   * @param  array  $queryParams body 값
   * @param  array  $headers     헤더 정보
   * @return array  curl 옵션의 전체 정보
   */
  public function buildCurlOptions($method, $url, $queryParams, $headers = []) {
    $options = [
      CURLOPT_URL            => $url . '?' . $queryParams,
      CURLOPT_RETURNTRANSFER => true,
    ];

    if ($method == "POST") {
      $options[CURLOPT_CUSTOMREQUEST] = 'POST';
      $options[CURLOPT_POSTFIELDS]    = $queryParams;
    }

    // 추가적인 헤더 설정
    if (!empty($headers)) {
      $options[CURLOPT_HTTPHEADER] = $headers;
    }

    return $options;
  }

  /**
   * 재시도하는거
   * @param  array  $ch          api 실행
   * @param  string $maxWaitTime 시간 (초)
   * @param  array  $queryParams body 값
   * @param  array  $headers     헤더 정보
   * @return array  curl 옵션의 전체 정보
   */
  public function executeCurlWithRetry($ch, $maxWaitTime = 30) {
    $startTime = time();

    do {
      $response  = curl_exec($ch);
      $error     = curl_error($ch);
      $errorCode = curl_errno($ch);
      $info      = curl_getinfo($ch);

      if ($response !== false || $info['http_code'] != 0) {
        break;
      }

      sleep(1);
    } while (time() - $startTime < $maxWaitTime);

    if ($error || $errorCode !== 0) {
      $response = ($error) ? $error : "CURL Error: $errorCode";
    }

    return $response;
  }

  public function getApi($url, $params, $headers = []) {
    $queryParams = $this->buildQueryParams($params);
    $ch          = curl_init();
    $options     = $this->buildCurlOptions("GET", $url, $queryParams, $headers);

    curl_setopt_array($ch, $options);

    return $ch;
  }

  public function postApi($url, $params, $headers = []) {
    $queryParams = $this->buildQueryParams($params);
    $ch          = curl_init();
    $options     = $this->buildCurlOptions("POST", $url, $queryParams, $headers);

    // 추가적인 POST 설정이 필요하다면 여기에 추가

    curl_setopt_array($ch, $options);

    return $ch;
  }

  public function runApi($method, $url, $params, $headers = []) {
    if ($method == "GET") {
      $ch = $this->getApi($url, $params, $headers);
    } else if ($method == "POST") {
      $ch = $this->postApi($url, $params, $headers);
    } else {
      $ch = $this->postApi($url, $params, $headers);
    }

    $response = $this->executeCurlWithRetry($ch);

    curl_close($ch);

    return $response;
  }
}

class Common_Model {
  public static function set($db_input) {
    $set = "";
    end($db_input);
    $last_key = key($db_input);

    foreach ($db_input as $k => $v) {
      $v = str_replace('"', "'", $v);
      if ($k == $last_key) {
        $set .= $k . '= "' . $v . '"';
      } else {
        $set .= $k . '= "' . $v . '",';
      }
    }

    return $set;
  }
}

class IUD_Model extends Common_Model {
  public static function delete($table, $where) {
    $sql = "DELETE FROM {$table} {$where}";

    return sql_query($sql, true);

    // return $sql;
  }

  public static function insert($table, $db_input) {

    $set = Common_Model::set($db_input);
    $sql = "INSERT INTO {$table} SET {$set}";

    sql_query($sql, true);

    $idx = sql_insert_id();

    return $idx;
  }

  public static function update($table, $db_input, $where) {

    $set = Common_Model::set($db_input);
    $sql = "UPDATE {$table} SET {$set} {$where}";

    return sql_query($sql);
  }
}

function shuffle2() {
  $chars_array = array_merge(range(0, 9), range('a', 'z'), range('A', 'Z'));
  shuffle($chars_array);
  $shuffle = implode('', $chars_array);

  return $shuffle;
}

function category_depth($depth, $upcate = "") {
  if (!$depth) {
    return false;
  }
  $catecodeLength = 3 * $depth;
  $AND            = $depth > 1 ? "AND upcate = '{$upcate}'" : "";

  $sql_chk = "SELECT * FROM shop_category WHERE catecode = '{$upcate}' ORDER BY caterank asc";
  $res_chk = sql_query($sql_chk);

  $sql    = "SELECT * FROM shop_category WHERE LENGTH(catecode) = {$catecodeLength} {$AND} ORDER BY caterank asc";
  $res    = sql_query($sql);
  $maxRow = sql_num_rows($res);

  if ($maxRow > 0) {
    for ($i = 0; $row = sql_fetch_array($res); $i++) {
      $html      = "";
      $html_head = "";
      if ($depth == 1) {
        if ($i == 0) {
          $html .= "<li data-d1='{$row['catecode']}' class='active'>{$row['catename']}</li>";
        } else {
          $html .= "<li data-d1='{$row['catecode']}' class=''>{$row['catename']}</li>";
        }
      } else {
        $sql2 = "SELECT * FROM shop_category WHERE catecode = '{$upcate}'";
        $row2 = sql_fetch($sql2);
        if ($i == 0) {
          $html_head .= "<a href='/m/shop/list.php?ca_id={$upcate}'>";
          $html_head .= "  <span class='ic'><img src='/data/category/{$row2['cateimg1']}' alt=''></span>";
          $html_head .= "  <span>{$row2['catename']}</span>";
          $html_head .= "  <span class='ic-right'><img src='/src/img/ct-dep2-right.png' alt=''></span>";
          $html_head .= "</a>";
          $html .= "<li><a href='/m/shop/list.php?ca_id={$row['catecode']}'>{$row['catename']}</a></li>";
        } else {
          $html .= "<li><a href='/m/shop/list.php?ca_id={$row['catecode']}'>{$row['catename']}</a></li>";
        }
      }
      $htmlArr[]     = $html;
      $htmlHeadArr[] = $html_head;
      $cateArr[]     = $row['catecode'];
      $cateNameArr[] = $row['catename'];
      $cateImg[]     = $row['cateimg1'];
      $cateArrUp[]   = $row['upcate'];
    }
  } else {
    for ($j = 0; $row2 = sql_fetch_array($res_chk); $j++) {
      $html      = "";
      $html_head = "";

      if ($j == 0) {
        $html_head .= "<a href='/m/shop/list.php?ca_id={$upcate}'>";
        $html_head .= "  <span class='ic'><img src='/data/category/{$row2['cateimg1']}' alt=''></span>";
        $html_head .= "  <span>{$row2['catename']}</span>";
        $html_head .= "  <span class='ic-right'><img src='/src/img/ct-dep2-right.png' alt=''></span>";
        $html_head .= "</a>";
        $html .= "<li><a href='/m/shop/list.php?ca_id={$row2['catecode']}'>{$row2['catename']}</a></li>";
      } else {
        $sql2 = "SELECT * FROM shop_category WHERE catecode = '{$upcate}'";
        $row2 = sql_fetch($sql2);
        $html .= "<li><a href='/m/shop/list.php?ca_id={$row2['catecode']}'>{$row2['catename']}</a></li>";
      }
      $htmlArr[]     = $html;
      $htmlHeadArr[] = $html_head;
      $cateArr[]     = $row['catecode'];
      $cateNameArr[] = $row['catename'];
      $cateImg[]     = $row['cateimg1'];
      $cateArrUp[]   = $row['upcate'];
    }

  }
  $data = array(
    'cateArr'     => $cateArr,
    'cateArrUp'   => $cateArrUp,
    'cateNameArr' => $cateNameArr,
    'cateImg'     => $cateImg,
    'html'        => $htmlArr,
    'html_head'   => $htmlHeadArr,
  );

  return $data;
}

// 토스 자동결제(빌링)
class Tosspay {
  private $auth = "test_sk_DpexMgkW36ZvQYYo5Rx93GbR5ozO";

  function __construct() {
    $this->uid = uniqid();
  }

  /**
   * 카드 등록을 요청합니다.
   *
   * @param  string   $customerKey   고객키
   * @param  string   $amount        결제 금액 (구분자 없음)
   * @param  string   $orderId       주문번호(솔루션 코드)
   * @param  string   $orderName     주문자
   * @param  string   $taxFreeAmount 과세 구분 (기본값은 0)
   * @param  string   $name          고객 이름
   * @param  string   $email         고객 이메일
   * @return stdClass API 응답
   */
  function autoPay($customerKey, $amount, $orderId, $orderName, $taxFreeAmount, $name, $email, $billingKey) {
    $url  = 'https://api.tosspayments.com/v1/billing/' . $billingKey;
    $data = array(
      'customerKey'        => $customerKey,
      'amount'             => $amount,
      'orderId'            => $orderId,
      'orderName'          => $orderName,
      'taxFreeAmount'      => $taxFreeAmount,
      'taxExemptionAmount' => 0,
      'customerName'       => $name,
      'customerEmail'      => $email,
    );

    return $this->callApi($url, $data);
  }

  /**
   * 결제 취소
   *
   * @param  string   $paymentKey   결제 키
   * @param  string   $cancelReason 취소 사유
   * @param  string   $cancelAmount 빈값은 전체 취소 값이 있으면 부분 취소
   * @return stdClass API 응답
   */
  function cancel($paymentKey, $cancelReason) {
    $url  = "https://api.tosspayments.com/v1/payments/{$paymentKey}/cancel";
    $data = array(
      'cancelReason' => $cancelReason,
    );

    return $this->callApi($url, $data);
  }

  /**
   * 빌링키 발급.
   *
   * @param  string   $authKey     결제 키
   * @param  string   $customerKey 고객 키
   * @param  string   $credential  고객 키
   * @return stdClass API 응답
   */
  function issueBillingKey($authKey, $customerKey, $credential) {
    $url  = 'https://api.tosspayments.com/v1/billing/authorizations/issue';
    $data = array(
      'authKey'     => $authKey,
      'customerKey' => $customerKey,
    );

    return $this->callApi($url, $data, $credential);
  }

  /**
   * API를 호출합니다.
   *
   * @param  string   $url  API 엔드포인트 URL
   * @param  array    $data 전송할 데이터
   * @return stdClass API 응답
   */
  private function callApi($url, $data, $credential = "") {
    if (empty($credential)) {
      $credential = base64_encode($this->auth . ':');
    } else {
      $credential = base64_encode($credential . ':');
    }
    $curlHandle = curl_init($url);
    curl_setopt_array($curlHandle, [
      CURLOPT_POST           => TRUE,
      CURLOPT_RETURNTRANSFER => TRUE,
      CURLOPT_HTTPHEADER     => [
        'Authorization: Basic ' . $credential,
        'Content-Type: application/json',
      ],
      CURLOPT_POSTFIELDS     => json_encode($data),
    ]);
    $response = curl_exec($curlHandle);
    $err      = curl_error($curlHandle);
    curl_close($curlHandle);

    if ($err) {
      return json_decode($err); // 요청 실패
    } else {
      return json_decode($response); // 요청 성공
    }
  }
}

/**
 * 지회 지부
 *
 * @param  string   $depth  1차댑스
 * @param  string   $depth2 2차댑스
 * @return array    뎁스 정보
 */
function juinGroupInfo($depth, $depth2 = ''){
  switch ($depth) {
    case '1':
      $sql = "SELECT kf_region2 AS region, COUNT(kf_region2) FROM kfia_region
              GROUP BY kf_region2";
      break;
    case '2':
      $sql = "SELECT kf_region3 AS region, COUNT(kf_region3) FROM kfia_region
              WHERE kf_region2 = '{$depth2}'
              GROUP BY kf_region3";
      break;

  }
  $res = sql_query($sql);
  $data = array();
  while ($row = sql_fetch_array($res)) {
    $data[] = $row;
  }

  return $data;
}