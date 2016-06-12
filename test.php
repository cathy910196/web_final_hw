<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>test</title>
<!--JQuery--->
<link href="jquery/jquery-ui.css" rel="stylesheet">
<script src="jquery/js/jquery-1.7.1.min.js"></script>
<script src="jquery/jquery.masonry.min.js"></script>
<script src="jquery/external/jquery/jquery.js"></script>
<script src="jquery/jquery-ui.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="jquery/jquery.scrollTo.js"></script>
<script src="jquery/jquery.localScroll.js"></script>
<style>
body {
	margin: 0;
	padding: 0;
	color: #000000;
	font-family: 微軟正黑體;
	text-align:center;
}
nav {
	width: 100%;
	height: 80px;
	text-align: center;
	line-height: 80px;
	background-color: #000000;
	position: fixed;
}
word{
	text-align: center;
	font-weight:bold;
	color: #ffffff;
	font-family:微軟正黑體;
	font-size:24px;
}
word2{
	text-align: center;
	font-weight:bold;
	color: #000000;
	font-family:微軟正黑體;
	font-size:24px;
}
nav a {
	margin: 15px;
	color: #fff;
	text-decoration: none;
}
#box1 {
	width: 100%;
	height: 800px;
	background-color: #FFFF77;
	font-weight:bold;
	font-size:60px;
}
#box2 {
	width: 100%;
	height: 1000px;
	background-color: #33CCFF;
	font-weight:bold;
	font-size:60px;
}
#box3 {
	width: 100%;
	height: 1200px;
	background-color: #FFDA40;
	font-weight:bold;
	font-size:60px;
}
#box3 {
	width: 100%;
	height: 1200px;
	background-color:#99FF33;
	font-weight:bold;
	font-size:60px;
}
#box4 {
	width: 100%;
	height: 1400px;
	background-color:#00BBFF;
	font-weight:bold;
	font-size:60px;
}
#box5 {
	width: 100%;
	height: 1600px;
	background-color:#77DDFF;
	font-weight:bold;
	font-size:60px;
}
#box6 {
	width: 100%;
	height: 1800px;
	background-color:#CCEEFF;
	font-weight:bold;
	font-size:60px;
}
#box7 {
	width: 100%;
	height: 2000px;
	background-color: #77FF00;
	font-weight:bold;
	font-size:60px;
}
#box8 {
	width: 100%;
	height: 2200px;
	background-color:#BBFF66;
	font-weight:bold;
	font-size:60px;
}
#box9 {
	width: 100%;
	height: 2400px;
	background-color:#CCFF99;
	font-weight:bold;
	font-size:60px;
}
</style>
</head>

<body>
<?php
session_start();

include("mysql.inc.php");

//抓取所有資料
 $sql = "SELECT * FROM  sender order by id ASC";
 $sql_result = mysqli_query ($conn,$sql);
 $info = mysqli_fetch_array($sql_result);
  ?>
<div id="container">
  <nav><word>做一個小小的性向測驗<word></nav>
  <section id="box1">
  <br><br>你喜歡
   <h1><a href="#box2">成年的</a> <a href="#box3">年幼的</a></h1>
  </section>
  <section id="box2"><br><br>你喜歡成年中的<br><a href="#box4">大型/</a><a href="#box5">中型/</a><a href="#box6">小型
  <br><input type ="button" onclick="history.back()" value="回上步"></input>
  </a></section>
  <section id="box3"><br><br>你喜歡幼年中的<br><a href="#box7">大型/</a><a href="#box8">中型/</a><a href="#box9">小型</a>
  <br><input type ="button" onclick="history.back()" value="回上步"></input>
  </section>
  <section id="box4"> 
  <!---成年，大--->
  <br><br>成年，大

     <?php 
     $i=1;
   do { 
       if ($i%3==0) {$liclass="#FFCCCC";}
    else if($i%3==1){$liclass="#BBFFEE";} 
	else{{$liclass="#FFFFBB";} }?>
  <div class="item"  style="font-size:24px; background-color:
  <?php echo $liclass;?>;">
    <?php if($info["size"]=="大型"&&$info["age"]>2 ){ ?>
    <?php echo "編號：",$info["id"],",";?>
    <?php echo "名字：",$info["name"],",";?>
    <?php echo "性別：",$info["gender"],",";?>
    <?php echo "年齡：",$info["age"],",";?>
    <?php echo "體型：",$info["size"],",";?>
    <?php echo "聯絡方式：",$info["contactinfo"];}
	?>
  </div>
  <?php
  $i++;
   } while ($info = mysqli_fetch_assoc($sql_result)); ?>
  
