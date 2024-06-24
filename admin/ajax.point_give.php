<?php
include_once('./_common.php');


// mb_id              //아이디
// po_datetime         //지급일시
// po_content      //지급사유
// po_point        //지급포인트내역
// po_expired      //만료
// po_expire_date  //포인트만료일
// po_mb_point     //지급당시 회원포인트
// po_rel_table   //관련테이블
// po_rel_id       //관령 아이디
// po_rel_action   //관련작업

// echo $_POST['po_point'];

// echo $_POST['po_content'];

// echo $_POST['id'];

$ids = explode("||",$_POST['id']);
for($i=0;$i<count($ids)-1;$i++){
    $mb = get_member($ids[$i]);
    if(!$mb['id']||$mb['id']!=''){
        $sq = "
            insert into shop_point
            set
            mb_id ='{$mb['id']}',
            po_datetime=now(),
            po_content = '{$_POST['po_content']}',
            po_point = '{$_POST['po_point']}',
            po_expired = 0,
            po_expire_date = '9999-01-01',
            po_mb_point = '{$mbid['point']}',
            po_rel_table='@member',
            po_rel_id='admin',
            po_rel_action='{$_POST['po_content']}'
            ";
        sql_query($sq);
    }   

    
}