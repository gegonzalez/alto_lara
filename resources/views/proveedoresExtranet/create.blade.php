@extends('layouts.app')
@section('title','Agregar Nuevo Proveedor Extranet')
@section('content')
    <hr/>
    {!! Form::open(['url' => 'proveedores', 'class' => 'form-horizontal']) !!}
        <div class="form-group {{ $errors->has('codigo_proveedor') ? 'has-error' : ''}}">
            {!! Form::label('codigo_proveedor', trans('Código') , ['class' => 'col-sm-2 control-label']) !!}
            <div class="col-sm-2">
                {!! Form::number('codigo_proveedor', null,['class' => 'form-control', 'required' => 'required']) !!}
                {!! $errors->first('codigo_proveedor', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
        <div class="form-group {{ $errors->has('cedula') || $errors->has('nombre') ? 'has-error' : ''}}">
            {!! Form::label('cedula', trans('Cédula'), ['class' => 'col-sm-2 control-label']) !!}
            <div class="col-sm-2">
                {!! Form::text('cedula', null, ['class' => 'form-control', 'required' => 'required']) !!}
                {!! $errors->first('cedula', '<p class="help-block">:message</p>') !!}
            </div>
            {!! Form::label('nombre', trans('Nombre'), ['class' => 'col-sm-2 control-label']) !!}
            <div class="col-sm-4">
                {!! Form::text('nombre', null, ['class' => 'form-control', 'required' => 'required']) !!}
                {!! $errors->first('nombre', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
        <div class="form-group {{ $errors->has('fecha_nacimiento') || $errors->has('codigo_especialidad') ? 'has-error' : ''}}">
            {!! Form::label('fecha_nacimiento', trans('Fecha Nacimiento'), ['class' => 'col-sm-2 control-label']) !!}
            <div class="col-sm-2">
                {!! Form::date('fecha_nacimiento', null, ['class' => 'form-control', 'required' => 'required']) !!}
                {!! $errors->first('fecha_nacimiento', '<p class="help-block">:message</p>') !!}
            </div>
            {!! Form::label('codigo_especialidad', trans('Especialidad'), ['class' => 'col-sm-2 control-label']) !!}
            <div class="col-sm-4">
                {!! Form::select('codigo_especialidad', $especialidades, null, ['class' => 'form-control', 'placeholder' => 'Seleccione una opción', 'required' => 'required']) !!}
                {!! $errors->first('codigo_especialidad', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
        <div class="form-group {{ $errors->has('telefono_casa') || $errors->has('telefono_movil') ? 'has-error' : ''}}">
            {!! Form::label('telefono_casa', trans('Teléfono Local'), ['class' => 'col-sm-2 control-label']) !!}
            <div class="col-sm-2">
                {!! Form::text('telefono_casa', null, ['class' => 'form-control', 'required' => 'required','placeholder' => '021X-1234567']) !!}
                {!! $errors->first('telefono_casa', '<p class="help-block">:message</p>') !!}
            </div>
            {!! Form::label('telefono_movil', trans('Teléfono Movil'), ['class' => 'col-sm-2 control-label']) !!}
            <div class="col-sm-2">
                {!! Form::text('telefono_movil', null, ['class' => 'form-control', 'required' => 'required','placeholder' => '04XX-1234567']) !!}
                {!! $errors->first('telefono_movil', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
        <div class="form-group {{ $errors->has('colegiatura') || $errors->has('email') ? 'has-error' : ''}}">
            {!! Form::label('colegiatura', trans('Colegiatura'), ['class' => 'col-sm-2 control-label']) !!}
            <div class="col-sm-2">
                {!! Form::number('colegiatura', null, ['class' => 'form-control', 'required' => 'required']) !!}
                {!! $errors->first('colegiatura', '<p class="help-block">:message</p>') !!}
            </div>
            {!! Form::label('email', trans('Email'), ['class' => 'col-sm-2 control-label']) !!}
            <div class="col-sm-4">
                {!! Form::email('email', null, ['class' => 'form-control', 'required' => 'required']) !!}
                {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
        <div class="form-group {{ $errors->has('msas') ? 'has-error' : ''}}">
            {!! Form::label('msas', trans('MSAS'), ['class' => 'col-sm-2 control-label']) !!}
            <div class="col-sm-2">
                {!! Form::number('msas', null, ['class' => 'form-control', 'required' => 'required']) !!}
                {!! $errors->first('msas', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
        <hr>
        <div class="form-group {{ $errors->has('codigo_estado') || $errors->has('email') ? 'has-error' : ''}}">
            {!! Form::label('codigo_estado', trans('Estado'), ['class' => 'col-sm-2 control-label']) !!}
            <div class="col-sm-3">
                {!! Form::select('codigo_estado', $estados, null, ['class' => 'form-control', 'placeholder' => 'Seleccione una opción']) !!}
                {!! $errors->first('codigo_estado', '<p class="help-block">:message</p>') !!}
            </div>
            {!! Form::label('ciudad', trans('Ciudad'), ['class' => 'col-sm-1 control-label']) !!}
            <div class="col-sm-4">
                {!! Form::text('ciudad', null, ['class' => 'form-control', 'required' => 'required']) !!}
                {!! $errors->first('ciudad', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
        <div class="form-group {{ $errors->has('urbanizacion') ? 'has-error' : ''}}">
            {!! Form::label('urbanizacion', trans('Urbanización'), ['class' => 'col-sm-2 control-label']) !!}
            <div class="col-sm-3">
                {!! Form::text('urbanizacion', null, ['class' => 'form-control', 'required' => 'required']) !!}
                {!! $errors->first('urbanizacion', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
        <div class="form-group {{ $errors->has('direccion') ? 'has-error' : ''}}">
            {!! Form::label('direccion', trans('Dirección'), ['class' => 'col-sm-2 control-label']) !!}
            <div class="col-sm-8">
                {!! Form::textarea('direccion', null, ['class' => 'form-control', 'required' => 'required', 'rows' => '2']) !!}
                {!! $errors->first('direccion', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-3">
                {!! Form::submit('Guardar', ['class' => 'btn btn-primary form-control']) !!}
            </div>
        </div>
    {!! Form::close() !!}
@endsection