<input type ="button" onclick="history.back()" value="回上步"></input>
<input type ="button" onclick=location.href='sender_3.html' value="下一步"></input>
  </section>
  <section id="box5">
    <!---成年，中--->
    <br><br>成年，中
     <?php

//抓取所有資料
 $sql = "SELECT * FROM  sender order by id ASC";
 $sql_result = mysqli_query ($conn,$sql);
 $info = mysqli_fetch_array($sql_result);
  ?>
         <?php 
     $i=1;
   do { 
       if ($i%3==0) {$liclass="#FFCCCC";}
    else if($i%3==1){$liclass="#BBFFEE";} 
	else{{$liclass="#FFFFBB";} }?>
  <div class="item"  style="font-size:24px; background-color:
  <?php echo $liclass;?>;">
    <?php if($info["size"]=="中型"&&$info["age"]>2 ){ ?>
    <?php echo "編號：",$info["id"],",";?>
    <?php echo "名字：",$info["name"],",";?>
    <?php echo "性別：",$info["gender"],",";?>
    <?php echo "年齡：",$info["age"],",";?>
    <?php echo "體型：",$info["size"],",";?>
    <?php echo "聯絡方式：",$info["contactinfo"];}
	?>
  </div>
  <?php
  $i++;
   } while ($info = mysqli_fetch_assoc($sql_result)); ?>
  
<input type ="button" onclick="history.back()" value="回上步"></input>
<input type ="button" onclick=location.href='sender_3.html' value="下一步"></input>
  </section>
  <section id="box6">
    <!---成年，小--->
    <br><br>成年，小
     <?php

//抓取所有資料
 $sql = "SELECT * FROM  sender order by id ASC";
 $sql_result = mysqli_query ($conn,$sql);
 $info = mysqli_fetch_array($sql_result);
  ?>
         <?php 
     $i=1;
   do { 
       if ($i%3==0) {$liclass="#FFCCCC";}
    else if($i%3==1){$liclass="#BBFFEE";} 
	else{{$liclass="#FFFFBB";} }?>
  <div class="item"  style="font-size:24px; background-color:
  <?php echo $liclass;?>;">
    <?php if($info["size"]=="小型"&&$info["age"]>2 ){ ?>
    <?php echo "編號：",$info["id"],",";?>
    <?php echo "名字：",$info["name"],",";?>
    <?php echo "性別：",$info["gender"],",";?>
    <?php echo "年齡：",$info["age"],",";?>
    <?php echo "體型：",$info["size"],",";?>
    <?php echo "聯絡方式：",$info["contactinfo"];}
	?>
  </div>
  <?php
  $i++;
   } while ($info = mysqli_fetch_assoc($sql_result)); ?>
  
<input type ="button" onclick="history.back()" value="回上步"></input>
<input type ="button" onclick=location.href='sender_3.html' value="下一步"></input>
  </section>
  <section id="box7">
    <!---幼年，大--->
    <br><br>幼年，大
     <?php

