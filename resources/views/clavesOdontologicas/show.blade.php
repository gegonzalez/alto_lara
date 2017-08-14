@extends('layouts.app')
@section('title','Detalle Clave Odontológica')
@section('content') 
<h4>Beneficiario</h4>
@if (isset($clave))
<?php
     $user = Auth::user();
     $user_type =  $user->type;
?>   
    @foreach ($clave as $data_clave)    
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
                    <td>{{ $data_clave->cedula_afiliado}}</td>
                    <td>{{ $data_clave->nombre}}</td>
                    <td>{{ date("d-m-Y",strtotime($data_clave->fecha_nacimiento)) }}</td>
                    @if ($data_clave->sexo == 'M')
                      <td>Masculino</td>
                    @endif
                    @if ($data_clave->sexo == 'F')
                      <td>Femenino</td>
                    @endif
                    <td>{{ $data_clave->telefono}}</td>                                                            
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
                    <td>{{ $data_clave->cedula_titular}}</td>
                    <td>{{ $data_clave->nombre_titular}}</td>
                    <td>{{ $data_clave->aseguradora}}</td>                    
                    <td>{{ $data_clave->colectivo}}</td>                                        
                </tr>
            </tbody>
        </table>
    </div>    
    @endforeach 
    <h4>Clave</h4>
    @foreach ($clave as $data_clave)    
    <div class="table-responsive">    
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                 @if($user_type != 3 )
                    <th>Clave</th>
                 @endif   
                    <th>Contrato</th>
                    <th>Fecha de Atención</th>                    
                    <th>Motivo</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                  @if($user_type != 3 )
                    <td>{{ $data_clave->clave}}</td>
                  @endif     
                    <td>{{ $data_clave->contrato}}</td>
                    <td>{{ date("d-m-Y",strtotime($data_clave->fecha_cita)) }}</td>                    
                    <td>{{ $data_clave->motivo}}</td>
                </tr>
            </tbody>
        </table>
    </div>     
    {!! Form::hidden('id_clave', $data_clave->id_clave) !!}
    <?php $id_clave =  $data_clave->id_clave; ?>
    @endforeach 
@endif
@endsection