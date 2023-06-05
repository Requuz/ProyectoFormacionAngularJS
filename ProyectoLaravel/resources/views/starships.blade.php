<!DOCTYPE html>
<html lang="en" ng-app="starshipsApp">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Naves</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="{{ asset('js/angular.min.js') }}"></script>
    <script src="{{ asset('ProyectoLaravel\resources\js\app.js') }}"></script>
</head>
<body>
    <div class="container" ng-controller="StarshipsController">
        <h1>Naves</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Modelo</th>
                    <th>Fabricante</th>
                    <th>Costo en créditos</th>
                    <th>Longitud</th>
                    <th>Velocidad atmosférica máxima</th>
                    <th>Equipo requerido</th>
                    <th>Pasajeros</th>
                    <th>Capacidad de carga</th>
                    <th>Consumibles</th>
                    <th>Clasificación del navío</th>
                    <th>Velocidad en el hiperespacio</th>
                    <th>MGLT</th>
                    <th>Pilotos</th>
                </tr>
            </thead>
            <tbody>
                <tr ng-repeat="starship in starships">
                    <td>{{ starship.name }}</td>
                    <td>{{ starship.model }}</td>
                    <td>{{ starship.manufacturer }}</td>
                    <td>{{ starship.cost_in_credits }}</td>
                    <td>{{ starship.length }}</td>
                    <td>{{ starship.max_atmosphering_speed }}</td>
                    <td>{{ starship.crew }}</td>
                    <td>{{ starship.passengers }}</td>
                    <td>{{ starship.cargo_capacity }}</td>
                    <td>{{ starship.consumables }}</td>
                    <td>{{ starship.starship_class }}</td>
                    <td>{{ starship.hyperdrive_rating }}</td>
                    <td>{{ starship.MGLT }}</td>
                    <td>
                        <span ng-repeat="pilot in starship.pilots">
                            {{ pilot.name }}<span ng-if="!$last">, </span>
                        </span>
                        <span ng-if="!starship.pilots.length">Desconocido</span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>

