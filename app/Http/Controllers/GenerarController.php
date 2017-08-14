<?php
namespace App\Http\Controllers\ClaveOdontologica;

use DB;
use Session;
use Carbon\Carbon;
use App\Models\AcClaveOdontologica;
use App\Models\AcAfiliado;
use App\Models\AcAfiliadoTemporal;
use App\Models\AcContrato;
use App\Models\AcTipoControl;
use App\Models\AcProveedoresExtranet;
use App\Models\AcEspecialidadesExtranet;
use Illuminate\Http\Request;
use App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ClaveController; #add christiam chivico 
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Controllers\ValidarFechaController;
use Illuminate\Http\RedirectResponse;


class GenerarController extends Controller{

    /**
     * Display a listing of the resource.
     * @param Request
     * @return Response
     */
    public function buscar(Request $request){
        $ValidarFecha = new ValidarFechaController();
        if  (!($ValidarFecha->validarHorario()) and false){
            return redirect('home')->with('message', 'No se encuentra dentro del Horario Autorizado.');
        }
        if(isset($request->cedula)){
            if(empty($request->cedula)){
                return redirect()->back()->withInput()->with('message', 'El campo cédula es obligatorio.');
            }else{
                try{
                    $this->validate($request,['cedula' => 'numeric']);
                    $afiliadoIni = AcAfiliado::where('cedula', '=', $request->cedula)->firstOrFail();
                }catch(ModelNotFoundException $e){  // catch(Exception $e) catch any exception
                    //dd(get_class_methods($e)); // lists all available methods for exception object
                    $tipoAfiliado = \App\Models\AcTipoAfiliado::pluck('nombre', 'id')->toArray();
                    $estado = \App\Models\AcEstado::pluck('es_desc', 'es_id')->toArray();
                    $aseguradora = \App\Models\AcAseguradora::pluck('nombre', 'codigo_aseguradora')->toArray();    
                    try{
                        $afiliadosTemporale = AcAfiliadoTemporal::where('cedula', '=', $request->cedula)->firstOrFail();
                        $colectivo = \App\Models\AcColectivo::pluck('nombre', 'codigo_colectivo')->toArray();
                        return view('afiliadosTemporales.edit', compact('afiliadosTemporale','tipoAfiliado','aseguradora','estado','colectivo'));
                    }catch(ModelNotFoundException $e){
                        return redirect()->back()->withInput()->with('respuesta', 'No existe el Afiliado. Presione si desea ');
                    }
                }

                $contratos = $this->getContratos($afiliadoIni->cedula_titular);

                if(!empty($contratos)){
                    return view('clavesOdontologicas.gestionar', compact('contratos'));
                }else{
                    Session::flash('flash_message', 'No tiene contrato vigente!');
                    return view('clavesOdontologicas.gestionar', compact('contratos'));
                }
            }
        }else{
            return view('clavesOdontologicas.gestionar');
        }
    }
    
    /**
     * Display a listing of the resource.
     * @param  Request $request
     * @return Response
     */
    public function buscarClave(Request $request){
        if(empty($request->icedula)){
            return redirect()->back()->withInput()->with('message', 'Debe seleccionar un beneficiario.');
        }
        $id = $request->input('icedula');
        $beneficiario['contrato'] = $request->input(['contrato'.$id]);
        $beneficiario['cedula_afiliado'] = $request->input('cedula_afiliado'.$id);
        $beneficiario['nombre_afiliado'] = $request->input('nombre_afiliado'.$id);
        $beneficiario['plan'] = $request->input('plan'.$id);
        $beneficiario['colectivo'] = $request->input('colectivo'.$id);
        $beneficiario['aseguradora'] = $request->input('aseguradora'.$id);
        $beneficiario['tipo_afiliado'] = $request->input('tipo_afiliado'.$id);
        $user = \Auth::user();
        $claves = AcClaveOdontologica::where([['cedula_afiliado', '=', $beneficiario['cedula_afiliado']],['ac_clave_odontologica.estatus', '=', 1]]) //ABIERTO
                    ->leftJoin('ac_tratamiento_odontologico', 'ac_tratamiento_odontologico.id_clave', '=', 'ac_clave_odontologica.id')
                    ->leftJoin('ac_procedimientos_medicos', 'ac_procedimientos_medicos.id', '=', 'ac_tratamiento_odontologico.id_procedimiento')
                    ->select('ac_clave_odontologica.*', 'ac_procedimientos_medicos.tipo_examen')
                    ->orderBy('ac_clave_odontologica.created_at','asc')
                    ->get(); // +++++++ array(StdClass)

        $tipos_control = AcTipoControl::where('id','<',3)->get();
        $tipo_control  = array_pluck($tipos_control,'descripcion','id');
        if($user->type == 3){ // PROVEEDOR   
            $proveedor = AcProveedoresExtranet::where('codigo_proveedor',"=", $user->proveedor)->firstOrFail();
            return view('clavesOdontologicas.gestionarDos', compact('beneficiario','claves','proveedor','tipo_control'));
        }else{
           
            return view('clavesOdontologicas.gestionarDos', compact('beneficiario','claves','tipo_control'));
        }
        
    }
    
