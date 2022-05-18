<?php
session_start();
require_once("/home/createengineer/www/bbs/system/config/db.php");
require_once("/home/createengineer/www/bbs/system/controller/main.php");
require_once("/home/createengineer/www/bbs/system/config/function.php");
require_once("/home/createengineer/www/bbs/system/config/config.php");
require_once("/home/createengineer/www/bbs/system/model/main_model.php");
//ページ到達時にログインしてるかチェック(クッキー管理)
$mail = $_COOKIE["address"];
loginCookieCheck($pdo,$mail);
logout($pdo,$mail);

if(isset($_POST["bord_create"])){
   $main = new main();
   $main->CreateThread($pdo);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
   <link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
   <link rel="stylesheet" href="../common/css/style.css">
   
   <title>BBS：スレッド作成</title>
</head>
<body>
   <header>
      <div class="bbs_user">
         <h1>
         <a href="../"><i class="far fa-edit"></i>&nbsp;WHATEVER BBS</a>
         </h1>
         <div class="head_btn_flex">
            <a href="bord_create.php" class="btn btn--yellow btn--cubic w100"><i class="far fa-clipboard"></i> スレッドを作成する</a>
            <form method="post">
               <?php if($_SESSION["acregister_success"]): ?>
                     <span class="session_success">
                        <?php
                           echo $_SESSION["main_success"];
                           unset($_SESSION["main_success"]);
                        ?>
                     </span>
               <?php endif; ?>
               
               <button name="logout" class="btn btn--red w100"><i class="fas fa-door-open"></i> ログアウト</button>
            </form>
            <div class="search">
               <form action="../bord/search.php" method="post" class="search_container">
                  <input name="search_text" type="text" size="25" placeholder="スレッドタイトルを入力" required>
                  <input class="search" type="submit" name="search" value="検索">
               </form>
            </div>
         </div>
      </div>
   </header>
   <div class="cat_box">
      <h2 class="cat_title">スレッド作成</h2>
   </div>
   <div class="wrpper bord_create">
      <form method="post" enctype="multipart/form-data">
         <table>
            <tr>
               <td>スレッドタイトル</td>
               <td>
                  <input type="text" name="bord_title" required>
               </td>
            </tr>
            <tr>
               <td>スレッド概要</td>
               <td>
                  <input type="text" name="bord_desc" required>
               </td>
            </tr>
            <tr>
               <td>カテゴリ</td>
               <td>
                  <label><input type="radio" name="cat_radio" value="雑談" checked>雑談</label>
                  <label><input type="radio" name="cat_radio" value="おもしろ">おもしろ</label>
                  <label><input type="radio" name="cat_radio" value="ゲーム">ゲーム</label>
                  <label><input type="radio" name="cat_radio" value="アニメ">アニメ</label>
                  <label><input type="radio" name="cat_radio" value="政治">政治</label>
                  <label><input type="radio" name="cat_radio" value="趣味">趣味</label>
               </td>
            </tr>
            <tr>
               <td>サムネイル</td>
               <td>
                  <input type="file" name="bord_img" accept="image/png, image/jpeg">
               </td>
            </tr>
         </table>
         <button class="btn btn--blue" name="bord_create"><i class="fas fa-check"></i> 作成</button>
      </form>
   </div>


   <footer id="footer">
      <p>Copyright © WHATEVER BBS All Rights Reserved.</p>
   </footer>
</body>
<script src="../common/js/jquery.js"></script>

<script src="../common/js/common.js"></script>

</html>

