@extends('layouts.app')
@section('title','Consulta de Pacientes Atendidos')

@section('content') 
{!! Form::open(['url' => 'auditoria/consultar', 'class' => 'form-horizontal', 'name' => 'consultar','method' => 'GET']) !!}
       {!! $filter->render('ac_claves.fecha_cita') !!}
        <div class="form-group {{ $errors->has('ac_afiliados.nombre') || $errors->has('ac_claves.cedula_afiliado') ? 'has-error' : ''}}">
          {!! Form::label('ac_afiliados.nombre', 'Nombre Paciente: ', ['class' => 'col-sm-2 control-label']) !!}
          <div class="col-sm-3">
              {!! $filter->field('ac_afiliados.nombre',['onchange'=>"ValidarAlpha(this.value,'ac_afiliados_nombre')"]) !!}
              {!! $errors->first('ac_afiliados.nombre', '<p class="help-block">:message</p>') !!}
          </div>
          {!! Form::label('ac_claves.cedula_afiliado', 'C.I: ', ['class' => 'col-sm-2 control-label']) !!}
         <div class="col-sm-3">
              {!! $filter->field('ac_claves.cedula_afiliado') !!}
              {!! $errors->first('ac_claves_cedula_afiliado', '<p class="help-block">:message</p>') !!}
          </div>
        </div>      
        <div class="form-group {{ $errors->has('ac_claves.clave') || $errors->has('ac_estatus.id') ? 'has-error' : ''}}">
          {!! Form::label('ac_claves.clave', 'Clave: ', ['class' => 'col-sm-2 control-label']) !!}
          <div class="col-sm-3">
              {!! $filter->field('ac_claves.clave',['onchange'=>"ValidarAlpha(this.value,'ac_claves_clave')"]) !!}
              {!! $errors->first('ac_claves.clave', '<p class="help-block">:message</p>') !!}
          </div>
          {!! Form::label('ac_colectivos.nombre', 'Colectivo: ', ['class' => 'col-sm-2 control-label']) !!}
          <div class="col-sm-3">
              {!! $filter->field('ac_colectivos.codigo_colectivo',['selected', 'value'=>'']) !!}
              {!! $errors->first('ac_colectivos.codigo_colectivo', '<p class="help-block">:message</p>') !!}
          </div>
        </div>    
        <div class="form-group {{ $errors->has('ac_tipo_documentos.id') || $errors->has('ac_estatus_detalle.id') ? 'has-error' : ''}}">
         {!! Form::label('ac_estatus_detalle.id', 'Estatus: ', ['class' => 'col-sm-2 control-label']) !!}
         <div class="col-sm-3">
              {!! $filter->field('ac_estatus_detalle.id') !!}
              {!! $errors->first('ac_estatus_detalle.id', '<p class="help-block">:message</p>') !!}
          </div>
         {!! Form::label('ac_aseguradora.codigo_aseguradora', 'Aseguradora: ', ['class' => 'col-sm-2 control-label']) !!}
         <div class="col-sm-3">
              {!! $filter->field('ac_aseguradora.codigo_aseguradora',['selected', 'value'=>'']) !!}
              {!! $errors->first('ac_aseguradora.codigo_aseguradora', '<p class="help-block">:message</p>') !!}
          </div> 
        </div>   
        <div class="form-group {{ $errors->has('ac_proveedores_extranet.codigo_proveedor') || $errors->has('ac_colectivo.nombre') ? 'has-error' : ''}}">
          <?php
             $user = Auth::user();
             $user_type =  $user->type;
          ?>   
        @if($user_type != 3 )
          {!! Form::label('ac_proveedores_extranet.codigo_proveedor', 'Proveedores: ', ['class' => 'col-sm-2 control-label']) !!}
          <div class="col-sm-3">
              {!! $filter->field('ac_proveedores_extranet.codigo_proveedor',['selected', 'value'=>'']) !!}
              {!! $errors->first('ac_proveedores_extranet.codigo_proveedor', '<p class="help-block">:message</p>') !!}
          </div>
        @endif
        </div> 
  {!!$filter->footer!!}    
  {!!$grid!!}    
  {{ Form::close() }}
@endsection
@section('script')
<script>
    $(function(){
        function ValidarAlpha(valor,campo){
            var charRegExp = /^([a-zA-ZñÑáéíóúÁÉÍÓÚ_-])+((\s*)+([a-zA-ZñÑáéíóúÁÉÍÓÚ_-]*)*)+$/;
            var valor1 = valor;
            if (charRegExp.test(valor1)== true){
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
    }); 
</script>
@endsection