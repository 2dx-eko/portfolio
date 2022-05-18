<?php
session_start();
require_once("/home/createengineer/www/postpic/system/config/db.php");
require_once("/home/createengineer/www/postpic/system/config/config.php");
require_once("/home/createengineer/www/postpic/system/config/function.php");
require_once("/home/createengineer/www/postpic/system/model/model.php");
require_once("/home/createengineer/www/postpic/system/validation/validation.php");
class ac{
    public function login($pdo){
        $id = h($_POST["login_acount"]);
        $pass = h($_POST["login_pass"]);
        $mail = h($_POST["login_mail"]);
        try{
            $login_check = model::loginSearch($pdo,$id,$pass,$mail);
            $error = validation::loginCheck($id,$pass,$mail,$login_check);
        }catch(PDOException $e){
            print('Error:'.$e->getMessage());
            echo DB_ERROR;
        }
        foreach((array)$error as $errors){
            $_SESSION["login_error"] .= $errors;
        }
        if($error){
            return false;
        }
        //ログインに成功したらセッションをtrueにしてindexへ
        $_SESSION["login_flg"] = true;
        $_SESSION["login_true_mail"] = $mail;//ログイン後にパス以外を保持
        $_SESSION["login_true_id"] = $id;
        $_SESSION["pic_success"] = ROGIN_SUCCESS;
        header("Location:/");
    }

    //アカウント作成
    public function acCreate($pdo){
        $ac_id = h($_POST["ac_id"]);
        $ac_pass = h($_POST["ac_pass"]);
        $ac_mail = h($_POST["ac_mail"]);
        try{
            $mail_check = model::mailCheck($pdo,$ac_mail); //DB内のアドレスにかぶりがないかチェック
            $error = validation::acCheck($ac_id,$ac_pass,$ac_mail,$mail_check);
        }catch(PDOException $e){
            print('Error:'.$e->getMessage());
            echo DB_ERROR;
        }
        foreach((array)$error as $errors){
            $_SESSION["ac_error"] .= $errors;
        }
        if($error){
            return false;
        }
        try{
            model::acRegister($pdo,$ac_id,$ac_pass,$ac_mail);
            $_SESSION["ac_success"] = ACOUNT_SUCCESS;
        }catch(PDOException $e){
            print('Error:'.$e->getMessage());
            echo DB_ERROR;
        }
        header("Location:/login/login.php");
    }

    //パスワード再設定
    public function acForget($pdo){
        $forget_address = h($_POST["ac_forget"]);
        try{
            $address = model::mailSearch($pdo,$forget_address);//アドレスを検索
            $error = validation::acForget($forget_address,$address);
        }catch(PDOException $e){
            print('Error:'.$e->getMessage());
            echo DB_ERROR;
        }
        foreach((array)$error as $errors){
            $_SESSION["forget_error_address"] .= $errors;
        }
        if($error){
            return false;
        }
        header("Location:/login/reset.php?mail=" . $address[0]["mail"]);
    }

    //パスワード再設定後のパス更新処理
    public function passReset($pdo){
        $address = h($_GET["mail"]);
        $new_path = h($_POST["pass_reset"]);
        $error = validation::passCheck($new_path);
        foreach((array)$error as $errors){
            $_SESSION["new_path_error"] .= $errors;
        }
        if($error){
            return false;
        }
        try{
            model::updatePath($pdo,$new_path,$address);//パス更新
            $_SESSION["ac_success"] = PASS_RESET;
        }catch(PDOException $e){
            print('Error:'.$e->getMessage());
            echo DB_ERROR;
        }
        header("Location:/login/login.php");
    }
}

?>