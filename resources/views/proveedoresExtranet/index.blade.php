@extends('layouts.app')
@section('title','Proveedores Extranet')
@section('content')
    <div class="pull-right">
        <a href="{{ url('proveedores/create') }}" class="btn btn-primary pull-right btn-sm">Agregar Nuevo Proveedor</a>
    </div>
    <div class="table">
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>{{ trans('messages.codigo') }}</th><th> {{ trans('messages.cedula') }} </th><th> {{ trans('messages.name') }} </th><th>{{ trans('messages.actions') }}</th>
                </tr>
            </thead>
            <tbody>
            {{-- */$x=0;/* --}}
            @foreach($proveedoresextranet as $item)
                {{-- */$x++;/* --}}
                <tr>
                    <td><a href="{{ url('proveedores', $item->id) }}">{{ $item->codigo_proveedor }}</a></td>
                    <td>{{ $item->cedula }}</td><td>{{ $item->nombre }}</td>
                    <td>
                        <a href="{{ url('proveedores/' . $item->id . '/edit') }}">
                            <button type="submit" class="btn btn-primary btn-xs">Actualizar</button>
                        </a> /
                        {!! Form::open([
                            'method'=>'DELETE',
                            'url' => ['proveedores', $item->id],
                            'style' => 'display:inline'
                        ]) !!}
                            {!! Form::submit('Eliminar', ['class' => 'btn btn-danger btn-xs']) !!}
                        {!! Form::close() !!}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="pagination"> {!! $proveedoresextranet->render() !!} </div>
    </div>
@endsection