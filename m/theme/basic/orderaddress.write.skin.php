<?php
if(!defined('_BLUEVATION_')) exit;
//echo test;
  //echo SEND GIT TEST5

if($wr_id){
	$sql = "select * from b_address where wr_id='$wr_id' ";
	$res = sql_fetch($sql);	

	$wr_id = $res['wr_id'];
	$mb_id = $res['mb_id'];
	$b_cellphone = $res['b_cellphone'];
	$b_telephone = $res['b_telephone'];
	$b_zip = $res['b_zip'];
	$b_addr1 = $res['b_addr1'];
	$b_addr2 = $res['b_addr2'];
	$b_addr3 = $res['b_addr3'];
	$b_addr_jibun = $res['b_addr_jibun'];
	$b_name = $res['b_name'];
	$b_base = $res['b_base'];
	$b_addr_jibeon = $res['b_addr_jibeon'];
}


?> 

<form name="b_saveform" id="b_saveform">
<input type="hidden" name = "wr_id" id="b_wr_id" value="<?=$wr_id?>">
    <div id="sod_addr_write">
        <div class="form-wrap">
            <div class="form-row">
                <div class="form-head">
                    <p class="title">받는 사람<b>*</b>
                    </p>
                </div>
                <div class="form-body">
                    <input type="text" name="b_name" id="b_name_save" value="<?=$b_name?>" class="w-per100 frm-input">
                </div>
            </div>
            <div class="form-row">
                <div class="form-head">
                    <p class="title">휴대폰 번호
					<?php  
					//echo $b_cellphone;
					if($b_cellphone){
							$phone = explode("-",$b_cellphone);
							$phone0 = $phone[0];
							$phone1 = $phone[1];
							$phone2 = $phone[2];
					}
					
						
					?>
					<b>*</b>
                    </p>
                </div>
                <div class="form-body phone">
					
                    <input type="text" name="b_cellphone" id="b_cellphone1_save" class="frm-input" value="<?=$phone0?>";>
                    <span class="hyphen">-</span>
                    <input type="text" name="b_cellphone" id="b_cellphone2_save" class="frm-input" value="<?=$phone1?>";>
                    <span class="hyphen">-</span>
                    <input type="text" name="b_cellphone" id="b_cellphone3_save" class="frm-input"  value="<?=$phone2?>";>
                </div>
            </div>
            <div class="form-row">
                <div class="form-head">
                    <p class="title">주소<b>*</b>
                    </p>
                </div>
                <div class="form-body address">
                    <input type="text" name="b_zip" id="b_zip_save"  value="<?=$b_zip?>" class="frm-input address-input_1">
                    <button type="button" class="ui-btn st3" onclick="execDaumPostcode()" >주소검색</button>
                    <input type="text" name="b_addr1" id="b_addr1_save"  value="<?=$b_addr1?>" class="frm-input address-input_2">
                    <input                         type="text"                       name="b_addr2"                        id="b_addr2_save"                        class="frm-input address-input_3"          value="<?=$b_addr2?>"               placeholder="나머지 주소를 입력하세요.">
					                    <input                         type="hidden"                       name="b_addr_jibeon"                        id="b_addr_jibeon_save"                        class="frm-input address-input_3"                        placeholder="나머지 주소를 입력하세요.">
                </div>
                <div class="frm-choice set_df_addr_wrap">
                    <input type="checkbox" name="b_base" id="set_df_addr" value="1" <?php if($b_base=="1") echo "checked"; ?>>
                    <label for="set_df_addr">기본배송지로 설정</label>
                </div>
            </div>
        </div>

        <div class="pop-btm">
            <button type="button" class="ui-btn round stBlack od-dtn__add">배송지 등록하기</button>
        </div>
    </div>
</form>
 

<!-- iOS에서는 position:fixed 버그가 있음, 적용하는 사이트에 맞게 position:absolute 등을 이용하여 top,left값 조정 필요 -->
<div id="layer" style="display:none;position:fixed;overflow:hidden;z-index:1;-webkit-overflow-scrolling:touch;">
<img src="//t1.daumcdn.net/postcode/resource/images/close.png" id="btnCloseLayer" style="cursor:pointer;position:absolute;right:-3px;top:-3px;z-index:1" onclick="closeDaumPostcode()" alt="닫기 버튼">
</div>
 
<script>
    // 우편번호 찾기 화면을 넣을 element
    var element_layer = document.getElementById('layer');

    function closeDaumPostcode() {
        // iframe을 넣은 element를 안보이게 한다.
        element_layer.style.display = 'none';
    }

    function execDaumPostcode() {
        new daum.Postcode({
            oncomplete: function(data) { 
                var addr = ''; // 주소 변수
                var extraAddr = ''; // 참고항목 변수
 
                if (data.userSelectedType === 'R') { // 사용자가 도로명 주소를 선택했을 경우
                    addr = data.roadAddress;
                } else { // 사용자가 지번 주소를 선택했을 경우(J)
                    addr = data.jibunAddress;
                }    
                document.getElementById('b_zip_save').value = data.zonecode;
                document.getElementById("b_addr1_save").value = addr;
            },
            width : '100%',
            height : '100%',
            maxSuggestItems : 5
        }).embed(element_layer);

        // iframe을 넣은 element를 보이게 한다.
        element_layer.style.display = 'block';

        // iframe을 넣은 element의 위치를 화면의 가운데로 이동시킨다.
        initLayerPosition();
    }

    // 브라우저의 크기 변경에 따라 레이어를 가운데로 이동시키고자 하실때에는
    // resize이벤트나, orientationchange이벤트를 이용하여 값이 변경될때마다 아래 함수를 실행 시켜 주시거나,
    // 직접 element_layer의 top,left값을 수정해 주시면 됩니다.
    function initLayerPosition(){
        var width = 300; //우편번호서비스가 들어갈 element의 width
        var height = 400; //우편번호서비스가 들어갈 element의 height
        var borderWidth = 5; //샘플에서 사용하는 border의 두께

        // 위에서 선언한 값들을 실제 element에 넣는다.
        element_layer.style.width = width + 'px';
        element_layer.style.height = height + 'px';
        element_layer.style.border = borderWidth + 'px solid';
        // 실행되는 순간의 화면 너비와 높이 값을 가져와서 중앙에 뜰 수 있도록 위치를 계산한다.
        element_layer.style.left = (((window.innerWidth || document.documentElement.clientWidth) - width)/2 - borderWidth) + 'px';
        element_layer.style.top = (((window.innerHeight || document.documentElement.clientHeight) - height)/2 - borderWidth) + 'px';
    }
 
	$(".od-dtn__add").click(function(){
			var frm = $("#b_saveform").serialize();
			$.ajax({ 
            type:"POST", 
            url:"./orderaddress.save.php",
            data: {
                'b_name':$("#b_name_save").prop('value'),
				'b_cellphone':$("#b_cellphone1_save").prop('value')+"-"+$("#b_cellphone2_save").prop('value')+"-"+$("#b_cellphone3_save").prop('value'),
				'b_zip':$("#b_zip_save").prop('value'),
				'b_addr1':$("#b_addr1_save").prop('value'),
				'b_addr2':$("#b_addr2_save").prop('value'),
					'b_base':$("#set_df_addr").prop('value'),
					'b_wr_id':$("#b_wr_id").prop('value'),
            },
            dataType:"text",
            success:function(result){ 
                console.log(result);
				if(result!="fail")
					{
					  //console.log(result);
						alert("기본 배송지가 등록되었습니다.");
						//cupondownladbtnevt();
						return false;
					}				

            }
        });
	});
</script>

 