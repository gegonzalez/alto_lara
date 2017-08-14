@extends('layouts.app')
@section('title','Generar Clave Especial')
@section('content')
<hr/>
<h4>Datos del Beneficiario</h4>
@if (isset($beneficiario))
    <div class="table">
        <table class="table table-bordered table-striped table-hover table-responsive">
            <thead>
                <tr>
                    <th>Cédula</th><th>Nombre</th><th>Tipo</th><th>Cobertura del Plan</th><th>Colectivo</th><th>Aseguradora</th>
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
<h4>Datos de la Atención Médica</h4>
    {!! Form::open(['url'    => 'clavesEspeciales/procesarClaveEspeciales',
                   'class'   => 'form-horizontal',
                   'name'    => 'procesar',
                   'id'      => "procesar",
                   'method'  => 'POST',
                   'files'   => 'true',
                   'data-parsley-validate' => '']) !!}
    <div class="form-group {{ $errors->has('fecha_cita') || $errors->has('telefono') ? 'has-error' : ''}}">
        {!! Form::label('fecha_solicitud', 'Fecha de Solicitud: ', ['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-3">
            {!! Form::text('fecha_solicitud', null, ['class' => 'form-control input-sm', 'required' => 'required','placeholder' => 'dd-mm-aaaa']) !!}
            {!! $errors->first('fecha_solicitud', '<p class="help-block">:message</p>') !!}
        </div>
        {!! Form::label('telefono', 'Teléfono Móvil: ', ['class' => 'col-sm-2 col-sm-offset-1 control-label']) !!}
        <div class="col-sm-2">
            {!! Form::text('telefono', null, ['class' => 'form-control', 'required' => 'required','placeholder' => '04XX-1234567','pattern' => '\b04\d{2}[-]{1}\d{7}\b']) !!}
            {!! $errors->first('telefono', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
    <div class="form-group {{ $errors->has('motivo') ? 'has-error' : ''}}">
        {!! Form::label('motivo', 'Motivo de la Consulta: ', ['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-8">
            {!! Form::textarea('motivo', null, ['class' => 'form-control', 'rows' => '2']) !!}
            {!! $errors->first('motivo', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
    <div class="form-group {{  $errors->has('codigo_servicio') || $errors->has('detalle_servicio') ? 'has-error' : ''}}">
        {!! Form::label('codigo_servicio', 'Tipo de Servicio: ', ['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-4">
            {!! Form::select('codigo_servicio', $servicios,null, ['class' => 'form-control', 'placeholder' => 'Seleccione una opción']) !!}
            {!! $errors->first('codigo_servicio', '<p class="help-block">:message</p>') !!}
        </div>
        {!! Form::label('detalle_servicio', 'Detalle Servicio: ', ['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-2">
            {!! Form::select('detalle_servicio', ['Primera Vez' => 'Primera Vez', 'Control' => 'Control'], null, ['class' => 'form-control', 
                            'placeholder' => 'Seleccione una opción']) !!}
            {!! $errors->first('detalle_servicio', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
    <div class="form-group {{ $errors->has('codigo_especialidad') ? 'has-error' : ''}}">
        {!! Form::label('codigo_especialidad', 'Especialidad: ', ['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-5">
            {!! Form::select('codigo_especialidad', $especialidades_cobertura,null, ['class' => 'form-control','placeholder' => 'Seleccione una opción']) !!}
            {!! $errors->first('codigo_especialidad', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
    <div class="form-group {{  $errors->has('procedimiento_medico') ? 'has-error' : ''}}">
        {!! Form::label('procedimiento_medico', 'Procedimiento Médico: ', ['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-8">
            <div id='div_procedimiento_medico'>
                {!! Form::select('procedimiento_medico',[''=>'Seleccione una opción'],null, ['class' => 'form-control']) !!}
            </div>
            {!! $errors->first('procedimiento_medico', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
    <div class="form-group {{ $errors->has('codigo_proveedor') ? 'has-error' : ''}}">
        {!! Form::label('codigo_proveedor', 'Proveedores: ', ['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-5">
            @if (isset($proveedor))
                {!! Form::label('codigo_proveedor_creador', $proveedor->nombre, ['class' => 'control-label']) !!}
                {!! Form::hidden('codigo_proveedor_creador',$proveedor->codigo_proveedor,['class' => 'form-control']) !!}
                {!! Form::hidden('codigo_proveedor',$proveedor->nombre,['class' => 'form-control']) !!}
            @else
            <div id='div_proveedor'>
                <!--{!! Form::select('codigo_proveedor',[''=>'Seleccione una opción'],null, ['class' => 'form-control']) !!}-->
                {!! Form::text('codigo_proveedor', null, ['class' => 'form-control']) !!}
                {!! Form::hidden('codigo_proveedor_creador', null, ['id' => 'codigo_proveedor_creador', 'required' => 'required']) !!}
            </div>
            @endif
            {!! $errors->first('codigo_proveedor', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-3 col-sm-offset-2">
            <button type="button" class="btn btn-sm btn-info btn-add-procedimiento">Agregar Procedimiento</button>
        </div>
    </div>
    <table id="procedimientos" class='table table-bordered table-striped table-hover'>
        <thead>
            <tr>
                <th>Servicio</th><th>Especialidad</th><th>Procedimiento</th><th>Proveedor</th><th></th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
    <div class="form-group {{ $errors->has('diagnostico') ? 'has-error' : ''}}">
        {!! Form::label('diagnostico', 'Diagnóstico: ', ['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-8">
            {!! Form::textarea('diagnostico', null, ['class' => 'form-control', 'rows' => '2']) !!}
            {!! $errors->first('diagnostico', '<p class="help-block">:message</p>') !!}
        </div>
    </div>                  
    {!! Form::hidden('max', 0, ['class' => 'form-control', 'required' => 'required','id' => 'max']) !!}
    {!! Form::hidden('cedula_afiliado', $beneficiario['cedula_afiliado'], ['class' => 'form-control','required' => 'required', 'id' => 'cedula_afiliado']) !!}
    {!! Form::hidden('codigo_contrato', $beneficiario['contrato'], ['class' => 'form-control','required' => 'required', 'id' => 'codigo_contrato']) !!}
     
    <!-- The fileinput-button span is used to style the file input field as button -->
    <span class="btn btn-success fileinput-button">
        <i class="glyphicon glyphicon-plus"></i>
        <span>Agregar archivo...</span>
        <!-- The file input field used as target for the file upload widget -->
        <input id="fileupload" type="file" name="files">
        <!--<input type="hidden" name="fileid" id="fileid">-->
    </span>
    <br>
    <br>
    <!-- The global progress bar -->
    <div id="progress" class="progress">
        <div class="progress-bar progress-bar-success"></div>
    </div>
    <!-- The container for the uploaded files -->
    <div id="files" class="files"></div>

    <br>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Consideraciones</h3>
        </div>
        <div class="panel-body">
            <ul>
                <li>El tamaño máximo del archivo para subir es <strong>999 KB</strong>.</li>
                <li>Sólo archivos (<strong> GIF, JPG, DOC </strong>) están permitidos.</li>
                <li>Puede usar <strong>arrastrar &amp; soltar</strong> en esta página.</li>
            </ul>
        </div>
    </div>
    
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-3">
            {!! Form::submit('Generar Clave', ['class' => 'btn btn-primary form-control', 'disabled' => 'disabled', 'id' => 'enviar']) !!}
        </div>
    </div>
{!! Form::close() !!}
@endsection
@section('script')
<!-- The File Upload user interface plugin -->
    <script>
        $(function(){
            $( "#fecha_cita" ).datepicker({ minDate: -0, maxDate: "+5D", dateFormat: "dd-mm-yy", changeYear: true });
            $('#procesar').parsley();
            $("#codigo_especialidad").on('change',function(){
                getProcedimientos($(this).val(),$('#codigo_servicio').val());
            });
            $("#codigo_servicio").on('change',function(){
                getProcedimientos($('#codigo_especialidad').val(),$(this).val());
            });
//            $("#enviar").on('click',function(){
//                alert($("#fileid[0]").val());
//                alert($("#fileid[0]").text());
//                $("#fileid").appendTo('#procesar');
//                //$( "#procesar" ).submit();
//            });
            function getProcedimientos(especialidad,servicio){
                if(especialidad !== "" && servicio !== ""){
                    var data = {
                        'contrato': {{ $beneficiario['contrato'] }},
                        'cedula'  : {{ $beneficiario['cedula_afiliado'] }},
                        'especialidad': especialidad,
                        'servicio': servicio,
                        'proveedor': proveedorX,
                        '_token': $('[name="_token"]').val()
                    };
                    var select = "";
                    $.post("{{url('selectProcedimientos')}}", data, function(data,select){
                        select = "<select class='form-control' id='procedimiento_medico' name='procedimiento_medico'>\n\
                                    <option selected='selected' value=''>Selecione una opción</option>";
                            $.each( data, function( key, val ) {
                                select = select + "<option value='" + key + "'>" + val + "</option>";
                              });
                            select = select + "</select>";
                            $("#div_procedimiento_medico").html(select);
//                            $("#procedimiento_medico").on('change',function(){
//                                getProveedor($('#codigo_especialidad').val(),$('#codigo_servicio').val(),$(this).val());
//                            });
                    });
                }
            }
            $( "#codigo_proveedor" ).autocomplete({
                delay: 0,
                source: function(request, response){
                    if($('#codigo_especialidad').val() !== "" && $('#codigo_servicio').val() !== "" && $('#procedimiento_medico').val() !== ""){
                        $.ajax( {
                          url       : "{{url('selectProveedores')}}",
                          dataType  : "json",
                          method    : "POST",
                          data: {
                            q: request.term.toUpperCase(),
                            'procedimiento' : $('#procedimiento_medico').val(),
                            'proveedor'     : proveedorX,
                            '_token'        : $('[name="_token"]').val()
                          },
                          success: function( data ) {
                            // Handle 'no match' indicated by [ "" ] response
                            response( data.length === 1 && data[ 0 ].length === 0 ? [] : data );
                          }
                        });
                    }else{
                        $("#result").addClass("alert alert-danger");
                        $("#result").html("Debe seleccionar todos los campos para agregar un Proveedor.");
                    }
                },
                focus: function( event, ui ) {
                    $( "#codigo_proveedor" ).val( ui.nombre );
                    return false;
                },
                select: function( event, ui ) {
                    $( "#codigo_proveedor" ).val( ui.item.nombre );
                    $( "#codigo_proveedor_creador" ).val( ui.item.codigo_proveedor );
                    return false;   
                }
            })
            .autocomplete( "instance" )._renderItem = function( ul, item ) {
                    return $( "<li>" )
                    .append( "<div>" + item.nombre + "<br></div>" )
                    .appendTo( ul );
                
            };
            $('table').on('click', '.btnAdd', function(){    
                var itemIndex = $(this).closest('tr').index();    
                var tr = "<tr><td><input type=text value=0 id= unit_" + itemIndex + "></input</td><td><input type=text value=0 id=rate></input></td><td><input type=button value=Add class=btnAdd></input></td></tr>";
                $(this).closest('table').append(tr);
                $(this).attr('value', 'Delete');
                $(this).toggleClass('btnDelete').toggleClass('btnAdd');
            }).on('click', '.btn-del-procedimiento', function(){
                //alert($(this).closest('tr').index());
                $(this).closest('tr').remove();
                if(a){
                    $('#codigo_servicio').append("<option value=1>Consulta</option>");
                    a = false;
                }
//                else if(b){
//                    $('#codigo_servicio').append("<option value=3>Estudio</option>");
//                    b = false;
//                }
                $('#max').val($('#max').val()-1);
                if($('#max').val() == 0){
                    proveedorX = '';
                    $('#codigo_proveedor').prop('disabled', false);
                    $('#enviar').prop('disabled', true);
                }
            });;
            var x = 0, a = false, b = false, proveedorX = '';
            $('.btn-add-procedimiento').on('click',function(){
                if($('#codigo_especialidad').val() !== "" && $('#codigo_servicio').val() !== "" && $('#procedimiento_medico').val() !== "" && $('#codigo_proveedor_creador').val() !== ""){
                    var especialidad = "<input type='hidden' value='"+ $('#codigo_especialidad').val() +"' name='id_especialidad" + x +"' id='id_especialidad" + x +"'>";
                    var servicio     = "<input type='hidden' value='"+ $('#codigo_servicio').val() +"' name='id_servicio" + x +"' id='id_servicio" + x +"'>";
                    var tratamiento  = "<input type='hidden' value='"+ $('#procedimiento_medico').val() +"' name='id_tratamiento" + x +"'>";
                    var proveedor    = "<input type='hidden' value='"+ $('#codigo_proveedor_creador').val() +"' name='id_proveedor" + x +"'>";
                    var detalle      = "<input type='hidden' value='"+ $('#detalle').val() +"' name='detalle" + x +"'>";
                    proveedorX       = $('#codigo_proveedor_creador').val();
                    $('#procedimientos').append("<tr class='fila" + x +"'><td>"+$("#codigo_servicio option:selected").text()+"</td>"+
                                                "<td>"+$("#codigo_especialidad option:selected").text()+"</td>"+
                                                "<td>"+$("#procedimiento_medico option:selected").text()+"</td>"+
                                                "<td>"+$("#codigo_proveedor").val()+"</td>"+
                                                "<td><button type='button' class='btn btn-sm btn-danger btn-del-procedimiento'"+
                                                ">Quitar</button></td>"
                                                +especialidad+servicio+tratamiento+proveedor+detalle+"</tr>");
                    x++;
                    if($('#codigo_servicio :selected').val() != 2 && $('#codigo_servicio :selected').val() != 3){ // Si no es laboratorio
                        if($('#codigo_servicio :selected').val() == 1){
                            a = true;
                        }else{
                            b = true;
                        }
                        $('#codigo_servicio :selected').remove();
                    }
                    //$('#codigo_servicio').val("");
                    $('#procedimiento_medico').val("");
                    $('#codigo_proveedor').prop('disabled', true);
                    //$('#detalle_servicio').val("");
                    $('#max').val(x);
                    $('#enviar').prop('disabled', false);
                }else{
                    $("#result").addClass("alert alert-danger");
                    $("#result").html("Debe seleccionar todos los campos para agregar un Procedimiento.");
                }
            });
});
 </script>
    <!--<script src="{{url('/')}}/js/main.js"></script>-->
    <!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->  
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
    <!-- The XDomainRequest Transport is included for cross-domain file deletion for IE 8 and IE 9 -->
    <!--[if (gte IE 8)&(lt IE 10)]>
    <script src="{{url('/')}}/js/cors/jquery.xdr-transport.js"></script>
    <![endif]-->
<script>
/*global window, $ */
$(function () {
    'use strict';
    // Change this to the location of your server-side upload handler:
        var url = 'http://190.202.55.42:7280/server/php/',
        uploadButton = $('<button/>')
            .addClass('btn btn-primary')
            .prop('disabled', true)
            .text('Procesando...')
            .on('click', function () {
                var $this = $(this),
                    data = $this.data();
                $this
                    .off('click')
                    .text('Abort')
                    .on('click', function () {
                        $this.remove();
                        data.abort();
                    });
                data.submit().always(function () {
                    $this.remove();
                });
            });
    $('#fileupload').fileupload({
        url: url,
        dataType: 'json',
        autoUpload: true,
        acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
        maxFileSize: 999000,
        // Enable image resizing, except for Android and Opera,
        // which actually support image resizing, but fail to
        // send Blob objects via XHR requests:
        disableImageResize: /Android(?!.*Chrome)|Opera/
            .test(window.navigator.userAgent),
        previewMaxWidth: 100,
        previewMaxHeight: 100,
        previewCrop: true
    }).on('fileuploadadd', function (e, data) {
        data.context = $('<div/>').appendTo('#files');
        $.each(data.files, function (index, file) {
            var node = $('<p/>')
                    .append($('<span/>').text(file.name));
            if (!index) {
                node
                    .append('<br>')
                    .append(uploadButton.clone(true).data(data));
            }
            node.appendTo(data.context);
        });
    }).on('fileuploadprocessalways', function (e, data) {
        var index = data.index,
            file = data.files[index],
            node = $(data.context.children()[index]);
        if (file.preview) {
            node
                .prepend('<br>')
                .prepend(file.preview);
        }
        if (file.error) {
            node
                .append('<br>')
                .append($('<span class="text-danger"/>').text(file.error));
        }
        if (index + 1 === data.files.length) {
            data.context.find('button')
                .text('Upload')
                .prop('disabled', !!data.files.error);
        }
    }).on('fileuploadprogressall', function (e, data) { 
        var progress = parseInt(data.loaded / data.total * 100, 10);
        $('#progress .progress-bar').css(
            'width',
            progress + '%'
        );
    }).on('fileuploaddone', function (e, data) {
        $.each(data.result.files, function (index, file) {
            if (file.url) {
                var link = $('<a>')
                    .attr('target', '_blank')
                    .prop('href', file.url);
                $(data.context.children()[index])
                    .wrap(link);
//            $('#fileid').val(file.url);
            } else if (file.error) {
                var error = $('<span class="text-danger"/>').text(file.error);
                $(data.context.children()[index])
                    .append('<br>')
                    .append(error);
            }
        });
    }).on('fileuploadfail', function (e, data) {
        $.each(data.files, function (index) {
            var error = $('<span class="text-danger"/>').text('File upload failed.');
            $(data.context.children()[index])
                .append('<br>')
                .append(error);
        });
    }).prop('disabled', !$.support.fileInput)
        .parent().addClass($.support.fileInput ? undefined : 'disabled');
});
</script>
@endsection