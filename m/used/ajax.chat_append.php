<?php
include_once('./_common.php');
//include_once G5_LIB_PATH.'/thumbnail.lib.php';

$chatno = trim($_POST['chatno']);
$vcount = trim($_POST['vcount']);
$seller = trim($_POST['seller']); //판매자ID

//5초에 100줄을 등록하지는 못하겠지...
$sql = "select * from shop_used_chatd where pno = {$chatno} order by no limit {$vcount}, 100";
$result = sql_query($sql);

$str = '';
while($row=sql_fetch_array($result)){    
    if($member['id']==$row['mb_id']){
        $str .= '<div class="chat-msg send"><div class="msgBox">';
        $str .= '<div class="msgText">'.nl2br($row['content']).'</div>';
        $vtime = str_replace(['AM','PM'], ['오전','오후'], date("A g:i", strtotime($row['regdate'])));
        $str .= '<span class="msgTime">'.$vtime.'</span>';
        $str .= '</div></div>';
    } else {
        $str .= '<div class="chat-msg receive"><div class="msgBox">';
        $str .= '<div class="msgText">'.nl2br($row['content']).'</div>';
        $vtime = str_replace(['AM','PM'], ['오전','오후'], date("A g:i", strtotime($row['regdate'])));
        $str .= '<span class="msgTime">'.$vtime.'</span>';
        $str .= '</div></div>';
    }
    $ymd = date("Y-m-d", strtotime($row['regdate']));
}

if($str){
    if($vcount=='0'){
        $str = '<p class="date">'.date("Y년 m월 d일").'</p>'.$str;
    } else {
        //추가할목록바로전1로우
        $from_record = $vcount - 1;
        $row2 = sql_fetch("select left(regdate,10) as regdate from shop_used_chatd where pno = {$chatno} order by no limit {$from_record}, 1");
        if($ymd > $row2['regdate']){
            $str = '<p class="date">'.date("Y년 m월 d일", strtotime($ymd)).'</p>'.$str;
        }
    }

    if($member['id']==$seller){
        sql_query("update shop_used_chatd set mread = 1 where pno = {$chatno}");
    } else {
        sql_query("update shop_used_chatd set uread = 1 where pno = {$chatno}");
    }
    echo $str;
}
exit;
?>