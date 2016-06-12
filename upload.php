<?php
header('Content-Type: text/html; charset=utf-8');
session_start();

//引入自訂的變數與資料庫設定檔
require_once('config.inc.php');
require_once('db.inc.php');

//定義 $errMsg 變數, 用以存放錯誤訊息
$errMsg='';
//定義 $usrMsg 變數, 用以存放一般訊息
$usrMsg='';

//---------------------- 上傳照片 -----------------------------------
//如果管理模式未開啟, 便不允許上傳照片
if ( ! isset($_SESSION['admin']) || $_SESSION['admin'] != TRUE) {
    $errMsg.='不允許上傳照片, 因為您不是管理員,
              或者登入閒置時間過久, 請重新登入。<br>';
    //不顯示上傳照片的表單
    $subTemplate=FALSE;
}
//檢查是否帶有隱藏欄位的參數, 若有, 表示已經執行上傳動作
elseif ( isset($_POST['doupload']) && $_POST['doupload'] == 1 ) {

  //逐筆讀取各上傳檔案在用戶端的原始檔名, 與其索引值
  foreach ($_FILES["picture"]["name"] as $key => $name) {

    //上傳後在伺服器上面的臨時檔名
    $filename_tmp = $_FILES["picture"]["tmp_name"][$key];

    //若原始檔名不存在, 表示某一欄位並未上傳檔案,
    //故忽略下面步驟, 進行下一輪迴圈
    if ( empty($name) ) continue;

    //取得副檔名
    $ext = strtolower(strrchr($name, '.'));
    //產生要儲存在伺服器上面的檔名
    $filename = uniqid(). $ext;
    //上傳檔案的大小
    $size = $_FILES['picture']['size'][$key];

    //搬移到 config.inc.php 所指定的照片目錄
    $dest=$dirPhoto.$filename;
    if ( move_uploaded_file($filename_tmp, $dest) ) {

      //使用自訂的 mkthumb() 函式製作縮圖
      $err=mkthumb($dest, $dirThumb.$filename, $thumbMaxLength);
      //mkthumb() 回傳值如果不是 ok, 表示縮圖製作時發生錯誤
      if ( $err != 'ok' ){
        $errMsg.=$err;
      }

      //設定使用台北時區
      date_default_timezone_set('Asia/Taipei');
	  
	  // mysqli_stmt_bind_param 繫結的參數
      // 為傳址呼叫, 所以將要寫入的日期設為變數
	  $date = date("Y-m-d H:i:s"); 

	  //將上傳檔案的相關資料寫入資料庫
      $stmt = mysqli_prepare($conn, 
                "INSERT $tbPhoto (`name`,`filename`,`size`,`date`)
                 VALUES (?, ?, ?, ?)");
      mysqli_stmt_bind_param($stmt, 'ssis', 
				$name, $filename, $size, $date);
      $result = mysqli_stmt_execute($stmt);         
      
      if ($result){
          $usrMsg.="$name 上傳成功<br>";
          //上傳成功後, 照片總數便會改變, 所以刪除存放照片總數
          //的變數, 下次重新取得照片總數
          unset($_SESSION['totalRows']);
      }
      else {
        $errMsg.="無法寫入資料庫, $name 上傳失敗<br>";
        //若無法寫入資料庫, 便無法讓相片正常顯示,
        //所以將已經上傳的檔案刪除
        unlink($dest);
      }
    }
    else {
      $errMsg.="$name 上傳失敗<br>";
    }
  }
}

//設定本程式使用的子樣版檔名
require_once($templateDir.'form_upload_tpl.php');

//將子樣版的檔名設定給 subTemplate 樣版變數
$subTemplate = $html_form_upload;

//引用連結樣版
require_once('templates/main_navigation_tpl.php');  
if(!empty($_SESSION['admin']))
  $navigation = $html_admin_navi;
else
  $navigation = $html_user_navi;  

//引用主樣版
require_once($templateDir.'main_tpl.php');  
echo $html;

//---------------------- 製作縮圖的函式 -----------------------------
//$orig, $thumb是原始圖與縮圖的路徑與檔名, $maxLength 是縮圖的最大長度
function mkthumb( $orig, $thumb, $maxLength ){

  $ext = strrchr($orig, ".");

  //依照副檔名, 使用不同函式將原始照片載入記憶體
  switch ($ext){
  case '.jpg':
  case '.jpeg':
    $picSrc = imagecreatefromjpeg($orig);
    break;
  case '.png':
    $picSrc = imagecreatefrompng($orig);
    break;
  case '.gif':
    $picSrc = imagecreatefromgif($orig);
    break;
  default:
    //傳回錯誤訊息
    return "不支援 $ext 圖檔格式, 無法製作 $orig 的縮圖"; 
  }

  //取得原始圖的高度 ($picSrc_y) 與寬度 ($picSrc_x)
  $picSrc_x = imagesx($picSrc);
  $picSrc_y = imagesy($picSrc);

  //依照 $maxLength 參數, 計算縮圖應該使用的
  //高度 ($picDst_y) 與寬度 ($picDst_x)
  if ($picSrc_x > $picSrc_y) {
    $picDst_x = $maxLength;
    //intval() 可取得數字的整數部分
    $picDst_y = intval($picSrc_y / $picSrc_x * $maxLength);
  } else {
    $picDst_x = $maxLength;
    $picDst_y = intval($picSrc_x / $picSrc_y * $maxLength);
  }

  //在記憶體中建立新圖
  $picDst = imagecreatetruecolor($picDst_x, $picDst_y);

  //將原始照片複製並且縮小到新圖
  imagecopyresized($picDst, $picSrc, 0, 0, 0, 0,
                   $picDst_x, $picDst_y, $picSrc_x, $picSrc_y);

  //將新圖寫入 $thumb 參數指定的縮圖檔名
  imagejpeg($picDst, $thumb);

  return 'ok';
}
?>