    /**
     * gestionarSecuencia: Controller con la logica de proceso para 
     * generar una clave de secuencia cuidando que exista un margen
     * de dos meses entre la fecha de creacion y la fecha actual, 
     * tambien valida que la fecha de aptualizacion tenga 2 meses de 
     * margen con la fecha actual, de esta manera la actusalizacion se 
     * permitira realizar cada dos meses.
     * @param  Request $request [Parametros que recibe la solicitud]
     * @return view             [vista segun la validacion]
     */
    public function gestionarSecuencia(Request $request){
        if(empty($request->iclave)){
                 return redirect()->to($this->getRedirectUrl())
                        ->withInput($request->input());        
        }
        $id = $request->input('icedula');
        $beneficiario['contrato'] = $request->input(['contrato'.$id]);
        $beneficiario['cedula_afiliado'] = $request->input('cedula_afiliado');
        $beneficiario['nombre_afiliado'] = $request->input('nombre_afiliado');
        $beneficiario['plan'] = $request->input('plan');
        $beneficiario['colectivo'] = $request->input('colectivo');
        $beneficiario['aseguradora'] = $request->input('aseguradora');
        $beneficiario['tipo_afiliado'] = $request->input('tipo_afiliado');

        $now = Carbon::now();
        $now = $now->toDateString();
        $claves = AcClaveOdontologica::where('id', '=', $request->iclave)->firstOrFail();
        $created = $claves->created_at->addMonth(1)->toDateString(); //f_creacion de la clave_odontolocia con un mes add
        $updated = $claves->updated_at->addMonth(1)->toDateString(); //fecha de actualizacion de la clave odontologica un mes add
         
        //Valído que la fecha de crecion haya cumplido mas de un mes
        if($now >= $created){ // Si aun no cumple el mes
            Session::flash('message', 'Debe esperar un mes desde la fecha de creación, para actualizar la clave de secuencia!');
            return redirect('clavesOdonto/gestionar');
        }
        else{ //Si cumplio los dos meses
            if ($created == $updated){ //valida si nunca han actualizado la clave de secuencia
                return view('clavesOdontologicas.actualizarSecuencia', compact('claves', 'beneficiario'));
            }
            // Si han actualizado la clave se valida que la fecha de actualizacion tenga dos meses r
            if($now >= $updated){
                Session::flash('message', 'Debe esperar un mes desde la fecha de creación, para actualizar la clave de secuencia!');
                #return redirect()->back()->withInput();
                return redirect('clavesOdonto/gestionar');
            }
            else{ //Aun no cumple los dos meses
                return view('clavesOdontologicas.actualizarSecuencia', compact('claves', 'beneficiario'));
            }
        }
    }

    /**
     * actualizarSecuencia: Actualiza las fechas tentativas de atencion 
     * @param  Request $request 
     * @return [view]           [vista con mensaje de ejecucion]
     */
    public function actualizarSecuencia(Request $request)
    {
        //valido 0que el id de la clave venga lleno
        if(!empty($request->iclave)){

            $claveOdon = AcClaveOdontologica::where('id', '=', $request->iclave)->firstOrFail();
            $numContro = AcClaveOdontologica::where('clave_primaria', '=', $claveOdon->clave)->max('numero_control');
               
            $now = Carbon::now();
            $now = $now->toDateString();
            #if($numContro != 5){
                $ClaveControlador = new ClaveController();
                $acClave          = new AcClaveOdontologica();
                $user             = \Auth::user();
                $clave            = $ClaveControlador->RandomClave($length=10,$uc=TRUE,$n=TRUE,$sc=FALSE);     

                $acClave->clave            = $clave;
                $acClave->tipo_control     = 3;
                $acClave->cedula_afiliado  = $claveOdon->cedula_afiliado;
                $acClave->codigo_contrato  = $claveOdon->codigo_contrato;
                $acClave->fecha_atencion1  = $now;
                #$acClave->fecha_atencion2  = $request->fecha_atencion2;
                #$acClave->fecha_atencion3  = $request->fecha_atencion3;
                $acClave->clave_primaria   = $claveOdon->clave;
                $acClave->codigo_proveedor_creador = $request->codigo_proveedor_creador;
                $acClave->estatus          = 1;
                $acClave->creador          = $user->id;
                $acClave->telefono         = $claveOdon->telefono;
                $acClave->numero_control   = $numContro+1;
                $acClave->save();
                /*
                #Hace eliminado logico de la clave de secuencia anterior
                if ($numContro != NULL){
                    $claveSecu = AcClaveOdontologica::
                    where('clave_primaria', '=', $claveOdon->clave)
                    ->where('numero_control', '=', $numContro)
                    ->delete();
                }
                */
                Session::flash('status', 'Clave Secuencia Generada exitosamente!');
                return view('clavesOdontologicas.gestionar');
            #}
            #Session::flash('message', 'Disculpe usted llego al limite permitido de las claves de secuencia');
            #return view('clavesOdontologicas.gestionar');
        }
    }

