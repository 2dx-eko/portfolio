<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\users;

use Illuminate\Support\Facades\Mail;
use App\Mail\passwordResetMail;


class acController extends Controller
{
    public function index(Request $request){
        $loginflg_session = session()->get('acid_session');//ログインしてるかどうかのセッションを取得
        $getuser = users::userGetId($loginflg_session);
        if($loginflg_session){ //セッションが存在したらTODOへ
            return redirect(route('todo.index',[
                'user_id' => $getuser[0]["id"]
            ]));
        }
        return view('index');
    }

    public function submitController(Request $request){
        $loginflg_session = session()->get('acid_session');
        $getuser = users::userGetId($loginflg_session);
        if($request->has('login')){//ログイン
            if(!$loginflg_session){
                $id = $request->input('login-user-id');
                $pass = $request->input('login-user-pass');
                $acloginchecks = users::acLoginCheck($id,$pass);
                $loginChecks =$this::loginCkeck($id,$pass,$acloginchecks);
                
                if($loginChecks){
                    return view('index',compact('loginChecks'));
                }
                users::acLoginflg($id,$pass); //ログインOKならフラグをtrueに
                session()->put('acid_session',$acloginchecks[0]["id"]);//セッションにidを登録(ログインしてるかどうかで使う)
                return redirect(route('todo.index',[
                    'user_id' => $acloginchecks[0]["id"]
                ])); //URLにidのパラメータ付けてTODOにリダイレクト
            }else{
                return redirect(route('todo.index',[
                    'user_id' => $getuser[0]["id"]
                ]));
            }

        }else if($request->has('ac_create')){//アカウント作成
            $id = $request->input('user-id');
            $pass = $request->input('user-pass');
            $mail = $request->input('user-mail');
            $acChecks = $this::acCheck($id,$pass,$mail);
            if($acChecks){
                return view('index',compact('acChecks'));
            }
           try{
                DB::beginTransaction();
                users::usersCreate($id,$pass,$mail);
                session()->put('ac_session',"アカウント作成が完了しました！");
                DB::commit();
            }catch(Exeption $e){
                DB::rollBack();
                echo $e->getMessage();
            }

            $request->session()->regenerateToken();

        }else if($request->has('forget_mail')){ //パス再登録
            $mail = $request->input('forget-user-mail');
            $mail = users::usersMailCheck($mail);
            $mailchecks = $this::mailcheck($mail);
            if($mailchecks){
                return view('index',compact('mailchecks'));
            }
            session()->put('ac_session',"パスワード再設定のメールを送信しました！");
            $mailarray = [];
            $mailarray['mail'] = $mail[0]['user-mail'];
            $mailarray['id'] = $mail[0]['id'];
            Mail::send(new passwordResetMail($mailarray));
        }
        return redirect('/');
    }

    static function acCheck($id,$pass,$mail){ //アカウント作成時チェック
        $error = [];
        
        if(empty($id)){
            array_push($error,'■ユーザー名を入力してください');
        }else if(!preg_match("/^[a-zA-Z0-9]+$/", $id)){
            array_push($error,'■ユーザー名は半角英数字で入力してください');
        }

        if(empty($pass)){
            array_push($error,'■パスワードを入力してください');
        }else if(!preg_match("/^[a-zA-Z0-9]+$/", $pass)){
            array_push($error,'■パスワードは半角英数字で入力してください');
        }

        $getusers = users::usersMailCheck($mail);
        $pattern = "/^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:.[a-zA-Z0-9-]+)*$/";
        if(empty($mail)){
            array_push($error,'■メールアドレスを入力してください');
        }else if(!filter_var($mail,FILTER_VALIDATE_EMAIL)){
            array_push($error,'■正しい形式のメールアドレスを入力してください');
        }else if(!(count($getusers) == 0)){
            array_push($error,'■入力されたメールアドレスはすでに登録されています');
        }
        return $error;
    }

    static function mailcheck($mail){
        $error = [];
        if(count($mail) == 0){
            array_push($error,'■入力されたメールアドレスは登録されていません');
        }
        return $error;
    }

    static function passcheck($pass){
        $error = [];
        if(empty($pass)){
            array_push($error,'■パスワードを入力してください');
        }else if(!preg_match("/^[a-zA-Z0-9]+$/", $pass)){
            array_push($error,'■パスワードは半角英数字で入力してください');
        }
        return $error;
    }

    static function loginCkeck($id,$pass,$acloginchecks){ //アカウント作成時チェック
        $error = [];
        
        if(empty($id)){
            array_push($error,'■ユーザー名を入力してください');
        }

        if(empty($pass)){
            array_push($error,'■パスワードを入力してください');
        }

        if(!(empty($id)) && !(empty($pass)) && (count($acloginchecks) == 0)){
            array_push($error,'■ユーザー名またはパスワードが違います');
        }
        return $error;
    }

    public function passreset(Request $request){
        return view('passreset.index');
    }

    public function resetsubmit(Request $request){
        $id = request('id');
        $id = (int)substr($id,0,-1);
        $pass = $request->input('passwordreset-mail');
        $passchecks = $this::passcheck($pass);
        if($passchecks){
            return view('passreset.index',compact('passchecks'));
        }
        try{
            DB::beginTransaction();
            users::userPassReset($id,$pass);
            DB::commit();
        }catch(Exeption $e){
            DB::rollBack();
            echo $e->getMessage();
        }
        session()->put('ac_session',"パスワード再設定が完了しました！");
        return redirect('/');
    }

}

