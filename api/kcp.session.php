<?php

include_once '/home/juin/www/common.php';

set_session("ss_cert_type",    $_POST["ss_cert_type"]);
set_session("ss_cert_no",      $_POST["ss_cert_no"]);
set_session("ss_cert_hash",    $_POST["ss_cert_hash"]);
set_session("ss_cert_adult",   $_POST["ss_cert_adult"]);
set_session("ss_cert_birth",   $_POST["ss_cert_birth"]);
set_session("ss_cert_sex",     $_POST["ss_cert_sex"]);
set_session('ss_cert_dupinfo', $_POST['ss_cert_dupinfo']);