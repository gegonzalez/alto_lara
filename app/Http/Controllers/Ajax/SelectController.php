<?php
namespace App\Http\Controllers\Ajax;

use DB;
use Session;
use Carbon\Carbon;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Models\AcAfiliado;
use App\Http\Controllers\Controller;

class SelectController  extends Controller{
    
    /**
     * Display a select list of Colectivos.
     *
     * @return Response
     */
    public function getColectivos(){
        return response()->json(\App\Models\AcColectivo::where('codigo_aseguradora','=',\Input::get('id'))->orderBy('nombre','asc')
                ->pluck('nombre','codigo_colectivo'));
    }
    
    /**
     * Display a select list of Procedimientos.
     *
     * @return Response
     */
    public function getProcedimientos(){
        $user = \Auth::user();
        if (\Input::get('contrato') == 0 ){
            $afiliado = \App\Models\AcAfiliadoTemporal::where('cedula', '=', \Input::get('cedula'))->firstorFail();
            if($user->type == 3){ // PROVEEDOR
                $coberturas = DB::table('ac_cobertura_extranet')
                    ->where([['id_aseguradora', '=', $afiliado->codigo_aseguradora],['id_plan', '=', 25]]) // AMP
                    ->join('ac_procedimientos_medicos', function($join){
                            $join->on('ac_procedimientos_medicos.codigo_examen',"=", 'ac_cobertura_extranet.id_procedimiento')
                                 ->on('ac_procedimientos_medicos.codigo_especialidad',"=", 'ac_cobertura_extranet.id_especialidad')
                                 ->on('ac_procedimientos_medicos.codigo_servicio',"=", 'ac_cobertura_extranet.id_servicio')
                                 ->where('ac_procedimientos_medicos.codigo_servicio',"=",\Input::get('servicio'))
                                 ->where('ac_procedimientos_medicos.codigo_especialidad',"=",\Input::get('especialidad'));
                    })
                    ->join('ac_servicios_extranet', 'ac_servicios_extranet.codigo_servicio',"=", 'ac_procedimientos_medicos.codigo_servicio')
                    ->join('ac_especialidades_extranet', 'ac_especialidades_extranet.codigo_especialidad',"=", 'ac_procedimientos_medicos.codigo_especialidad')
                    ->join('ac_baremos', 'ac_procedimientos_medicos.id',"=", 'ac_baremos.id_procedimiento')
                    ->join('ac_proveedores_extranet', function($join){
                        $user = \Auth::user();
                        $join->on('ac_proveedores_extranet.codigo_proveedor',"=", 'ac_baremos.id_proveedor')
                             ->where('ac_proveedores_extranet.codigo_proveedor',"=", $user->proveedor);
                    })
                    ->select('tipo_examen','ac_procedimientos_medicos.id'); // +++++++ array(StdClass)
            }else{
                $coberturas = DB::table('ac_cobertura_extranet')
                    ->where([['id_aseguradora', '=', $afiliado->codigo_aseguradora],['id_plan', '=', 25]]) // AMP
                    ->join('ac_procedimientos_medicos', function($join){
                            $join->on('ac_procedimientos_medicos.codigo_examen',"=", 'ac_cobertura_extranet.id_procedimiento')
                                 ->on('ac_procedimientos_medicos.codigo_especialidad',"=", 'ac_cobertura_extranet.id_especialidad')
                                 ->on('ac_procedimientos_medicos.codigo_servicio',"=", 'ac_cobertura_extranet.id_servicio')
                                 ->where('ac_procedimientos_medicos.codigo_servicio',"=",\Input::get('servicio'))
                                 ->where('ac_procedimientos_medicos.codigo_especialidad',"=",\Input::get('especialidad'));
                    })
                    ->join('ac_servicios_extranet', 'ac_servicios_extranet.codigo_servicio',"=", 'ac_procedimientos_medicos.codigo_servicio')
                    ->join('ac_especialidades_extranet', 'ac_especialidades_extranet.codigo_especialidad',"=", 'ac_procedimientos_medicos.codigo_especialidad')
                    ->join('ac_baremos', 'ac_procedimientos_medicos.id',"=", 'ac_baremos.id_procedimiento')
                    ->join('ac_proveedores_extranet', function($join){
                        if(\Input::get('proveedor') !== ''){
                        $join->on('ac_proveedores_extranet.codigo_proveedor',"=", 'ac_baremos.id_proveedor')
                             ->where('ac_proveedores_extranet.codigo_proveedor','=',\Input::get('proveedor'));
                        }else{
                            $join->on('ac_proveedores_extranet.codigo_proveedor',"=", 'ac_baremos.id_proveedor');
                        }
                    })
                    ->select('tipo_examen','ac_procedimientos_medicos.id'); // +++++++ array(StdClass)
            }
        }else{   // SI ES AFILIADO
            if($user->type == 3){ // PROVEEDOR
                $coberturas = DB::table('ac_contratos')
                    ->where([['codigo_contrato', '=', \Input::get('contrato')]])
                    ->join('ac_planes_extranet', 'ac_planes_extranet.codigo_plan',"=", 'ac_contratos.codigo_plan')
                    ->join('ac_cobertura_extranet', 'ac_cobertura_extranet.id_plan',"=", 'ac_planes_extranet.codigo_plan')
                    ->join('ac_colectivos', 'ac_colectivos.codigo_colectivo',"=", 'ac_contratos.codigo_colectivo')
                    ->join('ac_aseguradora', 'ac_aseguradora.codigo_aseguradora',"=", 'ac_colectivos.codigo_aseguradora')
                    ->join('ac_procedimientos_medicos', function($join){
                            $join->on('ac_procedimientos_medicos.codigo_examen',"=", 'ac_cobertura_extranet.id_procedimiento')
                                 ->on('ac_procedimientos_medicos.codigo_especialidad',"=", 'ac_cobertura_extranet.id_especialidad')
                                 ->on('ac_procedimientos_medicos.codigo_servicio',"=", 'ac_cobertura_extranet.id_servicio')
                                 ->where('ac_procedimientos_medicos.codigo_servicio',"=",\Input::get('servicio'))
                                 ->where('ac_procedimientos_medicos.codigo_especialidad',"=",\Input::get('especialidad'));
                    })
                    ->join('ac_baremos', 'ac_procedimientos_medicos.id',"=", 'ac_baremos.id_procedimiento')
                    ->join('ac_proveedores_extranet', function($join){
                        $user = \Auth::user();
                        $join->on('ac_proveedores_extranet.codigo_proveedor',"=", 'ac_baremos.id_proveedor')
                             ->where('ac_proveedores_extranet.codigo_proveedor',"=", $user->proveedor);
                    })
                    ->select('tipo_examen','ac_procedimientos_medicos.id'); // +++++++ array(StdClass)
            }else{
                $coberturas = DB::table('ac_contratos')
                    ->where([['codigo_contrato', '=', \Input::get('contrato')]])
                    ->join('ac_planes_extranet', 'ac_planes_extranet.codigo_plan',"=", 'ac_contratos.codigo_plan')
                    ->join('ac_cobertura_extranet', 'ac_cobertura_extranet.id_plan',"=", 'ac_planes_extranet.codigo_plan')
                    ->join('ac_colectivos', 'ac_colectivos.codigo_colectivo',"=", 'ac_contratos.codigo_colectivo')
                    ->join('ac_aseguradora', 'ac_aseguradora.codigo_aseguradora',"=", 'ac_colectivos.codigo_aseguradora')
                    ->join('ac_procedimientos_medicos', function($join){
                            $join->on('ac_procedimientos_medicos.codigo_examen',"=", 'ac_cobertura_extranet.id_procedimiento')
                                 ->on('ac_procedimientos_medicos.codigo_especialidad',"=", 'ac_cobertura_extranet.id_especialidad')
                                 ->on('ac_procedimientos_medicos.codigo_servicio',"=", 'ac_cobertura_extranet.id_servicio')
                                 ->where('ac_procedimientos_medicos.codigo_servicio',"=",\Input::get('servicio'))
                                 ->where('ac_procedimientos_medicos.codigo_especialidad',"=",\Input::get('especialidad'));
                    })
                    ->join('ac_baremos', 'ac_procedimientos_medicos.id',"=", 'ac_baremos.id_procedimiento')
                    ->join('ac_proveedores_extranet', function($join){
                        if(\Input::get('proveedor') !== ''){
                        $join->on('ac_proveedores_extranet.codigo_proveedor',"=", 'ac_baremos.id_proveedor')
                             ->where('ac_proveedores_extranet.codigo_proveedor','=',\Input::get('proveedor'));
                        }else{
                            $join->on('ac_proveedores_extranet.codigo_proveedor',"=", 'ac_baremos.id_proveedor');
                        }
                    })
                    ->select('tipo_examen','ac_procedimientos_medicos.id');
            }
        }
        return response()->json($coberturas->pluck('tipo_examen','id'));
    }
    
