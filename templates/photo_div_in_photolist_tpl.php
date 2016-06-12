<?php
// 採用 PHP 5.3 NOWDOC 語法
$html_photo_div = <<<'HERE'
  <div class="photolist">
    <span>
    <img id="photolist" alt="{$row['name']}" src="{$row['imgsrc']}" href="#"
         onclick="xajax_showPhoto({$row['id']});">
    {$admin_edit_links}
    </span>
  </div>
HERE;
?>