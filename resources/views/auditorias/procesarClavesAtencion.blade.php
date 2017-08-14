@extends('layouts.app')
@section('title','Auditoría')
@section('content')
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">Motivo del Rechazo</h4>
            </div>
            <div class="modal-body">
                <div class="form-group {{ $errors->has('rechazo') ? 'has-error' : ''}}">
                  <!--{!! Form::label('Motivo de Rechazo', 'Motivo de Rechazo: ', ['class' => 'col-sm-2 control-label']) !!}-->
                    <!--<div class="col-sm-8">-->
                        {!! Form::textarea('rechazo', null, ['class' => 'form-control', 'rows' => '2', 'id'=>'rechazo']) !!}
                        {!! $errors->first('rechazo', '<p class="help-block">:message</p>') !!}
                    </div>
                <!--</div>-->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <div class="col-sm-offset-2 col-sm-3">  
                   <p><a href="{{ url('auditoria/rechazar?&id_factura='.$factura->id) }}"  class="btn btn-danger form-control ">Rechazar</a></p>    
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@if (isset($factura))
    <h4>Factura</h4>   
    <div class="table-responsive">    
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>Nro. Factura</th>
                    <th>Nro. Control</th>
                    <th>Fecha Factura</th>                    
                    <th>Monto</th>
                    <th>Proveedor</th>
                    <th>Documentos</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{$factura->numero_factura}}</td>                    
                    <td>{{$factura->numero_control}}</td>
                    <td>{{date("d-m-Y",strtotime($factura->fecha_factura)) }}</td>                    
                    <td>{{$factura->monto}}</td>
                    <td>{{$factura->acProveedor->nombre}}</td> 
                    <td><a href="descargarDocumento?idFactura={{$factura->id}}&idProveedor={{$factura->codigo_proveedor_creador}}">{{$factura->documento}}</a></td>                    
                </tr>
            </tbody>
        </table>
    </div>
    @if (isset($claves))
    <h4>Clave</h4>   
        <div class="table-responsive">    
            <table class="table table-bordered table-striped table-hover table-condensed table-responsive">
                <thead>
                    <tr>
                        <th>Clave</th>
                        <th>Contrato</th>
                        <th>Fecha Cita</th>
                        <th>Motivo</th>
                        <th>Observaciónes</th>                                                            
                    </tr>
                </thead>
                <tbody>
                 @foreach ($claves as $data_clave)  
                    <tr>
                        <td><a href="detalleClaveAtencion?clave={{$data_clave->clave}}">{{$data_clave->clave}}</a></td>                    
                        <td>{{ $data_clave->codigo_contrato}}</td>
                        <td>{{ date("d-m-Y",strtotime($data_clave->fecha_cita)) }}</td>                    
                        <td>{{ $data_clave->motivo}}</td>
                        <td>{{ $data_clave->observaciones}}</td>                                                            
                    </tr>
                @endforeach   
                </tbody>
            </table>
        </div>
    
        <div class="modal fade" id="procesarConfirmar" role="dialog" tabindex="-1">
            <div class="modal-dialog" role="document" ><!-- Modal content-->
            </div>
        </div>
    
    @endif
    @if (isset($cartasAval))
        <h4>Claves y Autorizaciones Especiales</h4>   
        <div class="table-responsive">    
            <table class="table table-bordered table-striped table-hover table-condensed table-responsive">
                <thead>
                    <tr>
                        <th>Clave</th>
                        <th>Contrato</th>
                        <th>Fecha Solicitud</th>                    
                        <th>Motivo</th>
                        <th>Observaciónes</th>                                                            
                    </tr>
                </thead>
                <tbody>
                @foreach ($cartasAval as $carta)
                    <tr>
                        <td><a href="DetalleClave?clave={{$carta->clave}}">{{$carta->clave}}</a></td>                    
                        <td>{{ $carta->codigo_contrato}}</td>
                        <td>{{ date("d-m-Y",strtotime($carta->fecha_solicitud)) }}</td>                    
                        <td>{{ $carta->motivo}}</td>                                        
                        <td>{{ $carta->observaciones}}</td>                                                            
                    </tr>
                @endforeach   
                </tbody>
            </table>
        </div>
    @endif
    <div class="form-group">    
        <div class="col-sm-offset-2 col-sm-3">  
            <p><a href="{{ url('auditoria/aprobar?&id_factura='.$factura->id) }}"  class="btn btn-primary form-control ">Aprobar</a></p>    
        </div>
        <div class="col-sm-offset-2 col-sm-3"><!--   -->
            {!! Form::button('Rechazar', ['class' => 'btn btn-danger form-control','data-toggle'=>'modal', 'data-target'=>'#myModal']) !!}
        </div>
    </div>    
@endif
@endsection