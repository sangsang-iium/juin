<?php
include_once('./_common.php');
include_once(BV_LIB_PATH.'/json.lib.php');

set_session('ss_admin_token', '');

$error = admin_referer_check(true);
if($error)
    die(json_encode(array('error'=>$error, 'url'=>BV_URL)));

$token = get_admin_token();

die(json_encode(array('error'=>'', 'token'=>$token, 'url'=>'')));
?>