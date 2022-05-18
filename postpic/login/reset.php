<?php
session_start();
require_once("/home/createengineer/www/postpic/system/config/db.php");
require_once("/home/createengineer/www/postpic/system/controller/ac.php");
require_once("/home/createengineer/www/postpic/system/config/function.php");
loginflgTrue();

unset($_SESSION["new_path_error"]);
//パラメータにmailがないとリダイレクト
$url = $_SERVER["REQUEST_URI"];
if(!strpos($url,"?mail=")){
   header("Location:/login/login.php");
}

if(isset($_POST["reset_button"])){
   $ac = new ac();
   $ac->passReset($pdo);
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
   <title>POSTPIC|パスワード再設定</title>
</head>
<body class="login back_slider">
   <div class="login_col">
      <div class="title"><a href="/login/login.php">Password Reset</a></div>
      <?php if(isset($_SESSION["new_path_error"])): ?>
         <div class="error">
            <?php echo "<div>" .  $_SESSION["new_path_error"] . "</div>"; ?>
         </div>
      <?php endif; ?>
      <form method="post">
         <input type="text" placeholder="New Password" name="pass_reset" value="<?php echo $_POST["pass_reset"]; ?>">
         <button type="submit" class="login" name="reset_button">Submit</button>
      </form>
      
   </div>
   <!-- /login -->
</body>
<script src="/common/js/jquery.js"></script>
<script src="/common/js/jquery.bgswitcher.js"></script>
<script src="/common/js/common.js"></script>
</html>

