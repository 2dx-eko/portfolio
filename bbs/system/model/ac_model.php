<?php
require_once("/home/createengineer/www/bbs/system/config/config.php");
class ac_model{
   public $error = [];
   //メール送信時の仮登録（アドレスだけを登録）
   public static function TemporaryRegister($pdo,$mail,$token){
      $sql = "INSERT INTO user (name,mail,pass,token,login_flg) VALUES(NULL,:mail,NULL,:token,1)";
      $statement = $pdo->prepare($sql);
      $statement->bindvalue(":mail",$mail);
      $statement->bindvalue(":token",$token);
      $statement->execute();

      //↓アドレス宛に送信↓
      $to = $mail;
      // 件名
      $subject = "BBSより仮登録完了のお知らせ";
      // 本文
      $text = "仮登録完了しました、こちらから本登録をお願いします。
https://createengineer.sakura.ne.jp/bbs/login/create.php?token=" . $token . "&mail=" . $mail;
      // 送信元
      $from = "BBS";
      // 送信元メールアドレス
      $from_mail = "2dxeko11@gmail.com";
      // 送信者名
      $from_name = "test";
      // 送信者情報の設定
      $header = '';
      $header .= "Content-Type: text/plain \r\n";
      $header .= "Return-Path: " . $from_mail . " \r\n";
      $header .= "From: " . $from ." \r\n";
      $header .= "Sender: " . $from ." \r\n";
      $header .= "Reply-To: " . $from_mail . " \r\n";
      $header .= "Organization: " . $from_name . " \r\n";
      $header .= "X-Sender: " . $from_mail . " \r\n";
      $header .= "X-Priority: 3 \r\n";

      //メール送信
      $response = mb_send_mail( $to, $subject, $text, $header);
   }

   //同じアドレスで以前登録した情報削除
   public static function otherACDelete($pdo,$mail,$token){
      $sql = "DELETE FROM user WHERE mail = :mail AND token NOT IN(:token)";
      $statement = $pdo->prepare($sql);
      $statement->bindvalue(":mail",$mail);
      $statement->bindvalue(":token",$token);
      $statement->execute();
   }

   //アカウント作成画面遷移時トークンチェック
   public static function tokenCheck($pdo,$token){
      $sql = "SELECT * FROM user WHERE token = :token";
      $statement = $pdo->prepare($sql);
      $statement->bindvalue(":token",$token);
      $statement->execute();
      $statement = $statement->fetchAll(PDO::FETCH_ASSOC);
      return $statement;
   }

   //アカウント本登録
   public static function MainRegister($pdo,$id,$pass,$token){
      $pass = sha1($pass); //passは暗号化して登録
      $sql = "UPDATE user SET name = :name , pass = :pass, login_flg = 2 WHERE token = :token";
      $statement = $pdo->prepare($sql);
      $statement->bindvalue(":name",$id);
      $statement->bindvalue(":pass",$pass);
      $statement->bindvalue(":token",$token);
      $statement->execute();
   }

   //DBにアドレスが登録されてるかチェック
   public static function mailRegisterCheck($pdo,$mail){
      $sql = "SELECT * FROM user WHERE mail = :mail";
      $statement = $pdo->prepare($sql);
      $statement->bindvalue(":mail",$mail);
      $statement->execute();
      $statement = $statement->fetchAll(PDO::FETCH_ASSOC);
      return $statement;
   }
   
   //パスワードリセット時のメール送信処理
   public static function passResetMail($pdo,$mail){
      $token = $token = uniqid(dechex(random_int(0,255)));

      //↓アドレス宛に送信↓
      $to = $mail;
      // 件名
      $subject = "BBSよりパスワードを忘れた方へお知らせ";
      // 本文
      $text = "下記URLよりパスワードの再設定をよろしくお願いします。
https://createengineer.sakura.ne.jp/bbs/login/pass.php?token=" . $token . "&mail=" . $mail;
      // 送信元
      $from = "FROM:BBS";
      // 送信元メールアドレス
      $from_mail = "2dxeko11@gmail.com";
      // 送信者名
      $from_name = "test";
      // 送信者情報の設定
      $header = '';
      $header .= "Content-Type: text/plain \r\n";
      $header .= "Return-Path: " . $from_mail . " \r\n";
      $header .= "From: " . $from ." \r\n";
      $header .= "Sender: " . $from ." \r\n";
      $header .= "Reply-To: " . $from_mail . " \r\n";
      $header .= "Organization: " . $from_name . " \r\n";
      $header .= "X-Sender: " . $from_mail . " \r\n";
      $header .= "X-Priority: 3 \r\n";

      //メール送信
      $response = mb_send_mail( $to, $subject, $text, $header);
   }

   //パス再登録
   public static function passResetRegister($pdo,$mail,$pass){
      $pass = sha1($pass);
      $sql = "UPDATE user SET pass = :pass WHERE mail = :mail";
      $statement = $pdo->prepare($sql);
      $statement->bindvalue(":pass",$pass);
      $statement->bindvalue(":mail",$mail);
      $statement->execute();
   }

   public static function loginRunCheck($pdo,$name,$mail,$pass){
      $pass = sha1($pass);
      $sql = "SELECT * FROM user WHERE name = :name AND mail = :mail AND pass = :pass";
      $statement = $pdo->prepare($sql);
      $statement->bindvalue(":name",$name);
      $statement->bindvalue(":mail",$mail);
      $statement->bindvalue(":pass",$pass);
      $statement->execute();
      $statement = $statement->fetchAll(PDO::FETCH_ASSOC);

      return $statement;
   }

   public static function loginSuccess($pdo,$mail){
      $sql = "UPDATE user SET login_check = 1 WHERE mail = :mail";
      $statement = $pdo->prepare($sql);
      $statement->bindvalue(":mail",$mail);
      $statement->execute();
   }

}
?>