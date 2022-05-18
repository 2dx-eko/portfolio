<?php
session_start();
require_once("/home/createengineer/www/postpic/system/config/db.php");
require_once("/home/createengineer/www/postpic/system/controller/ac.php");
require_once("/home/createengineer/www/postpic/system/config/function.php");
loginflgTrue();

unset($_SESSION["ac_error"]);
if(isset($_POST["ac_button"])){
   $ac = new ac();
   $ac->acCreate($pdo);
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
   <title>POSTPIC|アカウント作成</title>
</head>
<body class="login back_slider">
   <div class="login_col">
      <div class="title"><a href="/login/login.php">Acount Create</a></div>

      <?php if(isset($_SESSION["ac_error"])): ?>
      <div class="error">
         <?php echo "<div>" . $_SESSION["ac_error"] . "</div>"; ?>
      </div>
      <?php endif; ?>

      <form method="post">
         <input type="text" placeholder="Acount ID" name="ac_id" value="<?php echo $_POST["ac_id"]; ?>">
         <br>
         <input type="text" placeholder="Acount Password" name="ac_pass" value="<?php echo $_POST["ac_pass"]; ?>">
         <br>
         <input type="text" placeholder="Email Address" name="ac_mail" value="<?php echo $_POST["ac_mail"]; ?>">
         <button type="submit" class="login" name="ac_button">Acount Create</button>
      </form>
      
   </div>
   <!-- /login -->
</body>
<script src="/common/js/jquery.js"></script>
<script src="/common/js/jquery.bgswitcher.js"></script>
<script src="/common/js/common.js"></script>
</html>

