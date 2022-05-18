<?php
session_start();
require_once("/home/createengineer/www/todo/system/config/db.php");
require_once("/home/createengineer/www/todo/system/validation/validation.php");
require_once("/home/createengineer/www/todo/system/model/model.php");
class Todo{
   //投稿処理
   public function Register($pdo,$content,$day){
         $error = validation::errorCheck($content);
         if(!$error){
            $_SESSION["validation_text"] = "内容を入力してください";
            return false;
         }else{
            unset($_SESSION["validation_text"]);
         }
      $m = date("Y-m");
      $today = $m . "-" . $day; //2021-00-00で検索させる※//2021-1-1これは検索できない(2の位が必要)
      try{
         model::sqlRegister($pdo,$today,$content);
      }catch (PDOException $e){
         print('Error:'.$e->getMessage());
         echo "データベースエラー";
      }
      header("Refresh:0"); //多重投稿回避用にリロード
   }

   //投稿情報を取得
   public function getRegister($pdo,$day){
      $m = date("Y-m");
      $today = $m . "-" . $day; //2021-00-00で検索させる※//2021-1-1これは検索できない(2の位が必要)
      try{
         $info = model::sqlGetRegister($pdo,$today);
         $pdo = null;
         return $info;
      }catch (PDOException $e){
         print('Error:'.$e->getMessage());
         echo "データベースエラー";
      }
   }

   //削除処理
   public function delete($pdo,$param){
      try{
         model::sqlDelete($pdo,$param);
         $pdo = null;
      }catch (PDOException $e){
         print('Error:'.$e->getMessage());
         echo "データベースエラー";
      }
      header("Location:/");
   }
   
   //更新機能
   public function edit($pdo,$id,$text){
      try{
         model::sqlEdit($pdo,$id,$text);
         $day = $_POST["edit_day"];
         $pdo = null;
      }catch (PDOException $e){
         print('Error:'.$e->getMessage());
         echo "データベースエラー";
      }
      if($day){
         header("Location:/index.php?day=".$day);
      }else{
         header("Location:/");
      }
   }

   //検索機能
   public function search($pdo,$text){
      try{
         if(empty($text)){
            return false;
         }
         $info = model::sqlSearch($pdo,$text);
         $pdo = null;
         return $info;
      }catch (PDOException $e){
         print('Error:'.$e->getMessage());
         echo "データベースエラー";
      }
   }

}
?>