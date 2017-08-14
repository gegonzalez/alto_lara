<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;

use App\Http\Requests;

use App\Models\AcClave;
use App\Models\AcAfiliado;
use App\Models\AcProveedoresExtranet;
use App\Models\AcEstatus;
use App\Models\AcAseguradora;
use App\Models\AcColectivo;
use App\Models\AcEspecialidadesExtranet;
use App\Models\AcContrato;

use DB;

class consultarClaveTemporal extends Controller
{  
 public function getFilter()
    {   
       $user = \Auth::user();
     // Analista Proveedor   
      if ($user->type == 3){
       $query = DB::table('ac_claves')
                    ->where([['ac_claves.estatus_clave','=',5],['users.id','=',$user->id]])
                    ->join('ac_claves_detalle'         , 'ac_claves.id',"=",'ac_claves_detalle.id_clave')
                    ->join('ac_afiliados_temporales'   , 'ac_afiliados_temporales.cedula',"=", 'ac_claves.cedula_afiliado')
                    ->join('ac_tipo_afiliado'          , 'ac_afiliados_temporales.tipo_afiliado',"=", 'ac_tipo_afiliado.id')
                    ->join('ac_estatus'                , 'ac_estatus.id',"=",'ac_claves.estatus_clave')
                    ->join('ac_colectivos'             , 'ac_colectivos.codigo_colectivo',"=",'ac_afiliados_temporales.codigo_colectivo')                 
                    ->join('ac_aseguradora'            , 'ac_colectivos.codigo_aseguradora',"=",'ac_afiliados_temporales.codigo_aseguradora')                 
                    ->join('ac_proveedores_extranet'   , 'ac_proveedores_extranet.codigo_proveedor',"=", 'ac_claves_detalle.codigo_proveedor')
                    ->join('ac_especialidades_extranet', 'ac_especialidades_extranet.codigo_especialidad',"=", 'ac_claves_detalle.codigo_especialidad') 
                    ->join('users'                     , 'users.proveedor' ,'=','ac_proveedores_extranet.codigo_proveedor')
                    ->join('user_types'                , 'users.type','=','user_types.id')       
                    ->select('ac_claves.id as id',
                             'ac_claves.fecha_cita as fecha_citas',
                             'ac_claves.cedula_afiliado',
                             'ac_claves.clave as clave',
                             'ac_afiliados_temporales.nombre as nombre_afiliado',
                             'ac_planes_extranet.nombre as plan',
                             'ac_colectivos.nombre as colectivo',
                             'ac_aseguradora.nombre as aseguradora',
                             'ac_tipo_afiliado.nombre as tipo_afiliado',
                             'ac_estatus.nombre as estatus',
                             'ac_especialidades_extranet.descripcion as especialidad',
                             'ac_proveedores_extranet.nombre as proveedor',
                             'ac_estatus.nombre as estatus'
                            );
      }elseif ($user->type == 4) // Analista Aseguradora  
            {
             $query = DB::table('ac_claves')
                    ->where([['ac_claves.estatus_clave','=',5],['users.id','=',$user->id]])
                    ->join('ac_claves_detalle'         , 'ac_claves.id',"=",'ac_claves_detalle.id_clave')
                    ->join('ac_afiliados_temporales'   , 'ac_afiliados_temporales.cedula',"=", 'ac_claves.cedula_afiliado')
                    ->join('ac_tipo_afiliado'          , 'ac_afiliados_temporales.tipo_afiliado',"=", 'ac_tipo_afiliado.id')
                    ->join('ac_estatus'                , 'ac_estatus.id',"=",'ac_claves.estatus_clave')
                    ->join('ac_colectivos'             , 'ac_colectivos.codigo_colectivo',"=",'ac_afiliados_temporales.codigo_colectivo')                 
                    ->join('ac_aseguradora'            , 'ac_colectivos.codigo_aseguradora',"=",'ac_afiliados_temporales.codigo_aseguradora')                 
                    ->join('ac_proveedores_extranet'   , 'ac_proveedores_extranet.codigo_proveedor',"=", 'ac_claves_detalle.codigo_proveedor')
                    ->join('ac_especialidades_extranet', 'ac_especialidades_extranet.codigo_especialidad',"=", 'ac_claves_detalle.codigo_especialidad')   
                    ->join('user_types'                , 'users.type','=','user_types.id')     
                    ->join('users'                     , 'users.proveedor' ,'=','ac_aseguradora.codigo_aseguradora')
                    ->select('ac_claves.id as id',
                             'ac_claves.fecha_cita as fecha_citas',
                             'ac_claves.cedula_afiliado',
                             'ac_claves.clave as clave',
                             'ac_afiliados_temporales.nombre as nombre_afiliado',
                             'ac_planes_extranet.nombre as plan',
                             'ac_colectivos.nombre as colectivo',
                             'ac_aseguradora.nombre as aseguradora',
                             'ac_tipo_afiliado.nombre as tipo_afiliado',
                             'ac_estatus.nombre as estatus',
                             'ac_especialidades_extranet.descripcion as especialidad',
                             'ac_proveedores_extranet.nombre as proveedor',
                             'ac_estatus.nombre as estatus'
                            );
           }else{
                     $query = DB::table('ac_claves')
                            ->where([['ac_claves.estatus_clave','=',5],['users.id','=',$user->id]])
                            ->join('ac_claves_detalle'         , 'ac_claves.id',"=",'ac_claves_detalle.id_clave')
                            ->join('ac_afiliados_temporales'   , 'ac_afiliados_temporales.cedula',"=", 'ac_claves.cedula_afiliado')
                            ->join('ac_tipo_afiliado'          , 'ac_afiliados_temporales.tipo_afiliado',"=", 'ac_tipo_afiliado.id')
                            ->join('ac_estatus'                , 'ac_estatus.id',"=",'ac_claves.estatus_clave')
                            ->join('ac_colectivos'             , 'ac_colectivos.codigo_colectivo',"=",'ac_afiliados_temporales.codigo_colectivo')                 
                            ->join('ac_aseguradora'            , 'ac_colectivos.codigo_aseguradora',"=",'ac_afiliados_temporales.codigo_aseguradora')                 
                            ->join('ac_proveedores_extranet'   , 'ac_proveedores_extranet.codigo_proveedor',"=", 'ac_claves_detalle.codigo_proveedor')
                            ->join('ac_especialidades_extranet', 'ac_especialidades_extranet.codigo_especialidad',"=", 'ac_claves_detalle.codigo_especialidad')  
                            ->join('user_types'                , 'users.type','=','user_types.id')     
                            ->select('ac_claves.id as id',
                                     'ac_claves.fecha_cita as fecha_citas',
                                     'ac_claves.cedula_afiliado',
                                     'ac_claves.clave as clave',
                                     'ac_afiliados_temporales.nombre as nombre_afiliado',
                                     'ac_planes_extranet.nombre as plan',
                                     'ac_colectivos.nombre as colectivo',
                                     'ac_aseguradora.nombre as aseguradora',
                                     'ac_tipo_afiliado.nombre as tipo_afiliado',
                                     'ac_estatus.nombre as estatus',
                                     'ac_especialidades_extranet.descripcion as especialidad',
                                     'ac_proveedores_extranet.nombre as proveedor',
                                     'ac_estatus.nombre as estatus'
                                    );
                }
                
        $filter = \DataFilter::source($query);   
        //->option('0','Seleccione Una Opción')->
        //$filter->add('fecha_cita','Fecha','daterange')->format('dd/mm/yyyy', 'es');
        $filter->add('ac_afiliados_temporales.nombre','Nombre', 'text'); //validation;        
        $filter->add('ac_claves.cedula_afiliado','C.I.','number');//validation;        
        $filter->add('ac_aseguradora.codigo_aseguradora','Seleccione una Opción','select')->option('','Seleccione Una Opción')->options(AcAseguradora::lists('nombre', 'codigo_aseguradora')->all());
        $filter->add('ac_colectivos.codigo_colectivo','Seleccione una Opción','select')->option('','Seleccione Una Opción')->options(AcColectivo::lists('nombre', 'codigo_colectivo')->all());         
        $filter->add('ac_proveedores_extranet.codigo_proveedor','Seleccione una Opción','select')->option('','Seleccione Una Opción')->options(AcProveedoresExtranet::lists('nombre', 'codigo_proveedor')->all()); 
        $filter->add('ac_claves.clave','Clave', 'text');
        $filter->add('ac_estatus.id','Seleccione una opcion ','select')->option('','Seleccione Una Opción')->options(AcEstatus::lists('altocentro.ac_estatus.nombre', 'id')->all());         
        $filter->add('user_types.id','Seleccione una opcion ','select')->option('','Seleccione Una Opción')->options(UserType::lists('user_types.name', 'id')->all());         
        $filter->submit('search');
        $filter->reset('reset');
        $filter->build();

       $grid = \DataGrid::source($filter);
       $grid->attributes(array("class"=>"table table-striped"));
       $grid->add('id','ID', false);
       $grid->add('fecha_cita|strtotime|date[m/d/Y]','Fecha', false);
       $grid->add('clave','Clave', false);   
       $grid->add('cedula_afiliado','Cédula', false);
       $grid->add('nombre_afiliado','Paciente', false);
       $grid->add('especialidad','Especialidad', false);
       // $grid->add('AcProcedimientosMedico.tipo_examen','Procedimiento', true);
       $grid->add('estatus','Estatus', false);
       $grid->add('proveedor','Proveedor', false);
       $grid->addActions('/altocentro/public/claves/consultarDetalle', 'Ver','show','id');
       $grid->paginate(10);
        
        
       return  view('claves.consultarClaveTemporal', compact('filter','grid'));
    }
    
