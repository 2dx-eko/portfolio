<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <link href="{{asset('style.css')}}" rel="stylesheet">
    <title>勤務管理システム|ユーザー登録</title>
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
                <h2>ユーザー登録</h2>
                <form method="post">
                    @csrf
                    <div class="user_box">
                        <label>ユーザー名:</label>
                        <input type="text" name="user_name" placeholder="ユーザー名">
                    </div>
                    <div class="user_submit">
                        <input class="user_create" type="submit" name="user_create" value="登録"></input>
                    </div>
                </form>
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

