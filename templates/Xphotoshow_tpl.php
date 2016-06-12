<?php
// 顯示上一張、下一張照片的連結 
$html_photoshow = '<div id="photoshow_nav">';

// 檢查上一張照片的 id 是否大於等於 1, 若否, 表示此為第一張照片,
// 故將上一張的連結失效 *}
if ($photo_previd >= 1)
  $html_photoshow .=  <<<HERE
  <a href="#" onclick="xajax_showPhoto({$photo_previd});
       return false;">&lt;上一張</a>
HERE;
else
  $html_photoshow .= '<span style="color: #999999;">&lt;上一張</span>';
  
$html_photoshow .= '| <a href="index.php">回首頁</a> |';

// 檢查下一張照片的 id 是否小於等於照片總數, 若否, 表示此為最後
// 一張照片, 故將下一張的連結失效 *}
if ($photo_nextid <= $_SESSION['totalRows'])
  $html_photoshow .= <<<HERE
  <a href="#" onclick="xajax_showPhoto({$photo_nextid});
       return false;"> 下一張&gt;</a>
HERE;
else
  $html_photoshow .= 
     '<span style="color: #999999;">下一張&gt;</span>';

$html_photoshow .= <<<HERE
</div>

<div id="photoshow_photo">
  <p> {$row['name']} {* 照片名稱 *}
HERE;

// 如果管理模式已經開啟, 便顯示編輯與刪除連結
if (!empty($_SESSION['admin']))
  $html_photoshow .= <<<HERE
        [<a href="edit.php?id={$row['id']}">編輯</a>]
        [<a href="del.php?id={$row['id']}"
            onClick="return confirm('確定要刪除嗎?')">刪除</a>]
HERE;

$html_photoshow .= <<<HERE
  </p>

  <img id="photoshow_photo" alt="{$row['name']}" src="{$row['imgsrc']}">

  
  <p>{$row['comment']}</p>
</div>

<div id="photoshow_thumblist">
HERE;

// 顯示前後兩張照片的縮圖 
foreach($allthumb as $thumb) {
  $html_photoshow .= <<<HERE
      <img id="photoshow_thumblist_this" alt="{$thumb['name']}" 
	       src="{$thumb['imgsrc']}"
HERE;
  
  // 如果縮圖屬於本頁照片, 便特別框起來, 並且不提供連結 
  if ($row['id'] != $thumb['id'] )
    $html_photoshow .= ' href="#" onclick="xajax_showPhoto('.$thumb['id'].');"';
  
  $html_photoshow .= '>';
}

$html_photoshow .=  <<<HERE
  </div>
HERE;
?>