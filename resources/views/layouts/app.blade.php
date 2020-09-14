<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Админка: Авторизация</title>

    <!-- Scripts -->
    <script src="/js/app.js" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="/css/app.css" rel="stylesheet">
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/admin.css" rel="stylesheet">
</head>
<body>
<div id="app">
    <nav class="navbar navbar-default navbar-expand-md navbar-light navbar-laravel">
        <div class="container">
            <a class="navbar-brand" href="{{route('index')}}">
                Вернуться на сайт
            </a>

            <div id="navbar" class="collapse navbar-collapse">
                <ul class="nav navbar-nav">
                </ul>

                <ul class="nav navbar-nav navbar-right">
                    @guest()
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('login')}}">Войти</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('register')}}">Зарегистрироваться</a>
                        </li>
                    @endguest
                    @auth()
                        <li class="nav-item"><a href="/logout">Выйти</a></li>
                    @endauth
                </ul>

            </div>
        </div>
    </nav>

    <div class="py-4">
            @yield('content')
    </div>
</div>
</body>
</html>
