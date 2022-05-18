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
//スレ情報呼び出し（カラム）
$thread_info = main_model::callColumn($pdo);

//絞り込み
$sort = $_POST["sort"];
$thread_cat = main_model::callCatColumn($pdo,$sort);

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
   <link rel="stylesheet" href="common/css/style.css">
   
   <title>BBS</title>
</head>
<body>
   <header>
      <div class="bbs_user">
         <h1>
         <i class="far fa-edit"></i>&nbsp;WHATEVER BBS
         </h1>
         <div class="head_btn_flex">
            <a href="bord/bord_create.php" class="btn btn--yellow btn--cubic w100"><i class="far fa-clipboard"></i> スレッドを作成する</a>
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
               <form action="bord/search.php" method="post" class="search_container">
                  <input name="search_text" type="text" size="25" placeholder="スレッドタイトルを入力" required>
                  <input class="search" type="submit" name="search" value="検索">
               </form>
            </div>
         </div>
      </div>
   </header>
   <div class="cat_box">
      <h2 class="cat_title">スレッド一覧</h2>
   </div>
   <div class="bbs_parent">
      <div class="sort">
         <form id="sort" method="post">
         絞り込み機能：
            <select id="submit_select" name="sort">
               <option value="">選択してください</option>
               <option value="全カテゴリ表示">全カテゴリ表示</option>
               <option value="雑談">雑談</option>
               <option value="おもしろ">おもしろ</option>
               <option value="ゲーム">ゲーム</option>
               <option value="アニメ">アニメ</option>
               <option value="政治">政治</option>
               <option value="趣味">趣味</option>
            </select>
         </form>
      </div>
      <div class="bbs_info">
         <?php if(!$sort): ?>
            <?php foreach($thread_info as $thread_infos): ?>
            <?php
               $date = $thread_infos["created_at"];
               $new = isNew($date);
            ?>
            <div class="col <?php echo $thread_infos["classname"]; ?>">
               <?php if($new):echo $new; endif; ?>
               <a href="bord/bord.php?id=<?php echo $thread_infos["id"]; ?>">
                  <h2><?php echo $thread_infos["category"]; ?></h2>
                  <div class="padding">
                     <div class="title">
                     <?php echo $thread_infos["title"]; ?>
                     </div>
                     <div class="thubmnail">
                        <img src="common/bbs_img/<?php echo $thread_infos["img"]; ?>">
                     </div>
                     <div class="desc">
                     <?php echo $thread_infos["gaiyo"]; ?>
                     </div>
                  </div>
               </a>
            </div>
            <?php endforeach; ?>
         <?php elseif($sort == "全カテゴリ表示"): ?>
            <?php foreach($thread_info as $thread_infos): ?>
            <?php
               $date = $thread_infos["created_at"];
               $new = isNew($date);
            ?>
            <div class="col <?php echo $thread_infos["classname"]; ?>">
               <?php if($new):echo $new; endif; ?>
               <a href="bord/bord.php?id=<?php echo $thread_infos["id"]; ?>">
                  <h2><?php echo $thread_infos["category"]; ?></h2>
                  <div class="padding">
                     <div class="title">
                     <?php echo $thread_infos["title"]; ?>
                     </div>
                     <div class="thubmnail">
                        <img src="common/bbs_img/<?php echo $thread_infos["img"]; ?>">
                     </div>
                     <div class="desc">
                     <?php echo $thread_infos["gaiyo"]; ?>
                     </div>
                  </div>
               </a>
            </div>
            <?php endforeach; ?>
         <?php else: ?>
            <?php foreach($thread_cat as $thread_cats): ?>
            <?php
               $date = $thread_cats["created_at"];
               $new = isNew($date);
            ?>
            <div class="col <?php echo $thread_cats["classname"]; ?>">
               <?php if($new):echo $new; endif; ?>
               <a href="bord/bord.php?id=<?php echo $thread_cats["id"]; ?>">
                  <h2><?php echo $thread_cats["category"]; ?></h2>
                  <div class="padding">
                     <div class="title">
                     <?php echo $thread_cats["title"]; ?>
                     </div>
                     <div class="thubmnail">
                        <img src="common/bbs_img/<?php echo $thread_cats["img"]; ?>">
                     </div>
                     <div class="desc">
                     <?php echo $thread_cats["gaiyo"]; ?>
                     </div>
                  </div>
               </a>
            </div>
            <?php endforeach; ?>
         <?php endif; ?>
      </div>
   </div>


   <footer id="footer">
      <p>Copyright © WHATEVER BBS All Rights Reserved.</p>
   </footer>
</body>
<script src="common/js/jquery.js"></script>
<script src="common/js/common.js"></script>

<script type="text/javascript">
$(function(){
  $("#submit_select").change(function(){
    $("#sort").submit();
  });
});
</script>
</html>

