@extends('layouts.app')
@section('title','Autorizar Afiliados Temporales')

@section('content') 
{!! Form::open(['url' => 'claves/autorizarAfiliadosTemporales', 'class' => 'form-horizontal', 'name' => 'autorizarAfiliadosTemporales','method' => 'GET']) !!}
  
  {!!$filter->footer!!}    
  
  {{ Form::close() }}
@endsection
@section('script')
<script>
 function ValidarAlpha(valor,campo){
     var charRegExp = new RegExp("^[a-zA-Z]$") 
     var Nombre = valor; 
     if (Nombre.search(charRegExp)!=0 )
        { 
          $("#result").addClass("alert alert-danger");
          $("#result").html("Debe introducir solo carácteres Alfabéticos"); 
          $("#"+campo).focus(); 
          return false;
        } else return true;      
 }; 

</script>
@endsection