<?php
// 採用 PHP 5.3 NOWDOC 語法
$html_admin_edit_links = <<<'HERE'
      [<a href="edit.php?id={$row['id']}">編輯</a>]
      [<a href="del.php?id={$row['id']}"
          onClick="return confirm('確定要刪除嗎?');">刪除</a>]
HERE;

?>