angular.module('pilotsApp', [])
    .controller('PilotsController', function($scope, $http) {
        $http.get('http://127.0.0.1:8000/api/pilots')
            .then(function(response) {
                console.log(response.data);
                $scope.pilots = response.data;
            });

    });