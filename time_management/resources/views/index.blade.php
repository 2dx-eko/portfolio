<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <link href="{{asset('style.css')}}" rel="stylesheet">
    <title>勤務管理システム</title>
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
        <div class="clock_panret">
            <div class="clock">
            <p class="clock-date"></p>
            <p class="clock-time"></p>
        </div>
      </div>
      <div class="top_form">
            <form method="post">
                @csrf
                <div class="user_box">
                    <label>ID:</label>
                    <input type="text" name="id" placeholder="123">
                </div>
                <div class="top_submit">
                    <input class="syukkin" type="submit" name="attendance" value="出勤"></input>
                    <input class="taikin" type="submit" name="leave" value="退勤"></input>
                </div>
            </form>
        </div>
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
            {{ Session::get('search_id') }}
            {{ Session::forget('search_id') }}
            {{ Session::get('search_flg') }}
            {{ Session::forget('search_flg') }}
        </div>
        <div class="session_text">
        {{ Session::get('user_register') }}
        {{ Session::forget('user_register') }}
        {{ Session::get('attendance_success') }}
        {{ Session::forget('attendance_success') }}
        {{ Session::get('leaving_success') }}
        {{ Session::forget('leaving_success') }}
        </div>
    </main>
</body>
<script src="{{asset('common.js')}}"></script>
</html>

