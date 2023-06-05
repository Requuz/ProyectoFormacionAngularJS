<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" ng-app="starWarsApp">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Mi Proyecto Laravel')</title>
    <link href="https://fonts.googleapis.com/css2?family=Star+Jedi&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
</head>
<body>

    <div class="starwars-demo">
    <img src="//cssanimation.rocks/demo/starwars/images/star.svg" alt="Star" class="star">
    <img src="//cssanimation.rocks/demo/starwars/images/wars.svg" alt="Wars" class="wars">
  </div>

    <div class="container">
        <a href="/starshipPilot" class="btn btn-2">Naves y pilotos</a><br>
        <a href="/starships" class="btn btn-2">Todas las naves</a><br>
        <a href="/pilots" class="btn btn-2">Toda la gente</a>
        @yield('content')
    </div>


    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.8.2/angular.min.js"></script>
</body>
</html>
