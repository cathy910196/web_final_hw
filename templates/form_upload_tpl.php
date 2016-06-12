<?php
$html_form_upload = <<<HERE
<p>請輸入要上傳的照片檔名稱：</p>

<form id="upload" action="upload.php"
      method="post" enctype="multipart/form-data">

  <input type="file" name="picture[]" size="30"><br>
  <input type="file" name="picture[]" size="30"><br>
  <input type="file" name="picture[]" size="30"><br>
  <input type="file" name="picture[]" size="30"><br>
  <input type="file" name="picture[]" size="30"><br>

  <input name="doupload" value="1" type="hidden"><br><br>
  <input type="submit" value="上傳">
</form>

<p><a href="index.php">回網路相簿首頁</a></p>
HERE;
?>