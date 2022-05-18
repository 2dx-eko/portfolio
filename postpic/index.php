<?php
session_start();
require_once("/home/createengineer/www/postpic/system/config/db.php");
require_once("/home/createengineer/www/postpic/system/config/function.php");
require_once("/home/createengineer/www/postpic/system/controller/main.php");
loginflgFalse();
logout();
unset($_SESSION["pic_error"]);
$main = new main();
//アップロードされたら
if(isset($_POST["up_file"])){
   $main->picSave($pdo);
}

//deleteが押されたら
if(isset($_POST["delete_btn"])){
   $main->imgDelete($pdo);
}

//ログイン情報を元に画像読み込み
$post = $main->callImage($pdo);


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
   <title>POSTPIC</title>
</head>
<body class="top back_slider">
<header>
   <div class="parent">
      <div class="logo">
         <span class="red">P</span>ost <span class="blue">P</span>ic
      </div>
      <div class="content">
      <form method="post" enctype="multipart/form-data">
            <input class="file" id="file_upload" type="file" name="up_img">
            <button class="upload" name="up_file">UPLOAD <i class="fas fa-file-upload"></i></button>
         <button class="logout" name="logout_button">LOGOUT <i class="fas fa-door-open"></i></button>
      </form>
      </div>
   </div>
</header>
<main>
   <?php if(isset($_SESSION["pic_error"])): ?>
      <div class="error">
         <?php echo $_SESSION["pic_error"]; ?>
      </div>
   <?php endif; ?>

   <div class="success fadein">
      <?php echo $_SESSION["pic_success"]; ?>
      <?php unset($_SESSION["pic_success"]); ?>
   </div>
   <?php if(isset($post)): ?>
      <div class="pic_parent">
         <ul>
         <?php foreach($post as $posts): ?>
            <li><a href="#" class="popup"><img src="<?php echo $posts["img"]; ?>"></a></li>
         <?php endforeach; ?>
         </ul>
      </div>
   <?php endif; ?>
<div class="popup_area"></div>
</main>
<!-- /main -->
</body>
<script src="common/js/jquery.js"></script>
<script src="common/js/common.js"></script>
<!--script src="common/js/jquery.bgswitcher.js"></!--script>

</html>

