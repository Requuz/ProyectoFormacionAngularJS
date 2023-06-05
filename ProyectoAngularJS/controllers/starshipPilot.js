angular.module('starshipPilotsApp', []).controller('StarshipPilotController', function($scope, $http) {

    $scope.fetchData = function() {
        $http.get('http://127.0.0.1:8000/api/pilots').then(function(response) {
            $scope.pilots = response.data.sort(function(a, b) {
                return a.name.localeCompare(b.name);
            });
            if ($scope.pilots.length > 0) {
                $scope.selectedPilotToDelete = $scope.pilots[0].id;
                $scope.selectedPilot = $scope.pilots[0];
            }
        });

        $http.get('http://127.0.0.1:8000/api/starships').then(function(response) {
            $scope.starships = response.data.sort(function(a, b) {
                return a.name.localeCompare(b.name);
            });
            if ($scope.starships.length > 0) {
                $scope.selectedStarship = $scope.starships[0];
            }
        });

        $http.get('http://127.0.0.1:8000/api/starshipPilot').then(function(response) {

            $scope.starship_pilot = response.data;

        });
    };

    function init() {
        $scope.pilotId = null;
        $scope.starshipId = null;
        $scope.fetchData();
    }

    init();

    //Obtener nombres de las naves
    $scope.getStarshipName = function(starship_id) {
        for (var i = 0; i < $scope.starships.length; i++) {
            if ($scope.starships[i].id === starship_id) {
                return $scope.starships[i].name;
            }
        }
    };

    //Obtener precios de las naves
    $scope.getStarshipPrice = function(starship_id) {
        for (var i = 0; i < $scope.starships.length; i++) {
            if ($scope.starships[i].id === starship_id) {
                return $scope.starships[i].cost_in_credits;
            }
        }
    };

    //Pasar a base 15
    $scope.base10to15 = function(number) {
        const codes = "0123456789ßÞ¢μ¶";
        let result = "";
        do {
            result = codes[number % 15] + result;
            number = Math.floor(number / 15);
        } while (number > 0);
        return result;
    };

    //Obtener nombres de los pilotos
    $scope.getPilotName = function(pilot_id) {
        for (var i = 0; i < $scope.pilots.length; i++) {
            if ($scope.pilots[i].id === pilot_id) {
                return $scope.pilots[i].name;
            }
        }
    };
    //Agrupar pilotos por nave separados por ,
    $scope.groupPilotsByStarship = function() {

        if (!$scope.starship_pilot) {
            return;
        }

        let grouped = {};

        for (let i = 0; i < $scope.starship_pilot.length; i++) {
            let entry = $scope.starship_pilot[i];
            let starshipId = entry.starship_id;

            if (!grouped[starshipId]) {
                grouped[starshipId] = {
                    starship_id: starshipId,
                    pilots: []
                };
            }
            grouped[starshipId].pilots.push(entry.pilot_id);
        }

        return Object.values(grouped);
    };

    $scope.getPilotsList = function(pilotIds) {
        let pilotNames = pilotIds.map(function(pilotId) {
            return $scope.getPilotName(pilotId);
        });
        return pilotNames.join(', ');
    };

    $scope.linkPilot = function(pilotId, starshipId) {
        $http({
                method: 'POST',
                url: 'http://127.0.0.1:8000/api/linkPilot/' + pilotId + '/' + starshipId,
                headers: {
                    'Content-Type': 'application/json'
                }
            }).then(function(response) {
                if (response.data.success) {
                    $scope.successMessage = response.data.success;
                    $scope.errorMessage = null;
                    $scope.fetchData();
                } else {
                    $scope.errorMessage = 'Error: ' + response.data.message;
                    $scope.successMessage = null;
                }
            })
            .catch(function(error) {
                if (error.data && error.data.message) {
                    $scope.errorMessage = 'Error: ' + error.data.message;
                } else {
                    $scope.errorMessage = 'Error: No se pudo completar la operación';
                }
                $scope.successMessage = null;
            });
    };


    $scope.unlinkPilot = function(pilotId, starshipId) {
        $http({
                method: 'POST',
                url: 'http://127.0.0.1:8000/api/unlinkPilot/' + pilotId + '/' + starshipId,
                headers: {
                    'Content-Type': 'application/json'
                }
            }).then(function(response) {
                if (response.data.success) {
                    $scope.successMessage = response.data.success;
                    $scope.errorMessage = null;
                    $scope.fetchData();
                } else {
                    $scope.errorMessage = 'Error: ' + response.data.message;
                    $scope.successMessage = null;
                }
            })
            .catch(function(error) {
                if (error.data && error.data.message) {
                    $scope.errorMessage = 'Error: ' + error.data.message;
                } else {
                    $scope.errorMessage = 'Error: No se pudo completar la operación';
                }
                $scope.successMessage = null;
            });
    };

    $scope.deletePilot = function(pilotId) {

        console.log('ID del piloto a eliminar:', pilotId);
        console.log('URL completa:', 'http://127.0.0.1:8000/api/destroyById/' + pilotId);

        $http({
                method: 'POST',
                url: 'http://127.0.0.1:8000/api/destroyById/' + pilotId,
                headers: {
                    'Content-Type': 'application/json'
                }
            }).then(function(response) {
                if (response.data.success) {
                    $scope.pilots = response.data.pilots;
                    $scope.starship_pilot = response.data.starship_pilot;
                    $scope.errorMessage = null;
                    $scope.selectedPilotToDelete = null;
                    $scope.successMessage = response.data.success;

                } else {
                    $scope.errorMessage = 'Error: ' + response.data.message;
                    $scope.successMessage = null;
                }
            })
            .catch(function(error) {
                if (error.data && error.data.message) {
                    $scope.errorMessage = 'Error: ' + error.data.message;
                } else {
                    $scope.errorMessage = 'Error: No se pudo completar la operación';
                }
                $scope.successMessage = null;
            });

        $scope.fetchData();
        console.log('$scope.pilots:', $scope.pilots);
        console.log('$scope.starship_pilot:', $scope.starship_pilot);
    };

});