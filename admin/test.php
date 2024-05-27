<?php
exit;
//*회원정보에 엑셀로 업로드된 주소정보로 좌표 생성 *//
include_once('./_common.php');
$sql = "select id, ju_addr_full from shop_member where grade = 8 and ju_addr_full != '' and ju_lat = '' and ju_lng = '' order by index_no limit 5";
$result = sql_query($sql);
$data = [];
$idx = 0;
while($row=sql_fetch_array($result)){
    if($row['ju_addr_full']){
        $addrs = explode("(", $row['ju_addr_full']);
        $data[$idx]['mb_id'] = $row['id'];
        $data[$idx]['address'] = $addrs[0];
        $idx++;
    }
}

echo count($data);
?>

<meta http-equiv="Refresh" content="10">

<script src="https://juin.eumsvr.com/js/jquery-1.8.3.min.js"></script>
<script type="text/javascript" src="https://dapi.kakao.com/v2/maps/sdk.js?appkey=<?php echo $default['de_kakao_js_apikey'] ?>&libraries=services"></script>
<?php echo BV_POSTCODE_JS ?>
<script>
// 주소-좌표 변환 객체를 생성합니다
var geocoder = new kakao.maps.services.Geocoder();
// 주소로 좌표를 검색합니다
function getPosition(mb_id, address){
    address = address.trim();

    geocoder.addressSearch(address, function(result, status) {
        // 정상적으로 검색이 완료됐으면 
        if (status === kakao.maps.services.Status.OK) {
             posUpdate(mb_id, result[0].y, result[0].x);
        } else {
            posUpdate(mb_id, 0, 0);
        }
    });
}

function posUpdate(mb_id, lat, lng){
    $.post("ajax.pos.php", {mb_id:mb_id, lat:lat, lng:lng}, function(){
        
    })
}

const adata = <?php echo json_encode($data); ?>;
if(adata.length==5){
    for(var i=0;i < adata.length;i++){
        getPosition(adata[i]['mb_id'], adata[i]['address']);
    }
}
</script>