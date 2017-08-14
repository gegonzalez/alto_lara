@extends('layouts.app')
@section('title','Generar Clave de Secuencia')
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
        {!! Form::open(['url' => 'clavesOdonto/gestionarTres', 'class' => 'form-horizontal', 'name' => 'beneficiario']) !!}
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
                            <td>{!! Form::hidden('clave'.$x, $clave->clave) !!}
                                {{ $clave->clave }}</td>
                            <td>{!! Form::hidden('tipo_control'.$x, $clave->acTipoControl->descripcion) !!}
                                {{ $clave->acTipoControl->descripcion }}</td>
                            <td>{!! Form::hidden('fecha_creacion'.$x, $clave->created_at) !!}
                                {{ $clave->created_at->format('d-m-Y') }}</td>
                            <td>{!! Form::hidden('fecha_atencion1'.$x, $clave->fecha_atencion1) !!}
                                {{ $clave->fecha_atencion1->format('d-m-Y') }}</td>
                            <td>{!! Form::hidden('estatus'.$x, $clave->acEstatus->nombre) !!}
                                {{ $clave->acEstatus->nombre }}</td>
                            <td>{!! Form::radio('iclave', $clave->id, null, ['id' => 'iclave']) !!}
                                {!! $errors->first('iclave', '<p class="help-block">:message</p>') !!}</td>
                        </tr>
                    @endforeach
                    {!! Form::hidden('max', $x) !!}
                </tbody>
            </table>
            <div class="col-sm-2 pull-right">
                {!! Form::submit('Siguiente', ['class' => 'btn btn-primary form-control', 'id' => 'seleccionar']) !!}
            </div>
        </div>
        {!! Form::close() !!}
    @else
        <h4>Datos de la Atención Odontológica</h4>
        {!! Form::open(['url' => 'clavesOdonto', 'class' => 'form-horizontal', 'id' => 'procesarClave', 'name' => 'procesar', 'lang' => 'es', 'data-parsley-validate' => '']) !!}
        <div class="form-group {{ $errors->has('fecha_atencion1')}}">
            {!! Form::label('fecha_atencion1', 'Fecha de Atención: ', ['class' => 'col-sm-2 control-label']) !!}
            <div class="col-sm-3">
                {!! Form::date('fecha_atencion1', null, ['class' => 'form-control input-sm', 'required' => 'required','placeholder' => 'dd-mm-aaaa']) !!}
                {!! $errors->first('fecha_atencion1', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
        <div class="form-group {{ $errors->has('telefono')}}">
            {!! Form::label('telefono', 'Teléfono Móvil: ', ['class' => 'col-sm-2 control-label']) !!}
            <div class="col-sm-2">
                {!! Form::text('telefono', null, ['class' => 'form-control', 'required' => 'required','placeholder' => '04XX-1234567','pattern' => '\b04\d{2}[-]{1}\d{7}\b']) !!}
                {!! $errors->first('telefono', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
        <div class="form-group {{  $errors->has('tipo_control') }}">
            {!! Form::label('tipo_control', 'Tipo de Control: ', ['class' => 'col-sm-2 control-label']) !!}
            <div class="col-sm-2">
                {!! Form::select('tipo_control', $tipo_control,1, ['class' => 'form-control', 'required' => 'required']) !!}
                {!! $errors->first('tipo_control', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
        <div class="form-group {{ $errors->has('codigo_proveedor') ? 'has-error' : ''}}">
            {!! Form::label('codigo_proveedor', 'Proveedor: ', ['class' => 'col-sm-2 control-label']) !!}
            <div class="col-sm-5">
                @if (isset($proveedor))
                    {!! Form::label('codigo_proveedor', $proveedor->nombre, ['class' => 'control-label']) !!}
                    {!! Form::hidden('codigo_proveedor',$proveedor->codigo_proveedor,['class' => 'form-control']) !!}
                @else
                <div id='div_proveedor'>
                    {!! Form::select('codigo_proveedor',$proveedores,null, ['class' => 'form-control']) !!}
                </div>
                @endif
                {!! $errors->first('codigo_proveedor', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
        {!! Form::hidden('max', 0, ['class' => 'form-control', 'required' => 'required','id' => 'max']) !!}
        {!! Form::hidden('cedula_afiliado', $beneficiario['cedula_afiliado'], ['class' => 'form-control','required' => 'required', 'id' => 'cedula_afiliado']) !!}
        {!! Form::hidden('codigo_contrato', $beneficiario['contrato'], ['class' => 'form-control','required' => 'required', 'id' => 'codigo_contrato']) !!}
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-3"><!--   -->
                {!! Form::submit('Generar Clave', ['class' => 'btn btn-primary form-control', 'id' => 'enviar_clave']) !!}
            </div>
        </div>
        {!! Form::close() !!}
    @endif
@endsection

@section('script')
    <script>
        $(function(){
            $("#fecha_atencion1").datepicker({ minDate: -5, maxDate: "+5D", dateFormat: "dd-mm-yy" });
            $('#procesarClave').parsley();
        });
    </script>
@endsection