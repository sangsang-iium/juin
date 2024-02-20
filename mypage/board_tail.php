<?php
if(!defined('_BLUEVATION_')) exit;

$file = BV_DATA_PATH.'/board/boardimg/'.$board['fileurl2'];
if(is_file($file) && $board['fileurl2']) {
	$file = rpc($file, BV_PATH, BV_URL);
	echo '<p><img src="'.$file.'"></p>';
}
?>
		<?php
		include_once(BV_MYPAGE_PATH."/admin_tail.sub.php"); 
		?>
	</div>
</div>

<?php
include_once(BV_MYPAGE_PATH."/admin_tail.php"); 
?>