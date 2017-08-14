@extends('layouts.app')
@section('title','Editar Afiliado Temporal')
@section('content')
    <hr/>
    {!! Form::model($afiliadosTemporale, [
        'method' => 'PATCH',
        'url' => ['claves/afiliadosTemporales'],
        'class' => 'form-horizontal'
    ]) !!}

    <div class="form-group {{ $errors->has('cedula') ? 'has-error' : ''}}">
        {!! Form::label('cedula', trans('Cédula'), ['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-2">
            {!! Form::number('cedula', null, ['class' => 'form-control', 'required' => 'required', 'min' => '0', 'placeholder' => 'Ej:12345678']) !!}
            {!! $errors->first('cedula', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
    <div class="form-group {{ $errors->has('nombre') || $errors->has('apellido') ? 'has-error' : ''}}">
        {!! Form::label('nombre', trans('Nombres'), ['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-3">
            {!! Form::text('nombre', null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => 'Nombre']) !!}
            {!! $errors->first('nombre', '<p class="help-block">:message</p>') !!}
        </div>
        {!! Form::label('apellido', trans('Apellido'), ['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-3">
            {!! Form::text('apellido', null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => 'Apellido']) !!}
            {!! $errors->first('apellido', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
    <div class="form-group {{ $errors->has('fecha_nacimiento') || $errors->has('email') ? 'has-error' : ''}}">
        {!! Form::label('fecha_nacimiento', trans('Fecha Nacimiento'), ['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-3">
            {!! Form::text('fecha_nacimiento', null, ['class' => 'form-control', 'required' => 'required']) !!}
            {!! $errors->first('fecha_nacimiento', '<p class="help-block">:message</p>') !!}
        </div>
        {!! Form::label('email', trans('Correo'), ['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-3">
            {!! Form::email('email', null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => 'correo@dominio.com']) !!}
            {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
    <div class="form-group {{ $errors->has('sexo') || $errors->has('tipo_afiliado') ? 'has-error' : ''}}">
        {!! Form::label('sexo', trans('Sexo'), ['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-3">
            {!! Form::select('sexo',array('M'=>'Masculino', 'F'=>'Femenino'), null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => 'Seleccione una opción']) !!}
            {!! $errors->first('sexo', '<p class="help-block">:message</p>') !!}
        </div>
        {!! Form::label('tipo_afiliado', trans('Tipo Afiliado'), ['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-3">
            {!! Form::select('tipo_afiliado',$tipoAfiliado, null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => 'Selecione una opción']) !!}
            {!! $errors->first('tipo_afiliado', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
    <div class="form-group {{ $errors->has('telefono') ? 'has-error' : ''}}">
        {!! Form::label('telefono', trans('Teléfono'), ['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-3">
            {!! Form::text('telefono', null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => '0212-1234567']) !!}
            {!! $errors->first('telefono', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
    <hr/>
    <div class="form-group {{ $errors->has('cedula_titular') || $errors->has('nombre_titular') ? 'has-error' : ''}}">
        {!! Form::label('cedula_titular', trans('Cédula Titular'), ['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-3">
            {!! Form::number('cedula_titular', null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => 'Cédula Titular']) !!}
            {!! $errors->first('cedula_titular', '<p class="help-block">:message</p>') !!}
        </div>
        {!! Form::label('nombre_titular', trans('Nombre Titular'), ['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-3">
            {!! Form::text('nombre_titular', null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => 'Nombre Titular']) !!}
            {!! $errors->first('nombre_titular', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
    <div class="form-group {{ $errors->has('apellido_titular') ? 'has-error' : ''}}">
        {!! Form::label('apellido_titular', trans('Apellido Titular'), ['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-3">
            {!! Form::text('apellido_titular', null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => 'Apellido Titular']) !!}
            {!! $errors->first('apellido_titular', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
    <hr/>
    <div class="form-group {{ $errors->has('codigo_aseguradora') || $errors->has('codigo_colectivo') ? 'has-error' : ''}}">
        {!! Form::label('codigo_aseguradora', trans('Aseguradora'), ['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-3">
            {!! Form::select('codigo_aseguradora',$aseguradora, null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => 'Selecione una opción']) !!}
            {!! $errors->first('codigo_aseguradora', '<p class="help-block">:message</p>') !!}
        </div>
        {!! Form::label('codigo_colectivo', trans('Colectivo'), ['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-3">
            <div id="colectivo">
            {!! Form::select('codigo_colectivo',$colectivo, null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => 'Selecione una opción']) !!}
            </div>
            {!! $errors->first('codigo_colectivo', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
    <div class="form-group {{ $errors->has('estado') || $errors->has('ciudad') ? 'has-error' : ''}}">
        {!! Form::label('estado', trans('Estado'), ['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-3">
            {!! Form::select('estado',$estado, null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => 'Seleccione una opción']) !!}
            {!! $errors->first('estado', '<p class="help-block">:message</p>') !!}
        </div>
        {!! Form::label('ciudad', trans('Ciudad'), ['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-3">
            {!! Form::text('ciudad', null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => 'Ciudad']) !!}
            {!! $errors->first('ciudad', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
    {!! Form::hidden('val_user', 'S', ['class' => 'form-control', 'required' => 'required']) !!}
    
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-3">
            {!! Form::submit('Actualizar', ['class' => 'btn btn-primary form-control']) !!}
        </div>
    </div>
    {!! Form::close() !!}
@endsection
@section('script')
    <script>
        $(function(){
            $('#procesar').parsley();
            $("#fecha_nacimiento").datepicker({ maxDate: 0, dateFormat: "dd-mm-yy", changeMonth: true , changeYear: true, yearRange: "1910:2016"});
            $('#cedula_titular').on('change',function(e){
                if($(this).val() !== ''){
                    var data = {
                        'id': $(this).val(),
                        '_token': $('[name="_token"]').val()
                    };
                if ($("tipo_afiliado").val() !== '1' ){
                    $.post("{{url('getTitular')}}", data, function(data){
                        if(data.nombre !== ''){
                            $("#nombre_titular").val(data.nombre);
                            $("#apellido_titular").val(data.apellido);
                            $("#result").addClass("alert alert-success");
                            $("#result").html("Verifique los datos del Titular.");
                            $("[type='submit']").prop('disabled', false);
                        }else{
                            $("#result").addClass("alert alert-danger");
                            $("#result").html("No existe el Titular.");
                            $("#nombre_titular").val('');
                            $("#apellido_titular").val('');
                            $("[type='submit']").prop('disabled', true);
                        }
                    });
                }      
              }
            });
        });
        $(function(){
            $("#codigo_aseguradora").on('change',function(e){
                var data = {
                    'id': $(this).val(),
                    '_token': $('[name="_token"]').val()
                };
                var select = "";
                $.post("{{url('selectColectivos')}}", data, function(data,select){
                    select = "<select class='form-control' required='required' id='codigo_colectivo' name='codigo_colectivo'>\n\
                                <option selected='selected' value=''>Selecione una opción</option>";
                        $.each( data, function( key, val ) {
                            select = select + "<option value='" + key + "'>" + val + "</option>";
                            //items.push( "<li id='" + key + "'>" + val + "</li>" );
                          });
                        select = select + "</select>";
                        $("#colectivo").html(select);
                });
            });
        });   

        $(function(){
            $("#tipo_afiliado").on('change',function(e){
                  if($(this).val() == '1'){
                       $("#cedula_titular").val($("#cedula").val());
                       $("#nombre_titular").val($("#nombre").val());
                       $("#apellido_titular").val($("#apellido").val());
                       $("#telefono").focus(); 
                       $("#cedula_titular").prop('disabled', true);
                       $("#nombre_titular").prop('disabled', true);
                       $("#apellido_titular").prop('disabled', true);
                  }else{
                       $("#cedula_titular").prop('disabled'  , false);
                       $("#nombre_titular").prop('disabled'  , false);
                       $("#apellido_titular").prop('disabled', false);
                  }
            });
        });   
          
    function ValidarAlpha(valor,campo){
     var charRegExp = /^([a-zA-ZñÑáéíóúÁÉÍÓÚ_-])+((\s*)+([a-zA-ZñÑáéíóúÁÉÍÓÚ_-]*)*)+$/;
     var valor1 = valor;
             if (charRegExp.test(valor1)== true)
             {
                  $("[type='submit']").prop('disabled', false);
                  return true;
              }else{ 
                  $("#result").addClass("alert alert-danger");
                  $("#result").html("Debe introducir solo carácteres Alfabéticos"); 
                  $("#"+campo).focus(); 
                  $("[type='submit']").prop('disabled', true);
                   return false;
               }       
          };       
          
    </script>
@endsection