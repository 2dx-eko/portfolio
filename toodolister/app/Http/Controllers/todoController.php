<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\users;
use App\Models\listparent;
use App\Models\listtodo;

class todoController extends Controller
{
    //todoindex
    public function index(Request $request){
        $parameter_userid = request("user_id");
        $loginflg_session = session()->get('acid_session');
        if($loginflg_session){
            $getlists = listparent::getList($parameter_userid); //リストを取得
            $gettodos = listtodo::getTodo($parameter_userid);
            if($getlists){
                return view('todo.index',compact('getlists','gettodos'));        
            }
 

        }else{//セッションがなければac画面へ
            return redirect('/');
        }
        return view('todo.index');
    }

    //POST処理
    public function submit(Request $request){
        if($request->has('logout')){//ログアウト

            $get_session = session()->get('acid_session');//パラメータid取得
            users::acLogout($get_session);
            session()->forget('acid_session');
            return redirect('/');

        }else if($request->has('cat_create_submit')){ //リスト作成

            $text = $request->input('cat_create');
            $id = session()->get('acid_session');
            try{
                DB::beginTransaction();
                listparent::listCreate($id,$text);
                session()->put('ac_session',"リストの作成が完了しました！");
                DB::commit();
            }catch(Exeption $e){
                DB::rollBack();
                echo $e->getMessage();
            }

        }else if($request->has('todo_create_submit')){//todo作成

            $userid = session()->get('acid_session'); //ユーザーid
            $todo_create = $request->input('todo_create'); //todoテキスト
            $list_parentId = $request->input('todo_create_submit'); //リストID
            try{
                DB::beginTransaction();
                listtodo::todoCreate($list_parentId,$userid,$todo_create);
                session()->put('ac_session',"TODOを作成しました");
                DB::commit();
            }catch(Exeption $e){
                DB::rollBack();
                echo $e->getMessage();
            }

        }else if($request->has('todo-del')){ //todo削除

            $userid = session()->get('acid_session');
            $listparent_id = $request->input('todo-del');
            $todo_id = $request->input('todoid');
            try{
                DB::beginTransaction();
                listtodo::todoDelete($todo_id,$listparent_id,$userid);
                session()->put('ac_session',"押下したTODOを削除しました！");
                DB::commit();
            }catch(Exeption $e){
                DB::rollBack();
                echo $e->getMessage();
            }

        }else if($request->has('list-del')){ //リスト削除

            $userid = session()->get('acid_session');
            $parentid = $request->input('list-del');
            try{
                DB::beginTransaction();
                listparent::listDelete($userid,$parentid);
                session()->put('ac_session',"押下したリストを削除しました！");
                DB::commit();
            }catch(Exeption $e){
                DB::rollBack();
                echo $e->getMessage();
            }

        }else if($request->has('todo-bold')){ //todo bold処理
            
            $todo_id = $request->input('todoid');
            $listparent_id = $request->input('todo-bold');
            $userid = session()->get('acid_session');
            try{
                DB::beginTransaction();
                $gettodo = listtodo::getTodoPart($todo_id,$listparent_id,$userid);
                if($gettodo[0]['bold-flg']){
                    listtodo::listBoldFalse($todo_id,$listparent_id,$userid);
                }else{
                    listtodo::listBold($todo_id,$listparent_id,$userid);
                }

                DB::commit();
            }catch(Exeption $e){
                DB::rollBack();
                echo $e->getMessage();
            }


        }

        $parameter_userid = request("user_id");
        return redirect(route('todo.index',[
            'user_id' => $parameter_userid
        ]));
    }

    
}

