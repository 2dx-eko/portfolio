<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\management;
use App\Models\timeManagement;
use Carbon\Carbon;

class pastcontroller extends Controller
{
    public function index(){
        try{
            DB::beginTransaction();
            $db = new management;
            $dbtime = new timeManagement;
            $alls = $dbtime::all();
            if(isset($_GET['month'])){ //今月以外の時
                $m = $prev_next_month = $_GET['month'];//パラメータ取得、パラメータの値が今月という考え方
            }else{//今月のだったら
                $m = date('n');
            }
            $now_year = date('Y');
            $now_month = $m;
            $prev_month = $m - 1;
            $next_month = $m + 1;

            $calendars = $this->getCalendar($m);//今月を取得
            //$month_datesが入ってないとエラーになるので注意
            $month_dates = $dbtime::whereYear('attendance_time', $now_year)->whereMonth('attendance_time', $m)->orderBy('attendance_time')->get();
            $day_array = [];
            for($i = 0; $i < count($month_dates);$i++){
                $get_day = (int)date('d', strtotime($month_dates[$i]["attendance_time"]));
                //↑一桁の日付は先頭に0が付くため(int)にして０を削除している       
                $month_dates[$i]["day_key"] = $get_day; //day_keyという場所（新規）に日付の数字を追加
            }
            DB::commit();
        }catch(Exeption $e){
            DB::rollBack();
            echo $e->getMessage();
        }
        return view('/past.index',compact("calendars","month_dates","now_month","prev_month","next_month","now_year"));
    }

    public function pastRegister(Request $request){
        $request->validate([ //バリデーション(変更時間だけ別でバリデーション)
            'user_id' => 'required|integer',
        ],[
            'user_id.required' => '■ユーザーIDを入力してください！',
            'user_id.integer' => '■ユーザーIDは半角英数字で入力してください！',
        ]);
       
        $db = new management;
        $dbtime = new timeManagement;
        
        $get_id = $request->input('user_id');
        $get_time = $request->input('user_time');
        $get_day = $request->input('user_day');
        $get_changetime = $request->input('change_time');

        $search_user = $dbtime::where('user_id',$get_id)->get();

        if(count($search_user) == 0){
            session()->put('search_id',"入力したユーザーIDは存在しません！");//未ユーザーなら
            return redirect('/past/');
        }
        
        if(empty($get_changetime)){
            session()->put('update_time',"変更時間が入力されていません！");//未ユーザーなら
            return redirect('/past/');
        }else if(!($get_changetime === date('Y-m-d H:i:s',strtotime($get_changetime)))){//形式が正しいかどうか
            session()->put('update_time',"変更時間の入力が正しくありません！（例：2022-12-24 00:00:00）");
            return redirect('/past/');
        }

        if($get_time == ('出勤')){
            for($i = 0; $i < count($search_user); $i++){
                if(substr($search_user[$i]['attendance_time'], 8, 2) == $get_day){//日付の日だけを$get_dayと比較
                    $search_day = $dbtime::where(['user_id'=>$get_id,'attendance_time'=>$search_user[$i]['attendance_time']])->get();
                }
            }
            if(!isset($search_day)){ //$search_dayが存在しなければバリデーション
                session()->put('search_day',"入力したユーザーIDの選択した変更内容で変更日は登録されていません！");
                return redirect('/past/');
            }
        }else if($get_time == '退勤'){
            for($i = 0; $i < count($search_user); $i++){
                if(substr($search_user[$i]['leaving_time'], 8, 2) == $get_day){//日付の日だけを$get_dayと比較
                    $search_day = $dbtime::where(['user_id'=>$get_id,'leaving_time'=>$search_user[$i]['leaving_time']])->get();
                }
            }
            if(!isset($search_day)){ //$search_dayが存在しなければバリデーション
                session()->put('search_day',"入力したユーザーIDで選択した変更日は登録されていません！");
                return redirect('/past/');
            }
        }

        //バリデーション後に出退勤の時間を更新するので実勤務時間も更新
        $get_changetime_status = strtotime($get_changetime);
        if($get_time == '出勤'){
            $attendance_status = strtotime($search_day[0]["leaving_time"]);
            $time = $attendance_status - $get_changetime_status; //時間差が秒単位での計算
        }else if($get_time == '退勤'){
            $attendance_status = strtotime($search_day[0]["attendance_time"]);
            $time = $get_changetime_status - $attendance_status; //時間差が秒単位での計算
        }

        $hours = floor($time / 3600);
        $minutes = floor(($time / 60) % 60);
        $difference = $hours . "時間" . $minutes . "分";
        $today = date('d');
        //両DBを更新
        if($get_time == "出勤"){
            if($today == $get_day){
                $db::where('user_id',$get_id)->update(['attendance_time' => $get_changetime,'difference' => $difference]);
            }
            $dbtime::where('user_id', $get_id)->where('attendance_time',$search_day[0]["attendance_time"])->update(['attendance_time' => $get_changetime,'difference'=>$difference]);
        }else if($get_time == "退勤"){
            if($today == $get_day){
                $db::where('user_id',$get_id)->update(['leaving_time' => $get_changetime,'difference' => $difference]);
            }
            $dbtime::where('user_id',$get_id)->where('leaving_time', $search_day[0]["leaving_time"])->update(['leaving_time' => $get_changetime,'difference'=>$difference]);
        }
        session()->put('update_time',"更新が完了しました！");
        DB::commit();
        return redirect('/past/');
    }
    
    public function getCalendar($m){
        $year = date('Y');
        $month = $m;
        $yobi_array = ['日曜日','月曜日','火曜日','水曜日','木曜日','金曜日','土曜日'];
        $last_day = date('j', mktime(0, 0, 0, $month + 1, 0, $year));//今月の末日
        $calendar = [];

        for ($i = 1; $i < $last_day + 1; $i++) {
            $calendar[$i]['day'] = $i;
            $calendar[$i]['yobi'] = $yobi_array[date('w', mktime(0, 0, 0, $month, $i, $year))];            
        }
        return $calendar;
    }
    
    

}
