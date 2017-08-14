@extends('layouts.app')
@section('title','Registrar Atención al Paciente')
@section('content') 
{!! Form::open(['url' => 'servicios/grabar', 'class' => 'form-horizontal', 'name' => 'fileupload','id' =>"fileupload",'method' => 'POST',
    'enctype' => 'multipart/form-data','files' => 'true']) !!}
<h4>Afiliado</h4>
    @if (isset($clave))
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
                        <td>{{date("d-m-Y",strtotime($data_clave->fecha_nacimiento))}}</td>
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
       {!! Form::hidden('cedula_afiliado', $data_clave->cedula_afiliado,['id' => 'cedula_afiliado']) !!} 
        @endforeach 
        <h4>Clave</h4>
        @foreach ($clave as $data_clave)    
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
                        <td>{{ $data_clave->clave}}</td>
                        <td>{{ $data_clave->contrato}}</td>
                        <td>{{date("d-m-Y",strtotime($data_clave->fecha_cita)) }}</td>                    
                        <td>{{ $data_clave->motivo}}</td>                                        
                        <td>{{ $data_clave->observaciones}}</td>                                                            
                    </tr>
                </tbody>
            </table>
        </div>     
        {!! Form::hidden('id_clave_detalle', $data_clave->id_clave_detalle,['id' => 'id_clave_detalle']) !!}   
        {!! Form::hidden('clave', $data_clave->clave,['id' => 'clave']) !!} 
        @endforeach 
        <div class="form-group {{ $errors->has('fecha_atencion') ? 'has-error' : ''}}">
            {!! Form::label('fecha_atencion', 'Fecha de Atención: ', ['class' => 'col-sm-2 control-label']) !!}
            <div class="col-sm-2">
               {!! Form::date('fecha_atencion', null, ['class' => 'form-control input-sm', 'required' => 'required','placeholder' => 'dd-mm-aaaa']) !!}
                {!! $errors->first('fecha_atencion', '<p class="help-block">:message</p>') !!}
            </div>
        </div>    
        <div class="form-group {{ $errors->has('patologia') ? 'has-error' : ''}}">
            {!! Form::label('patologia', 'Diagnostico: ', ['class' => 'col-sm-2 control-label']) !!}
            <div class="col-sm-8">
                {!! Form::textarea('patologia', null, ['class' => 'form-control', 'rows' => '2', 'required' => 'required']) !!}
                {!! $errors->first('patologia', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
            
        <br>
        <!-- The file upload form used as target for the file upload widget -->
        <!--<form id="fileupload" action="{{url('/')}}/MIRUTA" method="POST" enctype="multipart/form-data">-->
            <!-- Redirect browsers with JavaScript disabled to the origin page -->
            <noscript><input type="hidden" name="redirect" value="https://blueimp.github.io/jQuery-File-Upload/"></noscript>
            <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
            <div class="row fileupload-buttonbar">
                <div class="col-lg-7">
                    <!-- The fileinput-button span is used to style the file input field as button -->
                    <span class="btn btn-success fileinput-button">
                        <i class="glyphicon glyphicon-plus"></i>
                        <span>Agregar Archivos...</span>
                        <input type="file" name="files[]"  multiple>
                    </span>
                    <button type="submit" class="btn btn-primary start">
                        <i class="glyphicon glyphicon-upload"></i>
                        <span>Subir</span>
                    </button>
                    <button type="reset" class="btn btn-warning cancel">
                        <i class="glyphicon glyphicon-ban-circle"></i>
                        <span>Cancelar</span>
                    </button>
                    <button type="button" class="btn btn-danger delete">
                        <i class="glyphicon glyphicon-trash"></i>
                        <span>Eliminar</span>
                    </button>
                    <input type="checkbox" class="toggle">
                    <!-- The global file processing state -->
                    <span class="fileupload-process"></span>
                </div>
                <!-- The global progress state -->
                <div class="col-lg-5 fileupload-progress fade">
                    <!-- The global progress bar -->
                    <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                        <div class="progress-bar progress-bar-success" style="width:0%;"></div>
                    </div>
                    <!-- The extended global progress state -->
                    <div class="progress-extended">&nbsp;</div>
                </div>
            </div>
            <!-- The table listing the files available for upload/download -->
            <table role="presentation" class="table table-striped"><tbody class="files"></tbody></table>
<!--        </form>-->
        <br>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Consideraciones</h3>
            </div>
            <div class="panel-body">
                <ul>
                    <li>El tamaño máximo del archivo para subir es <strong>999 KB</strong>.</li>
                    <li>Sólo archivos (<strong> JPG, PNG, DOC, PDF, ZIP </strong>) están permitidos.</li>
                    <li>Puede usar <strong>arrastrar &amp; soltar</strong> en esta página.</li>
                </ul>
            </div>
        </div>
             <a class="upload-field-ids"></a>
        <div class="col-sm-offset-2 col-sm-3"><!--   -->
            {!! Form::submit('Registrar', ['class' => 'btn btn-primary form-control']) !!}
        </div>    
    @endif
    <!-- The blueimp Gallery widget -->
    <div id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls" data-filter=":even">
        <div class="slides"></div>
        <h3 class="title"></h3>
        <a class="prev">‹</a>
        <a class="next">›</a>
        <a class="close">×</a>
        <a class="play-pause"></a>
        <ol class="indicator"></ol>
    </div>
 {{ Form::close() }}   
@endsection
@section('script')
<!-- The File Upload user interface plugin -->
<script src="{{url('/')}}/js/main.js"></script>
<!-- The template to display files available for upload -->
<script id="template-upload" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-upload fade">
        <td>
            <span class="preview"></span>
        </td>
        <td>
            <p class="name">{%=file.name%}</p>
            <strong class="error text-danger"></strong>
        </td>
        <td>
            <p class="size">Procesando...</p>
            <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="progress-bar progress-bar-success" style="width:0%;"></div></div>
        </td>
        <td>
            {% if (!i && !o.options.autoUpload) { %}
                <button class="btn btn-primary start" disabled>
                    <i class="glyphicon glyphicon-upload"></i>
                    <span>Iniciar</span>
                </button>
            {% } %}
            {% if (!i) { %}
                <button class="btn btn-warning cancel">
                    <i class="glyphicon glyphicon-ban-circle"></i>
                    <span>Cancelar</span>
                </button>
            {% } %}
        </td>
    </tr>
{% } %}
</script>
<!-- The template to display files available for download -->
<script id="template-download" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-download fade">
        <td>
            <span class="preview">
                {% if (file.thumbnailUrl) { %}
                    <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" data-gallery><img src="{%=file.thumbnailUrl%}"></a>
                {% } %}
            </span>
        </td>
        <td>
            <p class="name">
                {% if (file.url) { %}
                    <a href="{%=file.url%}"  title="{%=file.name%}" download="{%=file.name%}" {%=file.thumbnailUrl?'data-gallery':''%}>{%=file.name%}</a>
                    <input type="hidden" name="fileid[]" id= "fileid[]" value="{%=file.name%}">                                    
                {% } else { %}
                    <span>{%=file.name%}</span>
                {% } %}
            </p>
            {% if (file.error) { %}
                <div><span class="label label-danger">Error</span> {%=file.error%}</div>
            {% } %}            
        </td>
        <td>    
          {!! Form::select('tipo_documentos[]', $tipo_documentos, [''=>'Seleccione una opción'] , ['class' => 'form-control', 'placeholder' => 'Seleccione una opción','required' => 'required'] ) !!}
        </td>
        <td>
            <span class="size">{%=o.formatFileSize(file.size)%}</span>
        </td>
        <td>
            {% if (file.deleteUrl) { %}
                <button class="btn btn-danger delete" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}"{% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
                    <i class="glyphicon glyphicon-trash"></i>
                    <span>Eliminar</span>
                </button>
                <input type="checkbox" name="delete" value="1" class="toggle">
            {% } else { %}
                <button class="btn btn-warning cancel">
                    <i class="glyphicon glyphicon-ban-circle"></i>
                    <span>Cancelar</span>
                </button>
            {% } %}
        </td>
    </tr>
{% } %}
</script>
<script>
 $(function(){
     $("#fecha_atencion" ).datepicker({ minDate: -5, maxDate: "+5D", dateFormat: "dd-mm-yy" });
   }
 );
 </script>   

@endsection
