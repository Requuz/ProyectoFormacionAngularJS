import './bootstrap';

angular.module('starshipsApp', [])
    .controller('StarshipsController', ['$scope', '$http', function($scope, $http) {
        $http.get('http://127.0.0.1:8000/api/starships')
            .then(function(response) {
                $scope.starships = response.data;
            });
    }]);