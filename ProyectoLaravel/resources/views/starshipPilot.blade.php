<!DOCTYPE html>
<html lang="en" ng-app="starshipPilotsApp">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Naves y pilotos</title>
    <script src="{{ asset('js/angular.min.js') }}"></script>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="stylesheet" href="{{ asset('css/starshipPilot.css') }}">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" />
</head>
<body ng-controller="StarshipPilotController">
    <h1>Naves y pilotos</h1>
    <div class="content-wrapper">
    <div class="actions">
    <div class="row">
        <div class="col-md-12">
            <form ng-submit="deletePilot()">
                <div class="form-group">
                    <h2>Eliminar piloto</h2>
                    <label for="name">Nombre del piloto a eliminar:</label>
                    <input type="text" class="form-control" id="name" placeholder="Ej: Obi-Wan Kenobi" ng-model="pilotToDelete" required>
                </div>
                <button type="submit" class="btn btn-danger">Eliminar</button>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <br>
            <br>
            <h2>Vincular/Desvincular</h2>
            <form ng-submit="linkPilot()">
                <div class="form-group">
                    <label for="pilot_id">Selecciona un piloto:</label>
                    <select class="form-control" id="pilot_id" ng-model="selectedPilot" ng-options="pilot as pilot.name for pilot in pilots" required>
                    </select>
                </div>
                <div class="form-group">
                    <label for="starship_id">Selecciona una nave:</label>
                    <select class="form-control" id="starship_id" ng-model="selectedStarship" ng-options="starship as starship.name for starship in starships" required>
                    </select>
                </div>
                <div class="button-container">
                <button type="submit" class="btn btn-primary">Vincular piloto a nave</button>
            </form>

            <form ng-submit="unlinkPilot()">
                <button type="submit" class="btn btn-warning">Desvincular piloto y nave</button>
            </form>
            </div>
        </div>
    </div>
</div>
    <div class="table-container container">
        <br>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Nave</th>
                    <th>Precio</th>
                    <th>Pilotos</th>
                </tr>
            </thead>
            <tbody>
                <<tr ng-repeat="entry in starship_pilot">
                    <td>{{ entry.starship.name }}</td>
                    <td class="starship-price" ng-attr-data-cost-in-credits="{{ entry.starship.cost_in_credits }}">{{ base10to15(entry.starship.cost_in_credits) }}</td>
                    <td>{{ entry.pilot.name }}</td>
                </tr>
                </tbody>
            </table>
</div>
</div>


    <script>
    angular.module('starshipPilotsApp', [])
        .controller('StarshipPilotController', ['$scope', '$http', function($scope, $http) {
            // Poblar datos de pilotos y naves
            // Reemplazar la URL con la ruta real de la API en tu aplicación
            $http.get('/api/pilots').then(function(response) {
                $scope.pilots = response.data;
            });

            $http.get('/api/starships').then(function(response) {
                $scope.starships = response.data;
            });

            $http.get('/api/starship_pilot').then(function(response) {
                $scope.starship_pilot = response.data;
            });

            $scope.base10to15 = function(number) {
                const codes = "0123456789ßÞ¢μ¶";
                let result = "";
                do {
                    result = codes[number % 15] + result;
                    number = Math.floor(number / 15);
                } while (number > 0);
                return result;
            };

            $scope.deletePilot = function() {
                // Eliminar piloto
                // Reemplazar la URL con la ruta real de la API en tu aplicación
                $http.post('/api/pilots/deleteByName', { name: $scope.pilotToDelete }).then(function(response) {
                    // Actualizar datos después de eliminar
                    $scope.pilots = response.data;
                });
            };

            $scope.linkPilot = function() {
                // Vincular piloto y nave
                // Reemplazar la URL con la ruta real de la API en tu aplicación
                $http.post('/api/starships/linkPilot', { pilot_id: $scope.selectedPilot.id, starship_id: $scope.selectedStarship.id }).then(function(response) {
                    // Actualizar datos después de vincular
                    $scope.starship_pilot = response.data;
                });
            };

            $scope.unlinkPilot = function() {
                // Desvincular piloto y nave
                // Reemplazar la URL con la ruta real de la API en tu aplicación
                $http.post('/api/starships/unlinkPilot', { pilot_id: $scope.selectedPilot.id, starship_id: $scope.selectedStarship.id }).then(function(response) {
                    // Actualizar datos después de desvincular
                    $scope.starship_pilot = response.data;
                });
            };
        }]);
</script>

</body>
</html>

