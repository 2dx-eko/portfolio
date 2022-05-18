<?php
class model{
   public static function sqlRegister($pdo,$today,$content){
      $sql = "INSERT INTO info(entry_day,content,full_day) VALUES(:today,:content,NOW())";
      $statement = $pdo->prepare($sql);
      $statement->bindvalue(":today",$today);
      $statement->bindvalue(":content",$content);
      $statement->execute();

   }

   public static function sqlGetRegister($pdo,$today){
      $sql = "SELECT * FROM info WHERE entry_day='$today'";
      $statement = $pdo->query($sql);
      $info = $statement->fetchAll(PDO::FETCH_ASSOC);
      return $info;
   }

   public static function sqlDelete($pdo,$param){
      $sql = "DELETE FROM info WHERE id='$param'";
      $pdo->query($sql);
   }

   public static function sqlEdit($pdo,$id,$text){
      $sql = "UPDATE info SET content=:text WHERE id =:id";
      $statement = $pdo->prepare($sql);
      $statement->bindvalue(":text",$text);
      $statement->bindvalue(":id",$id);
      $statement->execute();
   }

   public static function sqlSearch($pdo,$text){
      $sql = "SELECT * FROM info WHERE content LIKE :text";
      $statement = $pdo->prepare($sql);
      $text = '%'. $text . '%';
      $statement->bindvalue(':text',$text,PDO::PARAM_STR);
      $statement->execute();
      $info = $statement->fetchAll(PDO::FETCH_ASSOC);
      return $info;
   }
}
?>