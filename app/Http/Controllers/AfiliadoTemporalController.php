<?php
namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Auth;
use App\Models\AcAfiliadoTemporal;
use App\Models\AcColectivo;
use App\Models\AcAseguradora;
use App\Models\AcAfiliado;
use App\Models\AcPlanesExtranet;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Session;
use App\Models\AcTipoAfiliado;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Contracts\Validation\Validator;
use DB;
//use Validator;


class AfiliadoTemporalController extends Controller{
    
    public function validarForm(MiFormulario $formulario){
        $validator = Validator::make(
                $formulario->all(), 
                $formulario->rules(),
                $formulario->messages()
                );
        if ($validator->valid()){

            if ($formulario->ajax()){
                return response()->json(["valid" => true], 200);
            }
            else{
            return redirect('home/miformulario')
                    ->with('message', 'Enhorabuena formulario enviado correctamente');
            }
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $afiliadostemporales = AcAfiliadoTemporal::paginate(15);

        return view('afiliadosTemporales.index', compact('afiliadostemporales'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('afiliadosTemporales.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
       $this->validate($request,  ['cedula'             => 'required|unique:ac_afiliados_temporales|max:10',
                                   'nombre'             => 'required|max:40', 
                                   'apellido'           => 'required|max:40', 
                                   'fecha_nacimiento'   => 'required', 
                                   'email'              => 'required|email|max:60',
                                   'sexo'               => 'required', 
                                   'tipo_afiliado'      => 'required',
                                   'telefono'           => 'required|regexp:/^04[\d]{9}$/',
                                   'nombre_titular'     => 'required|min:2|max:40|regex:/^([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-])+((\s*)+([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-]*)*)+$/',
                                   'apellido_titular'   => 'required|min:2|max:40|regex:/^([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-])+((\s*)+([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-]*)*)+$/',
                                   'cedula_titular'     => 'required',
                                   'codigo_aseguradora' => 'required',
                                   'codigo_colectivo'   => 'required',
                                   'estado'             => 'required',
                                   'ciudad'             => 'required|min:2|max:40|regex:/^([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-])+((\s*)+([0-9a-zA-ZñÑáéíóúÁÉÍÓÚ_-]*)*)+$/']);
         AcAfiliadoTemporal::create($request->all());
         return true;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return Response
     */
    public function show($id)
    {
        $afiliadostemporale = AcAfiliadoTemporal::findOrFail($id);
        return view('afiliadosTemporales.show', compact('afiliadostemporale'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $afiliadostemporale = AcAfiliadoTemporal::findOrFail($id);
        return view('afiliadosTemporales.edit', compact('afiliadostemporale'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     *
     * @return Response
     */
    public function update($id, Request $request)
    {
        $this->validate($request, cedula, nombre, apellido, fecha_nacimiento, email, sexo, val_user,tipo_afiliado,telefono, nombre_titular,apellido_titular, cedula_titular,codigo_aseguradora,codigo_colectivo,estado,ciudad,$user->id);

        $afiliadostemporale = AcAfiliadoTemporal::findOrFail($id);
        $afiliadostemporale->update($request->all());

        Session::flash('status', 'Afiliado Temporal actualizado!');

        return redirect('afiliadostemporales');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        AcAfiliadoTemporal::destroy($id);

        Session::flash('status', 'Afiliado Temporal eliminado!');

        return redirect('afiliadosTemporales');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  $request
     *
     * @return Response
     */
    public function generarClaveEspeciales( Request $request)
    {        
        $afiliadosTemporale = \App\Models\AcAfiliado::where('cedula_titular','=',$request->cedula_titular)->get();
        if ($afiliadosTemporale->isEmpty()){
             Session::flash('message', 'Cédula del Titular no Existe');
             $tipoAfiliado = \App\Models\AcTipoAfiliado::pluck('nombre', 'id')->toArray();
             $estado = \App\Models\AcEstado::pluck('es_desc', 'es_id')->toArray();
             $aseguradora = \App\Models\AcAseguradora::pluck('nombre', 'codigo_aseguradora')->toArray();
             $afiliado['cedula'] = $request->cedula;
             $afiliado['proceso'] = 'claveEspeciales';
             return view('afiliadosTemporales.create', compact('tipoAfiliado','aseguradora','estado','afiliado'));   
        }
    
        if ($this->store($request)){
                $colectivos      = \App\Models\AcColectivo::where('codigo_colectivo','=',$request->codigo_colectivo)->get();
                $aseguradoras    = \App\Models\AcAseguradora::where('codigo_aseguradora','=',$request->codigo_aseguradora)->get();
                $planes          = \App\Models\AcPlanesExtranet::where('codigo_plan','=',25)->get(); 
                $tipo_afiliados  = \App\Models\AcTipoAfiliado::where('id','=',$request->tipo_afiliado)->get(); 
                $beneficiario['contrato']        = 0;
                $beneficiario['cedula_afiliado'] = $request->cedula;
                $beneficiario['nombre_afiliado'] = $request->nombre.' '.$request->apellido;
                foreach ($planes as $plan) {
                   $beneficiario['plan'] = $plan->nombre;
                }
                foreach ($colectivos as $colectivo) {
                   $beneficiario['colectivo'] = $colectivo->nombre;
                }
                foreach ($aseguradoras as $aseguradora) {
                   $beneficiario['aseguradora']     = $aseguradora->nombre;
                }
                foreach ($tipo_afiliados as $tipo_afiliado) {
                   $beneficiario['tipo_afiliado']   = $tipo_afiliado->nombre;                
                   
                }
                $coberturas = DB::table('ac_afiliados_temporales')
                ->where([['cedula', '=', $beneficiario['cedula_afiliado']]])
                ->join('ac_aseguradora', 'ac_aseguradora.codigo_aseguradora',"=", 'ac_afiliados_temporales.codigo_aseguradora')     
                ->join('ac_planes_extranet',  function ($query){
                                                      $query->where('ac_planes_extranet.codigo_plan',"=", 25);
                })
                ->join('ac_cobertura_extranet',function($join){
                                         $join->on('ac_cobertura_extranet.id_aseguradora',"=", 'ac_aseguradora.codigo_aseguradora')
                                              ->on('ac_cobertura_extranet.id_plan',"=", 'ac_planes_extranet.codigo_plan');
                  })      
                ->join('ac_procedimientos_medicos', function($join){
                        $join->on('ac_procedimientos_medicos.codigo_examen',"=", 'ac_cobertura_extranet.id_procedimiento')
                             ->on('ac_procedimientos_medicos.codigo_especialidad',"=", 'ac_cobertura_extranet.id_especialidad')
                             ->on('ac_procedimientos_medicos.codigo_servicio',"=", 'ac_cobertura_extranet.id_servicio');
                })
                ->join('ac_servicios_extranet', 'ac_servicios_extranet.codigo_servicio',"=", 'ac_procedimientos_medicos.codigo_servicio')
                ->join('ac_especialidades_extranet', 'ac_especialidades_extranet.codigo_especialidad',"=", 'ac_procedimientos_medicos.codigo_especialidad')
                ->select('id_servicio','ac_servicios_extranet.descripcion as servicio',
                        'id_especialidad','ac_especialidades_extranet.descripcion as especialidad')
                ->get(); // +++++++ array(StdClass)
            
            $especialidades_cobertura = array_pluck($coberturas,'especialidad','id_especialidad'); // ++++++++++++++++ ARRAY
            $servicios = array_pluck($coberturas,'servicio','id_servicio');
            $proveedores = DB::table('ac_procedimientos_medicos')
                                ->where([['ac_procedimientos_medicos.codigo_examen', '=', '1'],['ac_procedimientos_medicos.codigo_especialidad', '=', '3'],
                                    ['ac_procedimientos_medicos.codigo_servicio', '=', '2']])
                                ->join('ac_baremos', 'ac_procedimientos_medicos.id',"=", 'id_procedimiento')
                                ->join('ac_proveedores_extranet', 'ac_proveedores_extranet.codigo_proveedor',"=", 'id_proveedor')
                                ->select('nombre','codigo_proveedor')->get();
            $proveedor = array_pluck($proveedores,'nombre','codigo_proveedor');
            return view('claves.generarFinalClaveEspeciales', compact('beneficiario','coberturas','especialidades_cobertura','servicios','proveedor'));
        }   
    }  
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return Response
     */        
    public function generarClaveTemporal( Request $request)
    {
        
        $afiliadosTemporale = \App\Models\AcAfiliado::where('cedula_titular','=',$request->cedula_titular)->get();
        if ($afiliadosTemporale->isEmpty()){
             Session::flash('message', 'Cédula del Titular no Existe');
             $tipoAfiliado = \App\Models\AcTipoAfiliado::pluck('nombre', 'id')->toArray();
             $estado = \App\Models\AcEstado::pluck('es_desc', 'es_id')->toArray();
             $aseguradora = \App\Models\AcAseguradora::pluck('nombre', 'codigo_aseguradora')->toArray();
             $afiliado['cedula'] = $request->cedula;
             $afiliado['proceso'] = 'claveAtencion';
             return view('afiliadosTemporales.create', compact('tipoAfiliado','aseguradora','estado','afiliado'));   
        }
        if ($this->store($request)){
            $colectivos      = \App\Models\AcColectivo::where('codigo_colectivo','=',$request->codigo_colectivo)->get();
            $aseguradoras    = \App\Models\AcAseguradora::where('codigo_aseguradora','=',$request->codigo_aseguradora)->get();
            $planes          = \App\Models\AcPlanesExtranet::where('codigo_plan','=',25)->get(); 
            $tipo_afiliados  = \App\Models\AcTipoAfiliado::where('id','=',$request->tipo_afiliado)->get(); 
            $beneficiario['contrato']        = 0;
            $beneficiario['cedula_afiliado'] = $request->cedula;
            $beneficiario['nombre_afiliado'] = $request->nombre.' '.$request->apellido;
            foreach ($planes as $plan) {
               $beneficiario['plan'] = $plan->nombre;
            }
            foreach ($colectivos as $colectivo) {
               $beneficiario['colectivo'] = $colectivo->nombre;
            }
            foreach ($aseguradoras as $aseguradora) {
               $beneficiario['aseguradora']     = $aseguradora->nombre;
            }
            foreach ($tipo_afiliados as $tipo_afiliado) {
               $beneficiario['tipo_afiliado']   = $tipo_afiliado->nombre;                

            }
            $user = \Auth::user();
            if($user->type == 3){ // PROVEEDOR
                $coberturas = DB::table('ac_cobertura_extranet')
                    ->where([['id_aseguradora', '=', $request->codigo_aseguradora],['id_plan', '=', 25]]) // AMP
                    ->join('ac_procedimientos_medicos', function($join){
                            $join->on('ac_procedimientos_medicos.codigo_examen',"=", 'ac_cobertura_extranet.id_procedimiento')
                                 ->on('ac_procedimientos_medicos.codigo_especialidad',"=", 'ac_cobertura_extranet.id_especialidad')
                                 ->on('ac_procedimientos_medicos.codigo_servicio',"=", 'ac_cobertura_extranet.id_servicio');
                    })
                    ->join('ac_servicios_extranet', 'ac_servicios_extranet.codigo_servicio',"=", 'ac_procedimientos_medicos.codigo_servicio')
                    ->join('ac_especialidades_extranet', 'ac_especialidades_extranet.codigo_especialidad',"=", 'ac_procedimientos_medicos.codigo_especialidad')
                    ->join('ac_baremos', 'ac_procedimientos_medicos.id',"=", 'ac_baremos.id_procedimiento')
                    ->join('ac_proveedores_extranet', function($join){
                        $user = \Auth::user();
                        $join->on('ac_proveedores_extranet.codigo_proveedor',"=", 'ac_baremos.id_proveedor')
                             ->where('ac_proveedores_extranet.codigo_proveedor',"=", $user->proveedor);
                    })
                    ->select('id_servicio','ac_servicios_extranet.descripcion as servicio',
                            'id_especialidad','ac_especialidades_extranet.descripcion as especialidad',
                            'ac_procedimientos_medicos.id as id_procedimiento','tipo_examen')
                    ->get(); // +++++++ array(StdClass)
            }else{
                $coberturas = DB::table('ac_afiliados_temporales')
                    ->where([['cedula', '=', $beneficiario['cedula_afiliado']]])
                    ->join('ac_aseguradora', 'ac_aseguradora.codigo_aseguradora',"=", 'ac_afiliados_temporales.codigo_aseguradora')     
                    ->join('ac_planes_extranet',  function ($query){
                                                          $query->where('ac_planes_extranet.codigo_plan',"=", 25);
                    })
                    ->join('ac_cobertura_extranet',function($join){
                                             $join->on('ac_cobertura_extranet.id_aseguradora',"=", 'ac_aseguradora.codigo_aseguradora')
                                                  ->on('ac_cobertura_extranet.id_plan',"=", 'ac_planes_extranet.codigo_plan');
                      })      
                    ->join('ac_procedimientos_medicos', function($join){
                            $join->on('ac_procedimientos_medicos.codigo_examen',"=", 'ac_cobertura_extranet.id_procedimiento')
                                 ->on('ac_procedimientos_medicos.codigo_especialidad',"=", 'ac_cobertura_extranet.id_especialidad')
                                 ->on('ac_procedimientos_medicos.codigo_servicio',"=", 'ac_cobertura_extranet.id_servicio');
                    })
                    ->join('ac_servicios_extranet', 'ac_servicios_extranet.codigo_servicio',"=", 'ac_procedimientos_medicos.codigo_servicio')
                    ->join('ac_especialidades_extranet', 'ac_especialidades_extranet.codigo_especialidad',"=", 'ac_procedimientos_medicos.codigo_especialidad')
                    ->select('ac_planes_extranet.nombre as plan','id_servicio','ac_servicios_extranet.descripcion as servicio',
                            'id_especialidad','ac_especialidades_extranet.descripcion as especialidad','id_procedimiento','tipo_examen')
                    ->get(); // +++++++ array(StdClass)    
            }
            $especialidades_cobertura = array_pluck($coberturas,'especialidad','id_especialidad'); // ++++++++++++++++ ARRAY
            $servicios = array_pluck($coberturas,'servicio','id_servicio');
            return view('claves.generarFinal', compact('beneficiario','especialidades_cobertura','servicios'));
        }   
    }  
    
     /**
     * Remove the specified resource from storage.
     *
     * @param 
     * Request
     * @return view 
     */
    public function crearAfiliadosTemporales(Request $request)
    {
        $tipoAfiliado = \App\Models\AcTipoAfiliado::pluck('nombre', 'id')->toArray();
        $estado = \App\Models\AcEstado::pluck('es_desc', 'es_id')->toArray();
        $aseguradora = \App\Models\AcAseguradora::pluck('nombre', 'codigo_aseguradora')->toArray();
        $afiliado['cedula'] = $request->cedula;
        $afiliado['proceso'] = 'claveAtencion';
        return view('afiliadosTemporales.create', compact('tipoAfiliado','aseguradora','estado','afiliado'));
    }
     /**
     * Remove the specified resource from storage.
     *
     * @param 
     * Request
     * @return view 
     */
    public function crearAfiliadosTemporalesClaveEspecial(Request $request)
    {
        $tipoAfiliado = \App\Models\AcTipoAfiliado::pluck('nombre', 'id')->toArray();
        $estado = \App\Models\AcEstado::pluck('es_desc', 'es_id')->toArray();
        $aseguradora = \App\Models\AcAseguradora::pluck('nombre', 'codigo_aseguradora')->toArray();
        $afiliado['cedula'] = $request->cedula;
        $afiliado['proceso'] = 'claveEspeciales';
        return view('afiliadosTemporales.create', compact('tipoAfiliado','aseguradora','estado','afiliado'));
    }
     /**
     * Remove the specified resource from storage.
     *
     * @param  request  $request
     *
     * @return Response
     */
    function generarClave( Request $request)
    {
       if ($request->proceso == 'claveEspeciales'){
          return  $this->generarClaveEspeciales($request);
       }elseif ($request->proceso == 'claveAtencion'){
           return  $this->generarClaveTemporal($request);
       }
      
    }
}