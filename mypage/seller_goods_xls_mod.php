<?php
if(!defined('_BLUEVATION_')) exit;

$pg_title = "상품 엑셀일괄수정";
include_once("./admin_head.sub.php");
?>

<form name="fitemexcel" id="fitemexcel" method="post" onsubmit="return fitemexcel_submit(this);" enctype="MULTIPART/FORM-DATA">

<div class="tbl_frm02">
	<table>
	<colgroup>
		<col class="w180">
		<col>
	</colgroup>
	<tbody>
	<tr>
		<th scope="row">샘플파일 다운</th>
		<td>
            <div class="btn_wrap tal">
                <a href="<?php echo BV_LIB_URL; ?>/Excel/itemexcelsellerv3_mod.xls" class="fbtn xls"><span>샘플파일 다운로드</span></a>
                <a href="<?php echo BV_ADMIN_URL; ?>/category/category_excel.php" class="fbtn xls"><span>카테고리 다운로드</span></a>
            </div>
		</td>
	</tr>
	<tr>
		<th scope="row">파일 업로드</th>
		<td><input type="file" name="excelfile"></td>
	</tr>
	</tbody>
	</table>
</div>

<div class="btn_confirm">
	<input type="submit" value="상품 일괄수정" class="btn_large">
</div>
</form>

<div class="text_box btn_type mart50">
    <h5 class="tit">도움말</h5>
    <ul class="cnt_list step01">
        <li>엑셀자료는 1회 업로드당 최대 1,000건까지 이므로 1,000건씩 나누어 업로드 하시기 바랍니다.</li>
        <li>엑셀파일을 저장하실 때는 <strong>Excel 97 - 2003 통합문서 (*.xls)</strong>로 저장하셔야 합니다.</li>
        <li>엑셀데이터는 4번째 라인부터 저장되므로 샘플파일 설명글과 타이틀은 지우시면 안됩니다.</li>
    </ul>
</div>

<script>
function fitemexcel_submit(f)
{
    if(!f.excelfile.value) {
        alert('(*.xls) 파일을 업로드해주십시오.');
        return false;
    }

	if(!f.excelfile.value.match(/\.(xls)$/i) && f.excelfile.value) {
        alert('(*.xls) 파일만 등록 가능합니다.');
        return false;
    }

	if(!confirm("상품 일괄수정을 진행하시겠습니까?"))
		return false;

	f.action = "./page.php?code=seller_goods_xls_mod_update";
	return true;
}
</script>

<?php
include_once("./admin_tail.sub.php");
?>