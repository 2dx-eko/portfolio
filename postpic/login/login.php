<?php
session_start();
require_once("/home/createengineer/www/postpic/system/config/db.php");
require_once("/home/createengineer/www/postpic/system/controller/ac.php");
require_once("/home/createengineer/www/postpic/system/config/function.php");
loginflgTrue();

unset($_SESSION["login_error"]);
if(isset($_POST["login_button"])){
   $ac = new ac();
   $ac->login($pdo);
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
   <link rel="stylesheet" href="/common/css/style.css">
   <title>POSTPIC</title>
</head>
<body class="login back_slider">
   <div class="login_col">
      <div class="title">
         <span class="red">P</span>ost <span class="blue">P</span>ic
      </div>
      <div class="success">
         <?php echo $_SESSION["ac_success"]; ?>
         <?php unset($_SESSION["ac_success"]); ?>
      </div>

      <?php if(isset($_SESSION["login_error"])): ?>
      <div class="error">
        <?php echo $_SESSION["login_error"]; ?>
      </div>
      <?php endif; ?>

      <form action="" method="post">
         <input type="text" placeholder="Acount ID" name="login_acount" value="<?php echo $_POST["login_acount"]; ?>">
         <br>
         <input type="password" placeholder="Password" name="login_pass" value="<?php echo $_POST["login_pass"]; ?>">
         <input type="text" placeholder="Email Address" name="login_mail" value="<?php echo $_POST["login_mail"]; ?>">
         <button class="login" name="login_button">SIGN IN</button>
      </form>
      
      <p>■アカウント作成は<a class="red" href="create.php">コチラ</a></p>
      <p>■パスワードを忘れた場合は<a class="blue" href="forget.php">コチラ</a></p>
   </div>
   <!-- /login -->
</body>
<script src="/common/js/jquery.js"></script>
<script src="/common/js/jquery.bgswitcher.js"></script>
<script src="/common/js/common.js"></script>
</html>

