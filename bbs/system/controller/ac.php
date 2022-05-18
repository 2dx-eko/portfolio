<?php
session_start();
require_once("/home/createengineer/www/bbs/system/config/function.php");
require_once("/home/createengineer/www/bbs/system/model/ac_model.php");
require_once("/home/createengineer/www/bbs/system/validation/ac_validation.php");
require_once("/home/createengineer/www/bbs/system/config/config.php");
header('X-FRAME-OPTIONS: DENY');
class ac{
    public function login($pdo){
        $name = conversion($_POST["login_name"]);
        $mail = conversion($_POST["login_mail"]);
        $pass = conversion($_POST["login_pass"]);
        $model = validation::loginCheck($name,$mail,$pass);

        $error = modelRun($model);
        foreach((array)$error as $errors){
            $_SESSION["login_error"] .= $errors;
        }
        if($error){
            return false;
        }

        $check = ac_model::loginRunCheck($pdo,$name,$mail,$pass);
        if(!$check){
            $_SESSION["login_error"] = LOGIN_ERROR;
            return false;
        }
        $_SESSION["main"] = LOGIN_SUCCESS;
        //ログインが通ればログインチェックを１に
        ac_model::loginSuccess($pdo,$mail);
        setcookie("address",$mail,time() + (10 * 365 * 24 * 60 * 60),"/");
        $pdo = "";
        header("Location:https://createengineer.sakura.ne.jp/bbs/");

        
    }

    //仮登録
    public function mailSend($pdo){
        $mail = conversion($_POST["send_mail"]);
        $model = validation::sendMailCheck($mail);
        $error = modelRun($model);
        foreach((array)$error as $errors){
            $_SESSION["sendmail_error"] .= $errors;
        }
        if($error){
            return false;
        }
        
        //アドレスがDBに登録されてるかチェック(登録されていなくても送信しましたを表示)
        $address_check = ac_model::mailRegisterCheck($pdo,$mail);
        if($address_check){
            $_SESSION["acregister_success"] = SENDMAIL_SUCCESS;
            header("Location:./login.php");
            return false;
        }

        try{
            $_SESSION["acregister_success"] = SENDMAIL_SUCCESS;
            $token = uniqid(dechex(random_int(0,255)));//ユニークID
            ac_model::TemporaryRegister($pdo,$mail,$token);
            
        }catch(PDOException $e){
            print('Error:'.$e->getMessage());
            echo DB_ERROR;
        }
        $pdo = "";
        header("Location:./login.php");
    }

    //本登録
    public function ACMainRegister($pdo,$mail,$token){
        $id = conversion($_POST["ac_name"]);
        $pass = conversion($_POST["ac_pass"]);
        $model = validation::ACRegisterCheck($id,$pass);
        $error = modelRun($model);
        foreach((array)$error as $errors){
            $_SESSION["acregister_error"] .= $errors;
        }
        if($error){
            return false;
        }
        try{
            $_SESSION["acregister_success"] = ACREGISTER_SUCCESS;
            ac_model::otherACDelete($pdo,$mail,$token);//同じメールアドレスでDBに何個も登録された情報は削除
            ac_model::MainRegister($pdo,$id,$pass,$token);//本登録
        }catch(PDOException $e){
            print('Error:'.$e->getMessage());
            echo DB_ERROR;
        }
        $pdo = "";
        header("Location:./login.php");
    }

    //パスワードリセット
    public static function passReset($pdo){
        $mail = conversion($_POST["reset_mail"]);
        $model = validation::sendMailCheck($mail);
        $error = modelRun($model);
        foreach((array)$error as $errors){
            $_SESSION["reset_error"] .= $errors;
        }
        if($error){
            return false;
        }
        $_SESSION["acregister_success"] = SENDMAIL_SUCCESS;
        $address_check = ac_model::mailRegisterCheck($pdo,$mail);//アドレスがDBに登録されてるかチェック
        if($address_check){
            ac_model::passResetMail($pdo,$mail);
        }
        header("Location:./login.php");
    }

    //パス再設定登録処理
    public static function ACPassRegister($pdo,$mail){
        $pass = conversion($_POST["ac_pass"]);
        $model = validation::PassRegisterCheck($pass);
        $error = modelRun($model);
        foreach((array)$error as $errors){
            $_SESSION["resetpass_error"] .= $errors;
        }
        if($error){
            return false;
        }
        $_SESSION["acregister_success"] = PASS_RESET_REGISTER;
        ac_model::passResetRegister($pdo,$mail,$pass);
        header("Location:./login.php");
    }





}

?>