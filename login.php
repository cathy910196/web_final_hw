<?php
header('Content-Type: text/html; charset=utf-8');
session_start();
require_once('config.inc.php');

//$adminPass 陣列存放管理者帳號與密碼
//格式: $adminPass['帳號']='密碼'
$adminPass = array (
               'tony' => 'secret',
               'sophia' => '0810',
               'joe' => 'flagpw'
             );

//定義 $errMsg 變數, 用以存放錯誤訊息
$errMsg='';
//定義 $usrMsg 變數, 用以存放一般訊息
$usrMsg='';

//引入 xajax 類別檔並建立物件
require('../xajax_core/xajax.inc.php');
$xajax = new xajax();
$xajax->configure('javascript URI', '../');

//註冊 xajax 回應函式 chkLogin(), 用來檢查帳號密碼是否相符
$cObj = $xajax->register(XAJAX_FUNCTION,'chkLogin');
$cObj->useSingleQuote();
//以 form_login.tpl 子樣版上的 "login" 表單的所有欄位值為參數
$cObj->addParameter(XAJAX_FORM_VALUES,'login');

//處理 AJAX 回應
$xajax->processRequest();

//---------------------- 管理者登出功能 -----------------------------
//管理者按下登出連結時, 會以 GET 的方式傳入 logout 參數等於 1,
//所以如果 $_GET['logout'] 等於 1, 表示要登出, 關閉管理模式
if ( !empty($_GET['logout']) && $_GET['logout'] == 1 ){
  $_SESSION['admin'] = FALSE;
  $usrMsg.='已經成功登出<br>';
}

//---------------------- 顯示登入表單 -------------------------------
if ( isset($_SESSION['admin']) && $_SESSION['admin'] == TRUE ) {
  //如果管理模式已經開啟, 表示登入成功, 故將連線轉向至首頁 index.php
  header("Location: index.php");
}
else {
  //若未開啟管理模式, 便顯示相關訊息與登入表單

  $xajaxJS = $xajax->getJavascript();
  $xajaxLoginClick = $cObj->getscript();
  if(!empty($_SESSION['admin']) && $_SESSION['admin']==true){
    $navigation = '<a href="upload.php">上傳照片</a>';
    $navigation.= '<a href="login.php?logout=1">登出 '.$_SESSION['adminUser'].'</a>';
  }
  else
    $navigation = '<a href="login.php">管理者登入</a>';
  
  //設定本程式使用的子樣版檔名
  require_once($templateDir.'login_tpl.php');
  
  //將子樣版的檔名設定給 subTemplate 樣版變數
  $subTemplate = $html_login;

  //引用主樣版
  require_once($templateDir.'main_tpl.php');  
  echo $html;
}

//---------------------- AJAX 登入的回應函式 ------------------------
function chkLogin($form) {
  global $errMsg, $adminPass;

  //若使用者在登入表單輸入了帳號密碼
  if ( ! empty($form['username']) && ! empty($form['password']) ){

    //將帳號密碼設定給 $username 與 $password 變數
    $username=$form['username'];
    $password=$form['password'];

    //$adminPass[$username] 可以取得 $username 帳號的密碼, 表示
    //有這個帳號。如果 $adminPass[$username] 的密碼與使用者輸入
    //的相同, 表示密碼正確, 所以開啟管理模式
    if ( isset($adminPass[$username]) &&
         $adminPass[$username] == $password ) {
      //$_SESSION['admin'] 變數代表是否開啟管理模式
      $_SESSION['admin'] = TRUE;
      //$_SESSION['adminUser'] 變數存放管理者名稱
      $_SESSION['adminUser'] = $username;
    }
    else {
      $errMsg.='帳號密碼不相符<br>';
    }
  }

  $objResponse = new xajaxResponse();

  if ( isset($_SESSION['admin']) && $_SESSION['admin'] == TRUE ) {
    //如果管理模式已經開啟, 表示登入成功, 故將連線轉向至首頁 index.php
    //xajax 的 redirect() 方法可以將連線轉向
    $objResponse->redirect('index.php');
  }

  //顯示錯誤訊息
  $objResponse->assign('errMsg', 'innerHTML', $errMsg);

  return $objResponse;
}
?>
