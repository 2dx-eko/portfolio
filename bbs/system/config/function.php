<?php
session_start();
require_once("/home/createengineer/www/bbs/system/model/ac_model.php");
require_once("/home/createengineer/www/bbs/system/model/main_model.php");
require_once("/home/createengineer/www/bbs/system/config/config.php");
header('X-FRAME-OPTIONS: DENY');
function conversion($str){
   return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

function modelRun($model){
   try{
      $error = $model;
   }catch(PDOException $e){
         print('Error:'.$e->getMessage());
         echo DB_ERROR;
   }
   return $error;
}

//ログインしてるかチェック(ログインしてる時)
function loginCookieCheck($pdo,$mail){
   $login_check = main_model::loginCheck($pdo,$mail);
   if(!$login_check[0]["login_check"] == "1"){
      header("Location:/bbs/login/login.php");
   }
}

//ログインしてるかチェック(ログアウトしてる時)
function loginCookieCheckOut($pdo,$mail){
   $login_check = main_model::loginCheck($pdo,$mail);
   if($login_check[0]["login_check"] == "1"){
      header("Location:/bbs/");
   }
}


//ログアウト
function logout($pdo,$mail){
   if(isset($_POST["logout"])){
      main_model::logout($pdo,$mail);
      setcookie("address","",time()-1,"/");
      $_SESSION["acregister_success"] = LOGOUT;
      header("Location:/bbs/login/login.php");
   }
}

//newマーク用（1週間）
function isNew($date){//$dateはフォーマットの値を入れる
   $date = str_replace( "-", "", $date);//要らない/を取る
   $now = date('Ymd');
   if($now - $date <= 7 ){//ここで日数の差
      return " <span class=\"new\">NEW</span>";
   }
}


?>