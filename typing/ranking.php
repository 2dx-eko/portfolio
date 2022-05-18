<?php
require_once("/home/createengineer/www/typing/db/config.php");

function h($str) {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
 }

//$pdo;
$save_name = h($_GET["save_name"]);
$save_time = $_GET["save_time"];
(int)$save_time; //文字列なのでintに変換
$save_text = $_GET["save_text"];
$level = $_GET["level"];

//DB登録
try{
    $sql = "INSERT INTO ranking (user_name,time,time_text,level) VALUE(:user_name,:time,:time_text,:level)";
    $statement = $pdo->prepare($sql);
    $statement->bindvalue(':user_name',$save_name);
    $statement->bindvalue(':time',$save_time);
    $statement->bindvalue(':time_text',$save_text);
    $statement->bindvalue(':level',$level);
    $statement->execute();
}catch (PDOException $e){
    print("Error:".$e->getMessage());
    echo "データベースエラー";
    return false;
}

//データ全取得
try{
    $sql = "SELECT * FROM ranking WHERE level = :level";
    $statement = $pdo->prepare($sql);
    $statement->bindvalue(':level',$level);
    $statement->execute();
    $statement = $statement->fetchAll(PDO::FETCH_ASSOC);
    $pdo = null;
    header("Content-type: application/json");
    echo json_encode($statement);
    exit;
}catch (PDOException $e){
    print('Error:'.$e->getMessage());
    echo "データベースエラー";
    return false;
}

?>