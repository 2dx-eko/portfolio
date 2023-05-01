<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\management;
use App\Models\timeManagement;
use Carbon\Carbon;

class timecontroller extends Controller
{
    public function index(){
        return view('index');
    }
    
    public function userSubmit(Request $request){
        if($request->has('attendance')){ //出勤押下時
            $request->validate([
               'id' => 'required|integer',
            ],
            [
               'id.required' => '■idを入力してください！',
               'id.integer' => '■半角英数字を入力してください！',
            ]);
           //・ユーザーが登録されているかチェック後に問題なければ出勤のカラムをtrueにする
           //・すでに出勤がtrueだったら「このユーザーは出勤が押されています！」を表示
            try{
                DB::beginTransaction();
                $db = new management;
                $dbtime = new timeManagement;
                $id = (int)$request->input('id');
                $now = NOW();
                $search_user = management::where('user_id',$id)->get();
                $reset_flg = false;

                //DBのattendance_timeに今日じゃない日付が存在したら全カラムリセット
                $alls =  $db::all();
                for($i = 0; $i < count($alls); $i++){
                    $get_day = substr($alls[$i]['attendance_time'],0,10);
                    $dt = new Carbon($get_day);
                    if($dt->isToday() == false){ //$dtがNULLの場合、$dt->isToday()はtrue
                        DB::table('users')->update(['user_flg' => 0,'attendance_time' => NULL,'leaving_time' => NULL,'difference' => NULL]);
                        DB::commit();
                        $reset_flg = true;
                    }
                }
                
                if($reset_flg == false){
                    if(count($search_user) == 0){ //未ユーザーなら
                        session()->put('search_id',"存在しないユーザーです！");
                        return redirect('/');
                    }else if(count($search_user) == 1 && $search_user[0]["user_flg"] == 1){ //すでに出勤してきたら
                        session()->put('search_flg',"「{$search_user[0]['name']}さん」はすでに出勤を押下しています！");
                        return redirect('/');
                    }else if(!($search_user[0]["attendance_time"] == NULL) && !($search_user[0]["leaving_time"] == NULL) && $search_user[0]["user_flg"] == 1){//両方押下してたら
                        session()->put('search_flg',"「{$search_user[0]['name']}さん」本日は「出勤」から「退勤」まで押下済です！");
                        return redirect('/');
                    }
                }

                //問題なければ出勤登録
                $db::where('user_id',$id)->update(['user_flg'=>1,'attendance_time'=>$now]);//update
                $dbtime::insert(['name' => $search_user[0]['name'],'user_id' => $id,'attendance_time'=>$now,'leaving_time'=>NULL]); //日ごとのテーブルにもinsert
                session()->put('attendance_success',"「{$search_user[0]['name']}さん」の出勤ボタンが押下されました！");
                DB::commit();
            }catch(Exeption $e){
                DB::rollBack();
                echo $e->getMessage();
            }
           
        }else if($request->has('leave')){ //退勤押下時
            $request->validate([
                'id' => 'required|integer',
             ],
             [
                'id.required' => '■idを入力してください！',
                'id.integer' => '■半角英数字を入力してください！',
             ]);
             try{
                DB::beginTransaction();
                $db = new management;
                $dbtime = new timeManagement;
                $id = (int)$request->input('id');
                $now = NOW();
                $search_user = management::where('user_id',$id)->get();

                if(count($search_user) == 0){
                    session()->put('search_id',"存在しないユーザーです！");//未ユーザーなら
                    return redirect('/');
                }else if($search_user[0]["attendance_time"] == NULL){//先に退勤を押下時
                    session()->put('search_flg',"「{$search_user[0]['name']}さん」は出勤がまだ押下されていません！");
                    return redirect('/');
                }else if(count($search_user) == 1 && $search_user[0]["user_flg"] == 0){ //すでに退勤してきたら
                    session()->put('search_flg',"「{$search_user[0]['name']}さん」はすでに退勤を押下しています！");
                    return redirect('/');
                }else if(!($search_user[0]["attendance_time"] == NULL) && !($search_user[0]["leaving_time"] == NULL)){//両方押下時
                    session()->put('search_flg',"「{$search_user[0]['name']}さん」本日は「出勤」から「退勤」まで押下済です！");
                    return redirect('/');
                }

                //ここで出勤退勤の差分の時間を登録
                $attendance = strtotime($search_user[0]["attendance_time"]);
                $leaving = strtotime($now);
                $time = $leaving - $attendance; //時間差が秒単位での計算
                $hours = floor($time / 3600);
                $minutes = floor(($time / 60) % 60);
                $difference = $hours . "時間" . $minutes . "分";
                $dbtime::where('user_id',$id)->update(['name' => $search_user[0]['name'],'leaving_time'=>$now,'difference' => $difference]); //時間に変換した物を登録+退勤登録
                $db::where('user_id',$id)->update(['user_flg'=>1,'leaving_time'=>$now,'difference'=>$difference]);//update

                session()->put('leaving_success',"「{$search_user[0]['name']}さん」の退勤ボタンが押下されました！");
                DB::commit();
            }catch(Exeption $e){
                DB::rollBack();
                echo $e->getMessage();
            }

        }

        return redirect('/');
    }

}
