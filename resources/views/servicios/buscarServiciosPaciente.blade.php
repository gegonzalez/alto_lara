@extends('layouts.app')
@section('title','Pacientes Atendidos')
@section('content')
<hr/>
    {!! Form::open(['url' => 'servicios/buscarServicios', 'class' => 'form-horizontal', 'name' => 'buscar', 'lang' => 'es']) !!}
        <div class="form-group {{ $errors->has('cedula') ? 'has-error' : ''}}">
            {!! Form::label('cedula', 'Cédula Afiliado: ', ['class' => 'col-sm-2 control-label']) !!}
            <div class="col-sm-2">
                {!! Form::number('cedula', Input::old('cedula'), ['class' => 'form-control', 'min' => '0', 'placeholder' => 'Ej:12345678']) !!}
                {!! $errors->first('cedula', '<p class="help-block">:message</p>') !!}
            </div>
            <div class="col-sm-2">
                {!! Form::submit('Buscar', ['class' => 'btn btn-primary form-control']) !!}
            </div>
        </div>
    @if (isset($grid))
      {!!$grid!!}   
    @endif;  
    {!! Form::close() !!}
@endsection
@section('script')
<script>
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