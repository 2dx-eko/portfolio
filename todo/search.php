<?php
session_start();
require_once("system/controller/main.php");
require_once("system/config/function.php");
$todo = new Todo();
if(isset($_POST["search"])){
   $text = $_POST["search_text"];
   $post = $todo->search($pdo,$text);
   if(!empty($post)){
      $count = count($post);//検索から件数を取得
   }

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link href="https://fonts.googleapis.com/css?family=Noto+Sans+JP" rel="stylesheet">
   <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
   <link rel="stylesheet" href="/common/css/styles.css">
   <title></title>
</head>
<body>
   <div class="parent">
      <div class="title">
         <div><a href="/">TODO List</a></div>
         <div>
            <form method="post" action="search.php">
               <i class="fas fa-search"></i>&nbsp;<input type="text" placeholder="search" name="search_text">
               &nbsp;<button class="search" name="search">検索</button>
            </form>
         </div>
      </div>
      <br>
      <?php if(empty($post)): ?>
         <div class="error">
         「 <?php echo $text; ?> 」で該当する内容は見つかりませんでした
         </div>
      <?php endif; ?>
      
      <?php if(!empty($count)): ?>
      <div class="search_hit">
         「 <?php echo $text; ?> 」の検索結果：<span><?php echo $count ?></span>件見つかりました
      </div>
      <?php endif; ?>

      <?php if($post): ?>
      <table class="post search">
         <?php foreach($post as $posts): ?>
         <tr>
            <td class="search_content"><?php echo $posts["content"]; ?></td>
            <td class="search_day"><i class="far fa-clock"></i>&nbsp;<?php echo $posts["full_day"]; ?></td>
         </tr>
         <?php endforeach; ?>
      </table>
      <?php endif; ?>
      <a class="link_c1" href="/">投稿ページへ戻る</a>
   </div>
   <!-- /parent -->
</body>
<script src="common/js/jquery.js"></script>
<script src="common/js/common.js"></script>
</html>

