<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class users extends Model
{
    protected $table = 'users';
    
    //ユーザー作成
    public static function usersCreate($id,$pass,$mail){
        users::insert([
            'user-id' => $id,
            'user-pass' => $pass,
            'user-mail' => $mail,
            'created_at' => NOW(),
            'updated_at' => NOW(),
            'loginflg' => false,
        ]);
    }

    //パスリセット
    public static function userPassReset($id,$pass){
        users::where('id',$id)->update(['user-pass' => $pass,'updated_at' => NOW()]);
    }

    //メールアドレス被りチェック
    public static function usersMailCheck($mail){
        $query = users::where('user-mail',$mail)->get();
        return $query;
    }

    //ログインチェック
    public static function acLoginCheck($id,$pass){
        $query = users::where('user-id',$id)->where('user-pass',$pass)->get();
        return $query;
    }

    //ログインフラグtrueに
    public static function acLoginflg($id,$pass){
        users::where('user-id',$id)->where('user-pass',$pass)->update(['loginflg' => true,'updated_at' => NOW()]);
    }
    
    //ログアウト
    public static function acLogout($get_session){
        users::where('id',$get_session)->update(['loginflg' => false, 'updated_at' => NOW()]);
    }

    //where id only
    public static function userGetId($loginflg_session){
        $query = users::where('id',$loginflg_session)->get();
        return $query;
    }
}
