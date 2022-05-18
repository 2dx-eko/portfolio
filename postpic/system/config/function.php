<?php
function h($str) {
   return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

//ログアウト時関数
function logout(){
   if(isset($_POST["logout_button"])){
      $_SESSION["login_flg"] = false;
      unset($_SESSION["login_true_mail"]);//保持していた情報を削除
      unset($_SESSION["login_true_id"]);
      header("Location:/login/login.php");
   }
}

//ログインしてたらTOPへ
function loginflgTrue(){
   if($_SESSION["login_flg"]){
      header("Location:/");
   }
}

//ログアウトしてたらログインページへ
function loginflgFalse(){
   if(!$_SESSION["login_flg"]){
      header("Location:/login/login.php");
   }
}


?>