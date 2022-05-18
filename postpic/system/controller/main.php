<?php
session_start();
require_once("/home/createengineer/www/postpic/system/config/db.php");
require_once("/home/createengineer/www/postpic/system/config/config.php");
require_once("/home/createengineer/www/postpic/system/config/function.php");
require_once("/home/createengineer/www/postpic/system/model/model.php");
require_once("/home/createengineer/www/postpic/system/validation/validation.php");
class main{
    //画像保存処理+DBにも情報保存
    public function picSave($pdo){
        $before_dir = $_FILES["up_img"]["tmp_name"];
        $error = validation::imgCheck($before_dir);//拡張子が画像にのみ保存を許可
        foreach((array)$error as $errors){
            $_SESSION["pic_error"] = $errors;
        }
        if($error){
            return false;
        }
        $id = $_SESSION["login_true_id"] . "_";
        $after_dir = "/home/createengineer/www/postpic/common/user_img/".$id.basename($_FILES["up_img"]["name"]);//サーバー内の保存先
        $register_dir = "https://postpic.tank.jp/common/user_img/".$id.basename($_FILES["up_img"]["name"]);//DBに保存するフルパス
        move_uploaded_file($before_dir,$after_dir);//move_uploaded_file(移動前のディレクトリ,移動後のディレクトリで保存)

        $pic_error = model::picCheck($pdo,$register_dir);//画像は保存されるけどDB側ではかぶっているものは保存しないように
        if($pic_error){
            $_SESSION["pic_success"] = PIC_SUCCESS;
            //header("Refresh:0");
            return false;
        }
        //↑「画像が保存できるか」と「保存する際に画像に被りがないか」２段階でチェックを行っている
        model::picsaveDB($pdo,$register_dir);
        $_SESSION["pic_success"] = PIC_SUCCESS;
    
    }

    public function imgDelete($pdo){
        $img_url = $_POST["delete_img"];
        model::picDelete($pdo,$img_url);
        $_SESSION["pic_success"] = DELETE_PIC;
    }

    public function callImage($pdo){
        $info = model::loadImage($pdo);
        return $info;
    }
}

?>