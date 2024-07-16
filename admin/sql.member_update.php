<?php // MEMBER DB UPDATE _SY
include_once "_common.php";

/* 중복 회원 색출 */
// 중복값 색출
// $mem_du_sel = "SELECT ju_b_num, COUNT(*)
//                  FROM shop_member
//                 WHERE ju_b_num <> '' AND ju_b_num <> '000-00-00000'
//              GROUP BY ju_b_num
//                HAVING COUNT(*) > 1 ";
// $mem_du_res = sql_query($mem_du_sel);
// $mem_du_num = sql_num_rows($mem_du_res);

// // 중복맴버 색출
// while($mem_du_row = sql_fetch_array($mem_du_res)) {
//   $mem_sel = " SELECT * FROM shop_member WHERE ju_b_num = '{$mem_du_row['ju_b_num']}' ORDER BY index_no DESC LIMIT 1 ";
//   $mem_sel_row = sql_fetch($mem_sel);

//   $update_query = "UPDATE shop_member 
//                    SET zip = '{$mem_sel_row['zip']}',
//                        ju_cate = '{$mem_sel_row['ju_cate']}',
//                        ju_region3 = '{$mem_sel_row['ju_region3']}',
//                        ju_sectors = '{$mem_sel_row['ju_sectors']}'
//                    WHERE ju_b_num = '{$mem_du_row['ju_b_num']}'
//                    ORDER BY index_no ASC LIMIT 1";
//   sql_query($update_query);
//   $mem_del = sql_query(" DELETE FROM shop_member WHERE ju_b_num = '{$mem_du_row['ju_b_num']}' ORDER BY index_no DESC LIMIT 1 ");
// }



/* 비밀번호 암호화 */
// $mem_sel = " SELECT * FROM shop_member WHERE grade = 6 AND index_no >= 1576 ";
// $mem_res = sql_query($mem_sel);
// while($mem_row = sql_fetch_array($mem_res)) {
//   $pw = get_encrypt_string($mem_row['passwd']);

//   $update_query = " UPDATE shop_member SET 
//                           passwd = '{$pw}'
//                      WHERE index_no = '{$mem_row['index_no']}' ";
//   sql_query($update_query);
// }




/* 지회 지부 코드값으로 변경 */
// UPDATE shop_member AS mm
// JOIN kfia_office AS ko
// ON (mm.ju_region3 = ko.office_name)
// SET mm.ju_region2 = kb.branch_code
// SET mm.ju_region3 = kb.office_code



/* 주소 UPDATE */
// $mem_sel = "SELECT * FROM shop_member WHERE addr1 = '' AND id <> 'admin'";
// $mem_res = sql_query($mem_sel);
// while ($mem_row = sql_fetch_array($mem_res)) {
//     $newAddr = $mem_row['ju_addr_full'];
    
//     // 작은 따옴표를 이스케이프 처리
//     $newAddr = str_replace("'", "''", $newAddr);
    
//     $update_query = "UPDATE shop_member SET addr1 = '{$newAddr}' WHERE index_no = '{$mem_row['index_no']}'";
    
//     sql_query($update_query);
// }



/* grade, reg_time, auth 변경 */
// $mem_sel = " SELECT * FROM shop_manager where index_no >= 1569 ";
// $mem_res = sql_query($mem_sel);
// $now = date('Y-m-d H:i:s');
// while($mem_row = sql_fetch_array($mem_res)) {
//   $grade = 2;

//   $update_query = " UPDATE shop_manager SET 
//                           grade = '{$grade}'
//                           ,reg_time = '{$now}'
//                           ,auth_1 = '1'
//                           ,auth_6 = '1'
//                           ,auth_7 = '1'
//                           ,auth_10 = '1'
//                      WHERE index_no = '{$mem_row['index_no']}' ";
//   sql_query($update_query);
// }



