@extends('layouts.app')
@section('title','Tratamientos Realizados')
@section('content')
    <hr/>
    <h4>Datos del Beneficiario</h4>
    @if (isset($beneficiario))
        <div class="table">
            <table class="table table-bordered table-striped table-hover table-responsive">
                <thead>
                    <tr>
                        <th>Cédula</th><th>Nombre</th><th>Tipo</th><th>Cobertura del Plan</th><th>Colectivo</th><th>Aseguradora</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $beneficiario['cedula_afiliado'] }}</td>
                        <td>{{ $beneficiario['nombre_afiliado'] }}</td>
                        <td>{{ $beneficiario['tipo_afiliado'] }}</td>
                        <td>{{ $beneficiario['plan'] }}</td>
                        <td>{{ $beneficiario['colectivo'] }}</td>
                        <td>{{ $beneficiario['aseguradora'] }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    @endif
    @if (isset($claves) and (count($claves) > 0))
        <h4>Clave Activa</h4>
        {!! Form::open(['url' => 'tratamiento/cargar', 'class' => 'form-horizontal', 'name' => 'beneficiario']) !!}
        <div class="table">
            <table class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th>Clave</th><th>Tipo</th><th>Fecha Creación</th><th>Fecha Atención</th><th>Estatus</th><th></th>
                    </tr>
                </thead>
                <tbody>
                    {{-- */$x=0;/* --}}
                    @foreach ($claves as $clave)
                        {{-- */$x++;/* --}}
                        <tr>
                            <td>
                                {!! Form::hidden('clave'.$x, $clave->clave) !!}
                                {!! Form::hidden('cedula_afiliado', $beneficiario['cedula_afiliado'])!!}
                                {!! Form::hidden('nombre_afiliado', $beneficiario['nombre_afiliado'])!!}
                                {!! Form::hidden('tipo_afiliado'  , $beneficiario['tipo_afiliado'])!!}
                                {!! Form::hidden('plan'           , $beneficiario['plan'])!!}
                                {!! Form::hidden('colectivo'       , $beneficiario['colectivo'] )!!}
                                {!! Form::hidden('aseguradora'    , $beneficiario['aseguradora'])!!}
                                {{ $clave->clave }}
                                </td>
                            <td>{!! Form::hidden('tipo_control'.$x, $clave->acTipoControl->descripcion) !!}
                                {{ $clave->acTipoControl->descripcion }}</td>
                            <td>{!! Form::hidden('fecha_creacion'.$x, $clave->created_at) !!}
                                {{ $clave->created_at->format('d-m-Y') }}</td>
                            <td>{!! Form::hidden('fecha_atencion1'.$x, $clave->fecha_atencion1) !!}
                                {{ $clave->fecha_atencion1->format('d-m-Y') }}</td>
                            <td>{!! Form::hidden('estatus'.$x, $clave->acEstatus->nombre) !!}
                                {{ $clave->acEstatus->nombre }}</td>
                            <td>
                                {!! Form::radio('iclave', $clave->id, null, ['id' => 'iclave', 'name' => 'iclave']) !!}
                                {!! $errors->first('iclave', '<p class="help-block">:message</p>') !!}
                                <a href="{{ url('tratamiento/consultar' , [$clave->id , $beneficiario['cedula_afiliado']])}}">
                                    <span title="Consultar"><i class="glyphicon glyphicon-eye-open"></i></span>
                                </a>
                            </td>
                           
                        </tr>
                    @endforeach
                    {!! Form::hidden('max', $x) !!}
                </tbody>
            </table>
            
            <div class="col-sm-4 pull-right">
                {!! Form::submit('Carga Tratamiento', ['class' => 'btn btn-primary form-control', 'id' => 'seleccionar']) !!}
            </div>
        </div>
        {!! Form::close() !!}
    @else
        <h4>Usted no posee clave activa, para cargar un tratamiento</h4>
    @endif

    
@endsection

