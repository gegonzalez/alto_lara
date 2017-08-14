<?php
namespace App\Http\Controllers\ClaveOdontologica;

use DB;
use Session;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ClaveOdontologica\GenerarController;
use App\Models\AcDiente;
use App\Models\AcProcedimientosMedico;
use App\Models\AcTratamientoOdontologico;
use App\Models\AcClaveOdontologica;
use App\Models\AcTipoControl;
use App\Models\AcProveedoresExtranet;
use App\Models\AcAfiliado;
 
 
class TratamientoController extends Controller{
    
    public function buscar(Request $request)
    {
        if(isset($request->cedula)){
            if(empty($request->cedula)){
                return redirect()->back()->withInput()->with('message', 'El campo cédula es obligatorio.');
            }
            else{
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

                $generarController = new GenerarController();
                $contratos = $generarController->getContratos($afiliadoIni->cedula_titular);
                
                if(!empty($contratos)){
                    return view('clavesOdontologicas.tratamientoOdontologico.buscar', compact('contratos'));
                }else{
                    Session::flash('flash_message', 'No tiene contrato vigente!');
                    return view('clavesOdontologicas.tratamientoOdontologico.buscar', compact('contratos'));
                }
            }
        }
        
        return view('clavesOdontologicas.tratamientoOdontologico.buscar');

    }

    public function cargarTratamiento(Request $request)
    {   
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
        $beneficiario['iclave'] = $request->input('iclave');

        $dientes1 =  $this->dientes(1, '<=', 8);
        $dientes2 =  $this->dientes(2, '<=', 16);
        $dientes3 =  $this->dientes(4, '<=', 32);
        $dientes4 =  $this->dientes(3, '<=', 24);
        $dientes5 =  $this->dientes(1, '>', 32);
        $dientes6 =  $this->dientes(2, '>', 37);
        $dientes7 =  $this->dientes(3, '>', 42);
        $dientes8 =  $this->dientes(4, '>', 47);
        $todos    =  $this->dientes(0, '=', 0);

        
        $procedimientos = DB::table('ac_procedimientos_medicos')
            ->where('ac_especialidades_extranet.rama', '=', 1 )
            ->join('ac_especialidades_extranet', 'ac_especialidades_extranet.codigo_especialidad', '=', 'ac_procedimientos_medicos.codigo_especialidad')
            ->orderBy('ac_procedimientos_medicos.codigo_especialidad','asc')
            ->pluck('ac_procedimientos_medicos.tipo_examen', 'ac_procedimientos_medicos.id');

        $cara = DB::table('ac_ubicacion_tratamiento')->pluck('descripcion', 'id');

        return view('clavesOdontologicas/tratamientoOdontologico/tratamiento', compact('dientes1', 'dientes2', 'beneficiario',  
                    'dientes3','dientes4', 'dientes5', 'dientes6', 'dientes7', 'dientes8', 'todos', 'procedimientos', 'cara' ));
    }

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
                    #->toSql(); // sql 

