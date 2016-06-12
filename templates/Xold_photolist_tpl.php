<?php
// 顯示照片數量與分頁連結 
$html_photolist = <<<HERE
<div id="photolist_nav">
  共有 {$_SESSION['totalRows']} 張照片 / 頁次： {$pageLinks}
</div>
HERE;

// 顯示照片縮圖列表 
$i=0; 
foreach ($all as $row) {
  $html_photolist .= <<<HERE
  <div id="photolist">
    <span>
    <img id="photolist" alt="{$row['name']}" src="{$row['imgsrc']}" href="#"
         onclick="xajax_showPhoto({$row['id']});">
HERE;

// 如果管理模式已經開啟, 便顯示編輯與刪除連結 *}
  if (!empty($_SESSION['admin']))
    $html_photolist .= <<<HERE
      [<a href="edit.php?id={$row['id']}">編輯</a>]
      [<a href="del.php?id={$row['id']}"
          onClick="return confirm('確定要刪除嗎?');">刪除</a>]
HERE;

  $html_photolist .= <<<HERE
    </span>
  </div>
HERE;

}

$html_photolist .= <<<HERE
<div id="spacer">&nbsp;</div>

{* 顯示照片數量與分頁連結 *}
<div id="photolist_nav">
  共有 {$_SESSION['totalRows']} 張照片 / 頁次： {$pageLinks}
</div>
HERE;
?>