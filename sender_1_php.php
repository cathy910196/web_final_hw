<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
session_start();

include("mysql.inc.php");

$name=$_POST["name"];
$gender=$_POST["gender"];
$age=$_POST["age"];
$size=$_POST["size"];
$contactinfo=$_POST["contactinfo"];

if(isset($_POST["submit"])) {

	//執行新增的動作
		$query_insert = "INSERT INTO `sender` (`name`,`gender`,`age`, `size`, `contactinfo`) VALUES (";
		$query_insert .= "'".$_POST["name"]."',";
		$query_insert .= "'".$_POST["gender"]."',";
		$query_insert .= "'".$_POST["age"]."',";
		$query_insert .= "'".$_POST["size"]."',";
		$query_insert .= "'".$_POST["contactinfo"]."')";
		mysqli_query($conn,$query_insert);
		
		echo '<script>alert("您已成功新增資料！");</script>';
		echo $_POST["name"];
		echo '<script>location.href="sender_3.html";</script>';
	
}

?>
<title>sender_1_php</title> 
</head> 

<body>

</body>
</html>