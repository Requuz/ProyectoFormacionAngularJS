angular.module('starshipsApp', [])
    .controller('StarshipController', function($scope, $http) {
        $http.get('http://127.0.0.1:8000/api/starships')
            .then(function(response) {
                console.log(response.data);
                $scope.starships = response.data;
            });

    });