<?php
namespace App\Http\Controllers\ClaveOdontologica;

use DB;
use Session;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ClaveController;
use App\Models\AcClaveOdontologica;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Controllers\ValidarFechaController;

class ClaveOdontologicaController extends Controller{

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request){
        /**
        * Se Obtiene el id del Usuario y el codigo del Proveedor  de la Session 
        */
        
        $user = \Auth::user();
        $request = array_add($request, 'creador', $user->id);
        
        
        
        
       /**
        * Creacion del campo Clave
        */
        $ClaveControlador = new ClaveController();
        $clave   = $ClaveControlador->RandomClave($length=10,$uc=TRUE,$n=TRUE,$sc=FALSE);     
        $request = array_add($request, 'clave', $clave);
        $request = array_add($request, 'estatus', 1);   //ABIERTO
        
        $this->validate($request,  ['clave'           => 'required|max:10',
                                    'tipo_control'    => 'required',
                                    'cedula_afiliado' => 'required|max:10',
                                    'codigo_contrato' => 'required',
                                    'fecha_atencion1' => 'required|date', 
                                    'telefono'        => 'required',
                                    'codigo_proveedor_creador' => 'required'
                        ]);

        /*if(!($ValidarFecha->validarFecha($request))){
            return redirect('home')->with('message', 'Clave se encuentra fuera de rango de fechas  autorizado.');
        }*/
        $acClave = AcClaveOdontologica::create($request->all());
        //return $acClave;
        if(!$acClave){
            Session::flash('message', 'Ha ocurrido un error al generar la Clave Odontológica!');
        }else{
            Session::flash('status', 'Su clave '. $acClave->clave .' ha sido generada!');
        }
        return  view('clavesOdontologicas.gestionar');
        #return($this->show($acClave->id));
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return Response
     */
//    public function show($id)
//    {
//        $clave = AcClaveOdontologica::findOrFail($id);
//        return view('clavesOdontologicas.show', compact('clave'));
//    }
    public function show(Request $request){
        $id['clave'] = $request->input('show'); 
        if(isset($id['clave'])){
            $clave  = DB::table('ac_clave_odontologica')
                    ->where([['ac_clave_odontologica.id', '=', $id['clave']]])
                     ->join('ac_afiliados'     , 'ac_afiliados.cedula',"=", 'ac_clave_odontologica.cedula_afiliado')
                     ->join('ac_tipo_afiliado' , 'ac_afiliados.tipo_afiliado',"=", 'ac_tipo_afiliado.id')
                     ->join('ac_contratos'     , 'ac_contratos.cedula_afiliado',"=",'ac_clave_odontologica.cedula_afiliado')
                     ->join('ac_colectivos'    , 'ac_colectivos.codigo_colectivo',"=", 'ac_contratos.codigo_colectivo') 
                     ->join('ac_aseguradora'   , 'ac_aseguradora.codigo_aseguradora',"=", 'ac_colectivos.codigo_aseguradora')
                     ->join('ac_estatus'       , 'ac_estatus.id',"=", 'ac_clave_odontologica.estatus')
                    ->select('ac_clave_odontologica.cedula_afiliado as cedula_afiliado', 
                             'ac_clave_odontologica.id as id_clave',
                             'ac_tipo_afiliado.nombre as tipo_afiliado',
                             'ac_afiliados.nombre as nombre' ,
                             'ac_afiliados.apellido as apellido', 
                             'ac_afiliados.fecha_nacimiento as fecha_nacimiento',
                             'ac_afiliados.email as email', 
                             'ac_afiliados.sexo as sexo',
                             'ac_clave_odontologica.telefono as telefono',
                             'ac_afiliados.cedula_titular as cedula_titular',
                             'ac_afiliados.nombre as nombre_titular' ,
                             'ac_aseguradora.nombre as aseguradora',
                             'ac_colectivos.nombre as colectivo' ,
                             'ac_clave_odontologica.clave as clave',
                             'ac_clave_odontologica.codigo_contrato as contrato',
                             'ac_clave_odontologica.fecha_atencion1 as fecha_cita',
                             'ac_clave_odontologica.motivo as motivo',
                             'ac_estatus.nombre as estatus'
                            )
                    ->get(); // +++++++ array(StdClass)
            return view('clavesOdontologicas.show', compact('clave'));            
        }
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
        $clave = AcClaveOdontologica::findOrFail($id);

        return view('clavesOdontologicas.edit', compact('clave'));
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
        $this->validate($request,  ['clave'           => 'required|max:10',
                                    'tipo_control'    => 'required',
                                    'cedula_afiliado' => 'required|max:10',
                                    'codigo_contrato' => 'required',
                                    'fecha_atencion1' => 'required|date', 
                                    'telefono'        => 'required'
                        ]);
        
        $clafe = AcClaveOdontologica::findOrFail($id);
        $clafe->update($request->all());

        Session::flash('flash_message', 'Clave Odontológica actualizada!');

        return redirect('clavesOdonto');
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
        AcClave::destroy($id);

        Session::flash('flash_message', 'Clave Odontológica eliminada!');

        return redirect('clavesOdonto');
    }
}