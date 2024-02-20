<?php
if(!defined('_BLUEVATION_')) exit;

include_once(BV_MYPAGE_PATH."/admin_head.php");

$default['de_board_wr_use'] = 0;
$pg_title = $board['boardname'];
?>

<div id="wrapper">
	<div id="snb">
		<?php
		include_once($admin_snb_file);
		?>
	</div>
	<div id="content">
		<?php
		include_once(BV_MYPAGE_PATH."/admin_head.sub.php");

		$file = BV_DATA_PATH.'/board/boardimg/'.$board['fileurl1'];
		if(is_file($file) && $board['fileurl1']) {
			$file = rpc($file, BV_PATH, BV_URL);
			echo '<p><img src="'.$file.'"></p>';
		}
		?>
