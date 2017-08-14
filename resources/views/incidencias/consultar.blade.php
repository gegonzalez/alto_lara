@extends('layouts.app')
@section('title','Incidencias')
@section('content') 
{!! Form::open(['url' => 'auditoria/consultarDetalle', 'class' => 'form-horizontal', 'name' => 'consultar','method' => 'GET']) !!}
        <div class="form-group {{ $errors->has('ac_afiliados.nombre') || $errors->has('ac_claves.cedula_afiliado') ? 'has-error' : ''}}">
            {!! Form::label('ac_facturas.numero_factura', 'Número de Factura: ', ['class' => 'col-sm-2 control-label']) !!}
            <div class="col-sm-3">
              {!! $filter->field('ac_facturas.numero_factura') !!}
              {!! $errors->first('ac_facturas.numero_factura', '<p class="help-block">:message</p>') !!}
            </div>
        </div>      
  {!!$filter->footer!!}    
  {!!$grid!!}
  {{ Form::close() }}
@endsection