<?php
include_once "./_common.php";

// $sql = "SELECT * FROM shop_member a
//         left JOIN (SELECT * FROM shop_coupon_log WHERE cp_id = 2 GROUP BY mb_id )b ON ( a.id = b.mb_id )
//         WHERE b.mb_id IS null";

// $res = sql_query($sql);

for ($i = 0; $row = sql_fetch_array($res); $i++) {
  // $data['mb_id']           = $row['id'];
  // $data['mb_name']         = $row['mb_name'];
  // $data['mb_use']          = 0;
  // $data['od_no']           = '';
  // $data['cp_id']           = 1;
  // $data['cp_type']         = 5;
  // $data['cp_dlimit']       = '';
  // $data['cp_dlevel']       = 0;
  // $data['cp_subject']      = '주인장 가입 회원업소 10% 할인';
  // $data['cp_explan']       = '중앙회원 신규 가입 감사쿠폰';
  // $data['cp_use']          = 1;
  // $data['cp_download']     = 0;
  // $data['cp_overlap']      = 0;
  // $data['cp_sale_type']    = 0;
  // $data['cp_sale_percent'] = 10;
  // $data['cp_sale_amt_max'] = 10000;
  // $data['cp_sale_amt']     = 10000;
  // $data['cp_dups']         = 1;
  // $data['cp_use_sex']      = '';
  // $data['cp_use_sage']     = '';
  // $data['cp_use_eage']     = '';
  // $data['cp_week_day']     = '';
  // $data['cp_pub_1_use']    = 0;
  // $data['cp_pub_shour1']   = '';
  // $data['cp_pub_ehour1']   = '';
  // $data['cp_pub_1_cnt']    = 0;
  // $data['cp_pub_1_down']   = 0;
  // $data['cp_pub_2_use']    = 0;
  // $data['cp_pub_shour2']   = '';
  // $data['cp_pub_ehour2']   = '';
  // $data['cp_pub_2_cnt']    = 0;
  // $data['cp_pub_2_down']   = 0;
  // $data['cp_pub_3_use']    = 0;
  // $data['cp_pub_shour3']   = '';
  // $data['cp_pub_ehour3']   = '';
  // $data['cp_pub_3_cnt']    = 0;
  // $data['cp_pub_3_down']   = 0;
  // $data['cp_pub_sdate']    = '9999999999';
  // $data['cp_pub_edate']    = '9999999999';
  // $data['cp_pub_sday']     = '';
  // $data['cp_pub_eday']     = '';
  // $data['cp_inv_type']     = 1;
  // $data['cp_inv_sdate']    = '9999999999';
  // $data['cp_inv_edate']    = '9999999999';
  // $data['cp_inv_shour1']   = '99';
  // $data['cp_inv_shour2']   = '99';
  // $data['cp_inv_day']      = '90';
  // $data['cp_low_amt']      = 100000;
  // $data['cp_use_part']     = 0;
  // $data['cp_use_goods']    = '';
  // $data['cp_use_category'] = '';
  // $data['cp_wdate']        = date("Y-m-d H:i:s");
  // $data['cp_udate']        = '0000-00-00 00:00:00';

  // $cpModel = new IUD_Model();
  // $table   = "shop_coupon_log";

  // $cpModel->insert($table, $data);

// ddddddddddddddddddddddddddddddddddddddddddddd
  $data2['mb_id']           = $row['id'];
  $data2['mb_name']         = $row['mb_name'];
  $data2['mb_use']          = 0;
  $data2['od_no']           = '';
  $data2['cp_id']           = 2;
  $data2['cp_type']         = 5;
  $data2['cp_dlimit']       = '';
  $data2['cp_dlevel']       = 0;
  $data2['cp_subject']      = '신규 사장님 5천원 할인';
  $data2['cp_explan']       = '신규중앙회원가입';
  $data2['cp_use']          = 1;
  $data2['cp_download']     = 0;
  $data2['cp_overlap']      = 0;
  $data2['cp_sale_type']    = 1;
  $data2['cp_sale_percent'] = 0;
  $data2['cp_sale_amt_max'] = 0;
  $data2['cp_sale_amt']     = 5000;
  $data2['cp_dups']         = 1;
  $data2['cp_use_sex']      = '';
  $data2['cp_use_sage']     = '';
  $data2['cp_use_eage']     = '';
  $data2['cp_week_day']     = '';
  $data2['cp_pub_1_use']    = 0;
  $data2['cp_pub_shour1']   = '';
  $data2['cp_pub_ehour1']   = '';
  $data2['cp_pub_1_cnt']    = 0;
  $data2['cp_pub_1_down']   = 0;
  $data2['cp_pub_2_use']    = 0;
  $data2['cp_pub_shour2']   = '';
  $data2['cp_pub_ehour2']   = '';
  $data2['cp_pub_2_cnt']    = 0;
  $data2['cp_pub_2_down']   = 0;
  $data2['cp_pub_3_use']    = 0;
  $data2['cp_pub_shour3']   = '';
  $data2['cp_pub_ehour3']   = '';
  $data2['cp_pub_3_cnt']    = 0;
  $data2['cp_pub_3_down']   = 0;
  $data2['cp_pub_sdate']    = '9999999999';
  $data2['cp_pub_edate']    = '9999999999';
  $data2['cp_pub_sday']     = '';
  $data2['cp_pub_eday']     = '';
  $data2['cp_inv_type']     = 0;
  $data2['cp_inv_sdate']    = '9999999999';
  $data2['cp_inv_edate']    = '9999999999';
  $data2['cp_inv_shour1']   = '99';
  $data2['cp_inv_shour2']   = '99';
  $data2['cp_inv_day']      = '';
  $data2['cp_low_amt']      = 70000;
  $data2['cp_use_part']     = 0;
  $data2['cp_use_goods']    = '';
  $data2['cp_use_category'] = '';
  $data2['cp_wdate']        = date("Y-m-d H:i:s");
  $data2['cp_udate']        = '0000-00-00 00:00:00';

  $cpModel2 = new IUD_Model();
  $table2   = "shop_coupon_log";
  $cpModel2->insert($table2, $data2);


}
