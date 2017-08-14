@extends('layouts.app')
@section('title','Consulta Usuario')
@section('content')

    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>Usuario</th><th>Nombre</th><th>Email</th><th>Perfil</th><th>Estatus</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $usuario->user }}</td><td>{{ $usuario->name }}</td><td>{{ $usuario->email }}</td><td>{{ $usuario->userType->name }}</td>
                    @if($usuario->active == 'S')
                        <td>Activo</td>
                    @else
                        <td>Inactivo</td>
                    @endif
                </tr>
            </tbody>    
        </table>
    </div>

@endsection