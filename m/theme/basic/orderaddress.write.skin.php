<?php
if(!defined('_BLUEVATION_')) exit;
?>

<form name="">
<div id="sod_addr_write">
  <div class="form-wrap">
    <div class="form-row">
      <div class="form-head">
        <p class="title">받는 사람<b>*</b></p>
      </div>
      <div class="form-body">
        <input type="text" name="" id="" class="w-per100 frm-input">
      </div>
    </div>
    <div class="form-row">
      <div class="form-head">
        <p class="title">휴대폰 번호<b>*</b></p>
      </div>
      <div class="form-body phone">
        <input type="text" name="" id="" class="frm-input">
        <span class="hyphen">-</span>
        <input type="text" name="" id="" class="frm-input">
        <span class="hyphen">-</span>
        <input type="text" name="" id="" class="frm-input">
      </div>
    </div>
    <div class="form-row">
      <div class="form-head">
        <p class="title">주소<b>*</b></p>
      </div>
      <div class="form-body address">
        <input type="text" name="" id="" class="frm-input address-input_1">
        <button type="button" class="ui-btn st3">주소검색</button>
        <input type="text" name="" id="" class="frm-input address-input_2">
        <input type="text" name="" id="" class="frm-input address-input_3" placeholder="나머지 주소를 입력하세요.">
      </div>
      <div class="frm-choice set_df_addr_wrap">
        <input type="checkbox" name="chk" id="set_df_addr" value="">
        <label for="set_df_addr">기본배송지로 설정</label>
      </div>
    </div>
  </div>

  <div class="pop-btm">
    <button type="button" class="ui-btn round stBlack od-dtn__add">배송지 등록하기</button>
  </div>
</div>
</form>
