<?php
include_once("./_common.php");
include_once(BV_MPATH."/_head.php"); // 상단
include_once(BV_PATH.'/include/topMenu.php');

if(is_numeric($no)){
    $w = "u";
    $row = sql_fetch("select * from shop_used where no = '$no' and mb_id='{$member['id']}'");
    if(!$row['no']){
        alert("상품정보가 존재하지 않습니다.");
    }
}
?>

<div id="contents" class="sub-contents usedWrite">
<form name="fqaform" id="fqaform" method="post" action="./write_used.php" onsubmit="return fqaform_submit(this);" autocomplete="off" enctype="MULTIPART/FORM-DATA">
<input type="hidden" name="w" value="<?php echo $w ?>">
<input type="hidden" name="no" value="<?php echo $no ?>">

		<div class="form-faq-wrap">
			<div class="container">
				<div class="form-row">
					<div class="form-head">
						<p class="title">유형<b>*</b></p>
					</div>
					<div class="form-body">
		                <select name="gubun" required class="frm-select">
		                    <option value="">선택하세요</option>
		                    <option value="0"<?php echo ($row['gubun']=='0') ? ' selected' : '';?>>팝니다</option>
		                    <option value="1"<?php echo ($row['gubun']=='1') ? ' selected' : '';?>>삽니다</option>
		                </select>
					</div>
				</div>
                <div class="form-row">
					<div class="form-head">
						<p class="title">판매상태<b>*</b></p>
					</div>
					<div class="form-body">
		                <select name="status" required class="frm-select">
		                    <option value="">선택하세요</option>
		                    <option value="0"<?php echo ($row['status']=='0') ? ' selected' : '';?>>판매중</option>
		                    <option value="1"<?php echo ($row['status']=='1') ? ' selected' : '';?>>예약중</option>
		                    <option value="2"<?php echo ($row['status']=='2') ? ' selected' : '';?>>판매완료</option>
		                </select>
					</div>
				</div>
                <div class="form-row">
					<div class="form-head">
						<p class="title">분류<b>*</b></p>
					</div>
					<div class="form-body">
		                <select name="category" required class="frm-select">
		                    <option value="">선택하세요</option>
		                    <?php
		                    foreach($used_categorys as $v){
		                        if($v == $row['category']){
		                            echo '<option value="'.$v.'" selected>'.$v.'</option>';
		                        } else {
		                            echo '<option value="'.$v.'">'.$v.'</option>';
		                        }
		                    }
		                    ?>
		                </select>
					</div>
				</div>
				<div class="form-row">
					<div class="form-head">
						<p class="title">가격<b>*</b></p>
					</div>
					<div class="form-body">
						<input type="text" name="price" value="<?php echo $row['price'] ?>" class="frm-input" required placeholder="숫자만 입력해주세요.">
					</div>
				</div>
				<div class="form-row">
					<div class="form-head">
						<p class="title">제목<b>*</b></p>
					</div>
					<div class="form-body">
						<input type="text" name="title" value="<?php echo $row['title'] ?>" class="frm-input" required  placeholder="제목을 입력해주세요.">
					</div>
				</div>
				<div class="form-row">
					<div class="form-head">
						<p class="title">설명<b>*</b></p>
					</div>
					<div class="form-body">
						<textarea name="content" required rows="7" class="frm-txtar w-per100" placeholder="내용을 입력해주세요."><?php echo $row['content'] ?></textarea>
					</div>
				</div>
				<div class="form-row">
					<div class="form-head">
						<p class="title">거래장소<b>*</b></p>
					</div>
					<div class="form-body">
						<input type="text" name="address" id="address" required readonly class="frm-input" value="<?php echo $row['address'] ?>">
						<button type="button" class="btn_small" onclick="daumAddress();">주소검색</button>
						<input type="hidden" name="lat" id="lat" value="<?php echo $row['lat'] ?>">
						<input type="hidden" name="lng" id="lng" value="<?php echo $row['lng'] ?>">
					</div>
				</div>
				<div class="form-row">
					<div class="form-head">
						<p class="title">대표이미지</p>
					</div>
					<div class="form-body">
						<div class="img-upload">
							<div class="img-upload-list">
								<div class="img-upload-item">
									<input type="file" name="m_img"<?php echo (!$w) ? ' required' : '';?>>
		                            <?php
		                            if($row['m_img']){
		                                echo '<img src="'.BV_DATA_URL.'/used/'.$row['m_img'].'">';
		                            }
		                            ?>
								</div>
							</div>
						</div>
					</div>
				</div>
                <div class="form-row">
					<div class="form-head">
						<p class="title">상세이미지</p>
					</div>
					<div class="form-body">
						<div class="img-upload">
							<div class="img-upload-list">
		                    <?php
		                    $sub_imgs = explode("|", $row['s_img']);
		                    $sub_imgs = array_filter($sub_imgs);
		                    $sub_imgs = array_values($sub_imgs);
		                    for($i=0;$i < 5;$i++){
		                        echo '<div class="img-upload-item">X<input type="file" name="s_img[]">';
		                        if($sub_imgs[$i]){
		                            // css 때문에 삭제가 보이지 않아서 임시이미지로 처리함.
		                            echo '<div class="img_container"><img src="'.BV_DATA_URL.'/used/'.$sub_imgs[$i].'">&nbsp; <img src="/m/img/ajax-loader.gif" class="image_del" data-img_name="'.$sub_imgs[$i].'"></div>';
		                        }
		                        echo '</div>';
		                    }
		                    ?>
							</div>
						</div>
					</div>
				</div>

				<div class="cp-btnbar">
					<div class="container">
						<div class="cp-btnbar__btns">
							<input type="submit" value="등록하기" class="ui-btn round stBlack">
						</div>
					</div>
				</div>

			</div>
		</div>
