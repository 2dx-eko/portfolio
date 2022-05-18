<?php
require_once("/home/createengineer/www/bbs/system/config/config.php");
class validation{
   public $error = [];

   public static function loginCheck($name,$mail,$pass){
      if(empty($name)){
         $error[] = ID_EMPTY;
      }

      if(empty($mail)){
         $error[] = MAIL_EMPTY;
      }

      if(empty($pass)){
         $error[] .= PASS_EMPTY;
      }
      return $error;
   }

   //AC仮登録バリデーション
   public static function sendMailCheck($mail){
      if(empty($mail)){
         $error[] = MAIL_EMPTY;
      }else if(!preg_match('/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/iD',$mail)){
         $error[] .= MAIL_FORMAT;
      }
      return $error;
   }

   //AC本登録バリデーション
   public static function ACRegisterCheck($id,$pass){
      $id = trim(mb_convert_kana($id, "s"));
      $pass = trim(mb_convert_kana($pass, "s"));
      if(empty($id)){
         $error[] = ID_EMPTY;
      }
      if(empty($pass)){
         $error[] .= PASS_EMPTY;
      }else if(!preg_match("/^[a-zA-Z0-9]+$/", $pass)){
         $error[] .= HALF_PASSINPUT;
      }else if(mb_strlen($pass) < 6){
         $error[] .= PASS_STRREN;
      }
      return $error;
   }

   public static function PassRegisterCheck($pass){
      $pass = trim(mb_convert_kana($pass, "s"));
      if(empty($pass)){
         $error[] .= PASS_EMPTY;
      }else if(!preg_match("/^[a-zA-Z0-9]+$/", $pass)){
         $error[] .= HALF_PASSINPUT;
      }else if(mb_strlen($pass) < 6){
         $error[] .= PASS_STRREN;
      }
      return $error;
   }

}
?>