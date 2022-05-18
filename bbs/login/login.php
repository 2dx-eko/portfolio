<?php
session_start();
require_once("/home/createengineer/www/bbs/system/config/db.php");
require_once("/home/createengineer/www/bbs/system/controller/ac.php");
require_once("/home/createengineer/www/bbs/system/config/function.php");
require_once("/home/createengineer/www/bbs/system/model/main_model.php");

//ページ到達時にログインしてるかチェック(クッキー管理)
$mail = $_COOKIE["address"];
loginCookieCheckOut($pdo,$mail);

unset($_SESSION["login_error"]);
if($_SERVER["REQUEST_METHOD"] == "POST"){
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
   <link rel="stylesheet" href="../common/css/style.css">
   <title>BBS</title>
</head>
<body class="login">
   <div class="login_col">
      <div class="login_desc">
         <h1>Please write more and more</h1>
      </div>
      <div class="login_ingo">
         <form method="post">
            <?php if($_SESSION["acregister_success"]): ?>
               <div class="flex">
                  <span class="success">
                     <?php
                        echo $_SESSION["acregister_success"];
                        unset($_SESSION["acregister_success"]);
                     ?>
                  </span>
               </div>
            <?php endif; ?>
            <?php if($_SESSION["login_error"]): ?>
               <div class="flex">
                  <span class="error">
                     <?php echo $_SESSION["login_error"]; ?>
                     <?php unset($_SESSION["login_error"]); ?>
                  </span>
               </div>
            <?php endif; ?>
            <div class="flex">
               <p>ID</p>
               <input type="text" name="login_name" value="<?php echo $_POST["login_name"]; ?>">
            </div>
            <div class="flex">
               <p>MAIL</p>
               <input type="text" name="login_mail" value="<?php echo $_POST["login_mail"]; ?>">
            </div>
            <div class="flex">
               <p>PASS</p>
               <input type="text" name="login_pass" value="<?php echo $_POST["login_pass"]; ?>">
            </div>
            <button class="btn btn--blue login"><i class="fas fa-sign-in-alt"></i> ログイン</button>
         </form>
         <br>
         <p><a href="mail.php">■アカウント登録</a></p>
         <p><a href="forget.php">■パスワードを忘れた!</a></p>
      </div>   
   </div>
   <footer id="footer">
      <p>Copyright © WHATEVER BBS All Rights Reserved.</p>
   </footer>

</body>
<script src="/common/js/jquery.js"></script>

<script src="/common/js/common.js"></script>
</html>

