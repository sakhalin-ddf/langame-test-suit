<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    @vite('node_modules/bootstrap/dist/css/bootstrap.min.css')
    @vite('resources/css/app.css')
    @yield('styles')
</head>
<body>
<div class="pt-5 pb-5">
    <div class="container">
        <h1>Langame test suite</h1>

        <ul class="nav nav-pills mb-5">
            <li class="nav-item">
                <a
                    @class(['nav-link', 'active' => Route::getCurrentRoute()->uri === '/'])
                    @if(Route::getCurrentRoute()->uri === '/') aria-current="page" @endif
                    href="/"
                >
                    Поиск статей
                </a>
            </li>
            <li class="nav-item">
                <a
                    @class(['nav-link', 'active' => Route::getCurrentRoute()->uri === 'article-create'])
                    @if(Route::getCurrentRoute()->uri === 'article-create') aria-current="page" @endif
                    href="/article-create"
                >
                    Новая статья
                </a>
            </li>
        </ul>
        <div>
            @yield('content')
        </div>
    </div>
</div>
@vite('resources/js/app.js')
@yield('scripts')
</body>
</html>
