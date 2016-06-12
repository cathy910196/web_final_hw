<?php
if(empty($xajaxJS))    $xajaxJS ='';
if(empty($navigation)) $navigation ='';
if(empty($errMsg))     $errMsg = '';
if(empty($usrMsg))     $usrMsg ='';
if(empty($maintext))   $maintext ='';
if(empty($subTemplate)) $subTemplate ='';

$html = <<<HERE
<!DOCTYPE>
<html>
<head>
  <meta charset="UTF-8">
  <title>網路相簿</title>
  <link href="main.css" rel="stylesheet" type="text/css">
  <!-- 輸出 xajax 所產生的 JavaScript -->
  {$xajaxJS}
</head>

<body>
<div id="wrapper">
<div id="title">
  <img id="title_img" src="logo.jpg">
  <h1>網路相簿</h1>
  <div id="navigation">{$navigation}</div>
</div>

<div id="maintext">

  <!-- errMsg 是錯誤訊息, usrMsg 是一般訊息 -->
  <div id="errMsg">{$errMsg}</div>
  <div id="usrMsg">{$usrMsg}</div>

  <p>{$maintext}</p> <!-- 要顯示在 maintext 區域的內容 -->

  <!-- subTemplate 樣版變數代表要引用的子樣版 -->
  {$subTemplate}

</div>

</div>
</body>
</html>
HERE;
?>