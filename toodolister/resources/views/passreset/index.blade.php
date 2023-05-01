<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>TODO LISTER|パスワード再設定</title>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css">
        <script src="{{asset('js/vue.js')}}"></script>
    </head>
    <canvas id="canvas"></canvas>
    <body class="login">
        <section id="login">

            @if(isset($passchecks))
            <div class="error">
                <ul>
                    @foreach ($passchecks as $passcheck)
                        <li>{{ $passcheck }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            
            @if(Session::get('ac_session'))
                <div class="session_text">
                    {{ Session::get('ac_session') }}
                    {{ Session::forget('ac_session') }}
                </div>
            @endif

            <section>
                <h1>PASSWOED RESET</h1>
                <div class="pass_forget">
                    <form method="post">
                        @csrf
                        <div class="loginbox margin">
                            <p>■新しいパスワード</p>
                            <input type="text" name="passwordreset-mail" placeholder="new password">
                        </div>
                        <div class="center">
                            <input class="btn login" type="submit" name="reset_submit" value="パスワード再設定"></input>
                        </div>
                    </form>
                </div>
            </section>

        </section>



        
    </body>
</html>
<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/background.js') }}"></script>