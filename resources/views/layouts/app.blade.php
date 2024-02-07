<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    @vite('node_modules/bootstrap/dist/css/bootstrap.min.css')
    @vite('resources/css/app.css')
</head>
<body>
<div class="pt-5 pb-5">
    <div class="container">
        <h1>Langame test suite</h1>
        @yield('content')
    </div>
</div>
@vite('resources/js/app.js')
</body>
</html>
