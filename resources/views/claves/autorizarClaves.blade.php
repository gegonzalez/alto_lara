@extends('layouts.app')
@section('title','Autorizar Afiliados Temporales')

@section('content') 

{!! Form::open(['url' => 'claves/rechazarAfiliadosTemporales', 'class' => 'form-horizontal', 'name' => 'autorizarAfiliadosTemporales',
                                                               'method' => 'aprobar'       , 'id' => 'autorizarAfiliadosTemporales']) !!}
 <h4>Afiliado Temporal</h4>
@if (isset($data_clave))
    @foreach ($data_clave as $data)    
    <div class="table-responsive">    
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>Cédula del Afiliado</th>
                    <th>Nombre</th>
                    <th>Fecha de Nacimiento</th>
                    <th>Sexo</th>
                    <th>Télefono</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $data->cedula_afiliado}}</td>
                    <td>{{ $data->nombre}}</td>
                    <td>{{ date("d-m-Y",strtotime($data->fecha_nacimiento)) }}</td>
                    @if ($data->sexo == 'M')
                      <td>Masculino</td>
                    @endif
                    @if ($data->sexo == 'F')
                      <td>Femenino</td>
                    @endif
                    <td>{{ $data->telefono}}</td>                                                            
                </tr>
            </tbody>
        </table>
    </div>
    <h4>Titular</h4> 
    <div class="table-responsive">    
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>Cédula</th>
                    <th>Nombre</th>
                    <th>Aseguradora</th>                    
                    <th>Colectivo</th>                                        
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $data->cedula_titular}}</td>
                    <td>{{ $data->nombre_titular}}</td>
                    <td>{{ $data->aseguradora}}</td>                    
                    <td>{{ $data->colectivo}}</td>                                        
                </tr>
            </tbody>
        </table>
    </div>    
    <h4>Clave</h4> 
    <div class="table-responsive">    
        <table class="table table-bordered table-striped table-hover">
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
                <tr>
                    <td>{{ $data->clave}}</td>
                    <td>{{ $data->contrato}}</td>
                    <td>{{ date("d-m-Y",strtotime($data->fecha_cita)) }}</td>   
                    <td>{{ $data->motivo}}</td>                                        
                    <td>{{ $data->observaciones}}</td>                                                            
                </tr>
            </tbody>
        </table>
    </div>     
  @endforeach 
    <h4>Detalle Clave</h4> 
    <div class="table-responsive">    
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>Servicio</th>
                    <th>Especialidad</th>
                    <th>Procedimiento</th>    
                    <th>Proveedor</th>   
                </tr>
            </thead>
            <tbody>
             @foreach ($clave_detalle as $detalle)       
                <tr>
                    <td>{{ $detalle->servicio}}</td>
                    <td>{{ $detalle->especialidad}}</td>
                    <td>{{ $detalle->procedimiento}}</td>                    
                    <td>{{ $detalle->proveedor}}</td>                    
                </tr>
             @endforeach    
            </tbody>
        </table>
    </div>         
     {!! Form::hidden('id_clave', $data->id_clave) !!}
     {!! Form::hidden('id_afiliado_temporal', $data->id_afiliado_temporal) !!}     
        <table>  
        <div class="form-group {{ $errors->has('rechazo') ? 'has-error' : ''}}">
            {!! Form::label('Motivo de Rechazo', 'Motivo de Rechazo: ', ['class' => 'col-sm-2 control-label']) !!}
            <div class="col-sm-8">
                {!! Form::textarea('rechazo', null, ['class' => 'form-control', 'rows' => '2', 'id' => 'rechazo']) !!}
                {!! $errors->first('rechazo', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
      </table>  

   <div class="form-group">    
      <div class="col-sm-offset-2 col-sm-3">  
          <p><a href="{{ url('claves/aprobarAfiliadosTemporales?id_afiliado_temporal='.$data->id_afiliado_temporal.'&id_clave='.$data->id_clave) }}"  class="btn btn-primary form-control ">Aprobar</a>
          </p>    
      </div>
        <div class="col-sm-offset-2 col-sm-3"><!--   -->
            {!! Form::submit('Rechazar', ['class' => 'btn btn-primary form-control']) !!}
        </div>
    </div>
@endif
{!! Form::close() !!}
@endsection
@section('script')
<script>
 $(document).ready(function() {
     $("#autorizarAfiliadosTemporales").submit(function(e){
         if ( $("#rechazo").val() == ''){
              $("#result").addClass("alert alert-danger");
              $("#result").html("Debe indicar un motivo de Rechazo."); 
              return false;
         }else{
                return true;
              }
     });
 });        
</script>
@endsection
