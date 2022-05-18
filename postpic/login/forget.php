<?php
session_start();
require_once("/home/createengineer/www/postpic/system/config/db.php");
require_once("/home/createengineer/www/postpic/system/controller/ac.php");
require_once("/home/createengineer/www/postpic/system/config/function.php");
loginflgTrue();

unset($_SESSION["forget_error_address"]);
if(isset($_POST["ac_button"])){
   $ac = new ac();
   $ac->acForget($pdo);
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
   <title>POSTPIC|パスワードを忘れた場合</title>
</head>
<body class="login back_slider">
   <div class="login_col">
      <div class="title"><a href="/login/login.php">Acount Forget</a></div>
      <?php if(isset($_SESSION["forget_error_address"])): ?>
      <div class="error">
      <?php echo $_SESSION["forget_error_address"]; ?>
      </div>
      <?php endif; ?>
      <form method="post">
         <input type="text" placeholder="Email Address" name="ac_forget" value="<?php echo $_POST["ac_forget"]; ?>">
         <button type="submit" class="login" name="ac_button">Acount Create</button>
      </form>
      
   </div>
   <!-- /login -->
</body>
<script src="/common/js/jquery.js"></script>
<script src="/common/js/jquery.bgswitcher.js"></script>
<script src="/common/js/common.js"></script>
</html>

