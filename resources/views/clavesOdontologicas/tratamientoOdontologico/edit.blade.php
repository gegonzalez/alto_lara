@extends('layouts.app')
@section('title','Tratamientos Realizados')
@section('content')
	<hr/>
@if (isset($beneficiario))
    <div class="col-md-12">
        <div class="table">
            <table class="table table-bordered table-striped table-hover table-responsive">
                <thead>
                    <tr>
                        <th>Cédula</th><th>Nombre</th><th>Tipo</th><th>Cobertura del Plan</th><th>Colectivo</th><th>Aseguradora</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $beneficiario[0]->cedula_afiliado }}</td>
                        <td>{{ $beneficiario[0]->nombre_afiliado}}</td>
                        <td>{{ $beneficiario[0]->tipo_afiliado }}</td>
                        <td>{{ $beneficiario[0]->plan }}</td>
                        <td>{{ $beneficiario[0]->colectivo }}</td>
                        <td>{{ $beneficiario[0]->aseguradora }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endif
<div id="tratamiento">
	<h4>Datos del tratamiento</h4>
    {!! Form::model($tratamiento, [
    	'url' => ['tratamiento/update', $tratamiento->id ] ,
    	'class' => 'form-horizontal', 
    	'name' => 'tratamientoEdit']
    ) !!}
    	<div class="form-group {{ $errors->has('fecha_atencion') ? 'has-error' : ''}}">
        	{!! Form::label('fecha_atencion', 'Fecha de Atención: ', ['class' => 'col-sm-2 control-label']) !!}
			<div class="col-sm-3">
	            {!! Form::date('fecha_atencion', $tratamiento->fecha_atencion, ['class' => 'form-control input-sm', 'required' => 'required','placeholder' => 'dd-mm-aaaa']) !!}
	            {!! $errors->first('fecha_atencion', '<p class="help-block">:message</p>') !!}
	        </div>
		</div>
		<div class="form-group {{ $errors->has('id_procedimiento') ? 'has-error' : ''}}">
        	{!! Form::label('id_procedimiento', 'Tratamiento Realizado: ', ['class' => 'col-sm-2 control-label']) !!}
	        <div class="col-sm-6">
				<div id='div_procedimiento_odontologico'>
		            {!! Form::select('id_procedimiento', $procedimientos, null, ['class' => 'form-control']) !!}
		            {!! $errors->first('id_procedimiento', '<p class="help-block">:message</p>') !!}
	            </div>
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
				        		<button class="btn btn-danger diente" value="0" id="diente_00" 
				        			type="button" onclick="disableDiente(this.id, this.value, false)"> Corregir </button>						
				        	</td>
				        </tr>
					</tbody>
				</table>
		    </div>
	    </div>
	    <div class="form-group {{ $errors->has('id_ubicacion') ? 'has-error' : ''}}">
        	{!! Form::label('id_ubicacion', 'Tratamiento Realizado: ', ['class' => 'col-sm-2 control-label']) !!}
	        <div class="col-sm-6">
		            {!! Form::select('id_ubicacion', $ubicacion, null, ['class' => 'form-control']) !!}
		            {!! $errors->first('id_ubicacion', '<p class="help-block">:message</p>') !!}
			</div>
		</div>
	    <div class="form-group {{ $errors->has('observaciones') ? 'has-error' : ''}}">
        	{!! Form::label('observaciones', 'Observaciones: ', ['class' => 'col-sm-2 control-label']) !!}
			<div class="col-sm-10">
            	{!! Form::textarea('observaciones', $tratamiento->observaciones, ['class' => 'form-control input-sm', 'required' => 'required','id' => 'observaciones']) !!}
		        {!! $errors->first('observaciones', '<p class="help-block">:message</p>') !!}
	    	</div>
	    </div>
	    <div class="form-group {{ $errors->has('telefono')}}">
            {!! Form::label('telefono', 'Teléfono Móvil: ', ['class' => 'col-sm-2 control-label']) !!}
            <div class="col-sm-3	">
                {!! Form::text('telefono', $tratamiento->telefono, ['class' => 'form-control', 'required' => 'required','placeholder' => '04XX-1234567','pattern' => '\b04\d{2}[-]{1}\d{7}\b']) !!}
                {!! $errors->first('telefono', '<p class="help-block">:message</p>') !!}
            </div>
            {!! Form::hidden('dientes', $tratamiento->acDiente->descripcion, ['id' => 'diente']) !!}
            {!! Form::hidden('id_diente',$tratamiento->id_diente, ['id' => 'id_diente']) !!}
        </div>
        <div class="form-group">
	        <div class="col-sm-offset-2 col-sm-3">
	            {!! Form::submit('Editar', ['class' => 'btn btn-primary form-control', 'id' => 'enviar']) !!}
	        </div>
	    </div>
    {!! Form::close() !!}
</div>


@endsection
@section('script')
    <script>
        var diente = $('#diente').val();
        var idDiente = $('#id_diente').val();

	    disableDiente('diente_'+idDiente, diente, true);

        function disableDiente(id, value,  bol)
        {
        	id = id.replace('diente_', '');
        	for (var i=0; i<=52; i++){
        		if(id != i){
        			$('#diente_'+i).attr('disabled', bol);
        			$('#diente').val(value);
        			$('#id_diente').val(id);
        			if(id == 0){
        				$('#id_ubicacion').attr('readonly', bol);
        				$('#diente_0').attr('disabled', false);
        				$('#id_ubicacion').val(7);
        				
        			}
        			
        		}        		
        	}
        }
    </script>


 
@endsection