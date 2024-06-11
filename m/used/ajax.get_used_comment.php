<?php
include_once("./_common.php");

$pno = trim($_POST['pno']);
$more = trim($_POST['more']);
$mb_id = $member['id'];

$sql = "select * from shop_used_comment where pno = '$pno' order by 1 desc";
$result = sql_query($sql);
$rows = sql_num_rows($result);

$comment = '';
$comment_cnt = $rows;

for($i=0;$row=sql_fetch_array($result);$i++){
    if($more=='N' && $i > 1) break;
    
    $comment .= '<div class="fl-reply_item">';
    $comment .= '<div class="fl-reply_top"><div class="left"><p class="name">'.substr($row['mb_id'],0,3).'***</p></div><div class="right"><p class="date">'.substr($row['regdate'],0,10).'</p></div></div>';
    $comment .= '<div class="fl-reply_content-wr"><div class="fl-reply_content">';
    $comment .= '<div class="fl-reply_content-q-wr">'.nl2br($row['comment']).'</div>';
    if($row['mb_id'] == $mb_id){
        $comment .= '<div class="mngArea"><button type="button" class="ui-btn comment_edit" data-no="'.$row['no'].'">수정</button><button type="button" class="ui-btn comment_del" data-no="'.$row['no'].'">삭제</button></div>';
    }
    $comment .= '</div></div></div>';
}

if($i == 0){
    $comment .= '<p class="empty_list">댓글이 없습니다.</p>';
}

$data['comment'] = $comment;
$data['comment_cnt'] = $comment_cnt;
echo json_encode($data);
exit;
?>

<!--<div class="fl-reply_item">
  <div class="fl-reply_top">
    <div class="left">
      <p class="name">abc***</p>
    </div>
    <div class="right">
      <p class="date">2024-02-27</p>
    </div>
  </div>
  
  <div class="fl-reply_content-wr">
    <div class="fl-reply_content">
      
      <div class="fl-reply_content-q-wr">
        댓글 내용입니다. 댓글 내용입니다. 댓글 내용입니다. 댓글 내용입니다. 댓글 내용입니다.
      </div>

      <div class="mngArea">
        <button type="button" class="ui-btn">답글달기</button>
        <button type="button" class="ui-btn">신고하기</button>
      </div>
      
    </div>
  </div>
</div>

<div class="fl-reply_item">
  <div class="fl-reply_top">
    <div class="left">
      <p class="name">abc***</p>
    </div>
    <div class="right">
      <p class="date">2024-02-27</p>
    </div>
  </div>
  <div class="fl-reply_content-wr">
    <div class="fl-reply_content">

      <div class="fl-reply_content-q-wr">
        댓글 내용입니다. 댓글 내용입니다. 댓글 내용입니다. 댓글 내용입니다. 댓글 내용입니다.
      </div>

      <div class="mngArea">
        <button type="button" class="ui-btn">답글달기</button>
        <button type="button" class="ui-btn">신고하기</button>
      </div>

      <div class="fl-reply_content-a-wr">
        <p class="name">판매자</p>
        <div class="cont">
          답글 내용입니다. 답글 내용입니다. 답글 내용입니다. 답글 내용입니다. 답글 내용입니다.
        </div>
      </div>
      
    </div>
  </div>
</div>-->