  public function show(Request $request)
    {       
      $id['clave'] = $request->input('show'); 
      if (isset($id['clave'])){
            $clave  = DB::table('ac_claves')
                    ->where([['ac_claves.id', '=', $id['clave']]])
                     ->join('ac_afiliados_temporales' , 'ac_afiliados_temporales.cedula',"=", 'ac_claves.cedula_afiliado')
                     ->join('ac_tipo_afiliado'        , 'ac_afiliados.tipo_afiliado',"=", 'ac_tipo_afiliado.id')
                     ->join('ac_colectivos'           , 'ac_colectivos.codigo_colectivo',"=", 'ac_afiliados_temporales.codigo_colectivo') 
                     ->join('ac_aseguradora'          , 'ac_aseguradora.codigo_aseguradora',"=", 'ac_afiliados_temporales.codigo_aseguradora')
                     ->join('ac_estatus'              , 'ac_estatus.id',"=", 'ac_claves.estatus_clave')
                    ->select('ac_claves.cedula_afiliado as cedula_afiliado', 
                             'ac_claves.id as id_clave',
                             'ac_tipo_afiliado.nombre as tipo_afiliado',
                             'ac_afiliados_temporales.nombre as nombre' ,
                             'ac_afiliados_temporales.apellido as apellido', 
                             'ac_afiliados_temporales.fecha_nacimiento as fecha_nacimiento',
                             'ac_afiliados_temporales.email as email', 
                             'ac_afiliados_temporales.sexo as sexo',
                             'ac_afiliados_temporales.telefono as telefono',
                             'ac_afiliados_temporales.cedula_titular as cedula_titular',
                             'ac_afiliados_temporales.nombre as nombre_titular' ,
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
                
             return view('claves.consultarDetalle', compact('clave','clave_detalle'));
         }
         
        
     }    
}