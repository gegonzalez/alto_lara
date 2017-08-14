<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Models\AcClave;
use App\Models\AcAfiliado;
use App\Models\AcProveedoresExtranet;
use App\Models\AcEstatus;
use App\Models\AcAseguradora;
use App\Models\AcClavesDetalle;
use App\Models\AcColectivo;
use App\Models\AcEspecialidadesExtranet;
use App\Models\AcContrato;
use App\Models\AcTipoProveedor;
use App\Models\AcDocumento;
use App\Models\AcTipoDocumento;
use App\Models\UserType;

use DB;
use Session;

class actualizarAuditoriaController extends Controller
{  

 public function getFilter()
 {      
   $user = \Auth::user();
   // Analista Proveedor   
   if ($user->type == 3){
        $query = DB::table('ac_claves')
                ->where([['users.id','=',$user->id],['ac_claves_detalle.estatus','=',2]])
                ->join('ac_claves_detalle'         , 'ac_claves.id',"=",'ac_claves_detalle.id_clave')               
                ->join('ac_afiliados'              , 'ac_afiliados.cedula',"=", 'ac_claves.cedula_afiliado')
                ->join('ac_contratos'              , 'ac_afiliados.cedula',"=", 'ac_contratos.cedula_afiliado')         
                ->join('ac_tipo_afiliado'          , 'ac_afiliados.tipo_afiliado',"=", 'ac_tipo_afiliado.id')
                ->join('ac_planes_extranet'        , 'ac_planes_extranet.codigo_plan',"=", 'ac_contratos.codigo_plan')
                ->join('ac_colectivos'             , 'ac_colectivos.codigo_colectivo',"=",'ac_contratos.codigo_colectivo')                 
                ->join('ac_aseguradora'            , 'ac_colectivos.codigo_aseguradora',"=",'ac_aseguradora.codigo_aseguradora')                 
                ->join('ac_proveedores_extranet'   , 'ac_proveedores_extranet.codigo_proveedor',"=", 'ac_claves_detalle.codigo_proveedor')  
                ->join('ac_especialidades_extranet', 'ac_especialidades_extranet.codigo_especialidad',"=", 'ac_claves_detalle.codigo_especialidad')                            
                ->join('ac_pacientes_atendidos'    , 'ac_pacientes_atendidos.id_clave_detalle',"=", 'ac_claves_detalle.id')                            
                ->join('ac_servicios_extranet'     ,'ac_servicios_extranet.codigo_servicio',"=", 'ac_claves_detalle.codigo_servicio') 
                ->join('users'                     , 'users.proveedor' ,'=','ac_proveedores_extranet.codigo_proveedor')
                ->join('user_types'                , 'users.type','=','user_types.id')
                ->select('ac_claves_detalle.id as id',
                         'ac_claves.fecha_cita as fecha_citas',
                         'ac_pacientes_atendidos.fecha_atencion as fecha_atencion',                        
                         'ac_claves.cedula_afiliado',
                         'ac_claves.clave as clave',
                         'ac_afiliados.nombre as nombre_afiliado',
                         'ac_claves_detalle.detalle as detalle',
                         'ac_planes_extranet.nombre as plan',
                         'ac_colectivos.nombre as colectivo',
                         'ac_aseguradora.nombre as aseguradora',
                         'ac_tipo_afiliado.nombre as tipo_afiliado',
                         'ac_especialidades_extranet.descripcion as especialidad',
                         'ac_proveedores_extranet.nombre as proveedor',
                         'ac_servicios_extranet.descripcion as servicio'
                        );
   }elseif ($user->type == 4) // Analista Aseguradora  
     {
        $query = DB::table('ac_claves')
                ->where([['users.id','=',$user->id],['ac_claves_detalle.estatus','=',2]])                
                ->join('ac_claves_detalle'         , 'ac_claves.id',"=",'ac_claves_detalle.id_clave')
                ->join('ac_afiliados'              , 'ac_afiliados.cedula',"=", 'ac_claves.cedula_afiliado')
                ->join('ac_contratos'              , 'ac_afiliados.cedula',"=", 'ac_contratos.cedula_afiliado')         
                ->join('ac_tipo_afiliado'          , 'ac_afiliados.tipo_afiliado',"=", 'ac_tipo_afiliado.id')
                ->join('ac_planes_extranet'        , 'ac_planes_extranet.codigo_plan',"=", 'ac_contratos.codigo_plan')
                ->join('ac_estatus'                , 'ac_estatus.id',"=",'ac_claves.estatus_clave')
                ->join('ac_colectivos'             , 'ac_colectivos.codigo_colectivo',"=",'ac_contratos.codigo_colectivo')                 
                ->join('ac_aseguradora'            , 'ac_colectivos.codigo_aseguradora',"=",'ac_aseguradora.codigo_aseguradora')                 
                ->join('ac_proveedores_extranet'   , 'ac_proveedores_extranet.codigo_proveedor',"=", 'ac_claves_detalle.codigo_proveedor')
                ->join('ac_especialidades_extranet', 'ac_especialidades_extranet.codigo_especialidad',"=", 'ac_claves_detalle.codigo_especialidad') 
                ->join('ac_facturas'               , 'ac_facturas.clave',"=", 'ac_claves.clave')        
                ->join('users'                     , 'users.proveedor' ,'=','ac_aseguradora.codigo_aseguradora')
                ->join('user_types'                , 'users.type','=','user_types.id')                
                ->select('ac_claves.id as id',
                         'ac_claves.fecha_cita as fecha_citas',
                         'ac_claves.cedula_afiliado',
                         'ac_claves.clave as clave',
                         'ac_afiliados.nombre as nombre_afiliado',
                         'ac_planes_extranet.nombre as plan',
                         'ac_colectivos.nombre as colectivo',
                         'ac_aseguradora.nombre as aseguradora',
                         'ac_tipo_afiliado.nombre as tipo_afiliado',
                         'ac_estatus.nombre as estatus',
                         'ac_especialidades_extranet.descripcion as especialidad',
                         'ac_proveedores_extranet.nombre as proveedor',
                         'ac_estatus.nombre as estatus',
                         'ac_facturas.numero_factura as numero_factura',
                         'ac_facturas.numero_control as numero_control',                        
                         'ac_facturas.monto as monto',      
                         'ac_facturas.observaciones as observaciones'                           
                        );
     
   }else{        
        $query = DB::table('ac_claves')
                ->where([['ac_claves_detalle.estatus','=',2]])                                
                ->join('ac_claves_detalle'         , 'ac_claves.id',"=",'ac_claves_detalle.id_clave')               
                ->join('ac_afiliados'              , 'ac_afiliados.cedula',"=", 'ac_claves.cedula_afiliado')
                ->join('ac_contratos'              , 'ac_afiliados.cedula',"=", 'ac_contratos.cedula_afiliado')         
                ->join('ac_tipo_afiliado'          , 'ac_afiliados.tipo_afiliado',"=", 'ac_tipo_afiliado.id')
                ->join('ac_planes_extranet'        , 'ac_planes_extranet.codigo_plan',"=", 'ac_contratos.codigo_plan')
                ->join('ac_colectivos'             , 'ac_colectivos.codigo_colectivo',"=",'ac_contratos.codigo_colectivo')                 
                ->join('ac_aseguradora'            , 'ac_colectivos.codigo_aseguradora',"=",'ac_aseguradora.codigo_aseguradora')                 
                ->join('ac_proveedores_extranet'   , 'ac_proveedores_extranet.codigo_proveedor',"=", 'ac_claves_detalle.codigo_proveedor')  
                ->join('ac_especialidades_extranet', 'ac_especialidades_extranet.codigo_especialidad',"=", 'ac_claves_detalle.codigo_especialidad')                            
                ->join('ac_pacientes_atendidos'    , 'ac_pacientes_atendidos.id_clave_detalle',"=", 'ac_claves_detalle.id')                            
                ->join('ac_servicios_extranet'     ,'ac_servicios_extranet.codigo_servicio',"=", 'ac_claves_detalle.codigo_servicio') 
                ->select('ac_claves_detalle.id as id',
                         'ac_claves.fecha_cita as fecha_citas',
                         'ac_pacientes_atendidos.fecha_atencion as fecha_atencion',                        
                         'ac_claves.cedula_afiliado',
                         'ac_claves.clave as clave',
                         'ac_afiliados.nombre as nombre_afiliado',
                         'ac_claves_detalle.detalle as detalle',
                         'ac_planes_extranet.nombre as plan',
                         'ac_colectivos.nombre as colectivo',
                         'ac_aseguradora.nombre as aseguradora',
                         'ac_tipo_afiliado.nombre as tipo_afiliado',
                         'ac_especialidades_extranet.descripcion as especialidad',
                         'ac_proveedores_extranet.nombre as proveedor',
                         'ac_servicios_extranet.descripcion as servicio'
                        );
        }
        $filter = \DataFilter::source($query);           
        $filter->add('ac_claves.fecha_cita','Fecha Cita','daterange');
        $filter->add('ac_tipo_proveedor.id','Seleccione una Opción','select')->option('','Seleccione Una Opción')->options(AcTipoProveedor::lists('descripcion', 'id')->all());
        $filter->add('ac_proveedores_extranet.codigo_proveedor','Seleccione una Opción','select')->option('','Seleccione Una Opción')->options(AcProveedoresExtranet::lists('nombre', 'codigo_proveedor')->all()); 
        $filter->add('ac_afiliados.nombre','Nombre Paciente', 'text'); 
        $filter->add('ac_claves.cedula_afiliado','C.I.','number');
        $filter->add('ac_aseguradora.codigo_aseguradora','Seleccione una Opción','select')->option('','Seleccione Una Opción')->options(AcAseguradora::lists('nombre', 'codigo_aseguradora')->all());
        $filter->add('ac_colectivos.codigo_colectivo','Seleccione una Opción','select')->option('','Seleccione Una Opción')->options(AcColectivo::lists('nombre', 'codigo_colectivo')->all()); 
        $filter->add('ac_claves.clave','Clave', 'text');
        $filter->submit('Buscar','BL',array('class' => 'btn btn-primary'));
        $filter->reset('reset');
        $filter->build();

       $grid = \DataGrid::source($filter);
       $grid->attributes(array("class"=>"table table-grid"));
       $grid->add('id','ID', false);
       $grid->add('fecha_citas|strtotime|date[d/m/Y]','Fecha Cita', false);
       $grid->add('fecha_atencion|strtotime|date[d/m/Y]','Fecha Atención', false);
       $grid->add('servicio','Servicio', false);
       $grid->add('clave','Clave', false);   
       $grid->add('cedula_afiliado','Cédula Afiliado', false);
       $grid->add('nombre_afiliado','Paciente', false);
       $grid->add('detalle','Tipo Atención', false);
       $grid->add('aseguradora','Aseguradora', false);
       $grid->add('colectivo','Colectivo', false);
       $grid->add('proveedor','Proveedor', false);
       $grid->addActions('/altocentro/public/auditoria/actualizarDetalle', 'Ver','show','id');
       $grid->paginate(10);
       return  view('auditorias.actualizarPacienteAtendido', compact('filter','grid'));
    }
    
