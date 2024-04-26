<?php
include_once("./_common.php");
include_once(BV_MPATH."/_head.php"); // 상단
?>

<div id="contents" class="sub-contents flView usedView">
  <div class="fl-detailThumb">
    <div class="swiper-container">
      <div class="swiper-wrapper">
        <div class="swiper-slide item">
          <a href="" class="link">
            <figure class="image">
              <img src="/src/img/used/t-item_thumb1.jpg" class="fitCover" alt="식당용 식탁,의자 세트">
            </figure>
          </a>
        </div>
        <div class="swiper-slide item">
          <a href="" class="link">
            <figure class="image">
              <img src="/src/img/used/t-item_thumb1.jpg" class="fitCover" alt="식당용 식탁,의자 세트">
            </figure>
          </a>
        </div>
      </div>
      <div class="round swiper-control">
        <div class="pagination"></div>
      </div>
    </div>
  </div>

  <div class="bottomBlank container used-item_txtBox item_txtBox">
    <a href="" class="tRow2 title">
      <span class="cate">[주방용품]</span>
      <span class="subj">식당용 식탁,의자</span>
    </a>
    <p class="writer">
      <span>홍길동</span>
      <span>대전시 서구 월평동</span>
    </p>
    <ul class="inf">
      <li>
        <p class="prc">50,000<span class="won">원</span></p>
      </li>
      <li>
        <span class="status ing">판매중</span>
      </li>
    </ul>
    <ul class="extra">
      <li class="hit">
        <span class="icon">
          <img src="/src/img/used/icon_hit.png" alt="조회수">
        </span>
        <span class="text">56</span>
      </li>
      <li class="like">
        <span class="icon">
          <img src="/src/img/used/icon_like.png" alt="좋아요수">
        </span>
        <span class="text">23</span>
      </li>
      <li class="reply">
        <span class="icon">
          <img src="/src/img/used/icon_chat.png" alt="댓글수">
        </span>
        <span class="text">10</span>
      </li>
    </ul>
  </div>

  <div class="bottomBlank container prod-smInfo__body">
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
  </div>

  <div class="bottomBlank container fl-explan">
    상품설명 영역입니다. <br/>
    식당에서 쓰는 식탁과 의자 세트입니다. <br/>
    사용감은 조금 있지만 상태 좋고, 흔들림도 없습니다. <br/>
    직접 가지러 오셔야 하고, 거래 장소는 월평동입니다.
  </div>

  <div class="container fl-reply">
    <div class="fl-reply_body">
      <div class="fl-reply_title">
        <p class="title">댓글(20)</p>
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
      <button type="button" class="ui-btn round moreLong fl-reply_all-btn">
        <span class="text">전체보기</span>
      </button>

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

</div>

<?php
include_once(BV_MPATH."/_tail.php"); // 하단
?>