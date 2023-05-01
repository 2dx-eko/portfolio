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
    <div class="create_back"></div>
    <body class="login">
        <section id="login">
            <!--アカウント作成バリデーション-->
            @if(isset($acChecks))
            <div class="error">
                <ul>
                    @foreach ($acChecks as $acCheck)
                        <li>{{ $acCheck }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <!--ログインバリデーション-->
            @if(isset($loginChecks))
            <div class="error">
                <ul>
                    @foreach ($loginChecks as $loginCheck)
                        <li>{{ $loginCheck }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            @if(isset($mailchecks))
            <div class="error">
                <ul>
                    @foreach ($mailchecks as $mailcheck)
                        <li>{{ $mailcheck }}</li>
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
            <form method="post">
                @csrf
                <login-Component></login-Component>
            </form>
        </section>



        
    </body>
</html>
<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/background.js') }}"></script>