angular.module('starWarsApp', ['ngRoute']);

angular.module('starWarsApp')
    .config(function($routeProvider) {
        $routeProvider
            .when('/pilots', {
                templateUrl: 'pilots.html',
                controller: 'PilotsController'
            })
            .when('/starships', {
                templateUrl: 'starships.html',
                controller: 'StarshipController'
            })
            .when('/starships', {
                templateUrl: 'starships.html',
                controller: 'StarshipController'
            })
            .otherwise({
                redirectTo: '/'
            });
    });