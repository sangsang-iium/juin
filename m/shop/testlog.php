<?php
include_once "./_common.php";
?>

<form action="testlogView.php" method="POST">
  <input type="text" name="postdata">
  <button type="submit">POST SUBMIT</button>
</form>
<a href="/m/shop/testlogView.php?getdata=getvalue">QUERYSTRING SUBMIT</a>
