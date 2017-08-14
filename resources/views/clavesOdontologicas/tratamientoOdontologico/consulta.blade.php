@extends('layouts.app')
@section('title','Tratamientos Realizados')
@section('content')
@if (isset($beneficiario))
    <div class="col-md-12">
        <div class="table">
            <table class="table table-bordered table-striped table-hover table-responsive">
                <thead>
                    <tr>
                        <th>Cédula</th><th>Nombre</th><th>Tipo</th><th>Cobertura del Plan</th><th>Colectivo</th><th>Aseguradora</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $beneficiario[0]->cedula_afiliado }}</td>
                        <td>{{ $beneficiario[0]->nombre_afiliado}}</td>
                        <td>{{ $beneficiario[0]->tipo_afiliado }}</td>
                        <td>{{ $beneficiario[0]->plan }}</td>
                        <td>{{ $beneficiario[0]->colectivo }}</td>
                        <td>{{ $beneficiario[0]->aseguradora }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endif
@if (isset($tratamientos))
    @if (count($tratamientos) > 0)
        <div class="col-md-12">
	        <div class="table">
	            <table class="table table-bordered table-striped table-hover">
	                <thead>
	                    <tr>
	                        <th>Clave</th><th>Procedimiento</th><th>Diente</th><th>Ubicacion</th>
	                        <th>Fecha Atencion</th><th>Estatus</th><th></th>
	                    </tr>
	                </thead>
	                <tbody>
	                    {{-- */$x=0;/* --}}
	                    @foreach ($tratamientos as $tratamiento)
	                        {{-- */$x++;/* --}}
	                        <tr>
	                            <td>{{ $tratamiento->clave }}</td> 
	                            <td>{{ $tratamiento->tipo_examen }}</td>
	                            <td>{{ $tratamiento->descripcion }}</td>
	                            <td>{{ $tratamiento->cara }}</td>
	                            <td>{{ $tratamiento->fecha_atencion }}</td>
	                            <td>{{ $tratamiento->estatus }}</td>
	                            @if($tratamiento->estatus_clave == 1)
		                            <td>
		                            	<a href="{{ url('/tratamiento/editar',  [$tratamiento->id, $beneficiario[0]->cedula_afiliado])}}">
	                                        <span><i class="glyphicon glyphicon-edit"></i></span>
	                                    </a>
	                                </td>
	                        	@endif
	                            
	                        </tr>
	                    @endforeach
	                    {!! Form::hidden('max', $x) !!}
	                </tbody>
	            </table>
	        </div>
        </div>
    @endif
@endif
@endsection