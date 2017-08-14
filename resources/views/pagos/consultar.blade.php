@extends('layouts.app')
@section('title','Pagos')
@section('content') 
{!! Form::open(['url' => 'pagos/consultar', 'class' => 'form-horizontal', 'name' => 'consultar','method' => 'GET']) !!}
         {!! $filter->render('ac_facturas.fecha_factura') !!}
        <div class="form-group {{ $errors->has('ac_afiliados.nombre') || $errors->has('ac_claves.cedula_afiliado') ? 'has-error' : ''}}">
            {!! Form::label('ac_facturas.numero_factura', 'Número de Factura: ', ['class' => 'col-sm-2 control-label']) !!}
            <div class="col-sm-3">
              {!! $filter->field('ac_facturas.numero_factura') !!}
              {!! $errors->first('ac_facturas.numero_factura', '<p class="help-block">:message</p>') !!}
            </div>           
            {!! Form::label('ac_estatus.id', 'Estatus : ', ['class' => 'col-sm-2 control-label']) !!}
            <div class="col-sm-3">
                {!! $filter->field('ac_estatus.id',['selected', 'value'=>''] )!!}
                {!! $errors->first('ac_estatus.id', '<p class="help-block">:message</p>') !!}
            </div>
        </div>      
        <div class="form-group {{ $errors->has('ac_proveedores_extranet.codigo_proveedor')  ? 'has-error' : ''}}">
          {!! Form::label('ac_proveedores_extranet.codigo_proveedor', 'Proveedores: ', ['class' => 'col-sm-2 control-label']) !!}
          <div class="col-sm-3">
              {!! $filter->field('ac_proveedores_extranet.codigo_proveedor',['selected', 'value'=>'']) !!}
              {!! $errors->first('ac_proveedores_extranet.codigo_proveedor', '<p class="help-block">:message</p>') !!}
          </div>
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