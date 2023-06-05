@extends('layouts.app')

@section('title', 'Pilotos')

@section('content')
    <div class="container">
        <h1>Pilotos</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Altura</th>
                    <th>Peso</th>
                    <th>Color de cabello</th>
                    <th>Color de piel</th>
                    <th>Color de ojos</th>
                    <th>Año de nacimiento</th>
                    <th>Género</th>
                    <th>Mundo natal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pilots as $pilot)
                    <tr>
                        <td>{{ $pilot->name }}</td>
                        <td>{{ $pilot->height }}</td>
                        <td>{{ $pilot->mass }}</td>
                        <td>{{ $pilot->hair_color }}</td>
                        <td>{{ $pilot->skin_color }}</td>
                        <td>{{ $pilot->eye_color }}</td>
                        <td>{{ $pilot->birth_year }}</td>
                        <td>{{ $pilot->gender }}</td>
                        <td>{{ $pilot->homeworld }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
