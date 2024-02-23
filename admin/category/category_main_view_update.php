<?php
include_once("./_common.php");

$count = 0;
switch($W) {
	case "sel_ca_1":
		$count = count($_POST['sel_ca_1']);
		$code = $_POST['sel_ca_1'];
		break;
}

if($count) {
	for($i=0;$i<=$count;$i++){
		$k = ($i+1);

		$sql = " update iu_category_main set cm_rank = '$k' where cm_ca_id = '$code[$i]' ";
		sql_query($sql);
	}

	$msg = "정상적으로 처리 되었습니다";
} else {
	$msg = "처리할 항목이 없습니다";
}

echo "<meta charset='utf-8'>";
echo "<script>alert('".$msg."');</script>";

goto_url("/admin/category.php?code=main");
?>