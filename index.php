<?php
header('Content-Type: text/html; charset=utf-8');
session_start();

//引入自訂的變數與資料庫設定檔
require_once('config.inc.php');
require_once('db.inc.php');

//引入 xajax  並初始化 xajax 物件
require_once('../xajax_core/xajax.inc.php');
$xajax = new xajax();
$xajax->configure('javascript URI', '../');

//註冊顯示照片列表的 showPage() 回應函式
$pgObj = $xajax->register(XAJAX_FUNCTION, 'showPage');
$pgObj->useSingleQuote();

//註冊顯示照片的 showPhoto() 回應函式
$phtObj = $xajax->register(XAJAX_FUNCTION, 'showPhoto');
$phtObj->useSingleQuote();

//如果 SESSION 的 admin 與 adminUser 變數尚未建立, 則初始化之
if ( ! isset($_SESSION['admin']) ) {
  $_SESSION['admin'] = FALSE;
  $_SESSION['adminUser'] = '';
}

//如果 SESSION 的 $currentPage 變數尚未建立, 則初始化之
if ( ! isset($_SESSION['currentPage']) ||
     ! is_numeric($_SESSION['currentPage']) ) {   //若不是數字
  $_SESSION['currentPage'] = 1;
}

//取得照片列表時每一頁要顯示的照片數量
//$listRows 是每頁的列數, $perRow 代表每列的照片個數
$perPage=$listRows * $perRow;

//取得照片的總數
if (! isset($_SESSION['totalRows']) || empty($_SESSION['totalRows']) ){
  $result=mysqli_query($conn, "SELECT `id` FROM $tbPhoto");
  $_SESSION['totalRows']=mysqli_num_rows($result);
}

//處理 xajax 回應
$xajax->processRequest();

//將 xajax 輸出的 JavaScript 程式指定給 xajaxJS 樣版變數
$xajaxJS = $xajax->getJavascript();

//使用自訂的 getPhotoList() 函式取得目前頁面的照片列表,
//然後指定給 maintext 樣版變數
$maintext = getPhotoList($_SESSION['currentPage']);

//引入樣版
require_once('templates/main_navigation_tpl.php');  
if(!empty($_SESSION['admin']))
  $navigation = $html_admin_navi;
else
  $navigation = $html_user_navi;  

//引入樣版
require_once('templates/main_tpl.php');  
echo $html;


//-------------------- 自定函式取得子樣版的內容 -----------------
//getPhotoList() 函式用來產生特定頁面的照片列表
function getPhotoList($pageID=1){    //預設為第 1 頁

  //$dirPhoto, $dirThumb 分別是照片與縮圖資料夾路徑；
  //$perRow, $perPage 則分別是每列、每頁要顯示的照片數；
  //$tbPhoto 是資料表的名稱；$conn 為資料庫物件
  global $dirPhoto, $dirThumb, $perRow, $templateDir, $perPage, 
         $tbPhoto, $conn;

  //因為另有切換分頁的功能也使用此函式, 所以要將指定顯示的頁碼設定給
  //代表目前頁面的 $currentPage 變數
  $_SESSION['currentPage']=$pageID;

  //$perRow 代表照片列表時每列的照片個數
  $perRow=$perRow;
  $rangeStart=( $pageID - 1) * $perPage;
  
  //查詢資料表, 取得目前頁碼範圍內的資料
  $sql="SELECT * FROM $tbPhoto ORDER BY `id` LIMIT $rangeStart, 
                                                   $perPage";
  $result= mysqli_query($conn, $sql);           //執行查詢

  // 取得『孫』樣版的內容
  require_once( $templateDir.'admin_edit_links_tpl.php');
  require_once( $templateDir.'photo_div_in_photolist_tpl.php');
  
  //逐筆讀出目前頁碼範圍內各照片的資料, 放入 $all 二維陣列
  $photoList='';
  while ($row = mysqli_fetch_array($result)) {
    //將照片名稱中的特殊字元轉成 HTML 碼
    $name=htmlspecialchars($row['name'], ENT_QUOTES);

    if(!empty($_SESSION['admin'])){
	  // 將要照片的 id 代入管理者樣版中出現 id 的位置
	  $edit_links = '<br>'.str_replace('{$row[\'id\']}', 
	                            $row['id'], 
								$html_admin_edit_links);
	}
	else
	  $edit_links='';
	
	// 樣板中, 要被取代的參數名稱
	$find = [ '{$row[\'id\']}', '{$row[\'name\']}', 
	          '{$row[\'imgsrc\']}', '{$admin_edit_links}' ];  
	
	// 要代入樣板的參數名稱
	$replace = [ $row['id'], $name, 
	             $dirThumb.$row['filename'], $edit_links]; 
	// 取代字串後, 與前面照片的HTML串接起來
	$photoList .= str_replace($find, $replace, $html_photo_div);
  }

  //建立分頁
  $pageLinks='';
  $totalPages= ceil($_SESSION['totalRows']/$perPage);
  for($i=1;$i <= $totalPages; $i++){
    //將分頁連結轉換為呼叫 xajax 函式
	if($i!=1) $pageLinks .=  "&nbsp;|&nbsp;";
    $pageLinks .=  sprintf(
	    '<a href="#" onclick="xajax_showPage(%d);return false;">%d</a>',
        $i, $i);
  }
  
  //回傳子樣版的內容
  require_once('templates/photolist_tpl.php');
  return $html_photolist;
}

