<?php
include_once("./_common.php");
include_once(BV_MPATH."/_head.php"); // 상단

if(is_numeric($no)){
    $row = sql_fetch("select * from shop_used where no = '$no'");
    if(!$row['no']){
        alert("상품정보가 존재하지 않습니다.");
    }
    //조회수+
    sql_query("update shop_used set hit = hit + 1 where no = '$no'");
} else {
    alert("상품정보가 존재하지 않습니다.");
}

$imgs = [];
if(file(BV_DATA_URL.'/used/'.$row['m_img'])) array_push($imgs, BV_DATA_URL.'/used/'.$row['m_img']);
$subimgs = explode("|", $row['s_img']);
$subimgs = array_filter($subimgs);
foreach($subimgs as $v){
    if(file(BV_DATA_URL.'/used/'.$v)) array_push($imgs, BV_DATA_URL.'/used/'.$v);
}
$imgs = array_unique($imgs);
if(empty($imgs)){
    $imgs = ['/src/img/used/t-item_thumb1.jpg'];
}

$gubun_status = getUsedGubunStatus($row['gubun'], $row['status']);
$good_cnt = getUsedGoodCount($row['no']);
$comment_cnt = getUsedCommentCount($row['no']);
$goodyn = getUsedGoodRegister($row['no'], $member['id']);

/*$sql = "select * from shop_used_comment where pno = {$row['no']} order by no";
$result = sql_query($sql);*/
?>

<div id="contents" class="sub-contents flView usedView">
  <div class="fl-detailThumb">
    <div class="swiper-container">
      <div class="swiper-wrapper">
      <?php
      foreach($imgs as $v){
        echo '<div class="swiper-slide item">';
        echo '<a href="#none" class="link"><figure class="image"><img src="'.$v.'" class="fitCover" alt="'.$row['title'].'"></figure></a>';
        echo '</div>';
      }
      ?>
      </div>
      <div class="round swiper-control">
        <div class="pagination"></div>
      </div>
    </div>
  </div>

  <div class="bottomBlank container used-item_txtBox item_txtBox">
    <a href="" class="tRow2 title">
      <span class="cate">[<?php echo $row['category'] ?>]</span>
      <span class="subj"><?php echo $row['title'] ?></span>
    </a>
    <p class="writer">
      <span><?php echo getMemberName($row['mb_id']) ?></span>
      <span><?php echo getUsedAddress($row['address']) ?></span>
    </p>
    <ul class="inf">
      <li>
        <p class="prc"><?php echo number_format($row['price']) ?><span class="won">원</span></p>
      </li>
      <li>
        <span class="status ing"><?php echo $gubun_status[1] ?></span>
      </li>
    </ul>
    <ul class="extra">
      <li class="hit">
        <span class="icon">
          <img src="/src/img/used/icon_hit.png" alt="조회수">
        </span>
        <span class="text"><?php echo $row['hit'] ?></span>
      </li>
      <li class="like">
        <span class="icon">
          <img src="/src/img/used/icon_like.png" alt="좋아요수">
        </span>
        <span class="text"><?php echo $good_cnt ?></span>
      </li>
      <li class="reply">
        <span class="icon">
          <img src="/src/img/used/icon_chat.png" alt="댓글수">
        </span>
        <span class="text conmment_cnt"><?php echo $comment_cnt ?></span>
      </li>
    </ul>
  </div>

  <!-- 입력에 없는내용/기획서에서 관련내용없음-->
  <!--<div class="bottomBlank container prod-smInfo__body">
    <div class="info-list">
      <div class="info-item">
        <p class="tit">제품명</p>
        <p class="cont">식탁4개 의자8개(거의새것) 좀큰것1셋트포함</p>
      </div>
      <div class="info-item">
        <p class="tit">가격</p>
        <p class="cont">250만원에구매-35만원에판매</p>
      </div>
      <div class="info-item">
        <p class="tit">사용기간</p>
        <p class="cont">3년</p>
      </div>
      <div class="info-item">
        <p class="tit">판매위치</p>
        <p class="cont">경기 시흥시 은계지구</p>
      </div>
    </div>
  </div>-->

  <div class="bottomBlank container fl-explan"><?php echo nl2br($row['content']) ?></div>

  <div class="container fl-reply">
    <div class="fl-reply_body">
      <div class="fl-reply_title">
        <p class="title">댓글(<span class="conmment_cnt"><?php echo $comment_cnt ?></span>)</p>
      </div>

      <div class="fl-reply_list">
        
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
        
      </div>
      <?php if($comment_cnt > 2){ ?>
      <button type="button" class="ui-btn round moreLong fl-reply_all-btn">
        <span class="text" onclick="getUsedCommentList(<?php echo $row['no'] ?>, 'y');">전체보기</span>
      </button>
      <?php } ?>

      <div class="fl-reply_register">
        <form action="">
          <textarea name="" id="" required class="frm-txtar w-per100" placeholder="댓글을 입력해주세요."></textarea>
          <div class="bottomArea">
            <button type="submit" class="ui-btn st3 register-btn">등록하기</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <div class="prod-buy_area">
    <div class="dfBox">
      <div class="container">
        <div class="prod-buy__btns">
          <button type="button" data-no="<?php echo $row['no'] ?>" class="ui-btn wish-btn<?php echo ($goodyn) ? ' on' : '';?>" title="관심상품 등록하기"></button>
          <?php
          if($member['id']==$row['mb_id']){
            $chat_cnt = getUsedChatCount($row['no']);
            if($chat_cnt){
              echo '<a href="./chat_list.php?pno='.$row['no'].'" class="ui-btn round stBlack chat-btn">채팅하기</a>';
            } else {
              echo '<a href="#none" class="ui-btn round stBlack chat-btn">채팅이 없습니다</a>';
            }
          } else {
            echo '<a href="./chat_room.php?pno='.$row['no'].'&tid='.$member['id'].'" class="ui-btn round stBlack chat-btn">채팅하기</a>';
          }
          ?>
        </div>
      </div>
    </div>
  </div>

</div>

<script>
const pno = Number(<?php echo $no ?>);
let more = '';

function getUsedCommentList(pno, more){
    $.post("ajax.get_used_list.php", {pno:pno, more:more}, function(obj){
        $(".fl-reply_list").html(obj);
        reEvent();
    });
}

function reEvent(){
    $(".wish-btn").click(function(){
        var el = $(this);
        var no = el.data("no");
        var inout = 'in';
        if(el.hasClass("on")){
            inout = 'out';
        }
        $.post("ajax.used_good.php", {no:no, inout:inout}, function(obj){
            if(obj.trim()=='in'){
                el.addClass("on");
            } else if(obj.trim()=='out'){
                el.removeClass("on");
            }
        });
    });
}

$(document).ready(function(){
    $(".wish-btn").click(function(){
        var el = $(this);
        var no = el.data("no");
        var inout = 'in';
        if(el.hasClass("on")){
            inout = 'out';
        }
        $.post("ajax.used_good.php", {no:no, inout:inout}, function(obj){
            if(obj.trim()=='in'){
                el.addClass("on");
            } else if(obj.trim()=='out'){
                el.removeClass("on");
            }
        });
    });
    
    //getUsedCommentList(pno, more);
});
</script>

<?php
include_once(BV_MPATH."/_tail.php"); // 하단
?>