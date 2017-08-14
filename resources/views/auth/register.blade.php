@extends('layouts.app')
@section('title','Agregar Nuevo Usuario')
@section('content')
<hr/>
<form class="form-horizontal" role="form" method="POST" action="{{ url('/register') }}">
    {!! csrf_field() !!}
    <div class="form-group{{ $errors->has('user') ? ' has-error' : '' }}">
        <label class="col-md-2 control-label">Usuario</label>
        <div class="col-md-4">
            <input type="text" class="form-control" name="user" value="{{ old('user') }}">
            @if ($errors->has('user'))
                <span class="help-block">
                    <strong>{{ $errors->first('user') }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
        <label class="col-md-2 control-label">Nombre</label>
        <div class="col-md-4">
            <input type="text" class="form-control" name="name" value="{{ old('name') }}">
            @if ($errors->has('name'))
                <span class="help-block">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
        <label class="col-md-2 control-label">E-Mail</label>
        <div class="col-md-4">
            <input type="email" class="form-control" name="email" value="{{ old('email') }}">
            @if ($errors->has('email'))
                <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
        <label class="col-md-2 control-label">Clave</label>
        <div class="col-md-4">
            <input type="password" class="form-control" name="password">
            @if ($errors->has('password'))
                <span class="help-block">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
        <label class="col-md-2 control-label">Confirmar Clave</label>
        <div class="col-md-4">
            <input type="password" class="form-control" name="password_confirmation">
            @if ($errors->has('password_confirmation'))
                <span class="help-block">
                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="form-group {{ $errors->has('type') ? 'has-error' : ''}}">
        {!! Form::label('type', 'Tipo Perfil: ', ['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-4">
            <?php
                $perfiles = \App\Models\UserType::get();
                $perfil = array_pluck($perfiles,'name','id');
            ?>
            {!! Form::select('type', $perfil, null, ['class' => 'form-control', 'required' => 'required']) !!}
            {!! $errors->first('type', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
    <div class="form-group {{ $errors->has('codigo_proveedor') ? 'has-error' : ''}}">
        {!! Form::label('codigo_proveedor', 'Proveedores: ', ['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-5">
            <div id='div_proveedor'>
                {!! Form::select('codigo_proveedor',['' => 'Seleccione una opción'],null, ['class' => 'form-control']) !!}
            </div>
            {!! $errors->first('codigo_proveedor', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
    
    {!! Form::hidden('active', 'S') !!}
    <div class="form-group">
        <div class="col-md-2 col-md-offset-2">
            <button type="submit" class="btn btn-primary">
                <i class="fa fa-btn fa-user"></i>Guardar
            </button>
        </div>
    </div>
</form>
@endsection
@section('script')
    <script>
        $(function(){
            $("#type").on('change',function(this){
                var data = {
                    '_token': $('[name="_token"]').val()
                };
                var select = "";alert($(this).val());
                if($('#type').val() === 3){//Analista Proveedor
                    $.post("{{url('selectProveedores')}}", data, function(data,select){
                        select = "<select class='form-control' id='codigo_proveedor' name='codigo_proveedor'>\n\
                                    <option selected='selected' value=''>Selecione una opción</option>";
                            $.each( data, function( key, val ) {
                                select = select + "<option value='" + key + "'>" + val + "</option>";
                              });
                            select = select + "</select>";
                            $("#div_proveedor").html(select);
                    });
                }else if($('#type').val() === 4){//Analista Aseguradora
                    $.post("{{url('selectAseguradors')}}", data, function(data,select){
                        select = "<select class='form-control' id='codigo_proveedor' name='codigo_proveedor'>\n\
                                    <option selected='selected' value=''>Selecione una opción</option>";
                            $.each( data, function( key, val ) {
                                select = select + "<option value='" + key + "'>" + val + "</option>";
                              });
                            select = select + "</select>";
                            $("#div_proveedor").html(select);
                    });
                }else{
                    $('#codigo_proveedor').prop( "disabled", true);
                }
            });
        });
    </script>
@endsection