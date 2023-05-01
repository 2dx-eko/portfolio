<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>TODO LISTER</title>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css">
        <script src="{{asset('js/vue.js')}}"></script>
        
    </head>
    <canvas id="canvas"></canvas>
    <header class="todo" id="todoheader">
        <form method="post">
            @csrf
            <todoheader-Component></todoheader-Component>
        </form>
    </header>
    <body class="todo">
        <div class="create_back"></div>
        <div class="catcreate_box"></div>

        @if(Session::get('ac_session'))
            <div class="session_text">
                {{ Session::get('ac_session') }}
                {{ Session::forget('ac_session') }}
            </div>
        @endif

        @if(isset($getlists))
        <div class="todo_box">
          <div class="flex">
            @foreach ($getlists as $getlist)

                <div class="col">
                    <p class="title">{{$getlist['list-title']}}</p>
                    <form method="post">
                    @csrf
                        <button class="list-del" type="submit" name="list-del" value="{{$getlist['id']}}">リスト削除</button>
                    </form>
                    <form method="post">
                    @csrf
                        <div class="todo_input">
                            <input class="todo_create" type="text" name="todo_create" required>
                            <button class="todo_create_submit" type="submit" name="todo_create_submit" value="{{$getlist['id']}}">TODO<br>作成</button>
                        </div>
                    </form>
                    
                    @if(isset($gettodos))
                        <div class="todo_col_parent">
                        @foreach ($gettodos as $gettodo)
                            @if($getlist['id'] == $gettodo['listparent-id'])
                                @if($gettodo['bold-flg'])
                                <div class="content bold">
                                @else
                                <div class="content">
                                @endif
                                    <p class="date">作成日:{{$gettodo['created_at']}}</p>
                                    <p>{{$gettodo['content']}}</p>
                                    <form method="post">
                                        @csrf
                                        <input type="hidden" value="{{$gettodo['id']}}" name="todoid">
                                        <button class="del" type="submit" name="todo-bold" value="{{$gettodo['listparent-id']}}">B</button>
                                        <button class="del" type="submit" name="todo-del" value="{{$gettodo['listparent-id']}}">×</button>
                                        
                                    </form>
                                </div>
                            @endif
                        @endforeach
                        </div>
                    @endif
                    
                </div>
            @endforeach
            </div>
        </div>
        @endif
        <!-- /todo_box -->
        
    </body>
</html>
<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/background.js') }}"></script>