</form>
</div>


<script type="text/javascript" src="https://dapi.kakao.com/v2/maps/sdk.js?appkey=<?php echo $default['de_kakao_js_apikey'] ?>&libraries=services"></script>
<?php echo BV_POSTCODE_JS ?>
<script>
// 주소-좌표 변환 객체를 생성합니다
var geocoder = new kakao.maps.services.Geocoder();
// 주소로 좌표를 검색합니다
function getPosition(){
    var address = $("#address").val();
    address = address.trim();

    geocoder.addressSearch(address, function(result, status) {
        console.log(result)
        // 정상적으로 검색이 완료됐으면 
        if (status === kakao.maps.services.Status.OK) {
             //var coords = new kakao.maps.LatLng(result[0].y, result[0].x);
             $("#lat").val(result[0].y);
             $("#lng").val(result[0].x);
        } else {
            alert("좌표를 확인할 수 없습니다. 주소를 확인해 주세요.");
        }
    });
}

function daumAddress(){
    new daum.Postcode({
        oncomplete: function(data) {
            // 팝업에서 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분입니다.
            if (data.userSelectedType === 'R') { // 사용자가 도로명 주소를 선택했을 경우
                addr = data.roadAddress;
            } else { // 사용자가 지번 주소를 선택했을 경우(J)
                addr = data.jibunAddress;
            }
            
            document.getElementById('address').value = addr;
            getPosition();
        }
    }).open();
}

/* 서브이미지 삭제 */
const no = Number(<?php echo $row['no'] ?>);

$(document).on("click", ".image_del", function(){
    var idx = $(".image_del").index(this);
    var img_name = $(this).data("img_name");
    if(confirm("이미지를 삭제하시겠습니까?")){
        $.post("ajax.sub.image.del.php", {no:no, img_name:img_name}, function(obj){
            if(obj=='Y'){
                $(".img_container").eq(idx).remove();
            }
        })
    }
});
/* 서브이미지 삭제 */
</script>


<?php
include_once(BV_MPATH."/_tail.php"); // 하단
?>