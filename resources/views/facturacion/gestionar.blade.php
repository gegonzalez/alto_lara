@extends('layouts.app')
@section('title','Facturación y Cierres de Caso')
@section('content')
<hr/>

<div id="tipo_facturacion" class="col-md-12">
    <h4>Consulta de Claves Otorgadas</h4>

    <div class="form-group">
        <div class="col-md-2">
            <label>Individual:</label>
        </div>
        <div class="col-md-1">
            <input type="radio" name="tipo" id="tipo1" value="individual" >
        </div>
        <div class="col-md-2">
            <label>Global:</label>
        </div>
        <div class="col-md-1">
            <input type="radio" name="tipo" id="tipo2" value="global">
        </div>      
    </div>   
</div>
<div id="form" class="col-md-12">
    {!! Form::open(['url' => 'facturacion/buscar',  'class' => 'form-horizontal', 'name' => 'buscar', 'method' => 'POST']) !!}
        <div id="tipo_individual" hidden="true" class="form-group {{ $errors->has('clave_buscar') || $errors->has('fecha') ? 'has-error' : ''}}">
            {!! Form::label('clave_buscar', 'Clave: ', ['class' => 'col-sm-2 control-label']) !!}
            <div class="col-sm-3">
                {!! Form::text('clave_buscar', null, ['class' => 'form-control input-sm', 'placeholder' => 'xLhjmh']) !!}
                {!! $errors->first('clave_buscar', '<p class="help-block">:message</p>') !!}
            </div>
            {!! Form::label('fecha', 'Fecha: ', ['class' => 'col-sm-2 control-label']) !!}
            <div class="col-sm-3">
                {!! Form::date('fecha', null, ['class' => 'form-control input-sm', 'placeholder' => 'dd-mm-aaaa']) !!}
                {!! $errors->first('fecha', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
        <div id="tipo_global" hidden="true" class="form-group {{ $errors->has('clave_buscar') || $errors->has('fecha_desde') || $errors->has('fecha_hasta')? 'has-error' : ''}}">
            {!! Form::label('fecha_desde', 'Fecha desde: ', ['class' => 'col-sm-3 control-label']) !!}
            <div class="col-sm-3">
                {!! Form::date('fecha_desde', null, ['class' => 'form-control input-sm', 'placeholder' => 'dd-mm-aaaa']) !!}
                {!! $errors->first('fecha_desde', '<p class="help-block">:message</p>') !!}
            </div>
            {!! Form::label('fecha_hasta', 'Fecha hasta: ', ['class' => 'col-sm-3 control-label']) !!}
            <div class="col-sm-3">
                {!! Form::date('fecha_hasta', null, ['class' => 'form-control input-sm', 'placeholder' => 'dd-mm-aaaa']) !!}
                {!! $errors->first('fecha_hasta', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
        <div id="boton_buscar" class="form-group" hidden="true">
            <div class="col-sm-offset-2 col-sm-4"><!--   -->
                {!! Form::submit('Buscar', ['class' => 'btn btn-primary form-control', 'id' => 'buscar']) !!}
            </div>
        </div>
    {!! Form::close() !!}
    <div id="consulta" >
        @if(isset($claves) || isset($cartas))
            {!! Form::open(['url' => 'facturacion/crear', 'class' => 'form-horizontal',  'name' => 'fileupload','id' =>"fileupload",
                    'method' => 'POST', 'enctype' => 'multipart/form-data', 'files' => 'true']) !!}
                <div class="table col-md-12">
                    <table class="table table-bordered table-striped table-hover table-responsive">
                        <thead>
                            <tr>
                                <th>Fecha</th><th>Clave</th>
                                <th>Cedula</th><th>Paciente</th><th>Especialidad</th>
                                <th>Servicio</th><th>Estatus</th><th>Tipo</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($claves) and (count($claves) > 0))
                                @foreach($claves as $clave)
                                    <tr>
                                        <td>{{$clave->fecha_cita}}</td>
                                        <td>{{$clave->clave}}</td>
                                        <td>{{$clave->cedula_afiliado}}</td>
                                        <td>{{$clave->nombre}} {{$clave->apellido}}</td>
                                        <td>{{$clave->especialidad }}</td>
                                        <td>{{$clave->tipo_examen}}</td>
                                        <td>{{$clave->estatus}}</td>
                                        <td> Clave </td>
                                        <td>
                                            @if($tipo == 'individual')
                                                {!! Form::radio('id_clave', $clave->id, null, ['id' => 'id_clave']) !!}
                                            @else
                                                {!! Form::checkbox('id_clave[]', $clave->id, null, ['id' => 'id_clave']) !!}
                                            @endif
                                        </td>

                                    </tr>
                                @endforeach
                            @endif
                            @if(isset($cartas) and (count($cartas) > 0))
                                @foreach($cartas as $carta)
                                    <tr>
                                        <td>{{$carta->fecha_solicitud}}</td>
                                        <td>{{$carta->clave}}</td>
                                        <td>{{$carta->cedula_afiliado}}</td>
                                        <td>{{$carta->nombre}} {{$carta->apellido}}</td>
                                        <td>{{$carta->especialidad }}</td>
                                        <td>{{$carta->tipo_examen}}</td>
                                        <td>{{$carta->estatus}}</td>
                                        <td> Carta aval </td>
                                        <td>
                                           @if($tipo == 'individual')
                                                {!! Form::radio('id_aval', $carta->id, null, ['id' => 'id_clave']) !!}
                                            @else
                                                {!! Form::checkbox('id_aval[]', $carta->id, null, ['id' => 'id_clave']) !!}
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @endif

                        </tbody>
                    </table>
                </div>
                <div id="datos_factura">
                    <div class="form-group {{ $errors->has('numero_factura') || $errors->has('numero_control')}}">
                        {!! Form::label('numero_factura', 'Nro Factura: ', ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-3">
                            {!! Form::number(
                                'numero_factura', null, ['class' => 'form-control', 
                                'required' => 'required','placeholder' => '156780'] )
                            !!}
                        </div>
                        {!! Form::label('numero_control', 'Nro Control: ', ['class' => 'col-sm-2 control-label']) !!}
                        <div class="col-sm-3">
                            {!! Form::number(
                                'numero_control', null, ['class' => 'form-control', 
                                'required' => 'required','placeholder' => '78940'] )
                            !!}
                        </div>
                    </div>
                    <div class="form-group {{ $errors->has('fecha_factura') || $errors->has('monto')}}">
                        {!! Form::label('fecha_factura', 'Fecha Factura: ', ['class' => 'col-sm-3 control-label']) !!}
                        <div class="col-sm-3">
                            {!! Form::date(
                                'fecha_factura', null, ['class' => 'form-control', 
                                'required' => 'required','placeholder' => 'dd-mm-yy'] )
                            !!}
                        </div>
                        {!! Form::label('monto', 'Monto: ', ['class' => 'col-sm-2 control-label']) !!}
                        <div class="col-sm-3">
                            {!! Form::number(
                                'monto', null, ['class' => 'form-control', 
                                'required' => 'required','placeholder' => '10000'] )
                            !!}
                        </div>
                    </div>
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
                    <li>Sólo archivos (<strong> ZIP </strong>) están permitidos.</li>
                    <li>Puede usar <strong>arrastrar &amp; soltar</strong> en esta página.</li>
                </ul>
            </div>
        </div>
        <a class="upload-field-ids"></a>
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
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-4"><!--   -->
                            {!! Form::submit('Generar facturación', ['class' => 'btn btn-primary form-control', 'id' => 'enviar_clave']) !!}
                        </div>
                    </div>
                </div>
        @endif          
    </div>
</div>
{!! Form::close() !!}   
@endsection

@section('script')
<!-- The File Upload user interface plugin -->
<script src="{{url('/')}}/js/main.js"></script>
<!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->  
    <!-- The Templates plugin is included to render the upload/download listings -->
    <script src="//blueimp.github.io/JavaScript-Templates/js/tmpl.min.js"></script>
    <!-- The Load Image plugin is included for the preview images and image resizing functionality -->
    <script src="//blueimp.github.io/JavaScript-Load-Image/js/load-image.all.min.js"></script>
    <!-- The Canvas to Blob plugin is included for image resizing functionality -->
    <script src="//blueimp.github.io/JavaScript-Canvas-to-Blob/js/canvas-to-blob.min.js"></script>    
    <!-- blueimp Gallery script -->
    <!--<script src="//blueimp.github.io/Gallery/js/jquery.blueimp-gallery.min.js"></script>-->
    <script src="{{url('/')}}/js/blueimp-gallery.min.js"></script>
    <!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
    <script src="{{url('/')}}/js/jquery.iframe-transport.js"></script>
    <!-- The basic File Upload plugin -->
    <script src="{{url('/')}}/js/jquery.fileupload.js"></script>
    <!-- The File Upload processing plugin -->
    <script src="{{url('/')}}/js/jquery.fileupload-process.js"></script>
    <!-- The File Upload image preview & resize plugin -->
    <script src="{{url('/')}}/js/jquery.fileupload-image.js"></script>
    <!-- The File Upload audio preview plugin -->
    <script src="{{url('/')}}/js/jquery.fileupload-audio.js"></script>
    <!-- The File Upload video preview plugin -->
    <script src="{{url('/')}}/js/jquery.fileupload-video.js"></script>
    <!-- The File Upload validation plugin -->
    <script src="{{url('/')}}/js/jquery.fileupload-validate.js"></script>
    <!-- The File Upload user interface plugin -->
    <script src="{{url('/')}}/js/jquery.fileupload-ui.js"></script>    
    <!-- The XDomainRequest Transport is included for cross-domain file deletion for IE 8 and IE 9 -->
    <!--[if (gte IE 8)&(lt IE 10)]>
    <script src="{{url('/')}}/js/cors/jquery.xdr-transport.js"></script>
    <![endif]-->
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
            $('#fecha_desde, #fecha_hasta, #fecha_factura, #fecha').datepicker({dateFormat: "yy-mm-dd"});
            $('#tipo1').on('click', function(){
                $('#tipo_individual, #boton_buscar').show(true);
                $('#tipo_global').hide();
                $('#fecha_desde').attr('disabled', true);
                $('#fecha_hasta').attr('disabled', true);
                
                $('#clave').attr('disabled', false);
                $('#fecha').attr('disabled', false);
            });
            
            $('#tipo2').on('click', function(){
                $('#tipo_global, #boton_buscar').show(true);
                $('#tipo_individual').hide();
                $('#clave').attr('disabled', true);
                $('#fecha').attr('disabled', true);
                
                $('#fecha_desde').attr('disabled', false);
                $('#fecha_hasta').attr('disabled', false);
            });
        });
</script>
@endsection