    /**
     * actualizarFechaAtencion Consulta los datos de la clave odontologica y y lo remite a la vista de modificar 
     * @param  int $id id de la clave
     * @return views  retorna la vista para editar las fechas tentativas de secuencia
     */
    public function actualizarFechaAtencion($id)
    {
        $claves = AcClaveOdontologica::findOrFail($id);
        $claves = array_add($claves,'ruta', 'editarFechaSecuencia');
        return view('clavesOdontologicas.actualizarSecuencia', compact('claves'));
    }

    /**
     * Actualiza los datos de las fecha de secuencia
     * @param  Request $request 
     * @return view          re
     */
    public function updateFechaSecuencia(Request $request)
    {
        $clave = AcClaveOdontologica::where('id', '=', $request->iclave)->firstOrFail();
        $clave->update($request->all());
        
        Session::flash('status', 'Fechas de clave secuencia actualizada exitosamente!');
        return view('clavesOdontologicas.gestionar');
    }

    public function getContratos($cedula_titular)
    {
        $contratos = DB::table('ac_contratos')
            ->where([['cedula_titular', '=', $cedula_titular],['fecha_inicio','<=',date('Y-m-d').' 00:00:00'],['fecha_fin','>=',date('Y-m-d').' 00:00:00']])
            ->join('ac_afiliados', 'ac_afiliados.cedula',"=", 'ac_contratos.cedula_afiliado')
            ->join('ac_tipo_afiliado', 'ac_afiliados.tipo_afiliado',"=", 'ac_tipo_afiliado.id')
            ->join('ac_planes_extranet', 'ac_planes_extranet.codigo_plan',"=", 'ac_contratos.codigo_plan')
            ->join('ac_colectivos', 'ac_colectivos.codigo_colectivo',"=", 'ac_contratos.codigo_colectivo')
            ->join('ac_aseguradora', 'ac_colectivos.codigo_aseguradora',"=", 'ac_aseguradora.codigo_aseguradora')
            ->select('codigo_contrato','cedula_afiliado','ac_afiliados.nombre as nombre_afiliado','ac_afiliados.apellido as apellido_afiliado',
                    'ac_planes_extranet.nombre as plan','ac_colectivos.nombre as colectivo','ac_aseguradora.nombre as aseguradora','ac_tipo_afiliado.nombre as tipo_afiliado')
            ->get();

        return $contratos;
    }

    public function getBeneficiario($cedula_afiliado)
    {
        $beneficiario = AcContrato::where([['cedula_afiliado', '=', $cedula_afiliado],['fecha_inicio','<=',date('Y-m-d').' 00:00:00'],['fecha_fin','>=',date('Y-m-d').' 00:00:00']])
            ->join('ac_afiliados', 'ac_afiliados.cedula',"=", 'ac_contratos.cedula_afiliado')
            ->join('ac_tipo_afiliado', 'ac_afiliados.tipo_afiliado',"=", 'ac_tipo_afiliado.id')
            ->join('ac_planes_extranet', 'ac_planes_extranet.codigo_plan',"=", 'ac_contratos.codigo_plan')
            ->join('ac_colectivos', 'ac_colectivos.codigo_colectivo',"=", 'ac_contratos.codigo_colectivo')
            ->join('ac_aseguradora', 'ac_colectivos.codigo_aseguradora',"=", 'ac_aseguradora.codigo_aseguradora')
            ->select('codigo_contrato','cedula_afiliado','ac_afiliados.nombre as nombre_afiliado','ac_afiliados.apellido as apellido_afiliado',
                    'ac_planes_extranet.nombre as plan','ac_colectivos.nombre as colectivo','ac_aseguradora.nombre as aseguradora','ac_tipo_afiliado.nombre as tipo_afiliado')
            ->get();

        return $beneficiario;
    }

    public function getProveedores(Request $request)
    {
        $term = strtoupper($request->q);
        $proveedoresC = AcEspecialidadesExtranet::
            where([['rama', '=', 1] , ['nombre', 'like', '%'.$term.'%']])
            ->join('ac_proveedores_extranet', 'ac_proveedores_extranet.codigo_especialidad',"=", 'ac_especialidades_extranet.codigo_especialidad')
            ->select('codigo_proveedor','nombre')
            ->orderBy('codigo_proveedor','desc')
            ->get();
             
        return response()->json($proveedoresC);
    }
} 