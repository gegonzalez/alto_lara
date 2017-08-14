@extends('layouts.app')
@section('title','Generar Clave')
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
    {!! Form::open(['url' => 'claves/procesar', 'class' => 'form-horizontal', 'id' => 'procesar', 'name' => 'procesar', 'lang' => 'es', 'data-parsley-validate' => '']) !!}
    <div class="form-group {{ $errors->has('fecha_cita') || $errors->has('telefono') ? 'has-error' : ''}}">
        {!! Form::label('fecha_cita', 'Fecha de Atención: ', ['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-3">
            {!! Form::text('fecha_cita', null, ['class' => 'form-control input-sm', 'required' => 'required','placeholder' => 'dd-mm-aaaa']) !!}
            {!! $errors->first('fecha_cita', '<p class="help-block">:message</p>') !!}
        </div>
        {!! Form::label('telefono', 'Teléfono Móvil: ', ['class' => 'col-sm-2 col-sm-offset-1 control-label']) !!}
        <div class="col-sm-2">
            {!! Form::text('telefono', null, ['class' => 'form-control', 'required' => 'required','placeholder' => '04XX-1234567','pattern' => '\b04\d{2}[-]{1}\d{7}\b']) !!}
            {!! $errors->first('telefono', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
    <div class="form-group {{ $errors->has('motivo') ? 'has-error' : ''}}">
        {!! Form::label('motivo', 'Motivo: ', ['class' => 'col-sm-2 control-label']) !!}
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
        {!! Form::label('codigo_proveedor', 'Proveedor: ', ['class' => 'col-sm-2 control-label']) !!}
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
    <table id="procedimientos" class='table table-bordered table-striped table-hover table-responsive'>
        <thead>
            <tr>
                <th>Servicio</th><th>Especialidad</th><th>Procedimiento</th><th>Proveedor</th><th></th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
    <!--    <div class="form-group {{ $errors->has('cantidad_servicio') ? 'has-error' : ''}}">
        {!! Form::label('cantidad_servicio', 'Cantidad de Servicios: ', ['class' => 'col-sm-2 control-label', 'required' => 'required', 'step' => '1', 'min' => '0']) !!}
        <div class="col-sm-2">
            {!! Form::hidden('cantidad_servicio', null, ['class' => 'form-control', 'required' => 'required']) !!}
            {!! $errors->first('cantidad_servicio', '<p class="help-block">:message</p>') !!}
        </div>
    </div>-->
    <div class="form-group {{ $errors->has('observaciones') ? 'has-error' : ''}}">
        {!! Form::label('observaciones', 'Observaciones: ', ['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-8">
            {!! Form::textarea('observaciones', null, ['class' => 'form-control', 'rows' => '2']) !!}
            {!! $errors->first('observaciones', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
    {!! Form::hidden('max', 0, ['class' => 'form-control', 'required' => 'required','id' => 'max']) !!}
    {!! Form::hidden('cedula_afiliado', $beneficiario['cedula_afiliado'], ['class' => 'form-control','required' => 'required', 'id' => 'cedula_afiliado']) !!}
    {!! Form::hidden('codigo_contrato', $beneficiario['contrato'], ['class' => 'form-control','required' => 'required', 'id' => 'codigo_contrato']) !!}
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-3"><!--   -->
            {!! Form::submit('Generar Clave', ['class' => 'btn btn-primary form-control', 'disabled' => 'disabled', 'id' => 'enviar_clave']) !!}
        </div>
    </div>
    {!! Form::close() !!}
@endsection
@section('script')
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
            function getProcedimientos(especialidad,servicio){
                if(especialidad !== "" && servicio !== ""){
                    var data = {
                        'contrato': {{ $beneficiario['contrato'] }},
                        'cedula'  : {{ $beneficiario['cedula_afiliado'] }},
                        'especialidad': especialidad,
                        'servicio':  servicio,
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
//            function getProveedor(especialidad,servicio,procedimiento){
//                if(especialidad !== "" && servicio !== "" && procedimiento !== ""){
//                    var data = {
//                        'procedimiento': procedimiento,
//                        'especialidad': especialidad,
//                        'servicio': servicio,
//                        'proveedor': proveedorX,
//                        '_token': $('[name="_token"]').val()
//                    };
//                    var select = "";
//                    $.post("{{url('selectProveedores')}}", data, function(data,select){
//                        select = "<select class='form-control' id='codigo_proveedor' name='codigo_proveedor'>\n\
//                                    <option selected='selected' value=''>Selecione una opción</option>";
//                            $.each( data, function( key, val ) {
//                                select = select + "<option value='" + key + "'>" + val + "</option>";
//                              });
//                            select = select + "</select>";
//                            $("#div_proveedor").html(select);
//                    });
//                }else{
//                    $("#result").addClass("alert alert-danger");
//                    $("#result").html("Debe seleccionar todos los campos para agregar un Proveedor.");
//                }
//            }
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
                    $('#enviar_clave').prop('disabled', true);
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
                    //$('#codigo_especialidad').val("");
                    //$('#codigo_servicio').val("");
                    $('#procedimiento_medico').val("");
                    //$('#codigo_proveedor').val("");
                    $('#codigo_proveedor').prop('disabled', true);
                    //$('#codigo_proveedor_creador').val("");
                    //$('#detalle_servicio').val("");
                    $('#max').val(x);
                    $('#enviar_clave').prop('disabled', false);
                }else{
                    $("#result").addClass("alert alert-danger");
                    $("#result").html("Debe seleccionar todos los campos para agregar un Procedimiento.");
                }
            });
        });
    </script>
@endsection