  public function show(Request $request)
    {        
      $id['clave'] = $request->input('show'); 
      if (isset($id['clave'])){
            $clave  = DB::table('ac_claves')
                    ->where([['ac_claves_detalle.id', '=' , $id['clave']]])
                     ->join('ac_claves_detalle', 'ac_claves_detalle.id_clave',"=", 'ac_claves.id')
                     ->join('ac_afiliados'     , 'ac_afiliados.cedula',"=", 'ac_claves.cedula_afiliado')
                     ->join('ac_tipo_afiliado' , 'ac_afiliados.tipo_afiliado',"=", 'ac_tipo_afiliado.id')
                     ->join('ac_contratos'     , 'ac_contratos.cedula_afiliado',"=",'ac_claves.cedula_afiliado')
                     ->join('ac_colectivos'    , 'ac_colectivos.codigo_colectivo',"=", 'ac_contratos.codigo_colectivo') 
                     ->join('ac_aseguradora'   , 'ac_aseguradora.codigo_aseguradora',"=", 'ac_colectivos.codigo_aseguradora')
                     ->join('ac_estatus'       , 'ac_estatus.id',"=", 'ac_claves.estatus_clave')
                    ->select('ac_claves.cedula_afiliado as cedula_afiliado', 
                             'ac_claves.id as id_clave',
                             'ac_claves_detalle.id as id_clave_detalle',
                             'ac_tipo_afiliado.nombre as tipo_afiliado',
                             'ac_afiliados.nombre as nombre' ,
                             'ac_afiliados.apellido as apellido', 
                             'ac_afiliados.fecha_nacimiento as fecha_nacimiento',
                             'ac_afiliados.email as email', 
                             'ac_afiliados.sexo as sexo',
                             'ac_afiliados.telefono as telefono',
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
            $clave_detalle  = DB::table('ac_claves_detalle')
                    ->where([['ac_claves_detalle.id', '=', $id['clave']]])
                     ->join('ac_claves', 'ac_claves_detalle.id_clave',"=", 'ac_claves.id')
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
            
             $pacienteatendido = DB::table('ac_pacientes_atendidos')
                ->where([['ac_claves_detalle.id', '=', $id['clave']]])
                ->join('ac_claves_detalle', 'ac_pacientes_atendidos.id_clave_detalle',"=", 'ac_claves_detalle.id')                            
                ->select('ac_pacientes_atendidos.fecha_atencion as fecha_atencion',
                         'ac_pacientes_atendidos.patologia as patologia'
                        )
                    ->get(); // +++++++ array(StdClass)    
             
            $documentos = DB::table('ac_documentos')
                ->where([['ac_claves_detalle.id', '=', $id['clave']]])
                ->join('ac_pacientes_atendidos', 'ac_pacientes_atendidos.id',"=", 'ac_documentos.id_paciente')                                
                ->join('ac_claves_detalle', 'ac_pacientes_atendidos.id_clave_detalle',"=", 'ac_claves_detalle.id')                            
                ->join('ac_tipo_documentos', 'ac_tipo_documentos.id',"=", 'ac_documentos.id_tipo_documento')                                
                ->select('ac_documentos.id as id_documento',
                         'ac_documentos.file as file',
                         'ac_tipo_documentos.descripcion as tipo_documento'
                        )
                    ->get(); // +++++++ array(StdClass)     
            
             return view('auditorias.actualizarDetallePacienteAtendido', compact('clave','clave_detalle', 'pacienteatendido','documentos'));
         }
     }    
     
   public function facturar(Request $request)
    {   
      $acClaveDetalles = AcClavesDetalle::findOrFail($request->input('id_clave_detalle'));
      $acClaveDetalles->estatus = 3; /* FACTURACION */
      $acClaveDetalles->save();
      Session::flash('status', 'Actualidado pasado a facturación!');
      return redirect('auditoria/actualizar');
    }    
    
    
}