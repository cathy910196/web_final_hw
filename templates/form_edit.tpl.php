<?php
html_form_edit = <<<HERE
<form method="post" action="edit.php" name="edit">
  <img src="{$thumb}" /><br>
    檔案大小：{$size} Bytes<br>
    上傳時間：{$date}<br />
    照片名稱：<input name="name" value="{$name}"><br>
    照片說明：<br>
    <textarea cols="35" rows="3" name="comment">
      {$comment}
    </textarea><br>
  <input name="id" value="{$id}" type="hidden">
  <input name="submit" type="submit" value="送出">
</form>

<p><a href="index.php">回網路相簿首頁</a></p>
HERE;
?>