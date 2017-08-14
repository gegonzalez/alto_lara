@extends('layouts.app')
@section('title','Consulta AfiliadosTemporales')
@section('content')
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>ID.</th> <th>{{ trans('cedula') }}</th><th>{{ trans('nombre') }}</th><th>{{ trans('apellido') }}</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $afiliadosTemporale->id }}</td> <td> {{ $afiliadosTemporale->cedula }} </td><td> {{ $afiliadosTemporale->nombre }} </td><td> {{ $afiliadosTemporale->apellido }} </td>
                </tr>
            </tbody>    
        </table>
    </div>
@endsection