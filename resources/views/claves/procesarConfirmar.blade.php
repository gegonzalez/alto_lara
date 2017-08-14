@extends('layouts.app')
@section('title','Confirmación de Claves')
@section('content') 
{!! Form::open(['url' => 'claves/procesarConfirmar', 'class' => 'form-horizontal', 'name' => 'confirmarClave','id' => 'confirmarClave','lang' => 'es', 'data-parsley-validate' => '']) !!}
@foreach ($clave as $data_clave) 
<div class="modal fade" id="procesarConfirmar" role="dialog" tabindex="-1">
    <div class="modal-dialog" role="document" >
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Confirmar Clave</h4>
            </div>
            <div class="modal-body">
                <div class="form-group {{ $errors->has('cedula_afiliado') ? 'has-error' : ''}}">    
                    {!! Form::label('Cédula Afiliado : ', 'Cédula Afiliado : :', ['class' => 'col-sm-4 control-label']) !!}
                    <div class="col-sm-8">
                        {!! Form::text('cedula_afiliado', $data_clave->cedula_afiliado, ['class' => 'form-control', 'rows' => '1', 'id'=>'nombre_afiliado', 'disabled'] ) !!}
                        {!! $errors->first('cedula_afiliado', '<p class="help-block">:message</p>') !!}
                    </div>                
                </div>                  
                <div class="form-group {{ $errors->has('cedula_afiliado') ? 'has-error' : ''}}">    
                    {!! Form::label('Nombre Afiliado : ', 'Nombre Afiliado :', ['class' => 'col-sm-4 control-label']) !!}
                    <div class="col-sm-8">
                        {!! Form::text('nombre_afiliado', $data_clave->nombre, ['class' => 'form-control', 'rows' => '1', 'id'=>'nombre_afiliado', 'disabled'] ) !!}
                        {!! $errors->first('nombre_afiliado', '<p class="help-block">:message</p>') !!}
                    </div>                
                </div>                   
                <div class="form-group {{ $errors->has('tipo_afiliado') ? 'has-error' : ''}}">    
                    {!! Form::label('Tipo Afiliado : ', 'Tipo Afiliado :', ['class' => 'col-sm-4 control-label']) !!}
                    <div class="col-sm-8">
                        {!! Form::text('tipo_afiliado', $data_clave->tipo_afiliado, ['class' => 'form-control', 'rows' => '1', 'id'=>'tipo_afiliado', 'disabled'] ) !!}
                        {!! $errors->first('tipo_afiliado', '<p class="help-block">:message</p>') !!}
                    </div>                
                </div>                   
                 <div class="table-responsive">    
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th class="detalle">Servicio</th>
                                <th class="detalle">Especialidad</th>
                                <th class="detalle">Procedimiento</th>    
                                <th class="detalle">Proveedor</th>   
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
                <div class="form-group {{ $errors->has('idClave') ? 'has-error' : ''}}">
                    {!! Form::label('Clave : ', 'Clave:', ['class' => 'col-sm-2 control-label']) !!}
                    <div class="col-sm-8">
                        {!! Form::text('clave', null, ['class' => 'form-control', 'rows' => '2', 'id'=>'clave','required' => 'required','maxlength'=>"8", 'placeholder' => 'Clave' ]) !!}
                        {!! $errors->first('idClave', '<p class="help-block">:message</p>') !!}
                    </div>
                </div>
                <div class="form-group">    
                    <div class="col-sm-offset-2 col-sm-3">
                        {!! Form::submit('Confirmar', ['class' => 'btn btn-primary form-control']) !!}    
                    </div>
                    <div class="col-sm-offset-2 col-sm-3">  
                        <p><a href="{{url('claves/confirmar')}}"  class="btn btn-danger">Cancelar</a></p>    
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach 
{{ Form::close() }}
@endsection
@section('script')
<script>
    $('#procesarConfirmar').modal('show'); //show the modal
    $('#confirmarClave').parsley();
</script>
@endsection