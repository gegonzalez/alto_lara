@extends('layouts.app')
@section('title','Consulta Proveedores Extranet')
@section('content')
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>{{ trans('messages.codigo') }}</th><th> {{ trans('messages.cedula') }} </th><th> {{ trans('messages.name') }} </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $proveedoresextranet->codigo_proveedor }}</td><td>{{ $proveedoresextranet->cedula }}</td><td>{{ $proveedoresextranet->nombre }}</td>
                </tr>
            </tbody>    
        </table>
    </div>
@endsection