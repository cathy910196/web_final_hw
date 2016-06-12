<?php
// 顯示照片數量與分頁連結 
$html_photolist = <<<HERE
<div id="photolist_nav">
  共有 {$_SESSION['totalRows']} 張照片 / 頁次： {$pageLinks}
</div>
{$photoList}
<div id="spacer">&nbsp;</div>

<!-- 顯示照片數量與分頁連結 -->
<div id="photolist_nav">
  共有 {$_SESSION['totalRows']} 張照片 / 頁次： {$pageLinks}
</div>
HERE;
?>