    /**
     * Display a select list of Proveedores.
     *
     * @return Response
    */
    public function getProveedores(){
        if((\Input::get('procedimiento') !== null)){
            $user = \Auth::user();
            if($user->type == 3){
                $proveedores = \App\Models\AcProveedoresExtranet::where('codigo_proveedor','=',$user->proveedor)->get();
            }else{
                $proveedores = DB::table('ac_procedimientos_medicos')
                    ->where([['ac_procedimientos_medicos.id', '=', \Input::get('procedimiento')]])
                    ->join('ac_baremos', 'ac_procedimientos_medicos.id',"=", 'ac_baremos.id_procedimiento')
                    ->join('ac_proveedores_extranet', function($join){
                        $term = \Input::get('q');
                        if(\Input::get('proveedor') !== ''){
                            $join->on('ac_proveedores_extranet.codigo_proveedor',"=", 'ac_baremos.id_proveedor')
                                 ->where('ac_proveedores_extranet.codigo_proveedor','=',\Input::get('proveedor'));
                        }else{
                            $join->on('ac_proveedores_extranet.codigo_proveedor',"=", 'ac_baremos.id_proveedor')
                                    ->where('nombre', 'like', '%'.$term.'%');
                        }
                    })
                    ->select('codigo_proveedor','nombre')->get();
                //$formProveedor = \DataForm::source($proveedores);
                //$formProveedor->attributes(['class'=>'form-horizontal']);
                //$formProveedor->add('codigo_proveedor','Proveedor','select')->options(\App\Models\AcProveedoresExtranet::lists('nombre', 'codigo_proveedor')->all());
                //$formProveedor->add('codigo_proveedor','Proveedor','autocomplete')->search(array('name'));
            }
        }else{
            $term = \Input::get('q');
            if($term !== null && $term !== ""){
                $proveedores = \App\Models\AcProveedoresExtranet::get();
            }else{
                $proveedores = DB::table('ac_proveedores_extranet')
                                ->where('nombre', 'like', '%'.$term.'%')
                                ->get();
            }
        }
        return response()->json($proveedores);
    }
    
    /**
     * Display an Afiliado Titular.
     *
     * @return Response
     */
    public function getTitular(){
        $titular = AcAfiliado::where('cedula','=',\Input::get('id'))->first();
        if($titular){
            if($titular->tipo_afiliado == 1){
                return response()->json($titular);
            }else{
                return response()->json(['nombre' => '', 'apellido' => '']);
            }
        }else{
            return response()->json(['nombre' => '', 'apellido' => '']);
        }
    }
    
    /**
     * Display a select list of Aseguradoras.
     *
     * @return Response
    */  
    public function getAseguradoras(){
        $aseguradoras = \App\Models\AcAseguradora::get();
        return response()->json($aseguradoras->pluck('nombre','codigo_aseguradora'));
    }
}