<?php
if(!defined("_BLUEVATION_")) exit; // 개별 페이지 접근 불가
include_once(BV_PATH.'/head.php');


?>
<script>
  function getAllSessionKeys() {
    var keys = [];
    for (var i = 0; i < sessionStorage.length; i++) {
        var key = sessionStorage.key(i);
        keys.push(key);
    }
    return keys;
  }
  var sessionKeys = getAllSessionKeys();
  const memberSession ='<?php echo $member['id']?>';

  console.log(sessionKeys)
  console.log(sessionKeys.includes(memberSession))
  if(!sessionKeys.includes(memberSession)){
    sessionStorage.setItem(memberSession, '');
  }

</script>