//抓取所有資料
 $sql = "SELECT * FROM  sender order by id ASC";
 $sql_result = mysqli_query ($conn,$sql);
 $info = mysqli_fetch_array($sql_result);
  ?>
     <?php 
     $i=1;
   do { 
       if ($i%3==0) {$liclass="#FFCCCC";}
    else if($i%3==1){$liclass="#BBFFEE";} 
	else{{$liclass="#FFFFBB";} }?>
  <div class="item"  style="font-size:24px; background-color:
  <?php echo $liclass;?>;">
    <?php if($info["size"]=="大型"&&$info["age"]<=2 ){ ?>
    <?php echo "編號：",$info["id"],",";?>
    <?php echo "名字：",$info["name"],",";?>
    <?php echo "性別：",$info["gender"],",";?>
    <?php echo "年齡：",$info["age"],",";?>
    <?php echo "體型：",$info["size"],",";?>
    <?php echo "聯絡方式：",$info["contactinfo"];}
	?>
  </div>
  <?php
  $i++;
   } while ($info = mysqli_fetch_assoc($sql_result)); ?>
  
<input type ="button" onclick="history.back()" value="回上步"></input>
<input type ="button" onclick=location.href='sender_3.html' value="下一步"></input>
  </section>
  <section id="box8">
  <!---幼年，中--->
  <br><br>幼年，中 
   <?php

//抓取所有資料
 $sql = "SELECT * FROM  sender order by id ASC";
 $sql_result = mysqli_query ($conn,$sql);
 $info = mysqli_fetch_array($sql_result);
  ?>
      <?php 
     $i=1;
   do { 
       if ($i%3==0) {$liclass="#FFCCCC";}
    else if($i%3==1){$liclass="#BBFFEE";} 
	else{{$liclass="#FFFFBB";} }?>
  <div class="item"  style="font-size:24px; background-color:
  <?php echo $liclass;?>;">
    <?php if($info["size"]=="中型"&&$info["age"]<=2 ){ ?>
    <?php echo "編號：",$info["id"],",";?>
    <?php echo "名字：",$info["name"],",";?>
    <?php echo "性別：",$info["gender"],",";?>
    <?php echo "年齡：",$info["age"],",";?>
    <?php echo "體型：",$info["size"],",";?>
    <?php echo "聯絡方式：",$info["contactinfo"];}
	?>
  </div>
  <?php
  $i++;
   } while ($info = mysqli_fetch_assoc($sql_result)); ?>
  
<input type ="button" onclick="history.back()" value="回上步"></input>
<input type ="button" onclick=location.href='sender_3.html' value="下一步"></input>
 
  </section>
  <section id="box9">
  <!---幼年，小--->
  <br><br>幼年，小
   <?php

//抓取所有資料
 $sql = "SELECT * FROM  sender order by id ASC";
 $sql_result = mysqli_query ($conn,$sql);
 $info = mysqli_fetch_array($sql_result);
  ?>
     <?php 
     $i=1;
   do { 
       if ($i%3==0) {$liclass="#FFCCCC";}
    else if($i%3==1){$liclass="#BBFFEE";} 
	else{{$liclass="#FFFFBB";} }?>
  <div class="item"  style="font-size:24px; background-color:
  <?php echo $liclass;?>;">
    <?php if($info["size"]=="小型"&&$info["age"]<=2 ){ ?>
    <?php echo "編號：",$info["id"],",";?>
    <?php echo "名字：",$info["name"],",";?>
    <?php echo "性別：",$info["gender"],",";?>
    <?php echo "年齡：",$info["age"],",";?>
    <?php echo "體型：",$info["size"],",";?>
    <?php echo "聯絡方式：",$info["contactinfo"];}
	?>
  </div>
  <?php
  $i++;
   } while ($info = mysqli_fetch_assoc($sql_result)); ?>
  
<input type ="button" onclick="history.back()" value="回上步"></input>
<input type ="button" onclick=location.href='sender_3.html' value="下一步"></input>
  </section>
</body>
<script>
	$(document).ready(function(){
        $("nav").localScroll({
			duration:600,
			hash:true
		});
    });
</script>
</html>