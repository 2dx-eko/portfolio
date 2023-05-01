<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <link href="{{asset('style.css')}}" rel="stylesheet">
    <title>勤務管理システム|ユーザー管理</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
</head>
<body>
    <header>
        <section class="head_parent">
            <div class="center">
                <h1>
                    <span>T</span>ime and <span>A</span>ttendance 
                    <span>S</span>ystem
                </h1>
                <ul>
                    <li><a href="/time_management/">TOP</a></li>
                    <li><a href="/time_management/register/">ユーザー登録</a></li>
                    <li><a href="/time_management/management/">ユーザー管理</a></li>
                    <li><a href="/time_management/past/">勤務表</a></li>
                </ul>
            </div>
        </section>
    </header>
    <main>

      <div class="common_parent">
            <div class="center">
                <h2>ユーザー管理</h2>
                <p class="day">
                    
                </p>
                <table class="management">
                
                    <tr>
                        <th>ユーザー名</th>
                        <th>ユーザーID</th>
                        <th>勤務開始時間</th>
                        <th>勤務終了時間</th>
                        <th>実労働時間</th>
                    </tr>
                    @foreach($alls as $all)
                    <tr>
                        <td>{{$all['name']}}</td>
                        <td>{{$all['user_id']}}</td>
                        <td>{{$all['attendance_time']}}</td>
                        <td>{{$all['leaving_time']}}</td>
                        <td>{{$all['difference']}}</td>
                    </tr>
                    @endforeach
                </table>

                <br>
                @if ($errors->any())
                <div class="error">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{$error}}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <div class="error">
                {{ Session::get('overlap_name') }}
                {{ Session::forget('overlap_name') }}
                </div>
            </div>
      </div>

    </main>
</body>
<script src="{{asset('common.js')}}"></script>
</html>

<script>
    var hiduke=new Date(); 
    //年・月・日・曜日を取得する
    var year = hiduke.getFullYear();
    var month = hiduke.getMonth()+1;
    var week = hiduke.getDay();
    var day = hiduke.getDate();

    var yobi= new Array("日","月","火","水","木","金","土");

    document.querySelector(".day").innerHTML = "本日"+year+"年"+month+"月"+day+"日の勤務状況";
</script>