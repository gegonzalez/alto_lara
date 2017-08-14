@extends('layouts.app')
@section('title','Gestionar Clave Odontologica')
@section('content')
    <hr/>
    @if (isset($beneficiario))
        <h4>Datos del Beneficiario</h4>
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
        <h4>Datos Clave Primaria</h4>
        <div class="table">
            <table class="table table-bordered table-striped table-hover table-responsive">
                <thead>
                    <tr>
                        <th>Clave</th><th>Tipo</th><th>Fecha Creación</th><th>Fecha Atención</th><th>Proveedor</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $claves->clave }}</td>
                        <td>{{ $claves->acTipoControl->descripcion }}</td>
                        <td>{{ $claves->created_at->format('d-m-Y') }}</td>
                        <td>{{ $claves->fecha_atencion1->format('d-m-Y') }}</td>
                        <td>{{ $claves->acProveedoresExtranet->nombre }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    @endif
    @if(isset($claves->ruta))
        {!! Form::open([
            'url' => 'clavesOdonto/update', 'class' => 'form-horizontal', 
            'name' => 'actualizarSecuencia', 'lang' => 'es', 
            'data-parsley-validate' => '', 'id' => 'procesar']) !!}
    @else
        {!! Form::open([
            'url' => 'clavesOdonto/actualSecuencia', 'class' => 'form-horizontal', 
            'name' => 'actualizarSecuencia', 'lang' => 'es', 
            'data-parsley-validate' => '', 'id' => 'procesar']) !!}
    @endif
    <h4>Fechas Tentativas de Atención</h4>
    <div class="form-group {{ $errors->has('fecha_atencion1') || $errors->has('fecha_atencion2') || $errors->has('fecha_atencion3')? 'has-error' : ''}}">
        <div class="col-sm-3">
            {!! Form::hidden('iclave', $claves->id) !!}
            {!! Form::hidden('codigo_proveedor_creador', $claves->acProveedoresExtranet->codigo_proveedor) !!}
            {!! Form::label('fecha_atencion1', 'Fecha Consulta 1 ', ['class' => 'control-label']) !!}
            {!! Form::date('fecha_atencion1', $claves->fecha_atencion1, ['class' => 'form-control input-sm', 'id' => 'fecha_atencion1','required' => 'required','placeholder' => 'dd-mm-aaaa']) !!}
            {!! $errors->first('fecha_atencion1', '<p class="help-block">:message</p>') !!}
        </div>

        <!--<div class="col-sm-3">
            {!! Form::label('fecha_atencion2', 'Fecha Consulta 2 ', ['class' => 'control-label']) !!}
            {!! Form::date('fecha_atencion2', $claves->fecha_atencion2, ['class' => 'form-control input-sm', 'id' => 'fecha_atencion2','required' => 'required','placeholder' => 'dd-mm-aaaa']) !!}
            {!! $errors->first('fecha_atencion2', '<p class="help-block">:message</p>') !!}
        </div>
        <div class="col-sm-3">
            {!! Form::label('fecha_atencion3', 'Fecha Consulta 3 ', ['class' => 'control-label']) !!}
            {!! Form::date('fecha_atencion3', $claves->fecha_atencion3, ['class' => 'form-control input-sm', 'id' => 'fecha_atencion3', 'required' => 'required','placeholder' => 'dd-mm-aaaa']) !!}
            {!! $errors->first('fecha_atencion3', '<p class="help-block">:message</p>') !!}
        </div>-->
    </div>
    <div class="form-group">
        <div class="col-sm-offset-1 col-sm-3"><!--   -->
            {!! $errors->first('actualizarSecuencia', '<p class="help-block">:message</p>') !!}
            {!! Form::submit('Generar Secuencia', ['class' => 'btn btn-primary form-control']) !!}
        </div>
    </div>
    {!! Form::close() !!}
@endsection

@section('script')
    <script>
        $(function(){
            $('#procesar').parsley();

            $("#fecha_atencion1").datepicker({ maxDate: "+15D", dateFormat: "dd-mm-yy" });
            //$("#fecha_atencion2").datepicker({ maxDate: "+15D", dateFormat: "dd-mm-yy" });
            //$("#fecha_atencion3").datepicker({ maxDate: "+15D", dateFormat: "dd-mm-yy" });

            $("#procesar").submit(function(e){
                if ( $("#fecha_atencion1").val() == $("#fecha_atencion2").val() || 
                     $("#fecha_atencion1").val() == $("#fecha_atencion3").val() ||
                     $("#fecha_atencion2").val() == $("#fecha_atencion3").val() )
                {
                    $("#result").addClass("alert alert-danger");
                    $("#result").html("Las fechas no pueden ser iguales."); 
                    return false;
                }else{
                    return true;
               }
            });
        });
            
    </script>
@endsection