<?php
class model{
   /*---------------------------------ログイン前処理------------------------------------ */
   //ログイン時被りチェック処理
   public static function loginSearch($pdo,$id,$pass,$mail){
      $pass = sha1($pass);
      $sql = "SELECT * FROM ac WHERE ac_id = :id AND ac_pass = :pass AND mail = :mail";
      $statement = $pdo->prepare($sql);
      $statement->bindvalue(":id",$id);
      $statement->bindvalue(":pass",$pass);
      $statement->bindvalue(":mail",$mail);
      $statement->execute();
      $statement = $statement->fetchAll(PDO::FETCH_ASSOC);
      return $statement;
   }

   //アカウント登録処理
   public static function acRegister($pdo,$ac_id,$ac_pass,$ac_mail){
      $ac_pass = sha1($ac_pass); //passは暗号化して登録
      $sql = "INSERT INTO ac (id,ac_id,ac_pass,mail) VALUES(NULL,:ac_id,:ac_pass,:mail)";
      $statement = $pdo->prepare($sql);
      $statement->bindvalue(":ac_id",$ac_id);
      $statement->bindvalue(":ac_pass",$ac_pass);
      $statement->bindvalue(":mail",$ac_mail);
      $statement->execute();
   }

   //アカウント登録処理時アドレスチェック処理
   public static function mailCheck($pdo,$ac_mail){
      $sql = "SELECT * FROM ac WHERE mail = :mail";
      $statement = $pdo->prepare($sql);
      $statement->bindvalue(":mail",$ac_mail);
      $statement->execute();
      $statement = $statement->fetchAll(PDO::FETCH_ASSOC);
      return $statement;
   }

   //アドレス検索処理
   public static function mailSearch($pdo,$forget_address){
      $sql = "SELECT * FROM ac WHERE mail = :mail";
      $statement = $pdo->prepare($sql);
      $statement->bindvalue(":mail",$forget_address);
      $statement->execute();
      $statement = $statement->fetchAll(PDO::FETCH_ASSOC);
      return $statement;
   }

   //パスワード再設定処理
   public static function updatePath($pdo,$new_path,$address){
      $new_path = sha1($new_path);
      $sql = "UPDATE ac SET ac_pass = :ac_pass WHERE mail = :mail";
      $statement = $pdo->prepare($sql);
      $statement->bindvalue(":ac_pass",$new_path);
      $statement->bindvalue("mail",$address);
      $statement->execute();
      return $statement;
   }
/*---------------------------------ログイン後------------------------------------ */
   //ページリロード時に画像登録された画像を読み込む
   public static function loadImage($pdo){
      $mail = $_SESSION["login_true_mail"];
      $sql = "SELECT * FROM save_img WHERE mail = :mail";
      $statement = $pdo->prepare($sql);
      $statement->bindvalue(":mail",$mail);
      $statement->execute();
      $statement = $statement->fetchAll(PDO::FETCH_ASSOC);
      return $statement;
   }

   //画像名をDB(save_imgテーブル)に保存（アカウントごとに管理）
   public static function picsaveDB($pdo,$register_dir){
   //ログイン時に保存したセッションを取得
      $mail = $_SESSION["login_true_mail"];
      $sql = "INSERT INTO save_img (id,mail,img) VALUES(null,:mail,:register_dir)";
      $statement = $pdo->prepare($sql);
      $statement->bindvalue(":mail",$mail);
      $statement->bindvalue(":register_dir",$register_dir);
      $statement->execute();
   }

   //画像アップロード時にかぶりがないかチェック
   public static function picCheck($pdo,$register_dir){
      $mail = $_SESSION["login_true_mail"];
      $sql = "SELECT * FROM save_img WHERE mail = :mail AND img = :register_dir";
      $statement = $pdo->prepare($sql);
      $statement->bindvalue(":mail",$mail);
      $statement->bindvalue(":register_dir",$register_dir);
      $statement->execute();
      $statement = $statement->fetchAll(PDO::FETCH_ASSOC);
      return $statement;
   }

   public static function picDelete($pdo,$img_url){
      $mail = $_SESSION["login_true_mail"];
      $sql = "DELETE FROM save_img WHERE mail = :mail AND img = :img";
      $statement = $pdo->prepare($sql);
      $statement->bindvalue(":mail",$mail);
      $statement->bindvalue(":img",$img_url);
      $statement->execute();
   }
}
?>