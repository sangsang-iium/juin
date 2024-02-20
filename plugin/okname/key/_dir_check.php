<?php
if(!defined('_BLUEVATION_')) exit; // 개별 페이지 접근 불가

$key_dir = BV_OKNAME_PATH.'/key';
if(!is_dir($key_dir)) {
    alert_close(BV_PLUGIN_DIR.'/'.BV_OKNAME_DIR.' 에 key 디렉토리를 생성해 주십시오.\\n\\n디렉토리 생성 후 쓰기권한을 부여해 주십시오. 예: chmod 707 key');
}

if(strtoupper(substr(PHP_OS, 0, 3)) !== 'WIN') {
    $sapi_type = php_sapi_name();
    if(substr($sapi_type, 0, 3) == 'cgi') {
        if(!(is_readable($key_dir) && is_executable($key_dir)))
        {
            $msg = BV_PLUGIN_DIR.'/'.BV_OKNAME_DIR.'/key 디렉토리의 퍼미션을 705로 변경하여 주십시오.\\nchmod 705 key 또는 chmod uo+rx key';
            alert_close($msg);
        }
    } else {
        if(!(is_readable($key_dir) && is_writeable($key_dir) && is_executable($key_dir)))
        {
            $msg = BV_PLUGIN_DIR.'/'.BV_OKNAME_DIR.'/key 디렉토리의 퍼미션을 707로 변경하여 주십시오.\\n\\nchmod 707 key 또는 chmod uo+rwx key';
            alert_close($msg);
        }
    }
}
?>