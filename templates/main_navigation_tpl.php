<?php
$html_admin_navi =<<<HERE
      <a href="upload.php">上傳照片</a>
      <a href="login.php?logout=1">登出 {$_SESSION['adminUser']}</a>
HERE;

$html_user_navi =<<<HERE
      [<a href="login.php">管理者登入</a>]
HERE;
?>