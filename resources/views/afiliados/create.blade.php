@extends('layouts.app')
@section('title','Agregar Nuevo Afiliado')
@section('content')

    <hr/>

    {!! Form::open(['url' => 'afiliados', 'class' => 'form-horizontal']) !!}

                <div class="form-group {{ $errors->has('cedula') ? 'has-error' : ''}}">
                {!! Form::label('cedula', 'Cedula: ', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::text('cedula', null, ['class' => 'form-control', 'required' => 'required']) !!}
                    {!! $errors->first('cedula', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
            <div class="form-group {{ $errors->has('nombre') ? 'has-error' : ''}}">
                {!! Form::label('nombre', 'Nombre: ', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::text('nombre', null, ['class' => 'form-control', 'required' => 'required']) !!}
                    {!! $errors->first('nombre', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
            <div class="form-group {{ $errors->has('apellido') ? 'has-error' : ''}}">
                {!! Form::label('apellido', 'Apellido: ', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::text('apellido', null, ['class' => 'form-control', 'required' => 'required']) !!}
                    {!! $errors->first('apellido', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
            <div class="form-group {{ $errors->has('fecha_nacimiento') ? 'has-error' : ''}}">
                {!! Form::label('fecha_nacimiento', 'Fecha Nacimiento: ', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::date('fecha_nacimiento', null, ['class' => 'form-control', 'required' => 'required']) !!}
                    {!! $errors->first('fecha_nacimiento', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
            <div class="form-group {{ $errors->has('email') ? 'has-error' : ''}}">
                {!! Form::label('email', 'Email: ', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::email('email', null, ['class' => 'form-control', 'required' => 'required']) !!}
                    {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
            <div class="form-group {{ $errors->has('sexo') ? 'has-error' : ''}}">
                {!! Form::label('sexo', 'Sexo: ', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::text('sexo', null, ['class' => 'form-control', 'required' => 'required']) !!}
                    {!! $errors->first('sexo', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
            <div class="form-group {{ $errors->has('val_user') ? 'has-error' : ''}}">
                {!! Form::label('val_user', 'Val User: ', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::text('val_user', null, ['class' => 'form-control', 'required' => 'required']) !!}
                    {!! $errors->first('val_user', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
            <div class="form-group {{ $errors->has('tipo_afiliado') ? 'has-error' : ''}}">
                {!! Form::label('tipo_afiliado', 'Tipo Afiliado: ', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::number('tipo_afiliado', null, ['class' => 'form-control', 'required' => 'required']) !!}
                    {!! $errors->first('tipo_afiliado', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
            <div class="form-group {{ $errors->has('telefono') ? 'has-error' : ''}}">
                {!! Form::label('telefono', 'Telefono: ', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::text('telefono', null, ['class' => 'form-control', 'required' => 'required']) !!}
                    {!! $errors->first('telefono', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
            <div class="form-group {{ $errors->has('cedula_titular') ? 'has-error' : ''}}">
                {!! Form::label('cedula_titular', 'Cedula Titular: ', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::text('cedula_titular', null, ['class' => 'form-control', 'required' => 'required']) !!}
                    {!! $errors->first('cedula_titular', '<p class="help-block">:message</p>') !!}
                </div>
            </div>


    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-3">
            {!! Form::submit('Guardar', ['class' => 'btn btn-primary form-control']) !!}
        </div>
    </div>
    {!! Form::close() !!}
@endsection