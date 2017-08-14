<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link href="{{url('/')}}/css/pdf.css" rel="stylesheet">
    <title>Detalle de Clave Temporal</title>
  </head>
  <body>
  <div>
     <img src="images/altocentro.png" style="width:200px"/>
  </div>    
<h1>Claves de Atención Temporales</h1>
<h4>Afiliado</h4>
@if (isset($clave))
    <?php
         $user = Auth::user();
         $user_type =  $user->type;
    ?>   
    @foreach ($clave as $data_clave)       
    <table border="1" cellspacing="0" cellpadding="0">
	<tr>
             <th>Cédula del Afiliado</th>
             <td class="clave">{{ $data_clave->cedula_afiliado}}</td> 
        </tr>
	<tr>
              <th>Nombre</th>
	     <td class="clave">{{ $data_clave->nombre}}</td>
        </tr>
	<tr>
             <th>Fecha de Nacimiento</th>
            <td class="clave">{{ date("d-m-Y",strtotime($data_clave->fecha_nacimiento)) }}</td> 
        </tr>
      	<tr>
             <th>Email</th>
	     <td class="clave">{{ $data_clave->email}}</td>
        </tr>
        <tr>
             <th>Sexo</th>
	     @if ($data_clave->sexo == 'M')
                      <td class="clave">Masculino</td>
                    @endif
             @if ($data_clave->sexo == 'F')
                      <td class="clave">Femenino</td>
             @endif
        </tr>
	<tr>
             <th>Télefono</th>
	     <td class="clave">{{ $data_clave->telefono}}</td>
        </tr>
    </table>
    @endforeach   
 <h4>Clave</h4> 
    @foreach ($clave as $data_clave)    
    <div class="table-responsive">    
        <table  border="1" cellspacing="0" cellpadding="0">
            <tr>
                <th>Clave</th>
                <td class="clave">{{ $data_clave->clave}}</td> 
            </tr>
            <tr>
                <th>Fecha Cita</th>
                <td class="clave">{{ date("d-m-Y",strtotime($data_clave->fecha_cita)) }}</td> 
            </tr>    
            <tr>
                <th>Motivo</th>
                <td class="clave">{{ $data_clave->motivo}}</td> 
            </tr>    
            <tr>
                <th>Observaciónes</th>
                <td class="clave">{{ $data_clave->observaciones}}</td> 
            </tr>    
        </table>
    </div>     
  @endforeach  
<h4>Detalle Clave</h4> 
    <div class="table-responsive">    
        <table  border="1" cellspacing="0" cellpadding="0">
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
                    <td class="td_left">{{ $detalle->servicio}}</td>
                    <td class="td_left">{{ $detalle->especialidad}}</td>
                    <td class="td_left">{{ $detalle->procedimiento}}</td>                    
                    <td class="td_left">{{ $detalle->proveedor}}</td>                    
                </tr>
             @endforeach    
            </tbody>
        </table>
    </div>   
@endif
</body>
</html>