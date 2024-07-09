<?php

function encryptSin($input) {
  // UTF-8 인코딩된 문자열을 EUC-KR로 변환
  $input = iconv("UTF-8", "EUC-KR", $input);

  // 테스트 시 key, iv 는 0 으로 채움
  $key = str_repeat(chr(0), 16 * 2);
  $iv  = str_repeat(chr(0), 16);

  // OpenSSL을 사용하여 AES/CBC/PKCS5Padding 방식으로 암호화
  $cipher    = "aes-256-cbc";
  $encrypted = openssl_encrypt($input, $cipher, $key, OPENSSL_RAW_DATA, $iv);

  // BAS64 인코딩
  $base64 = base64_encode($encrypted);

  // get 전송을 위한 URL 인코딩
  $output = urlencode($base64);

  return $output;
}

function decryptSin($input) {
  // get 수신 후 URL 디코딩
  $base64 = urldecode($input);

  // BAS64 디코딩
  $enc = base64_decode($base64);

  // 테스트 시 key, iv 는 0 으로 채움
  $key = str_repeat(chr(0), 16 * 2);
  $iv  = str_repeat(chr(0), 16);

  // OpenSSL을 사용하여 AES/CBC/PKCS5Padding 방식으로 복호화
  $cipher    = "aes-256-cbc";
  $decrypted = openssl_decrypt($enc, $cipher, $key, OPENSSL_RAW_DATA, $iv);

  // 수신받은 첫번째 블럭은 버림
  $output = substr($decrypted, 16);

  // EUC-KR 인코딩을 UTF-8로 변환
  $output = iconv("EUC-KR", "UTF-8", $output);

  return $output;
}