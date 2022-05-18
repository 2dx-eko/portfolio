<?php
 $day = $_POST['item'];//ポストで受け取れる
 //略
 $html = "戻り値";
 $day = $day . $day;
 header('Content-type: application/json');//指定されたデータタイプに応じたヘッダーを出力する
 echo json_encode( $day );
?>