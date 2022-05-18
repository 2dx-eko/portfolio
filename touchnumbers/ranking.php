<?php
require_once("/home/createengineer/www/touchnumbers/db/config.php");

function h($str) {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
 }

//$pdo;
$end_time = $_GET["endtime"];
$db_time = $_GET["dbtime"];
$name = h($_GET["name"]);
$level = $_GET["level"];


//DB登録
try{
    $sql = "INSERT INTO ranking_register (endtime,dbtime,name,level) VALUE(:end_time,:db_time,:name,:level)";
    $statement = $pdo->prepare($sql);
    $statement->bindvalue(':end_time',$end_time);
    $statement->bindvalue(':db_time',$db_time);
    $statement->bindvalue(':name',$name);
    $statement->bindvalue(':level',$level);
    $statement->execute();
}catch (PDOException $e){
    print('Error:'.$e->getMessage());
    echo "データベースエラー";
    return false;
}

//データ全取得
try{
    $sql = "SELECT * FROM ranking_register WHERE level = " . $level;
    $statement = $pdo->prepare($sql);
    $statement->execute();
    $statement = $statement->fetchAll(PDO::FETCH_ASSOC);
    $pdo = null;
    header('Content-type: application/json');
    echo json_encode($statement);
}catch (PDOException $e){
    print('Error:'.$e->getMessage());
    echo "データベースエラー";
    return false;
}



?>