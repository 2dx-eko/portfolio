<?php
require_once("/home/createengineer/www/bbs/system/config/config.php");
class validation{
   public $error = [];

   //ログイン処理
   public static function loginCheck($id,$pass,$mail,$login_check){
      if(empty($id)){
         $error[] = ID_EMPTY;
      }

      if(empty($pass)){
         $error[] = PASS_EMPTY;
      }

      if(empty($mail)){
         $error[] = MAIL_EMPTY;
      }

      if(!empty($id) && !empty($pass) && !empty($mail) && !$login_check){
         $error[] = NOT_LOGIN_MATCH;
      }
      return $error;
   }

   //アカウント登録処理
   public static function acCheck($ac_id,$ac_pass,$ac_mail,$mail_check){
      if(empty($ac_id)){
         $error[] = ID_EMPTY;
      }else if(!preg_match("/^[a-zA-Z0-9]+$/", $ac_id)){
         $error[] = HALF_IDINPUT;
      }else if(mb_strlen($ac_id) < 6){
         $error[] = ID_STRREN;
      }

      if(empty($ac_pass)){
         $error[] = PASS_EMPTY;
      }else if(!preg_match("/^[a-zA-Z0-9]+$/", $ac_pass)){
         $error[] = HALF_PASSINPUT;
      }else if(mb_strlen($ac_pass) < 8){
         $error[] = PASS_STRREN;
      }

      if(empty($ac_mail)){
         $error[] = MAIL_EMPTY;
      }else if(!preg_match('/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/iD',$ac_mail)){
         $error[] = MAIL_FORMAT;
      }else if($mail_check){
         $error[] = ALREADY_REGISTER;
      }
      return $error;
   }

   //パスワード再設定アドレス入力
   public static function acForget($forget_address,$address){
      if(empty($forget_address)){
         $error[] = MAIL_EMPTY;
      }else if(!preg_match('/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/iD',$forget_address)){
         $error[] = MAIL_FORMAT;
      }else if(!$address){
         $error[] = NOT_REGISTER;
      }
      return $error;
   }

   //パスワード再設定入力
   public static function passCheck($new_path){
      if(empty($new_path)){
         $error[] = PASS_EMPTY;
      }else if(!preg_match("/^[a-zA-Z0-9]+$/", $new_path)){
         $error[] = HALF_PASSINPUT;
      }else if(mb_strlen($new_path) < 8){
         $error[] = PASS_STRREN;
      }
      return $error;
   }

   //画像保存できるかチェック
   public static function imgCheck($before_dir){
      if(empty($_FILES["up_img"]["tmp_name"])){
         $error[] = PIC_EMPTY;   
      }
      else if(!exif_imagetype($before_dir)){
          $error[] = PIC_ERROR;
      }
      return $error;
   }
}
?>