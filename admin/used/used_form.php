<?php
if(!defined('_BLUEVATION_')) exit;

if(is_numeric($no)){
    $w = "u";
    $row = sql_fetch("select * from shop_used where no = '$no'");
    if(!$row['no']){
        alert("상품정보가 존재하지 않습니다.");
    }
}

$qstr .= "&gubun=".$gubun."&page=".$page;
?>


<form name="fregisterform" id="fregisterform" action="./used/used_form_update.php" onsubmit="return fregisterform_submit(this);" method="post" autocomplete="off" enctype="MULTIPART/FORM-DATA">
<input type="hidden" name="sfl" value="<?php echo $sfl ?>">
<input type="hidden" name="stx" value="<?php echo $stx ?>">
<input type="hidden" name="fr_date" value="<?php echo $fr_date ?>">
<input type="hidden" name="to_date" value="<?php echo $to_date ?>">
<input type="hidden" name="gubun" value="<?php echo $gubun ?>">
<input type="hidden" name="page" value="<?php echo $page ?>">
<input type="hidden" name="w" value="<?php echo $w ?>">
<input type="hidden" name="no" value="<?php echo $no ?>">
<div class="tbl_frm01">
	<table>
	<colgroup>
		<col class="w180">
		<col>
	</colgroup>
	<tbody>
	<tr>
		<th scope="row">유형(*)</th>
		<td>
		    <select name="gubun" required class="required w150">
		        <option value="0"<?php echo ($row['gubun']=='0') ? ' checked' : '';?>>팝니다</option>
		        <option value="1"<?php echo ($row['gubun']=='1') ? ' checked' : '';?>>삽니다</option>
		    </select>
		</td>
	</tr>
	<tr>
		<th scope="row">상태(*)</th>
		<td>
		    <select name="status" required class="required w150">
		        <option value="0"<?php echo ($row['status']=='0') ? ' checked' : '';?>>판매중</option>
		        <option value="1"<?php echo ($row['status']=='1') ? ' checked' : '';?>>판매 완료</option>
		    </select>
		</td>
	</tr>
	<tr>
		<th scope="row">분류(*)</th>
		<td>
		    <select name="category" required class="required w150">
		        <option value="">선택하세요.</option>
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
		</td>
	</tr>
	<tr>
		<th scope="row">가격</th>
		<td><input type="text" name="price" value="<?php echo $row['price'] ?>" class="frm_input required w150" required placeholder="숫자만입력"></td>
	</tr>
	<tr>
		<th scope="row">제목</th>
		<td><input type="text" name="title" value="<?php echo $row['title'] ?>" class="frm_input required w100p" required></td>
	</tr>
	<tr>
		<th scope="row">설명</th>
		<td><textarea name="content" class="frm_input required w100p h200" required><?php echo $row['content'] ?></textarea></td>
	</tr>
	<tr>
		<th scope="row">거래장소</th>
		<td>
			<input type="text" name="address" id="address" required readonly class="frm_input required w50p" value="<?php echo $row['address'] ?>">
			<button type="button" class="btn_small" onclick="daumAddress();">주소검색</button>
			<input type="hidden" name="lat" id="lat" value="<?php echo $row['lat'] ?>">
			<input type="hidden" name="lng" id="lng" value="<?php echo $row['lng'] ?>">
		</td>
	</tr>
	<tr>
		<th scope="row">대표이미지 (jpg, gif, png)</th>
		<td>
		    <div class="fl w20p">
		        <input type="file" name="m_img"<?php echo (!$w) ? ' required' : '';?>>
		        <?php
		        if($row['m_img']){
		            echo '<img src="'.BV_DATA_URL.'/used/'.$row['m_img'].'" class="w90p">';
		        }
		        ?>
		    </div>
		</td>
	</tr>
	<tr>
		<th scope="row">상세이미지 (jpg, gif, png)</th>
		<td>
		<?php
		$sub_imgs = explode("|", $row['s_img']);
		$sub_imgs = array_filter($sub_imgs);
		$sub_imgs = array_values($sub_imgs);
		for($i=0;$i < 5;$i++){
		    echo '<div class="fl w20p"><input type="file" name="s_img[]">';
		    if($sub_imgs[$i]){
		        echo '<img src="'.BV_DATA_URL.'/used/'.$sub_imgs[$i].'" class="w90p"> &nbsp; <span class="image_del curp fs18" data-img_name="'.$sub_imgs[$i].'">X</span>';
		    }
		    echo '</div>';
		}
		?>
		</td>
	</tr>
	</tbody>
	</table>
</div>
<div class="btn_confirm">
	<input type="submit" value="저장" id="btn_submit" class="btn_large red" accesskey="s">
	<a href="<?php echo BV_ADMIN_URL.'/used.php?code=list'.$qstr; ?>" class="btn_large">목록</a>
</div>
</form>

<script>
function fregisterform_submit(f) {
	document.getElementById("btn_submit").disabled = "disabled";

    return true;
}

/* 서브이미지 삭제 */
const no = Number(<?php echo $row['no'] ?>);

$(document).on("click", ".image_del", function(){
    var img_name = $(this).data("img_name");
    if(confirm("이미지를 삭제하시겠습니까?")){
        $.post(bv_admin_url+"/used/ajax.sub.image.del.php", {no:no, img_name:img_name}, function(obj){
            if(obj=='Y'){
                location.reload();
            }
        })
    }
});
/* 서브이미지 삭제 */
</script>

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
</script>