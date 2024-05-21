<?php
include_once "./_common.php";
error_reporting(E_ALL);
ini_set("display_errors", 1);

// 자료가 많을 경우 대비 설정변경
set_time_limit(0);
ini_set('memory_limit', '500M');

// check_demo();

// check_admin_token();

$expire = '';
if ($config['cf_point_term'] > 0) {
  $expire = $config['cf_point_term'];
}

if ($_FILES['excelfile']['tmp_name']) {
  $file = $_FILES['excelfile']['tmp_name'];

  include_once BV_LIB_PATH . '/Excel/reader.php';

  $data = new Spreadsheet_Excel_Reader();


  // Set output Encoding.
  $data->setOutputEncoding('UTF-8');

  /***
    * if you want you can change 'iconv' to mb_convert_encoding:
    * $data->setUTFEncoder('mb');
    *
    **/

  /***
    * By default rows & cols indeces start with 1
    * For change initial index use:
    * $data->setRowColOffset(0);
    *
    **/

  /***
    * Some function for formatting output.
    * $data->setDefaultFormat('%.2f');
    * setDefaultFormat - set format for columns with unknown formatting
    *
    * $data->setColumnFormat(4, '%.3f');
    * setColumnFormat - set format for column (apply only to number fields)
    *
    **/

  $data->read($file);

	print_r($data);

  /*
	$data->sheets[0]['numRows'] - count rows
	$data->sheets[0]['numCols'] - count columns
	$data->sheets[0]['cells'][$i][$j] - data from $i-row $j-column

	$data->sheets[0]['cellsInfo'][$i][$j] - extended info about cell

	$data->sheets[0]['cellsInfo'][$i][$j]['type'] = "date" | "number" | "unknown"
	if 'type' == "unknown" - use 'raw' value, because  cell contain value with format '0.00';
	$data->sheets[0]['cellsInfo'][$i][$j]['raw'] = value if cell without format
	$data->sheets[0]['cellsInfo'][$i][$j]['colspan']
	$data->sheets[0]['cellsInfo'][$i][$j]['rowspan']
    */

  $dup_mb_id   = array();
  $dup_count   = 0; // 중복건수
  $total_count = 0; // 총회원수
  $fail_count  = 0; // 실패건수
  $succ_count  = 0; // 완료건수


  for ($i = 2; $i <= $data->sheets[0]['numRows']; $i++) {
    if(trim($data->sheets[0]['cells'][$i][1]) == '')
    	continue;

    $total_count++;

    $j = 1;

    $idx = addslashes(trim($data->sheets[0]['cells'][$i][$j++]));              // 번호
    $b   = addslashes(trim($data->sheets[0]['cells'][$i][$j++]));              // 지회/지부명
    $c   = addslashes(trim($data->sheets[0]['cells'][$i][$j++]));              // 사업자번호
    $d   = addslashes(trim($data->sheets[0]['cells'][$i][$j++]));              // 유형
    $e   = addslashes(trim($data->sheets[0]['cells'][$i][$j++]));              // 고객명
    $f   = addslashes(trim($data->sheets[0]['cells'][$i][$j++]));              // 대표자
    $g   = addslashes(trim($data->sheets[0]['cells'][$i][$j++]));              // 대표전화
    $h   = addslashes(trim($data->sheets[0]['cells'][$i][$j++]));              // 담당자
    $ii  = addslashes(trim($data->sheets[0]['cells'][$i][$j++]));              // 주소
    $jj   = addslashes(trim(replace_tel($data->sheets[0]['cells'][$i][$j++]))); // 연락처
    $k   = addslashes(trim($data->sheets[0]['cells'][$i][$j++]));              // 구매여부
    $l   = addslashes(trim($data->sheets[0]['cells'][$i][$j++]));              // 등록일
    $m   = addslashes(trim($data->sheets[0]['cells'][$i][$j++]));              // 주소
    $n   = addslashes(trim($data->sheets[0]['cells'][$i][$j++]));              // 주소풀

    // id, name 값이 없다면?
    // if(!$mb_id || !$mb_name) {
    //         $fail_count++;
    //         continue;
    //     }

    // id 형식체크
    // if(preg_match("/[^0-9a-z_]+/i", $mb_id)) {
    //         $fail_count++;
    //         continue;
    //     }

    // id 중복체크
    // $sql = " select count(*) as cnt from shop_member where id = '$mb_id' ";
    //     $row = sql_fetch($sql);
    // if($row['cnt']) {
    //         $dup_mb_id[] = $mb_id;
    // 	$dup_count++;
    //         $fail_count++;
    //         continue;
    // }

    // 추천인이 없으면 최고관리자로 바꿈
    // if(!$mb_recommend) $mb_recommend = 'admin';
    $newTable = "shop_member_new";
    $newC     = preg_replace("/[ #\&\+\-%@=\/\\\:;,\.'\"\^`~\_|\!\?\*$#<>()\[\]\{\}]/i", "", $c);
    $newM     = mb_substr($m, 0, 2);

    unset($value);
    $value['ju_name']          = $f;
    $value['ju_b_num']         = $c;
    $value['ju_restaurant']    = $e;
    $value['ju_region1']       = $newM;
    $value['delivery_comment'] = $n;

    $value['mailser'] = 'Y'; //메일링 수신여부
    $value['smsser']  = 'Y'; //SMS 수신여부

    $upd_where = " WHERE id = '{$newC}' ";

		print_r($upd_where);

    update($newTable, $value, $upd_where);

    // 포인트 부여
    // insert_point($mb_id, (int)$mb_point, "회원가입 축하", '@passive', $mb_id, $member['id'].'-'.uniqid(''), $expire);

    $succ_count++;
  }
}

?>

<h2>총 건수</h2>
<div class="tbl_frm02">
	<table>
	<colgroup>
		<col class="w180">
		<col>
	</colgroup>
	<tbody>
	<tr>
		<th scope="row">총회원수</th>
		<td><?php echo number_format($total_count); ?>건</td>
	</tr>
	<tr>
		<th scope="row">완료건수</th>
		<td><?php echo number_format($succ_count); ?>건</td>
	</tr>
	<tr>
		<th scope="row">실패건수</th>
		<td><?php echo number_format($fail_count); ?>건</td>
	</tr>
	<?php if ($fail_count > 0) {?>
	<tr>
		<th scope="row">중복된아이디</th>
		<td><?php echo implode(', ', $dup_mb_id); ?></td>
	</tr>
	<?php }?>
	</tbody>
	</table>
</div>

<div class="btn_confirm">
	<a href="<?php echo BV_ADMIN_URL; ?>/member.php?code=xls" class="btn_large">확인</a>
</div>

<div class="information">
	<h4>도움말</h4>
	<div class="content">
		<div class="desc02">
			<p>ㆍ엑셀자료는 1회 업로드당 최대 1,000건까지 이므로 1,000건씩 나누어 업로드 하시기 바랍니다.</p>
			<p>ㆍ엑셀파일을 저장하실 때는 <strong>Excel 97 - 2003 통합문서 (*.xls)</strong>로 저장하셔야 합니다.</p>
			<p>ㆍ엑셀데이터는 4번째 라인부터 저장되므로 샘플파일 설명글과 타이틀은 지우시면 안됩니다.</p>
		</div>
	 </div>
</div>

<script>
$(function() {
	// 새로고침(F5) 막기
	$(document).keydown(function (e) {
		if(e.which === 116) {
			if(typeof event == "object") {
				event.keyCode = 0;
			}
			return false;
		} else if(e.which === 82 && e.ctrlKey) {
			return false;
		}
	});
});
</script>
