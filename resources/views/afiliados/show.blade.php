@extends('layouts.app')
@section('title','Consulta Afiliado')
@section('content')

    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>ID.</th> <th>Cedula</th><th>Nombre</th><th>Apellido</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $afiliado->id }}</td> <td> {{ $afiliado->cedula }} </td><td> {{ $afiliado->nombre }} </td><td> {{ $afiliado->apellido }} </td>
                </tr>
            </tbody>    
        </table>
    </div>

@endsection