//getPhotoShow() 函式用來顯示指定 id 的照片
function getPhotoShow($id=1) {

  global $dirPhoto, $dirThumb, $templateDir, $tbPhoto, $conn;

  //查詢資料表, 取得 id 指定照片的所有資料
  $stmt = mysqli_prepare($conn, 
                 "SELECT * FROM $tbPhoto WHERE `id` = ?");
  mysqli_stmt_bind_param($stmt, 'i', $id);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);
  $row = mysqli_fetch_array($result);
  
  //將照片名稱與註解說明中的特殊字元轉成 HTML 碼
  $row['name']=htmlspecialchars($row['name'], ENT_QUOTES);
  if(!empty($row['comment'])){
  $row['comment']=htmlspecialchars($row['comment'], ENT_QUOTES);
  $row['comment']=str_replace('  ', '&nbsp;&nbsp;',     //處理空白與
                              nl2br($row['comment']) ); //換行字元
  }
  else
    $row['comment']='';
	
  //將照片的路徑放入 $row 陣列
  $row['imgsrc']=$dirPhoto.$row['filename'];

  //將前後張照片的 id 放入 $row 陣列
  $photo_previd = $id-1;
  $photo_nextid = $id+1;
  require_once($templateDir.'navi_link_in_photoshow_tpl.php');
  
  //--------設定上一筆連結
  //查詢資料表, 取得前1筆照片的 id
  $stmt = mysqli_prepare($conn, 
                 "SELECT max(id) FROM $tbPhoto WHERE id <? ");
  mysqli_stmt_bind_param($stmt, 'i', $id);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);
  $id_row = mysqli_fetch_array($result);
  
  // 查詢結果為 NULL 表示目前是第 1 筆
  if(is_null($id_row[0]))  $prev_link ='';
  else                      
	$prev_link=str_replace('{$prev_id}',$id_row[0],
	                       $html_prev_photo_link);
  
  //--------設定下一筆連結
  //查詢資料表, 取得後 1 筆照片的 id
  $stmt = mysqli_prepare($conn, 
                 "SELECT min(id) FROM $tbPhoto WHERE id >?");
  mysqli_stmt_bind_param($stmt, 'i', $id);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);
  $id_row = mysqli_fetch_array($result);
  
  // 查詢結果為 NULL 表示目前是最後一筆
  if(is_null($id_row[0]))  $next_link='';
  else 
	$next_link=str_replace('{$next_id}',$id_row[0],
	                        $html_next_photo_link);
  
  //--------設定管理者編輯連結
  // 預設無管理者編輯連線
  $admin_edit_links ='';
  if(!empty($_SESSION['admin'])){
    require_once($templateDir.'admin_edit_links_tpl.php');
	$admin_edit_links = $html_admin_edit_links;
  }
  
  //--------設定網頁下端的縮圖列表
  //查詢此資料表之前有幾筆照片
  $stmt = mysqli_prepare($conn, 
                 "SELECT count(id) FROM $tbPhoto WHERE id <?");
  mysqli_stmt_bind_param($stmt, 'i', $id);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);
  $id_row = mysqli_fetch_array($result);
  
  // 查詢結果比小於 2, 表示是最前面 2 筆	
  if($id_row[0]<=2)  
    $rangeStart=0;	
  // 查詢結果比總筆數少 2 以下, 表示是最後 2 筆	
  else if(($_SESSION['totalRows']-$id_row[0])<=2)
    $rangeStart=$_SESSION['totalRows'] - 5;
  else               
    $rangeStart = $id_row[0]-2;
  
  //取得前後兩張的照片資料, 以便在照片的下方顯示預覽縮圖
  $result= mysqli_query($conn, 
           "SELECT `id`, `name`, `filename` FROM $tbPhoto
            LIMIT $rangeStart, 5");
  
  //逐筆讀出各照片的資料, 並利用縮圖子樣版, 建立縮圖列表
  $all_thumbs=''; // 縮圖列表 HTML 字串 
  require_once($templateDir.'thumb_in_photoshow_tpl.php');
  while ($thumb = mysqli_fetch_array($result)) {
    // 建立 "資料夾/檔名" 路徑字串
    $thumb['imgsrc']= $dirThumb . $thumb['filename'];
	if($thumb['id'] == $id) // 是目前顯示的照片
	  $thumb_class = 'photoshow_thumblist_this';
	else
	  $thumb_class = 'photoshow_thumblist';
    
	$all_thumbs .= str_replace(
	       ['{$thumb_class}', '{$thumb_name}', '{$thumb_imgsrc}', '{$thumb_id}'] ,
		   [$thumb_class   , $thumb['name'], $thumb['imgsrc'], $thumb['id'] ] ,
		   $html_thumb);
  }

  //取得 photoshow.tpl 子樣版的 HTML 原始碼
  require_once('templates/photoshow_tpl.php');
  
  //回傳子樣版的內容
  return $html_photoshow;
}

//-------------------- 自定 xajax 函式處理 AJAX 要求 ------------
//showPage() 函式是 xajax 用來處理特定頁面照片列表的顯示要求
function showPage($pageID=1) {

  //呼叫 getPhotoList() 函式取得特定頁面照片列表的 HTML 原始碼
  $html=getPhotoList($pageID);

  $objResponse = new xajaxResponse();
  $objResponse->assign('maintext', 'innerHTML', $html);

  return $objResponse;
}

//showPhoto() 函式是 xajax 用來處理特定照片的顯示要求
function showPhoto($id=1) {

  //呼叫 getPhotoShow() 函式取得顯示特定照片的 HTML 原始碼
  $html=getPhotoShow($id);

  $objResponse = new xajaxResponse();
  $objResponse->assign('maintext', 'innerHTML', $html);

  return $objResponse;
}

?>
