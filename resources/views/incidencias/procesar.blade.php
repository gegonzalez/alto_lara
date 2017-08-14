@extends('layouts.app')
@section('title','Incidencias')
@section('content')
{!! Form::open(['url' => 'incidencias/gestionar', 'class' => 'form-horizontal',  'name' => 'fileupload','id' =>"fileupload",
                'method' => 'POST', 'enctype' => 'multipart/form-data', 'files' => 'true']) !!}
@if (isset($factura))
    <h4>Datos Factura</h4>   
    <div class="table-responsive">    
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>Proveedor</th>
                    <th>Documentos</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{$factura->acProveedor->nombre}}</td>
                    <td>{{$factura->documento}}</td>                                                            
                </tr>
            </tbody>
        </table>
    </div>
  <div id="datos_factura">
     <div class="form-group {{ $errors->has('numero_factura') || $errors->has('numero_control')}}">
        {!! Form::label('numero_factura', 'Nro Factura: ', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-3">
            {!! Form::number(
                'numero_factura', $factura->numero_factura, ['class' => 'form-control', 
                'required' => 'required','placeholder' => '156780'] )
            !!}
        </div>
        {!! Form::label('numero_control', 'Nro Control: ', ['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-3">
            {!! Form::number(
                'numero_control', $factura->numero_control, ['class' => 'form-control', 
                'required' => 'required','placeholder' => '78940'] )
            !!}
        </div>
    </div>  
    <div class="form-group {{ $errors->has('fecha_factura') || $errors->has('monto')}}">
        {!! Form::label('fecha_factura', 'Fecha Factura: ', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-3">
            {!! Form::date(
                'fecha_factura', $factura->fecha_factura, ['class' => 'form-control', 
                'required' => 'required','placeholder' => 'dd-mm-yy', 'id'=>'fecha_factura'] )
            !!}
        </div>
        {!! Form::label('monto', 'Monto: ', ['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-3">
            {!! Form::number(
                'monto',$factura->monto, ['class' => 'form-control', 
                'required' => 'required','placeholder' => '10000'] )
            !!}
        </div>
    </div>      
       {!! Form::hidden('idFactura'  , $factura->id  ,['id' => 'idFactura']) !!}       
       {!! Form::hidden('idProveedor', $factura->codigo_proveedor_creador,['id' => 'idProveedor']) !!}       
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
 </div>
 @if  ( (isset($claves)) && (!empty($claves)) && (count($claves) > 0))
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
    @endif
    @if  ( (isset($cartasAval)) && (!empty($cartasAval)) && (count($cartasAval) > 0))
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
            {!! Form::submit('Confirmar', ['class' => 'btn btn-primary form-control']) !!}    
        </div>
        <div class="col-sm-offset-2 col-sm-3">  
            <p><a href="{{url('incidencias/consultar')}}"  class="btn btn-danger form-control">Cancelar</a></p>    
        </div>
    </div>

@endif
{{ Form::close() }}
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
     $("#fecha_factura" ).datepicker({dateFormat: "dd-mm-yy" });
   }
 );
 </script>   
@endsection