@extends('layouts.app')
@section('title','Auditoría de Claves de Atención')
@section('content') 
{!! Form::open(['url' => 'auditoria/consultarDetalle', 'class' => 'form-horizontal', 'name' => 'consultar','method' => 'GET']) !!}
        <?php
             $user = Auth::user();
             $user_type =  $user->type;
        ?>  
         {!! $filter->render('ac_facturas.fecha_factura') !!}
        <div class="form-group {{ $errors->has('ac_afiliados.nombre') || $errors->has('ac_claves.cedula_afiliado') ? 'has-error' : ''}}">
            {!! Form::label('ac_facturas.numero_factura', 'Número de Factura: ', ['class' => 'col-sm-2 control-label']) !!}
            <div class="col-sm-3">
              {!! $filter->field('ac_facturas.numero_factura') !!}
              {!! $errors->first('ac_facturas.numero_factura', '<p class="help-block">:message</p>') !!}
            </div>
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
    $("#fecha_desde" ).datepicker({ dateFormat: "dd/mm/yy" });
    $("#fecha_hasta" ).datepicker({ dateFormat: "dd/mm/yy" });
</script>
@endsection