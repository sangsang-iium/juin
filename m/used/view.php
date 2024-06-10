<?php
include_once("./_common.php");
include_once(BV_MPATH."/_head.php"); // 상단

if(is_numeric($no)){
    $row = sql_fetch("select * from shop_used where no = '$no' and del_yn='N'");
    if(!$row['no']){
        alert("상품정보가 존재하지 않습니다.");
    }
    //조회수+ refresh(신고)제외
    if(!$r){
        sql_query("update shop_used set hit = hit + 1 where no = '$no'");
    }
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
$chat_cnt = getUsedChatCount($row['no']);
$comment_cnt = getUsedCommentCount($row['no']);
$goodyn = getUsedGoodRegister($row['no'], $member['id']);
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
    <button type="button" class="ui-btn st2 siren-btn" data="stIconLeft">
      <i class="icn">
        <img src="/src/img/siren_c.png" alt="">
      </i>
      <span class="txt siren-wBtn_open">신고하기</span>
    </button>
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
        <span class="status <?php echo $gubun_status[2] ?>"><?php echo $gubun_status[1] ?></span>
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
          <img src="/src/img/used/icon_chat.png" alt="채팅수">
        </span>
        <span class="text"><?php echo $chat_cnt ?></span>
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
      <div class="fl-reply_title" id="comment_top">
        <p class="title">댓글(<span class="comment_cnt">0</span>)</p>
      </div>

      <div class="fl-reply_list"></div>

      <?php if($comment_cnt > 2){ ?>
      <button type="button" class="ui-btn round moreLong fl-reply_all-btn" onclick="getUsedCommentList('Y');">
        <span class="text">전체보기</span>
      </button>
      <?php } ?>

      <div class="fl-reply_register" id="comment_bottom">
          <input type="hidden" id="edit_no"><!--수정시 댓글 key-->
          <textarea name="comment" id="comment" class="frm-txtar w-per100" placeholder="댓글을 입력해주세요."></textarea>
          <div class="bottomArea">
            <button type="button" class="ui-btn st3 register-btn" onclick="addComment();">등록하기</button>
          </div>
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
            echo '<a href="./write.php?no='.$row['no'].'" class="ui-btn round stBlack chat-btn">상품정보 수정</a>';
          } else {
            echo '<a href="./chat_room.php?pno='.$row['no'].'&tid='.$member['id'].'" class="ui-btn round stBlack chat-btn">채팅하기</a>';
          }
          ?>
        </div>
      </div>
    </div>
  </div>

</div>


<!--신고하기팝업-->
<div id="siren-write-popup" class="popup type02 add-popup">
  <div class="pop-inner">
    <div class="pop-top">
      <p class="tit">신고하기</p>
      <button type="button" class="btn close"></button>
    </div>
    <div class="pop-content line">
      <div class="pop-content-in">
        <div class="siren-reg">
          <div class="container">
            <form method="post" id="sform" action="write_singo.php" onsubmit="return singoSend(this);" enctype="MULTIPART/FORM-DATA">
            <input type="hidden" name="pno" value="<?php echo $row['no'] ?>">
            <input type="hidden" name="mb_id" value="<?php echo $member['id'] ?>">
              <div class="siren-reg_wrap">
                <div class="siren-reg_top">
                  <!-- 중고상품일 경우 { -->
                  <div class="used-item siren-reg_used-item">
                    <a href="#none" class="used-item_thumbBox">
                      <img src="<?php echo $imgs[0] ?>" class="fitCover" alt="<?php echo $row['title'] ?>">
                    </a>
                    <div class="used-item_txtBox">
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
                          <span class="status <?php echo $gubun_status[2] ?>"><?php echo $gubun_status[1] ?></span>
                        </li>
                      </ul>
                    </div>
                  </div>
                  <!-- } 중고상품일 경우 -->
                </div>
                <p class="siren-reg_tit"><img src="/src/img/siren_w.png" alt="">신고하기</p>
                <div class="siren-reg_con">
                  <div class="form-row">
                    <div class="form-head">
                      <p class="title">신고사유</p>
                    </div>
                    <div class="form-body">
                      <ul class="col2">
                      <?php
                      foreach($singo_categorys as $k => $v){
                        echo '<li><div class="frm-choice"><input type="radio" name="category" value="'.$v.'" id="test-radio'.$k.'"><label for="test-radio'.$k.'">'.$v.'</label></div></li>';
                      }
                      ?>
                      </ul>
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="form-head">
                      <p class="title">상세내용</p>
                    </div>
                    <div class="form-body">
                      <textarea name="content" rows="7" class="frm-txtar w-per100" required placeholder="신고 게시글에 대한 자세한 설명을 입력해 주세요"></textarea>
                    </div>
                    <div class="form-head">
                      <p class="title">이미지(jpg,jpeg,gif,png)</p>
                    </div>
					<div class="form-body">
						<div class="img-upload">
							<div class="img-upload-list">
								<div class="img-upload-item">
									<input type="file" name="img">
								</div>
							</div>
						</div>
					</div>
                  </div>
                </div>
                <div class="siren-reg_bot">
                  <button type="submit" class="ui-btn round stBlack siren-reg_submit">신고 접수하기</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!--신고하기팝업-->

