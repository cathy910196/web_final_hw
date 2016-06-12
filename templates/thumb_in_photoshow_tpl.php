<?php
// 縮圖樣版
$html_thumb = <<<'HERE'
    <img class="{$thumb_class}" alt="{$thumb_name}"
         src="{$thumb_imgsrc}" 
         href="#" onclick="xajax_showPhoto({$thumb_id});">
HERE;
?>