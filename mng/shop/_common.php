<?php
include_once('../../common.php');

if(isset($_REQUEST['sort']))  {
    $sort = trim($_REQUEST['sort']);
    $sort = preg_replace("/[\<\>\'\"\\\'\\\"\%\=\(\)\s]/", "", $sort);
} else {
    $sort = '';
}

if(isset($_REQUEST['sortodr']))  {
    $sortodr = preg_match("/^(asc|desc)$/i", $sortodr) ? $sortodr : '';
} else {
    $sortodr = '';
}

// $member2 추가 _20240624_SY
if(isset($member2['id'])) {
  $member = get_member($member2['id']);
}
?>
