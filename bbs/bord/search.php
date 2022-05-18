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

$search_text = $_POST["search_text"];
$search_info = main_model::searchThread($pdo,$search_text);

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
            <a href="../">
            <i class="far fa-edit"></i>&nbsp;WHATEVER BBS
            </a>
         </h1>
         <div class="head_btn_flex">
            <a href="../" class="btn btn--yellow btn--cubic w100">TOPへ戻る</a>


         </div>
      </div>

   </header>
   <div class="cat_box">
      <h2 class="cat_title">スレッド検索結果</h2>
   </div>
   <div class="bbs_parent">
      <?php if(!$search_info): ?>
         <h2 class="search_nottext">検索は見つかりませんでした</h2>
      <?php else: ?>
         <h2 class="search_nottext">
            検索結果は<?php echo count($search_info); ?>件見つかりました
         </h2>
      <?php endif; ?>
      <div class="bbs_info">
            <?php foreach($search_info as $search_infos): ?>
               <div class="col <?php echo $search_infos["classname"]; ?>">
                  <?php if($new):echo $new; endif; ?>
                  <a href="bord.php?id=<?php echo $search_infos["id"];  ?>">
                     <h2><?php echo $search_infos["category"]; ?></h2>
                     <div class="padding">
                        <div class="title">
                        <?php echo $search_infos["title"]; ?>
                        </div>
                        <div class="thubmnail">
                           <img src="../common/bbs_img/<?php echo $search_infos["img"]; ?>">
                        </div>
                        <div class="desc">
                        <?php echo $search_infos["gaiyo"]; ?>
                        </div>
                     </div>
                  </a>
               </div>
            <?php endforeach; ?>

      </div>
   </div>


   <footer id="footer">
      <p>Copyright © WHATEVER BBS All Rights Reserved.</p>
   </footer>
</body>
<script src="../common/js/jquery.js"></script>

<script src="../common/js/common.js"></script>


</html>