        #return $claves;
        $tipos_control = AcTipoControl::where('id','<',3)->get();
        $tipo_control  = array_pluck($tipos_control,'descripcion','id');
        if($user->type == 3){ // PROVEEDOR   
            $proveedor = AcProveedoresExtranet::where('codigo_proveedor',"=", $user->proveedor)->firstOrFail();
            return view('clavesOdontologicas.tratamientoOdontologico.gestionarDos', compact('beneficiario','claves','proveedor','tipo_control'));
        }else{
            $proveedoresC = DB::table('ac_especialidades_extranet')
                                ->where('rama', '=', 1)
                                ->join('ac_proveedores_extranet', 'ac_proveedores_extranet.codigo_especialidad',"=", 'ac_especialidades_extranet.codigo_especialidad')
                                ->select('codigo_proveedor','nombre')
                                ->get();
            $proveedores = array_pluck($proveedoresC,'nombre', 'codigo_proveedor');
            return view('clavesOdontologicas.tratamientoOdontologico.gestionarDos', compact('beneficiario','claves','proveedores','tipo_control'));
        }
        
    }

    public function buscarPorClave($id, $cedulaAfiliado)
    {
        $tratamiento = AcTratamientoOdontologico::where('id_clave', '=', $id)->get();
        if ($tratamiento->isEmpty()){
            Session::flash('message', 'La clave seleccionada no posee tratamiento cargado, debe procesar un tratamiento!');
            return view('clavesOdontologicas.tratamientoOdontologico.buscar');
        }

        $generarController = new GenerarController();
        $beneficiario = $generarController->getBeneficiario($cedulaAfiliado);
        
        $tratamientos = AcTratamientoOdontologico::where('id_clave', '=', $id)
            ->Join('ac_procedimientos_medicos', 'ac_procedimientos_medicos.id', '=', 'ac_tratamiento_odontologico.id_procedimiento')
            ->Join('ac_clave_odontologica', 'ac_clave_odontologica.id', '=', 'ac_tratamiento_odontologico.id_clave')
            ->Join('ac_ubicacion_tratamiento', 'ac_ubicacion_tratamiento.id', '=', 'ac_tratamiento_odontologico.id_ubicacion')
            ->Join('ac_estatus_detalle', 'ac_estatus_detalle.id', '=', 'ac_tratamiento_odontologico.estatus')
            ->Join('ac_diente', 'ac_diente.id', '=', 'ac_tratamiento_odontologico.id_diente')
            ->select('ac_tratamiento_odontologico.*','ac_procedimientos_medicos.tipo_examen', 'ac_clave_odontologica.clave', 'ac_diente.descripcion',
                'ac_ubicacion_tratamiento.descripcion as cara', 'ac_estatus_detalle.nombre as estatus', 'ac_clave_odontologica.estatus as estatus_clave')
            ->get();

        return view('clavesOdontologicas.tratamientoOdontologico.consulta', compact('tratamientos', 'beneficiario')); 

    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {

        $user = \Auth::user();
        $request = array_add($request, 'codigo_proveedor_creador', $user->proveedor);
        if (isset($request->iclave)){ 
            for ($i=0; $i < $request->input('max'); $i++) { 
                
                $this->validate($request,  [
                    #'id_clave'          => 'required',
                    'id_procedimiento'.$i  => 'required',
                    'diente'.$i            => 'required',
                    'id_ubicacion'.$i      => 'required',
                    'fecha_atencion'       => 'required|date'
                ]);

                if ($request->input(['diente'.$i]) == 'Todos'){
                    $diente = 0; 
                }else{
                    $diente = $request->input(['diente'.$i]);
                }

                $tratamientoOdonto = new AcTratamientoOdontologico();
                $tratamientoOdonto->id_clave         = $request->input(['iclave']);
                $tratamientoOdonto->id_procedimiento = $request->input(['id_procedimiento'.$i]);
                $tratamientoOdonto->id_diente        = $diente;
                $tratamientoOdonto->id_ubicacion     = $request->input(['id_ubicacion'.$i]);
                $tratamientoOdonto->fecha_atencion   = $request->input(['fecha_atencion']);
                $tratamientoOdonto->observaciones    = $request->input(['observasion']);
                $tratamientoOdonto->estatus          = 2;
                $tratamientoOdonto->creador          = $request->input(['codigo_proveedor_creador']);
                $tratamientoOdonto->telefono         = $request->input(['telefono']);
                $tratamientoOdonto->save();
            }

            Session::flash('status', 'Tratamientos registrados exitosamente!');
            return view('clavesOdontologicas.tratamientoOdontologico.buscar');
        }

        Session::flash('message', 'Error al registrar el Tratamiento, intente nuevamente!');
        return view('clavesOdontologicas.tratamientoOdontologico.buscar', compact('contratos'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return Response
     */
    public function edit($id, $cedulaAfiliado)
    {
        $generarController  = new GenerarController();
        $beneficiario       = $generarController->getBeneficiario($cedulaAfiliado);
        $tratamiento        = AcTratamientoOdontologico::findOrFail($id);
        
        $dientes1 =  $this->dientes(1, '<=', 8);
        $dientes2 =  $this->dientes(2, '<=', 16);
        $dientes3 =  $this->dientes(4, '<=', 32);
        $dientes4 =  $this->dientes(3, '<=', 24);
        $dientes5 =  $this->dientes(1, '>', 32);
        $dientes6 =  $this->dientes(2, '>', 37);
        $dientes7 =  $this->dientes(3, '>', 42);
        $dientes8 =  $this->dientes(4, '>', 47);
        $todos    =  $this->dientes(0, '=', 0);

        $procedimientos = $this->getProcedimientosOdontologicos();
        $ubicacion  = DB::table('ac_ubicacion_tratamiento')->pluck('descripcion', 'id');

        return view('clavesOdontologicas.tratamientoOdontologico.edit', compact('beneficiario','tratamiento',
            'dientes1', 'dientes2', 'beneficiario', 'dientes3','dientes4', 'dientes5', 'dientes6',
            'dientes7', 'dientes8', 'todos', 'procedimientos', 'ubicacion'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return Response
     */
    public function show($id)
    {
        $tratamiento = AcTratamientoOdontologico::findOrFail($id);

        return view('tratamientoOdontologicos.edit', compact('tratamiento'));
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
        $this->validate($request,  [
                                    'id_procedimiento'  => 'required',
                                    'id_diente'         => 'required',
                                    'id_ubicacion'      => 'required',
                                    'fecha_atencion'    => 'required|date'
                        ]); 
        $tratamiento = AcTratamientoOdontologico::findOrFail($id);
        $tratamiento->update($request->all());

        Session::flash('status', 'Tratamientos actualizado exitosamente!');
            return view('clavesOdontologicas.tratamientoOdontologico.buscar');
    
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
        AcTratamientoOdontologico::destroy($id);

        Session::flash('flash_message', 'Tratamiento eliminado!');

        return redirect('tratamientoOdonto');
    }

    public function getProcedimientosOdontologicos()
    {
        return $procedimientos = DB::table('ac_procedimientos_medicos')
            ->where('ac_especialidades_extranet.rama', '=', 1 )
            ->join('ac_especialidades_extranet', 'ac_especialidades_extranet.codigo_especialidad', '=', 'ac_procedimientos_medicos.codigo_especialidad')
            ->orderBy('ac_procedimientos_medicos.codigo_especialidad','asc')
            ->pluck('ac_procedimientos_medicos.tipo_examen', 'ac_procedimientos_medicos.id');
    }


    public function dientes($cuadrante, $operador, $id)
    {   
        return  AcDiente::where('cuadrante', '=', $cuadrante)
            ->where('id',  $operador, $id)
            ->orderBy('orden', 'asc')
            ->get();

    }

    public function getTratamientoSeisMese(Request $request)
    {
        $carbon = new Carbon();
        $now = $carbon->now();
        $fecha  = $carbon->subMonths(6)->toDateString();
        $cedula = $request->id_cedula;

        $tratamiento = DB::table('ac_tratamiento_odontologico')
            ->join('ac_clave_odontologica', 'ac_clave_odontologica.id', '=', 'ac_tratamiento_odontologico.id_clave')
            ->where([ ['fecha_atencion', '>', $fecha], ['ac_clave_odontologica.cedula_afiliado', '=', $cedula] ] )
            ->select('id_procedimiento' , 'id_diente', 'id_ubicacion', 'fecha_atencion')
            ->get();

        //$tratamiento->fecha_atencion = $tratamiento->fecha_atencion->addMonth(6)->toDateString();
        return $tratamiento;
         
    }


}