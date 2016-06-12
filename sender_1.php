<?php
$picturename=null;
?>
<!doctype html>
<html lang="us">
<head>
<meta charset="utf-8">
<!--RWD--->
<link rel="stylesheet" href="css/style-l.css" media="only screen and (min-width:600px)">
<link rel="stylesheet" href="css/style-s.css" media="only screen and (max-width:599px)">
<title>領養者專區-履歷</title>
<!--JQuery--->
<link href="jquery/jquery-ui.css" rel="stylesheet">
<script src="jquery/external/jquery/jquery.js"></script>
<script src="jquery/jquery-ui.js"></script>
<style>
body {
	margin: 20px;
}
jq {
	color: #000099;
	font-size: 80%;
}
</style>
</head>

<body>
<div id="wrapper">
  <div id="header">
    <div class="title" style="width:80%;height:80%;position:absolute;top:10px;left:20px;"> 領養者專區-履歷 </div>
  </div>
  <div id="sidebar1">
    <form method="POST" action="sender_1_php.php">
      &nbsp; 名字:
      <div class="title" style="position:absolute;"> &nbsp;
        <input type="text" name="name">
      </div>
      <br>
      <br>
      &nbsp;  性別:
      <div id="radioset"> &nbsp;
        <input type="radio" id="radio1" name="gender" value="男生">
        <label for="radio1">
          <jq>男生</jq>
        </label>
        <input type="radio" id="radio2" name="gender" value="女生">
        <label for="radio2">
          <jq>女生</jq>
        </label>
      </div>
      <br>
      <div class="demoHeaders">&nbsp; 年齡</div>
      &nbsp;
      <input id="spinner" name="age">
      <br>
      <br>
      <div class="demoHeaders">&nbsp; 體型</div>
      <jq> &nbsp;
        <select id="selectmenu" style="width:100px" name="size">
          <option vlaue="小型">小型</option>
          <option selected="selected" value="中型" >中型</option>
          <option value="大型">大型</option>
        </select>
      </jq>
      <div class="title2" style="position:absolute;">&nbsp;  聯絡資訊：<br>
        &nbsp;
        <textarea name="contactinfo" rows="3" cols="30"></textarea>
      </div>
      <br>
      <br>
      <br>
      <br>
      &nbsp;
      <input name="submit" type="submit" value="送出">
      &nbsp;
      &nbsp;
      &nbsp;
      <input name="reset" type="reset" value="清除">
    </form>
  </div>
  <div id="content">
    <div class="title3" style="position:absolute;">
      <form action="upload_php.php"
        method="post" enctype="multipart/form-data">
        <?php
        if($picturename==null){
        echo "要上傳的檔案：" ;
        }else{
        echo $picturename;
        }
        ?>
        <br>
        <input type="file" name="file">
        <br>
        <input name="upload" type="submit" value="送出">
        <br>
        <br>
        <img src="<?php echo $_POST["name"]; ?>" width="50%" height="50%"><br>
      </form>
    </div>
    <br>
  </div>
  <div id="footer"> 「網頁程式設計」與「網頁與人機互動應用」期末報告 </div>
</div>

<!--JQuery的script---> 
<script>

$( "#accordion" ).accordion();
var availableTags = [
	"ActionScript",
	"AppleScript",
	"Asp",
	"BASIC",
	"C",
	"C++",
	"Clojure",
	"COBOL",
	"ColdFusion",
	"Erlang",
	"Fortran",
	"Groovy",
	"Haskell",
	"Java",
	"JavaScript",
	"Lisp",
	"Perl",
	"PHP",
	"Python",
	"Ruby",
	"Scala",
	"Scheme"
];

$( "#autocomplete" ).autocomplete({
	source: availableTags
});

$( "#button" ).button();
$( "#radioset" ).buttonset();
$( "#spinner" ).spinner();
$( "#selectmenu" ).selectmenu();


</script>
</body>
</html>
