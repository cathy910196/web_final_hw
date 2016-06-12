<?php
$html_login = <<<HERE

<form id="login">
  帳號: <input name="username" type="text"><br>
  密碼: <input name="password" type="password"><br><br>
  
  <!-- 使用者按下按鈕時會觸發 onClick 事件, $xajaxLoginClick 則代表
     xajax 以 printscript() 方法產生的 xajax 函式呼叫 -->
  <button onClick="{$xajaxLoginClick}; return false;">登入</button>
</form>

<p><a href="index.php">回網路相簿首頁</a></p>

HERE;
?>