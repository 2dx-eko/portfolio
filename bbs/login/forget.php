<?php
session_start();
require_once("/home/createengineer/www/bbs/system/config/db.php");
require_once("/home/createengineer/www/bbs/system/controller/ac.php");
require_once("/home/createengineer/www/bbs/system/config/function.php");

unset($_SESSION["reset_error"]);
if($_SERVER["REQUEST_METHOD"] == "POST"){
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
   <link rel="stylesheet" href="../common/css/style.css">
   <title>BBS:PASSWORD RESET</title>
</head>
<body class="login">
   <div class="login_col">
      <div class="login_desc">
         <h1>Please write more and more</h1>
      </div>

      <div class="login_ingo">
         <form method="POST">         
            <div class="flex">
               <span class="border">「パスワードを忘れた！」方は<br>メールアドレスを入力してください</span>
            </div>
            <?php if($_SESSION["reset_error"]): ?>
               <div class="flex">
                  <span class="error"><?php echo $_SESSION["reset_error"]; ?></span>
               </div>
            <?php endif; ?>
            <div class="flex">
               <p>MAIL</p>
               <input type="text" name="reset_mail" value="<?php echo $_POST["reset_mail"]; ?>">
               <br>
            </div>
            <div class="flex">
               <button class="btn btn--blue"><i class="fas fa-envelope"></i> 送信</button>
            </div>
         </form>
         <p><a href="login.php">■ログイン画面へ</a></p>
      </div>   
   </div>
   <footer id="footer">
      <p>Copyright © WHATEVER BBS All Rights Reserved.</p>
   </footer>

</body>
<script src="../common/js/jquery.js"></script>
<script src="../common/js/common.js"></script>
</html>

