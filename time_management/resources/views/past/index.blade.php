<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <link href="{{asset('style.css')}}" rel="stylesheet">
    <title>勤務管理システム|勤務表</title>
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
                <h2>勤務表({{$now_year}}年{{$now_month}}月)</h2>
                <div class="dayancer">
                    <ul>
                    @for($i = 1; $i <= count($calendars); $i++)
                        <li><a href="#day{{$i}}">{{$i}}日</a></li>
                    @endfor
                    </ul>
                </div>

                <div class="prev_next">
                    <ul>
                        @if(!($prev_month == 0))
                        <li><a href="/time_management/past/?month={{$prev_month}}">前月へ</a></li>
                        @endif
                        <li><a href="/time_management/past/">今月へ</a></li>
                        @if(!($next_month == 13))
                        <li><a href="/time_management/past/?month={{$next_month}}">翌月へ</a></li>
                        @endif
                    </ul>
                </div>

                <div class="error user_update">
                    <ul>
                        <li>
                        {{ Session::get('search_id') }}
                        {{ Session::forget('search_id') }}
                        </li>
                        <li>
                        {{ Session::get('search_day') }}
                        {{ Session::forget('search_day') }}
                        </li>
                        <li>
                        {{ Session::get('update_time') }}
                        {{ Session::forget('update_time') }}
                        </li>
                    </ul>
                </div>
                <br>
                @if ($errors->any())
                <div class="error user_update">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{$error}}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <h3 class="update_h3">■勤務表更新</h3>
                <form method="post">
                @csrf
                <table class="management update">
                    <tr>
                        <th>ユーザーID</th>
                        <th>変更内容</th>
                        <th>変更日</th>
                        <th>変更時間</th>
                    </tr>
                    <tr>
                        <td>
                            <div class="user_box margin0">
                                <input type="text" name="user_id" placeholder="ユーザーID" value="{{old('user_id')}}">
                            </div>
                        </td>
                        <td>
                            <div class="user_box margin0">
                                <select name="user_time">
                                    <option value="出勤">出勤時間</option>
                                    <option value="退勤">退勤時間</option>
                                </select>
                            </div>
                        </td>
                        <td>
                            <div class="user_box margin0">
                                <select name="user_day">
                                @for($i = 1; $i <= count($calendars); $i++)
                                    @if($i <= 9)
                                    <option value="0{{$i}}">{{$now_month}}月{{$i}}日</option>
                                    @else
                                    <option value="{{$i}}">{{$now_month}}月{{$i}}日</option>
                                    @endif
                                @endfor

                                </select>
                            </div>
                        </td>
                        <td>
                            <div class="user_box margin0">
                                <input type="text" name="change_time" placeholder="2022-12-24 00:00:00" value="{{old('change_time')}}">
                            </div>
                        </td>
                    </tr>
                </table>
                <div class="user_submit">
                    <input class="user_create" type="submit" name="time_update" value="更新">
                </div>
                </form>
                

                @for($i = 1; $i <= count($calendars); $i++)
                    <div class="day" id="day{{$i}}">
                        <p>{{ $calendars[$i]['day'] }}日：{{ $calendars[$i]['yobi'] }}</p>
                    </div>
                    <table class="management">
                    <tr>
                        <th>ユーザー名</th>
                        <th>ユーザーID</th>
                        <th>勤務開始時間</th>
                        <th>勤務終了時間</th>
                        <th>実労働時間</th>
                    </tr>
                    @for($j = 0; $j < count($month_dates); $j++)
                        @if($month_dates[$j]["day_key"] == $i)
                            <tr>
                                <td>{{$month_dates[$j]["name"]}}</td>
                                <td>{{$month_dates[$j]["user_id"]}}</td>
                                <td>{{$month_dates[$j]["attendance_time"]}}</td>
                                <td>{{$month_dates[$j]["leaving_time"]}}</td>
                                <td>{{$month_dates[$j]["difference"]}}</td>
                            </tr>
                        @endif
                    @endfor
                    </table>
                @endfor
            </div>
      </div>

    </main>
</body>
</html>
<script>
$(function(){
  $('a[href^="#"]').click(function(){
    var speed = 1500;
    var href= $(this).attr("href");
    var target = $(href == "#" || href == "" ? 'html' : href);
    var position = target.offset().top;
    $("html, body").animate({scrollTop:position}, speed, "swing");
    return false;
  });
});

</script>
