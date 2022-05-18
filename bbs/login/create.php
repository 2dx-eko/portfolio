<?php
session_start();
require_once("/home/createengineer/www/bbs/system/config/db.php");
require_once("/home/createengineer/www/bbs/system/controller/ac.php");
require_once("/home/createengineer/www/bbs/system/config/function.php");
require_once("/home/createengineer/www/bbs/system/model/ac_model.php");
$token = $_GET["token"];
$token_check = ac_model::tokenCheck($pdo,$token);
if(!$token_check){ //チェックが空ならリダイレクト
   header("Location:./login.php");
}
unset($_SESSION["acregister_error"]);
$mail = $_GET["mail"];
if($_SERVER["REQUEST_METHOD"] == "POST"){
   $ac = new ac();
   $ac->ACMainRegister($pdo,$mail,$token);
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
   <title>BBS|アカウント登録 </title>
</head>
<body class="login">
   <div class="login_col">
      <div class="login_desc">
         <h1>Please write more and more</h1>
      </div>

      <div class="login_ingo">
         <form method="POST">
         
            <div class="flex">
               <span class="border">各項目入力してください</span>
            </div>
            <?php if($_SESSION["acregister_error"]): ?>
               <div class="flex">
                  <span class="error"><?php echo $_SESSION["acregister_error"]; ?></span>
               </div>
            <?php endif; ?>
            <div class="flex">
               <p>ID</p>
               <input type="text" name="ac_name" value="<?php echo $_POST["ac_name"]; ?>">
            </div>
            <div class="flex">
               <p>PASS</p>
               <input type="text" name="ac_pass" value="<?php echo $_POST["ac_pass"]; ?>">
            </div>
            <div class="flex">
               <button class="btn btn--blue"><i class="fas fa-user-circle"></i> 登録</button>
            </div>
         </form>
         <p>※IDは投稿時の名前として表示されます！</p>
         <br>
         <p><a href="login.php">■ログイン画面へ</a></p>
      </div>
   </div>
   <!-- /login_col -->
   <footer id="footer">
      <p>Copyright © WHATEVER BBS All Rights Reserved.</p>
   </footer>

</body>
<script src="../common/js/jquery.js"></script>
<script src="../common/js/common.js"></script>
</html>

