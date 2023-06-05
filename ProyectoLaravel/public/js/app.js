var app = angular.module('starWarsApp', []);

app.controller('StarshipsController', ['$scope', '$http', function($scope, $http) {
    $scope.starships = [];

    $scope.getStarships = function() {
        $http.get('/api/starships')
            .then(function(response) {
                $scope.starships = response.data;
            }, function(error) {
                console.error('Error al cargar naves y pilotos:', error);
            });
    };

    $scope.getStarships();
}]);