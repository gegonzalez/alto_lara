@extends('layouts.app')
@section('title','Tratamientos Realizados')
@section('content')
	<hr/>
    @if (isset($beneficiario))
    <h4>Datos del Beneficiario</h4>
        <div class="table">
            <table class="table table-bordered table-striped table-hover table-responsive">
                <thead>
                    <tr>
                        <th>Cédula</th><th>Nombre</th>
                        <th>Tipo</th><th>Cobertura del Plan</th><th>Colectivo</th><th>Aseguradora</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $beneficiario['cedula_afiliado'] }}</td>
                        <td>{{ $beneficiario['nombre_afiliado'] }}</td>
                        <td>{{ $beneficiario['tipo_afiliado'] }}</td>
                        <td>{{ $beneficiario['plan'] }}</td>
                        <td>{{ $beneficiario['colectivo'] }}</td>
                        <td>{{ $beneficiario['aseguradora'] }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    @endif
    <h4>Datos del tratamiento</h4>

    {!! Form::open(['url' => 'tratamiento/procesar', 'class' => 'form-horizontal', 
    		'id' => 'procesar', 'name' => 'procesar', 
    		'lang' => 'es', 'data-parsley-validate' => '']) !!}
		<div class="form-group {{ $errors->has('fecha_atencion') ? 'has-error' : ''}}">
        	{!! Form::label('fecha_atencion', 'Fecha de Atención: ', ['class' => 'col-sm-2 control-label']) !!}
			<div class="col-sm-3">
	            {!! Form::text('fecha_atencion', null, ['class' => 'form-control input-sm', 'placeholder' => 'dd-mm-aaaa']) !!}
	            {!! $errors->first('fecha_atencion', '<p class="help-block">:message</p>') !!}
	        </div>
		</div>
		<div class="form-group {{ $errors->has('id_tratamiento') ? 'has-error' : ''}}">
        	{!! Form::label('id_procedimiento', 'Tratamiento realizado: ', ['class' => 'col-sm-2 control-label']) !!}
	        <div class="col-sm-6">
				<div id='div_procedimiento_odontologico'>
	                {!! Form::select('id_procedimiento',$procedimientos,null, ['class' => 'form-control']) !!}
	                {!! Form::hidden('dientes', null, ['id' => 'diente']) !!}
	                {!! Form::hidden('idientes', null, ['id' => 'idiente']) !!}
	                {!! Form::hidden('bandera', null, ['id' => 'bandera']) !!}
	                {!! Form::hidden('fecha_proxima', null, ['id' => 'fecha_proxima']) !!}
        			{!! Form::hidden('max', 0, ['class' => 'form-control', 'required' => 'required','id' => 'max']) !!}
    				{!! Form::hidden('iclave',  $beneficiario['iclave']  )  !!}

	            </div>
		            {!! $errors->first('id_procedimiento', '<p class="help-block">:message</p>') !!}
			</div>
		</div>
		<div class="form-group">
		<div class="col-md-12">
			<table class="table">
		        <tbody>		        
			        <tr>
			        	<td class="text-right" > 
			        		@foreach ($dientes1 as $diente)
								<button class="btn btn-primary diente" value="{{ $diente->descripcion }}" id="diente_{{ $diente->id }}"
									type="button" onclick="disableDiente(this.id, this.value, true)" > {{ $diente->descripcion }} </button>
							@endforeach
			        	</td>
			        	<td>
			        		@foreach ($dientes2 as $diente)
								<button class="btn btn-primary diente" value="{{ $diente->descripcion }}" id="diente_{{ $diente->id }}"
									type="button" onclick="disableDiente(this.id, this.value, true)" > {{ $diente->descripcion }} </button>
							@endforeach
			        	</td>
			        </tr>
			        <tr>
			        	<td class="text-right">
			        		@foreach ($dientes3 as $diente)
			        			<button class="btn btn-primary diente" value="{{ $diente->descripcion }}" id="diente_{{ $diente->id }}"
									type="button" onclick="disableDiente(this.id, this.value, true)" > {{ $diente->descripcion }} </button>
							@endforeach
			        	</td>
			        	<td>
			        		@foreach ($dientes4 as $diente)
			        			<button class="btn btn-primary diente" value="{{ $diente->descripcion }}" id="diente_{{ $diente->id }}"
									type="button" onclick="disableDiente(this.id, this.value, true)" > {{ $diente->descripcion }} </button>
							@endforeach
			        	</td>
			        </tr>
			        <tr>
			        	<td class="text-right">
			        		@foreach ($dientes5 as $diente)
								<button class="btn btn-warning diente" value="{{ $diente->descripcion }}" id="diente_{{ $diente->id }}"
									type="button" onclick="disableDiente(this.id, this.value, true)" > {{ $diente->descripcion }} </button>
							@endforeach
			        	</td>
			        	<td>
			        		@foreach ($dientes6 as $diente)
			        			<button class="btn btn-warning diente" value="{{ $diente->descripcion }}" id="diente_{{ $diente->id }}"
									type="button" onclick="disableDiente(this.id, this.value, true)" > {{ $diente->descripcion }} </button>
							@endforeach
			        	</td>
			        </tr>
			        <tr>
			        	<td class="text-right">
			        		@foreach ($dientes7 as $diente)
			        			<button class="btn btn-warning diente" value="{{ $diente->descripcion }}" id="diente_{{ $diente->id }}"
									type="button" onclick="disableDiente(this.id, this.value, true)" > {{ $diente->descripcion }} </button>
							@endforeach
			        	</td>
			        	<td>
			        		@foreach ($dientes8 as $diente)
			        			<button class="btn btn-warning diente" value="{{ $diente->descripcion }}" id="diente_{{ $diente->id }}"
									type="button" onclick="disableDiente(this.id, this.value, true)" > {{ $diente->descripcion }} </button>
							@endforeach
			        	</td>
			        </tr>
			        <tr>
			        	<td class="text-center" >
			        		<button class="btn btn-danger diente" value="todos" id="diente_0" 
			        			type="button" onclick="disableDiente(this.id, this.value, true)"> Todos </button>						
			        	</td>
			        	<td class="text-center" >
			        		<button class="btn btn-danger diente" value="0" id="diente_0" 
			        			type="button" onclick="disableDiente(this.id, this.value, false)"> Corregir </button>						
			        	</td>
			        </tr>
				</tbody>
			</table>
	    </div>
	    </div>
		<div class="form-group {{ $errors->has('ubicacion') || $errors->has('telefono') ? 'has-error' : ''}}">
        	{!! Form::label('ubicacion', 'Ubicación: ', ['class' => 'col-sm-2 control-label']) !!}
			<div class="col-sm-3">
            	{!! Form::select('ubicacion', $cara, null, ['class' => 'form-control input-sm', 'required' => 'required','id' => 'ubicacion']) !!}
	    	</div>
	    	{!! Form::label('telefono', 'Teléfono Móvil: ', ['class' => 'col-sm-2 control-label']) !!}
            <div class="col-sm-3">
                {!! Form::text('telefono', null, ['class' => 'form-control', 'required' => 'required','placeholder' => '04XX-1234567','pattern' => '\b04\d{2}[-]{1}\d{7}\b']) !!}
                {!! $errors->first('telefono', '<p class="help-block">:message</p>') !!}
            </div>
	    </div>

	    <div class="form-group {{ $errors->has('observasion') ? 'has-error' : ''}}">
        	{!! Form::label('observasion', 'Observación: ', ['class' => 'col-sm-2 control-label']) !!}
			<div class="col-md-8">
            	{!! Form::textarea('observasion', null, ['class' => 'form-control input-sm', 'required' => 'required','id' => 'observacion']) !!}
	    	</div>
	    </div>

		<div class="form-group">
	        <div class="col-sm-3 col-sm-offset-2">
	            <button type="button" class="btn btn-sm btn-info btn-add-tratamiento">Agregar Procedimiento</button>
	        </div>
	    </div>
	    <div class="col-md-12">
	    	<table id="tratamientos" class='table table-bordered table-striped table-hover'>
		        <thead>
		            <tr>
		                <th>Fecha Atencion</th>
		                <th>Procedimiento</th>
		                <th>Diente</th>
		                <th>Ubicación</th>
		                <th></th>
		            </tr>
		        </thead>
		        <tbody></tbody>
		    </table>
	    </div>
	    <div class="form-group">
	        <div class="col-sm-offset-2 col-sm-3">
	            {!! Form::submit('Cargar Tratamiento', ['class' => 'btn btn-primary form-control', 'disabled' => 'disabled', 'id' => 'enviar']) !!}
	        </div>
	    </div>

    {!! Form::close() !!}

@endsection
@section('script')
    <script>
        $(function(){
            $( "#fecha_atencion" ).datepicker({ maxDate: "+0D", minDate: "-15D"
                //, dateFormat: "dd-mm-yy" 
            });
            $('#procesar').parsley();

            var x = 0;

	        $('.btn-add-tratamiento').on('click', function(){
	            if($('#fecha_atencion').val()!== "" && $('#id_procedimiento').val() !== "" && $('#diente').val() !== "" && $('#ubicacion').val() !== ""){
	            	var data = {
                        'id_cedula'  : {{ $beneficiario['cedula_afiliado'] }},
                        '_token': $('[name="_token"]').val()
                    };

	            	$.post("{{url('tratamiento/realizados')}}", data, function(response, callback){
			        	
	            		//console.log(response)
			        	$.each(response, function( key, value){
				        	if( //$('#idiente').val() == value.id_diente 
				        		($('#idiente').val() == value.id_diente && $('#id_procedimiento').val() == value.id_procedimiento) 
				        		|| ($('#idiente').val() == value.id_diente && $('#ubicacion').val() == value.id_ubicacion) 
							  )
				        	{
				        		$('#bandera').val('1');
				        		$('#fecha_proxima').val(value.fecha_atencion)
			        		}
			        	});

		        		if($('#bandera').val() == 0){
			                var fecha_atencion  = "<input type='hidden' value='"+ $('#fecha_atencion').val() +"' name='fecha_atencion"+x+"' id='fecha_atencion"+x+"'>";
			                var procedimiento  	= "<input type='hidden' value='"+ $('#id_procedimiento').val() +"' name='id_procedimiento"+x+"' id='id_procedimiento"+x+"'>";
			                var diente 			= "<input type='hidden' value='"+ $('#idiente').val() +"' name='diente"+x+"' id='diente"+x+"'>";
			                var ubicacion 		= "<input type='hidden' value='"+ $('#ubicacion').val() +"' name='id_ubicacion"+x+"' id='id_ubicacion"+x+"'>";

			                $('#tratamientos').append(
			                		"<tr class='fila" + x +"'>"+
								    "<td>"+$("#fecha_atencion").val()+"</td>"+
			                        "<td>"+$("#id_procedimiento option:selected").text()+"</td>"+
			                        "<td>"+$("#diente").val()+"</td>"+
			                        "<td>"+$("#ubicacion option:selected").text()+"</td>"+
			                        "<td><button type='button' class='btn btn-sm btn-danger btn-del-procedimiento'"+
			                        ">Quitar</button></td>"
			                        +fecha_atencion+procedimiento+diente+ubicacion+"</tr>"
			                );
			            	
			            	x++;

			            	disableDiente('diente_0', '', false);
			            	$('#enviar').attr('disabled', false);
			        		//$('#diente').val('');
		                    $('#max').val(x);
		            	}
		            	else{
		            		$("#result").addClass("alert alert-danger");
		                	$("#result").html("Usted ya posee un tratamiento en el diente seleccionado en fecha "+$('#fecha_proxima').val()+', debe esperar seis meses para poder registrar el mismo diente');
		            	}	
		            	
			        });

	            	
	            }
	            else{
	                $("#result").addClass("alert alert-danger");
	                $("#result").html("Verifique que no falte un campo por seleccionar.");
	            }
	        });

			$('table').on('click', '.btn-del-procedimiento', function(){
                $(this).closest('tr').remove();
                $('#max').val($('#max').val()-1);
                if($('#max').val() == 0){
                    proveedorX = '';
                    $('#enviar').attr('disabled', true);
                }
            });
			

        });
        

        function disableDiente(id, value,  bol)
        {
        	id = id.replace('diente_', '');
        	for (var i=0; i<=52; i++){
        		if(id != i){
        			$('#diente_'+i).attr('disabled', bol);
        			$('#diente').val(value);
        			$('#idiente').val(id);
        			$('#bandera').val('');
        			if(id == 0){
        				$('#ubicacion').attr('disabled', bol);
        				$('#diente_0').attr('disabled', bol);
        				$('#ubicacion').val(7);
        				if(value == 'todos'){
        					$('#diente').val('Todos');
        				}
        				else{
        					$('#diente').val('');
        				}
        			}
        			
        		}        		
        	}
        }


    </script>


 
@endsection