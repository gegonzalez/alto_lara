@extends('layouts.app')
@section('title','%%crudNameSingular%%')
@section('content')
    <div class="pull-right">
        <a href="{{ url('afiliadosTemporales/create') }}" class="btn btn-primary pull-right btn-sm">Agregar Nuevo AfiliadosTemporale</a>
    </div>
    <div class="table">
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>No</th><th>{{ trans('afiliadosTemporales.cedula') }}</th><th>{{ trans('afiliadosTemporales.nombre') }}</th><th>{{ trans('afiliadosTemporales.apellido') }}</th><th>Actions</th>
                </tr>
            </thead>
            <tbody>
            {{-- */$x=0;/* --}}
            @foreach($afiliadosTemporales as $item)
                {{-- */$x++;/* --}}
                <tr>
                    <td>{{ $x }}</td>
                    <td><a href="{{ url('afiliadosTemporales', $item->id) }}">{{ $item->cedula }}</a></td><td>{{ $item->nombre }}</td><td>{{ $item->apellido }}</td>
                    <td>
                        <a href="{{ url('afiliadosTemporales/' . $item->id . '/edit') }}">
                            <button type="submit" class="btn btn-primary btn-xs">Actualizar</button>
                        </a> /
                        {!! Form::open([
                            'method'=>'DELETE',
                            'url' => ['afiliadosTemporales', $item->id],
                            'style' => 'display:inline'
                        ]) !!}
                            {!! Form::submit('Eliminar', ['class' => 'btn btn-danger btn-xs']) !!}
                        {!! Form::close() !!}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="pagination"> {!! $afiliadosTemporales->render() !!} </div>
    </div>

@endsection
