<?php
include_once("./_common.php");

$pno = trim($_POST['pno']);
$more = trim($_POST['more']);

if($more=='y'){
    $sql = "select * from shop_used_comment where pno = '$pno' order by 1 desc";
} else {
    $sql = "select * from shop_used_comment where pno = '$pno' order by 1 desc limit 2";
}
$result = sql_query($sql);
$rows = sql_num_rows($result);

if($rows == 0){
    echo '<p class="empty_list">댓글이 없습니다.</p>';
} else {
    while($row=sql_fetch_array($result)){
        if($row['m_img']){
            $thumb = BV_DATA_URL.'/used/'.$row['m_img'];
        } else {
            $thumb = '/src/img/used/t-item_thumb1.jpg';
        }
        $gubun_status = getUsedGubunStatus($row['gubun'], $row['status']);
        $goodyn = getUsedGoodRegister($row['no'], $member['id']);
        
        echo '<div class="used-item">';
        echo '<a href="./view.php?no='.$row['no'].'" class="used-item_thumbBox"><img src="'.$thumb.'" class="fitCover" alt="'.$row['title'].'"></a>';
        echo '<div class="used-item_txtBox">';
        echo '<a href="./view.php?no='.$row['no'].'" class="tRow2 title"><span class="cate">['.$row['category'].']</span><span class="subj">'.$row['title'].'</span></a>';
        echo '<p class="writer"><span>'.getMemberName($row['mb_id']).'</span><span>'.getUsedAddress($row['address']).'</span></p>';
        echo '<ul class="inf"><li><p class="prc">'.number_format($row['price']).'<span class="won">원</span></p></li>';
        if($row['gubun']){
            echo '<li><span class="status ing">'.$gubun_status[0].'</span></li></ul>';
        } else if($row['status']=='1'){
            echo '<li><span class="status resv">'.$gubun_status[1].'</span></li></ul>';
        } else if($row['status']=='2'){
            echo '<li><span class="status end">'.$gubun_status[1].'</span></li></ul>';
        } else {
            echo '<li><span class="status ing">'.$gubun_status[1].'</span></li></ul>';
        }
        echo '<ul class="extra">';
        echo '<li class="hit"><span class="icon"><img src="/src/img/used/icon_hit.png" alt="조회수"></span><span class="text">'.$row['hit'].'</span></li>';
        echo '<li class="like"><span class="icon"><img src="/src/img/used/icon_like.png" alt="좋아요수"></span><span class="text">'.getUsedGoodCount($row['no']).'</span></li>';
        echo '<li class="reply"><span class="icon"><img src="/src/img/used/icon_chat.png" alt="댓글수"></span><span class="text">'.getUsedCommentCount($row['no']).'</span></li>';
        echo '</ul>';
        if($goodyn){
            echo '<button type="button" class="ui-btn wish-btn on" data-no="'.$row['no'].'" title="관심상품 등록하기"></button>';
        } else {
            echo '<button type="button" class="ui-btn wish-btn" data-no="'.$row['no'].'" title="관심상품 등록하기"></button>';
        }
        echo '</div></div>';
    }
}
?>

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
        </div>