<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\management;

class usercontroller extends Controller
{
    public function index(){
        return view('register.index');
    }
    
    public function overlapNum(){
        $user_id = mt_rand(100,999);
        $search_id = management::where('user_id',$user_id)->get();
        if(count($search_id) == 1){
            overlapNum();
        }else{
            return $user_id;
        }
        
    }

    public function userRegister(Request $request){
        $request->validate([ //バリデーション
            'user_name' => 'required',
        ],[
            'user_name.required' => 'ユーザー名を入力してください！',
        ]);
        try{
            DB::beginTransaction();
            $db = new management;
            $name = $request->input('user_name');
            $user_id = $this->overlapNum(); //IDに被りがないかチェック、あれば再起関数
            $search_name = management::where('name',$name)->get(); //nameに被りがないかチェック
            if(count($search_name) == 1){
                session()->put('overlap_name',"入力されたユーザー名はすでに登録されています！");
                return redirect('/register');
            }

            $db->name =$name;
            $db->user_id = $user_id;
            $db->user_flg = false;
            $db->save();
            DB::commit();
            session()->put('user_register',"ユーザー登録が完了しました");
            return redirect('/');
        }catch(Exeption $e){
            DB::rollBack();
            echo $e->getMessage();
        }
    }
    


}
