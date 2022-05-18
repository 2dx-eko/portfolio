<?php
session_start();
require_once("/home/createengineer/www/bbs/system/config/db.php");
require_once("/home/createengineer/www/bbs/system/config/config.php");
require_once("/home/createengineer/www/bbs/system/config/function.php");
require_once("/home/createengineer/www/bbs/system/model/main_model.php");
require_once("/home/createengineer/www/bbs/system/validation/validation.php");
class main{
    public function CreateThread($pdo){
        $title = conversion($_POST["bord_title"]);
        $desc = conversion($_POST["bord_desc"]);
        $cat = conversion($_POST["cat_radio"]);
        
        if($cat == "雑談"){
            $classname = "zatudan";
        }else if($cat == "おもしろ"){
            $classname = "omoshiro";
        }else if($cat == "ゲーム"){
            $classname = "game";
        }else if($cat == "アニメ"){
            $classname = "anime";
        }else if($cat == "政治"){
            $classname = "seiji";
        }else if($cat == "趣味"){
            $classname = "syumi";
        }
        $extension = substr($_FILES["bord_img"]["name"], strrpos($_FILES["bord_img"]["name"], '.') + 1);//添付画像の拡張子のみを取得
        if(strpos($extension,"jpg") !== false || strpos($extension,"png") !== false || strpos($extension,"jpeg") !== false){
            $img = date("YmdHis") . "_" . $_FILES["bord_img"]["name"];//画像名が被らないように先頭に名前,日付を入れる
            $filepath = "/home/createengineer/www/bbs/common/bbs_img/" . $img; //パスを変数に
            move_uploaded_file($_FILES['bord_img']['tmp_name'], $filepath);//保存処理
            main_model::threadRegister($pdo,$title,$desc,$cat,$img,$classname);
        }else{//サムネ未設定だったら
            $img = "noimage.png";
            main_model::threadRegister($pdo,$title,$desc,$cat,$img,$classname);
        }
        header("Refresh:0");
        header("Location:/bbs/");//←あとでスレッドの画面に変更
    }

    



}

?>