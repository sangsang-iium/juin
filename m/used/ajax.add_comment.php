<?php
include_once "./_common.php";

$edit_no = trim($_POST['edit_no']); //����
$pno = trim($_POST['pno']);
$comment = trim($_POST['comment']);
$mb_id = trim($_POST['mb_id']);

if(is_numeric($pno)){
    $row = sql_fetch("select * from shop_used where no = '$pno'");
    if(!$row['no']) exit;
} else {
    exit;
}

if($mb_id != $member['id']) exit;

if($edit_no){
    $sql = "update shop_used_comment set comment='$comment' where no='$edit_no'";
} else {
    $sql = "insert into shop_used_comment set pno='$pno', mb_id='$mb_id', comment='$comment', regdate='".BV_TIME_YMDHIS."'";

    // ��� ��� PUSH _20240705_SY
    $max_width    = 15;
    $text_trimmed = mb_strimwidth($row['title'], 0, $max_width, '...', 'utf-8');

    $token_sel = " SELECT fcm_token FROM shop_member WHERE id = '{$row['mb_id']}' ";
    $token_row = sql_fetch($token_sel);
    $fcm_token = $token_row['fcm_token'];
    
    $message = [
        'token' => $fcm_token, // �������� ����̽� ��ū
        'title' => '�߰����� ���',
        'body' => "\"$text_trimmed\" �߰����� �Խñۿ� ����� ��ϵǾ����ϴ�."
    ];
    
    $response = sendFCMMessage($message);
}
sql_query($sql);
echo 'Y';
exit;
?>