<script type="module">
import * as f from '/src/js/function.js';

$(".siren-wBtn_open").on("click", function () {
  $(".popDim").show();
  f.popupOpen('siren-write-popup');
  $(".prod-buy_area").hide();
});

$("#siren-write-popup .close").on("click", function () {
  $("#sform")[0].reset();
  $(".prod-buy_area").show();
});
</script>

<script>
function singoSend(f){
    if(f.category.value==''){
        alert("신고사유를 선택하세요.");
        return false;
    }
    
    if(confirm("신고하시겠습니까?")){
        return true;
    }
    
    return false;
}



const mb_id = "<?php echo $member['id'] ?>";
const pno = Number(<?php echo $no ?>);

function getUsedCommentList(more){
    $.post("ajax.get_used_comment.php", {pno:pno, more:more}, function(obj){
        var data = JSON.parse(obj);
        $(".fl-reply_list").html(data['comment']);
        $(".comment_cnt").text(data['comment_cnt']);
        if(more=='Y'){
            $(".moreLong").remove();
        }
        
        reEvent();
    });
}

function reEvent(){
    $(".comment_edit").click(function(){
        var idx = $(".comment_edit").index(this);
        var cno = $(this).data("no");
        var edit_text = $(".fl-reply_content-q-wr").eq(idx).text();
        
        $("#edit_no").val(cno);
        $("#comment").val(edit_text);
        $(".register-btn").text('수정하기');
        location.href = '#comment_bottom';
    });

    $(".comment_del").click(function(){
        var idx = $(".comment_del").index(this);
        var cno = $(this).data("no");
        if(confirm("댓글을 삭제하시겠습니까?\n삭제하시면 복구하실 수 없습니다.")){
            $.post("ajax.del_comment.php", {cno:cno, mb_id:mb_id}, function(obj){
                if(obj.trim()=='Y'){
                    $(".fl-reply_item").eq(idx).remove();
                }
            });
        }
    })
}

function addComment(){
    var edit_no = $("#edit_no").val();
    var comment = $("#comment").val();
    if(comment==''){
        alert("댓글을 입력하세요.");
        return false;
    }
    $.post("ajax.add_comment.php", {edit_no:edit_no, pno:pno, comment:comment, mb_id:mb_id}, function(obj){
        if(obj.trim()=='Y'){
            $("#comment").val('');
            $(".register-btn").text('등록하기');
            getUsedCommentList('Y');
            location.href = '#comment_top';
        }
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
    
    getUsedCommentList('N');
});
</script>

<?php
include_once(BV_MPATH."/_tail.php"); // 하단
?>