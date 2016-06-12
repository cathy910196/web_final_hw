<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>random</title>

<!--JQuery--->

<script src="jquery/js/jquery-1.7.1.min.js"></script>
<script src="jquery/jquery.masonry.min.js"></script>
<style>
.item {
	width: 220px;
	margin: 10px;
	float: left;
}
body{
	background-color:#00BBFF;
	font-family: 微軟正黑體;
	text-align:center;
	font-size:18px;
}
</style>

<?php
session_start();

include("mysql.inc.php");

//抓取所有資料
 $sql = "SELECT * FROM  sender order by id ASC LIMIT 10";
 $sql_result = mysqli_query ($conn,$sql);
 $info = mysqli_fetch_array($sql_result);
  ?>
  
  
</head>
<body>
<div id="container">
<div class="item">
   <?php 
     $i=1;
	 
   do { ?>
   <?php 
       if ($i%3==0) {$liclass="#FFCCCC";}
    else if($i%3==1){$liclass="#BBFFEE";} 
	else{{$liclass="#FFFFBB";} }?>
  <div class="item" style="background-color:<?php echo $liclass;?>;">
    <?php echo "編號：",$info["id"],"<br>";?>
    <?php echo "名字：",$info["name"],"<br>";?>
    <?php echo "性別：",$info["gender"],"<br>";?>
    <?php echo "年齡：",$info["age"],"<br>";?>
    <?php echo "體型：",$info["size"],"<br>";?>
    <?php echo "聯絡方式：",$info["contactinfo"],"<br>";?>
  </div>
  <?php
  $i++;
   } while ($info = mysqli_fetch_assoc($sql_result)); ?>

</div></div>

<a href="sender_3.html">next step</a>
</body>

<!--JQuery的script--->
<script>
$(function(){
  $('#container').masonry({
    // options
    itemSelector : '.item',
    columnWidth : 240
  });
});
</script>
</html>