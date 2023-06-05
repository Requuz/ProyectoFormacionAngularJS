<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" ng-app="starWarsApp">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Mi Proyecto Laravel')</title>
    <link href="https://fonts.googleapis.com/css2?family=Star+Jedi&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/starwars.css') }}">
</head>
<body>
    <div class="container">


        @yield('content')
    </div>
    <!-- AngularJS desde un CDN -->
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.8.2/angular.min.js"></script>
    <!-- Agrega el archivo app.js de AngularJS -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
