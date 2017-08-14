<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\AcPacientesAtendido;
use App\Models\AcDocumento;
use App\Models\AcClavesDetalle;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Session;
use App\Models\UserType;
use \Database\Query\Builder;
use App\Http\Controllers\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use DB;

class PacienteAtendidoController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $pacientesatendidos = AcPacientesAtendido::paginate(15);

        return view('pacientesatendidos.index', compact('pacientesatendidos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('pacientesatendidos.create');
    }

    /**
     * Store a newly created resource in storage.
     * 
    * @return Response
     */
    public function store(Request $request)
    {
      //$this->validate($request, tipo_autorizacion,cedula_afiliado,clave,id_clave_detalle,fecha_atencion,patologia);
        $pacientesAtendidos =  AcPacientesAtendido::create($request->all());
        return  $pacientesAtendidos;
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
//        $pacientesatendido = AcPacientesAtendido::findOrFail($id);
//
//        return view('pacientesatendidos.show', compact('pacientesatendido'));
//    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $pacientesatendido = AcPacientesAtendido::findOrFail($id);

        return view('pacientesatendidos.edit', compact('pacientesatendido'));
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
        $this->validate($request, tipo_autorizacion,cedula_afiliado,clave,id_clave_detalle,fecha_atencion,patologia);

        $pacientesatendido = AcPacientesAtendido::findOrFail($id);
        $pacientesatendido->update($request->all());

        Session::flash('flash_message', 'Registro actualizado!');

        return redirect('pacientesatendidos');
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
        AcPacientesAtendido::destroy($id);

        Session::flash('flash_message', 'Registro eliminado!');

        return redirect('pacientesatendidos');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  
     *
     * @return Response
     */
    public function registar()
    {
        return  view('servicios.buscarServiciosPaciente');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return Response
     */
    public function buscarServicios( Request $request)
    {
           if (isset($request->cedula)){
               $servicio['cedula_afiliado'] = $request->cedula;
           }else{
                  Session::flash('message', 'Debe introducir un numero de cedula del afiliado!');
                  return  view('servicios.buscarServiciosPaciente');                      
           }
           $user = \Auth::user();
           // Analista Proveedor 
           if ($user->type == 3){
                $query = DB::table('ac_claves')
                        ->where([['users.id','=',$user->id],
                                 ['ac_claves.cedula_afiliado','=',$servicio['cedula_afiliado']],
                                 ['ac_claves_detalle.estatus','=',1]])
                        ->join('ac_claves_detalle'         , 'ac_claves.id',"=",'ac_claves_detalle.id_clave')                
                        ->join('ac_afiliados'              , 'ac_afiliados.cedula',"=", 'ac_claves.cedula_afiliado')         
                        ->join('ac_tipo_afiliado'          , 'ac_afiliados.tipo_afiliado',"=", 'ac_tipo_afiliado.id')
                        ->join('ac_contratos'              , 'ac_afiliados.cedula',"=", 'ac_contratos.cedula_afiliado') 
                        ->join('ac_colectivos'             , 'ac_colectivos.codigo_colectivo',"=",'ac_contratos.codigo_colectivo')                  
                        ->join('ac_aseguradora'            , 'ac_colectivos.codigo_aseguradora',"=",'ac_aseguradora.codigo_aseguradora')
                        ->join('ac_proveedores_extranet'   , 'ac_proveedores_extranet.codigo_proveedor',"=", 'ac_claves_detalle.codigo_proveedor')  
                        ->join('ac_especialidades_extranet', 'ac_especialidades_extranet.codigo_especialidad',"=", 'ac_claves_detalle.codigo_especialidad')                            
                        ->join('ac_servicios_extranet'      ,'ac_servicios_extranet.codigo_servicio',"=", 'ac_claves_detalle.codigo_servicio')                    
                        ->join('users'                     , 'users.proveedor' ,'=','ac_proveedores_extranet.codigo_proveedor')
                        ->join('user_types'                , 'users.type','=','user_types.id')
                        ->select('ac_claves_detalle.id as id',
                                 'ac_claves.fecha_cita as fecha_cita',
                                 'ac_claves.cedula_afiliado',
                                 'ac_claves.clave as clave',
                                 'ac_afiliados.nombre as nombre_afiliado',
                                 'ac_aseguradora.nombre as aseguradora',
                                 'ac_proveedores_extranet.nombre as proveedor',
                                 'ac_tipo_afiliado.nombre as tipo_afiliado',
                                 'ac_especialidades_extranet.descripcion as especialidad',
                                 'ac_servicios_extranet.descripcion as servicio'
                                );
           }elseif ($user->type == 4) // Analista Aseguradora  
             {
                $query = DB::table('ac_claves')
                        ->where([['users.id','=',$user->id],
                                 ['ac_claves.cedula_afiliado','=',$servicio['cedula_afiliado']],
                                 ['ac_claves_detalle.estatus','=',1]])
                        ->join('ac_claves_detalle'         , 'ac_claves.id',"=",'ac_claves_detalle.id_clave')                
                        ->join('ac_afiliados'              , 'ac_afiliados.cedula',"=", 'ac_claves.cedula_afiliado')         
                        ->join('ac_tipo_afiliado'          , 'ac_afiliados.tipo_afiliado',"=", 'ac_tipo_afiliado.id')
                        ->join('ac_contratos'              , 'ac_afiliados.cedula',"=", 'ac_contratos.cedula_afiliado') 
                        ->join('ac_colectivos'             , 'ac_colectivos.codigo_colectivo',"=",'ac_contratos.codigo_colectivo')                  
                        ->join('ac_aseguradora'            , 'ac_colectivos.codigo_aseguradora',"=",'ac_aseguradora.codigo_aseguradora')
                        ->join('ac_proveedores_extranet'   , 'ac_proveedores_extranet.codigo_proveedor',"=", 'ac_claves_detalle.codigo_proveedor')  
                        ->join('ac_especialidades_extranet', 'ac_especialidades_extranet.codigo_especialidad',"=", 'ac_claves_detalle.codigo_especialidad')                            
                        ->join('ac_servicios_extranet'      ,'ac_servicios_extranet.codigo_servicio',"=", 'ac_claves_detalle.codigo_servicio')                    
                        ->join('users'                     , 'users.proveedor' ,'=','ac_aseguradora.codigo_aseguradora')
                        ->join('user_types'                , 'users.type','=','user_types.id')                
                        ->select('ac_claves_detalle.id as id',
                                 'ac_claves.fecha_cita as fecha_cita',
                                 'ac_claves.cedula_afiliado',
                                 'ac_claves.clave as clave',
                                 'ac_afiliados.nombre as nombre_afiliado',
                                 'ac_aseguradora.nombre as aseguradora',
                                 'ac_proveedores_extranet.nombre as proveedor',
                                 'ac_tipo_afiliado.nombre as tipo_afiliado',
                                 'ac_especialidades_extranet.descripcion as especialidad',
                                 'ac_servicios_extranet.descripcion as servicio'
                                );               
           }else{        
                $query = DB::table('ac_claves')
                        ->where([['ac_claves.cedula_afiliado','=',$servicio['cedula_afiliado']],
                                 ['ac_claves_detalle.estatus','=',1],])                        
                        ->join('ac_claves_detalle'         , 'ac_claves.id',"=",'ac_claves_detalle.id_clave')                
                        ->join('ac_afiliados'              , 'ac_afiliados.cedula',"=", 'ac_claves.cedula_afiliado')         
                        ->join('ac_tipo_afiliado'          , 'ac_afiliados.tipo_afiliado',"=", 'ac_tipo_afiliado.id')
                        ->join('ac_contratos'              , 'ac_afiliados.cedula',"=", 'ac_contratos.cedula_afiliado') 
                        ->join('ac_colectivos'             , 'ac_colectivos.codigo_colectivo',"=",'ac_contratos.codigo_colectivo')                  
                        ->join('ac_aseguradora'            , 'ac_colectivos.codigo_aseguradora',"=",'ac_aseguradora.codigo_aseguradora')
                        ->join('ac_proveedores_extranet'   , 'ac_proveedores_extranet.codigo_proveedor',"=", 'ac_claves_detalle.codigo_proveedor')  
                        ->join('ac_especialidades_extranet', 'ac_especialidades_extranet.codigo_especialidad',"=", 'ac_claves_detalle.codigo_especialidad')                            
                        ->join('ac_servicios_extranet'      ,'ac_servicios_extranet.codigo_servicio',"=", 'ac_claves_detalle.codigo_servicio')                    
                        ->select('ac_claves_detalle.id as id',
                                 'ac_claves.fecha_cita as fecha_cita',
                                 'ac_claves.cedula_afiliado',
                                 'ac_claves.clave as clave',
                                 'ac_afiliados.nombre as nombre_afiliado',
                                 'ac_aseguradora.nombre as aseguradora',
                                 'ac_proveedores_extranet.nombre as proveedor',
                                 'ac_tipo_afiliado.nombre as tipo_afiliado',
                                 'ac_especialidades_extranet.descripcion as especialidad',
                                 'ac_servicios_extranet.descripcion as servicio'
                                );               
                }

               $grid = \DataGrid::source($query);
               $grid->attributes(array("class"=>"table table-grid"));
               $grid->add('id','ID', false);
               $grid->add('fecha_cita||strtotime|date[d/m/Y]','Fecha Cita', false);
               $grid->add('clave','Clave', false);   
               $grid->add('servicio','Servicio', false);              
               $grid->add('cedula_afiliado','Cédula', false);
               $grid->add('nombre_afiliado','Paciente', false);
               $grid->add('proveedor','Proveedor', false);
               $grid->add('aseguradora','Aseguradora', false);
               $grid->add('especialidad','Especialidad', false);
               $grid->addActions('/altocentro/public/servicios/registrarAtencion', 'Ver','show','id');
               $grid->paginate(10);

                return  view('servicios.buscarServiciosPaciente' , compact('grid'));
    }    
    

    
      public function show(Request $request)
    {       
      $id['clave'] = $request->input('show'); 
      if (isset($id['clave'])){
            $clave  = DB::table('ac_claves_detalle')
                    ->where([['ac_claves_detalle.id', '=', $id['clave']]])
                     ->join('ac_claves'        , 'ac_claves.id',"=", 'ac_claves_detalle.id_clave')                    
                     ->join('ac_afiliados'     , 'ac_afiliados.cedula',"=", 'ac_claves.cedula_afiliado')
                     ->join('ac_tipo_afiliado' , 'ac_afiliados.tipo_afiliado',"=", 'ac_tipo_afiliado.id')
                     ->join('ac_contratos'     , 'ac_contratos.cedula_afiliado',"=",'ac_claves.cedula_afiliado')
                     ->join('ac_colectivos'    , 'ac_colectivos.codigo_colectivo',"=", 'ac_contratos.codigo_colectivo') 
                     ->join('ac_aseguradora'   , 'ac_aseguradora.codigo_aseguradora',"=", 'ac_colectivos.codigo_aseguradora')
                     ->join('ac_estatus'       , 'ac_estatus.id',"=", 'ac_claves.estatus_clave')
                    ->select('ac_claves.cedula_afiliado as cedula_afiliado', 
                             'ac_claves_detalle.id as id_clave_detalle',
                             'ac_tipo_afiliado.nombre as tipo_afiliado',
                             'ac_afiliados.nombre as nombre' ,
                             'ac_afiliados.apellido as apellido', 
                             'ac_afiliados.fecha_nacimiento as fecha_nacimiento',
                             'ac_afiliados.email as email', 
                             'ac_afiliados.sexo as sexo',
                             'ac_claves.telefono as telefono',
                             'ac_afiliados.cedula_titular as cedula_titular',
                             'ac_afiliados.nombre as nombre_titular' ,
                             'ac_aseguradora.nombre as aseguradora',
                             'ac_colectivos.nombre as colectivo' ,
                             'ac_claves.clave as clave',
                             'ac_claves.codigo_contrato as contrato',
                             'ac_claves.fecha_cita as fecha_cita',
                             'ac_claves.motivo as motivo',
                             'ac_claves.observaciones as observaciones',
                             'ac_estatus.nombre as estatus'
                            )
                    ->get(); // +++++++ array(StdClass)
  
            $clave_detalle  = DB::table('ac_claves')
                    ->where([['ac_claves.id', '=', $id['clave']]])
                     ->join('ac_claves_detalle', 'ac_claves_detalle.id_clave',"=", 'ac_claves.id')
                     ->join('ac_servicios_extranet', 'ac_servicios_extranet.codigo_servicio',"=", 'ac_claves_detalle.codigo_servicio')               
                     ->join('ac_especialidades_extranet', 'ac_especialidades_extranet.codigo_especialidad',"=", 'ac_claves_detalle.codigo_especialidad')               
                     ->join('ac_procedimientos_medicos', 'ac_procedimientos_medicos.id',"=", 'ac_claves_detalle.id_procedimiento')               
                     ->join('ac_proveedores_extranet', 'ac_proveedores_extranet.codigo_proveedor',"=", 'ac_claves_detalle.codigo_proveedor')                              
                    ->select('ac_servicios_extranet.descripcion as servicio',
                             'ac_especialidades_extranet.descripcion as especialidad', 
                             'ac_procedimientos_medicos.tipo_examen as procedimiento',
                             'ac_proveedores_extranet.nombre as proveedor',
                             'ac_claves_detalle.costo as costo',
                             'ac_claves_detalle.detalle as detalle'
                            )
                    ->get(); // +++++++ array(StdClass)
            
            $tipo_documentos = \App\Models\AcTipoDocumento::pluck('descripcion', 'id')->toArray();   
            
             return view('servicios.registrarPacientesAtencion', compact('clave','clave_detalle','tipo_documentos'));
         }
    }
    
 /**
  * Procesar Atencion al Paciente
  * 
  * @return Response 
  */
 public function procesarRegistrar(Request $request)
 {
     /* Tipo Autorizacion = 1, Claves de Atencion */
     $tipo_autorizacion = 1;
     $request = array_add($request, 'tipo_autorizacion', $tipo_autorizacion);
     /* Validacion de Archivos, que sean menor o igual a 5, y de tipo jpg,pdf,png,doc */
     if (($this->validarArchivos($request->fileid, $request ))){        
        $pacientesAtendidos = $this->store($request);
        if ($pacientesAtendidos){ 
          for($i = 0; $i < count($request->fileid); $i++):    
              /* Se cargan los archivo al directorio del afiliado */
              if ($this->subirArchivo($request->clave, $request->cedula_afiliado,$request->fileid[$i])) {
                $documento = new AcDocumento;
                $documento->id_paciente        = $pacientesAtendidos->id;
                $documento->id_tipo_documento  = $request->tipo_documentos[$i];
                $documento->file               = $request->fileid[$i];
                $documento->save();
              }else{
                 Session::flash('respuesta', 'Ocurrió un error al subir el Archivo '.$request->fileid[$i]);
                 return redirect()->to($this->getRedirectUrl())
                        ->withInput($request->input()); 
              }
          endfor;    
          $acClaveDetalle = AcClavesDetalle::findOrFail($request->id_clave_detalle);
          $acClaveDetalle->estatus = 2; /* Estatus Atendido*/ 
          $acClaveDetalle->save(); 
          Session::flash('status', 'Se ha Registrado la atencón al paciente!');
          return  view('servicios.buscarServiciosPaciente'); 
        }else{
               Session::flash('respuesta', 'Ocurrió un error al Registar la atención al  paciente');
                return redirect()->to($this->getRedirectUrl())
                        ->withInput($request->input());
        }
     }else{
         return redirect()->to($this->getRedirectUrl())
                        ->withInput($request->input());
     }
  }        
  
   public  function subirArchivo($clave, $cedula_afiliado,$nombre_archivo){ 
    $path_definitivo = $cedula_afiliado.'/'.$clave.'/';
    \Storage::disk('local')->put($nombre_archivo,\File::get('/files/'.$nombre_archivo));
    \Storage::makeDirectory($path_definitivo);
    \Storage::move($nombre_archivo, $path_definitivo.$nombre_archivo);
    \Storage::delete($nombre_archivo);
    return true;        
  } 
  
    public function validarArchivos($archivos,$request ){ 
        if (count($archivos) > 5){
            Session::flash('message', 'Cantidad Máxima de Archivo deben se cinco(5).');
             return false;
        } else{
                for($i = 0; $i < count($archivos); $i++):    
                   $FileType = pathinfo('/files/'.$archivos[$i],PATHINFO_EXTENSION);    
                   if($FileType != "doc" && $FileType != "docx" && $FileType != "jpg" && $FileType != "pdf" && $FileType != "png" &&
                      $FileType != "DOC" && $FileType != "DOCX" && $FileType != "JPG" && $FileType != "PDF" && $FileType != "PNG" &&
                      $FileType != "zip" && $FileType != "ZIP"     ) {
                     Session::flash('message', $archivos[$i].' es de un tipo de Archivo invalido. ');
                     return false;
                   }
                endfor;
                return true;
              }   
    }
          
}