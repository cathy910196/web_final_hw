<?php
$html_prev_photo_link = <<<'HERE'
    <a href="#" onclick="xajax_showPhoto({$prev_id});
       return false;">&lt;上一張</a>
HERE;

$html_next_photo_link = <<<'HERE'
    <a href="#" onclick="xajax_showPhoto({$next_id});
       return false;"> 下一張&gt;</a>
HERE;
?>