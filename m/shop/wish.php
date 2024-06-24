<?php
include_once("./_common.php");

if(!$is_member)
	goto_url(BV_MBBS_URL.'/login.php?url='.$urlencode);

$tb['title'] = "찜한상품";
include_once("./_head.php");

$sql  = " select a.wi_id, a.wi_time, a.gs_id, b.* 
            from shop_wish a left join shop_goods b ON ( a.gs_id = b.index_no )
		   where a.mb_id = '{$member['id']}' 
		   order by a.wi_id desc ";
$result = sql_query($sql);
$wish_count = sql_num_rows($result);

//중고장터
$sql1  = "select a.mb_id, b.* from shop_used_good a join shop_used b on a.pno = b.no where a.mb_id = '{$member['id']}' and b.del_yn = 'N' order by a.no desc";
$result1 = sql_query($sql1);
$wish_count1 = sql_num_rows($result1);

//회원사현황
$sql2  = "select a.mb_id, b.* from shop_store_good a join shop_member b on a.pno = b.index_no where a.mb_id = '{$member['id']}' and b.ju_mem = 1 order by a.no desc";
$result2 = sql_query($sql2);
$wish_count2 = sql_num_rows($result2);

include_once(BV_MTHEME_PATH.'/wish.skin.php');

include_once("./_tail.php");
?>