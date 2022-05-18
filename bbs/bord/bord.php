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
$mail = $_COOKIE["address"];
$threadId = $_GET["id"];

//テキスト登録
if(isset($_POST["thread_submit"])){
   $text = $_POST["thread_text"];
   //登録者の情報を取得
   $post = main_model::loginCheck($pdo,$mail);
   $user_name = $post[0]["name"];
   main_model::threadTextRegister($pdo,$text,$threadId,$user_name); 
}

//スレ情報取得
$thread_info = main_model::thread_info($pdo,$threadId);
//スレ登録情報の取得
$thread_text = main_model::getThreadText($pdo,$threadId);
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
   
   <title>BBS</title>
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
               <form action="search.php" method="post" class="search_container">
                  <input name="search_text" type="text" size="25" placeholder="スレッドタイトルを入力" required>
                  <input class="search" type="submit" name="search" value="検索">
               </form>
            </div>
         </div>
      </div>
   </header>
   <div class="bbs_parent">
      <div class="cat_box">
         <h2 class="cat_title">
            <?php echo $thread_info[0]["title"]; ?>
         </h2>
         <br>
         <p class="gaiyo">
            <?php echo $thread_info[0]["gaiyo"]; ?>
         </p>
      </div>
      <?php foreach($thread_text as $thread_texts): ?>
      <div class="bord_col">
         <div class="flex">
            <div class="name">name：<?php echo $thread_texts["user_name"]; ?></div>
            <div class="date"><?php echo $thread_texts["created_at"]; ?></div>
         </div>
         <div class="naiyou"><?php echo $thread_texts["naiyou"]; ?></div>
      </div>
      <?php endforeach; ?>

      <div class="thread_form">
         <form method="post">
            <textarea name="thread_text" placeholder="内容を記入してください!" required></textarea><br>
            <button class="btn btn--red btn--cubic" name="thread_submit"><i class="fas fa-laptop"></i> 送信</button>
            
         </form>
      </div>

   </div>
   <!--bbs_parent-->

   <footer id="footer">
      <p>Copyright © WHATEVER BBS All Rights Reserved.</p>
   </footer>
</body>
<script src="../common/js/jquery.js"></script>

<script src="../common/js/common.js"></script>


</html>

