<?php
$html_photoshow = <<<HERE
<div id="photoshow_nav">
  <!-- 顯示上一張、下一張照片的連結 -->
  $prev_link | <a href="index.php">回首頁</a> | $next_link
</div>

<div id="photoshow_photo">
  <!-- 顯示照片名稱、管理員編輯/刪除連結 -->
  <p> {$row['name']}  {$admin_edit_links}</p>

  <!-- 顯示照片 -->
  <img id="photoshow_photo" alt="{$row['name']}" src="{$row['imgsrc']}">

  <!-- 照片的註解說明 -->
  <p>{$row['comment']}</p>
</div>

<!-- 顯示{前兩張+目前+後兩張}照片的縮圖 -->
<div id="photoshow_thumblist">
  {$all_thumbs}
</div>
HERE;
?>