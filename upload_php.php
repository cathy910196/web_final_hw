<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>檔案上傳表單</title>
</head>
<body>
<?php
	$orig=$_FILES['file']['name'];
	    //取得副檔名
    $ext = strtolower(strrchr($orig, '.'));
	$srcs='./upload/';
				 
  //將原始檔搬移到上傳目錄
  move_uploaded_file($orig,$srcs);
	

  switch ($ext){
  case '.jpg':
  case '.jpeg':
    $src = @imagecreatefromjpeg($orig);
    break;
  case '.png':
    $src = @imagecreatefrompng($orig);
    break;
  case '.gif':
    $src = @imagecreatefromgif($orig);
    break;
  default:
    //傳回錯誤訊息
    return "不支援 $ext 圖檔格式, 無法製作 $orig 的縮圖"; 
  }
 // move_uploaded_file($this,$src);
  
// 取得上傳圖片
//$src = imagecreatefromgif($_FILES['file']['tmp_name']);

// 取得來源圖片長寬
$src_w = @imagesx($src);
$src_h = @imagesy($src);

// 假設要長寬不超過90
if($src_w > $src_h){
  $thumb_w = 90;
  $thumb_h = @intval($src_h / $src_w * 90);
}else{
  $thumb_h = 90;
  $thumb_w = @intval($src_w / $src_h * 90);
}

// 建立縮圖
$thumb = @imagecreatetruecolor($thumb_w, $thumb_h);

// 開始縮圖
@imagecopyresampled($thumb, $src, 0, 0, 0, 0, $thumb_w, $thumb_h, $src_w, $src_h);

// 儲存縮圖到指定 thumb 目錄
@imagejpeg($thumb, "thumb/".$_FILES['file']['name']);

// 複製上傳圖片到指定 images 目錄
copy($_FILES['file']['tmp_name'], "upload/" . $_FILES['file']['name']); 


?>
<img src="upload/<?php echo $orig; ?>" width="20%" height="20%"><br>
      <form method="POST" action="sender_1.php">
      <input type="hidden" name="name" value="upload/<?php echo $orig; ?>">
      <input name="upload" type="submit" value="回去">
      </form>

</body>
</html>