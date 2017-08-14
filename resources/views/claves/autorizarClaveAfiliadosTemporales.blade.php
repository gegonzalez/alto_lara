@extends('layouts.app')
@section('title','Autorizar Claves y Autorizaciones Afiliados Temporales')

@section('content') 
{!! Form::open(['url' => 'claves/autorizarAfiliadosTemporales', 'class' => 'form-horizontal', 'name' => 'autorizarAfiliadosTemporales','method' => 'GET']) !!}
        {!! $filter->render('ac_claves.fecha_cita') !!}
        <div class="form-group {{ $errors->has('ac_afiliados_temporales.nombre') || $errors->has('ac_claves.cedula_afiliado') ? 'has-error' : ''}}">
          {!! Form::label('ac_afiliados_temporales.nombre', 'Nombre Paciente: ', ['class' => 'col-sm-2 control-label']) !!}
          <div class="col-sm-3">
              {!! $filter->field('ac_afiliados_temporales.nombre',  ['onchange'=>"ValidarAlpha(this.value,'ac_afiliados_temporales_nombre')"]) !!}
              {!! $errors->first('ac_afiliados_temporales.nombre', '<p class="help-block">:message</p>') !!}
          </div>
         
          {!! Form::label('ac_claves.cedula_afiliado', 'C.I: ', ['class' => 'col-sm-2 control-label']) !!}
         <div class="col-sm-3">
              {!! $filter->field('ac_claves.cedula_afiliado') !!}
              {!! $errors->first('ac_claves.cedula_afiliado', '<p class="help-block">:message</p>') !!}
          </div>
        </div>      
  {!!$filter->footer!!}    
  {!!$grid!!}    
  {{ Form::close() }}
@endsection
@section('script')
<script>
 function ValidarAlpha(valor,campo){
     var charRegExp = /^([a-zA-ZñÑáéíóúÁÉÍÓÚ_-])+((\s*)+([a-zA-ZñÑáéíóúÁÉÍÓÚ_-]*)*)+$/;
     var valor1 = valor;
             if (charRegExp.test(valor1)== true)
             {
                  return true;
              }else{ 
                  $("#result").addClass("alert alert-danger");
                  $("#result").html("Debe introducir solo carácteres Alfabéticos"); 
                  $("#"+campo).focus(); 
                   return false;
               }       
          };
    $("#fecha_desde" ).datepicker({ dateFormat: "dd/mm/yy" });
    $("#fecha_hasta" ).datepicker({ dateFormat: "dd/mm/yy" });          
</script>
@endsection