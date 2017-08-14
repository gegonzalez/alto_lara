<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;

use App\Http\Requests;

use App\Models\AcCartaAval;
use App\Models\AcAfiliado;
use App\Models\AcProveedoresExtranet;
use App\Models\AcEstatus;
use App\Models\AcAseguradora;
use App\Models\AcColectivo;
use App\Models\AcEspecialidadesExtranet;
use App\Models\AcContrato;
use App\Models\UserType;

use DB;
Use File;
Use Response;
use Zofe;

class consultarClaveEspecialesController extends Controller
{  

 public function getFilter()
 {        
  $user = \Auth::user();
   // Analista Proveedor   
    $query = DB::table('ac_carta_aval')
                 ->join('ac_carta_aval_detalle'     , 'ac_carta_aval.id',"=",'ac_carta_aval_detalle.id_carta')
                 ->join('ac_afiliados'              , 'ac_afiliados.cedula',"=", 'ac_carta_aval.cedula_afiliado')
                 ->join('ac_contratos'              , 'ac_afiliados.cedula',"=", 'ac_contratos.cedula_afiliado')         
                 ->join('ac_tipo_afiliado'          , 'ac_afiliados.tipo_afiliado',"=", 'ac_tipo_afiliado.id')
                 ->join('ac_planes_extranet'        , 'ac_planes_extranet.codigo_plan',"=", 'ac_contratos.codigo_plan')
                 ->join('ac_estatus'                , 'ac_estatus.id',"=",'ac_carta_aval.estatus')
                 ->join('ac_colectivos'             , 'ac_colectivos.codigo_colectivo',"=",'ac_contratos.codigo_colectivo')                 
                 ->join('ac_aseguradora'            , 'ac_colectivos.codigo_aseguradora',"=",'ac_aseguradora.codigo_aseguradora')                 
                 ->join('ac_proveedores_extranet'   , 'ac_proveedores_extranet.codigo_proveedor',"=", 'ac_carta_aval_detalle.codigo_proveedor')
                 ->join('ac_especialidades_extranet', 'ac_especialidades_extranet.codigo_especialidad',"=", 'ac_carta_aval_detalle.codigo_especialidad') 
                 ->select('ac_carta_aval.id as id',
                          'ac_carta_aval.fecha_solicitud as fecha_solicitud',
                          'ac_carta_aval.cedula_afiliado',
                          'ac_carta_aval.clave as clave',
                          'ac_afiliados.nombre as nombre_afiliado',
                          'ac_planes_extranet.nombre as plan',
                          'ac_colectivos.nombre as colectivo',
                          'ac_aseguradora.nombre as aseguradora',
                          'ac_tipo_afiliado.nombre as tipo_afiliado',
                          'ac_estatus.nombre as estatus',
                          'ac_especialidades_extranet.descripcion as especialidad',
                          'ac_proveedores_extranet.nombre as proveedor',
                          'ac_estatus.nombre as estatus'
                         );

        $filter = \DataFilter::source($query);   
        //->option('0','Seleccione Una Opción')->
        $filter->add('ac_carta_aval.fecha_solicitud','Fecha Solicitud','daterange');
        $filter->add('ac_afiliados.nombre','Nombre', 'text'); //validation;        
        $filter->add('ac_carta_aval.cedula_afiliado','C.I.','number');//validation;        
        $filter->add('ac_aseguradora.codigo_aseguradora','Seleccione una Opción','select')->option('','Seleccione Una Opción')->options(AcAseguradora::lists('nombre', 'codigo_aseguradora')->all());
        $filter->add('ac_colectivos.codigo_colectivo','Seleccione una Opción','select')->option('','Seleccione Una Opción')->options(AcColectivo::lists('nombre', 'codigo_colectivo')->all());         
        $filter->add('ac_proveedores_extranet.codigo_proveedor','Seleccione una Opción','select')->option('','Seleccione Una Opción')->options(AcProveedoresExtranet::lists('nombre', 'codigo_proveedor')->all()); 
        if ($user->type != 3){
            $filter->add('ac_carta_aval.clave','Clave', 'text');
        } 
        $filter->add('ac_estatus.id','Seleccione una opcion ','select')->option('','Seleccione Una Opción')->options(AcEstatus::lists('ac_estatus.nombre', 'id')->all());         
        $filter->add('user_types.id','Seleccione una opcion ','select')->option('','Seleccione Una Opción')->options(UserType::lists('user_types.name', 'id')->all());         
        $filter->submit('Buscar');
        $filter->reset('reset');
        $filter->build();

       $grid = \DataGrid::source($filter);
       $url = new Zofe\Rapyd\Url();
       $grid->link($url->append('export',1)->get(),"Exportar a Excel", "TR");       
       $grid->attributes(array("class"=>"table table-grid"));
       $grid->add('id','ID', false);
       $grid->add('fecha_solicitud|strtotime|date[d/m/Y]','Fecha Solicitud', false);
       if ($user->type != 3){
          $grid->add('clave','Clave', false);   
       }   
       $grid->add('cedula_afiliado','Cédula', false);
       $grid->add('nombre_afiliado','Paciente', false);
       $grid->add('especialidad','Especialidad', false);
       // $grid->add('AcProcedimientosMedico.tipo_examen','Procedimiento', true);
       $grid->add('estatus','Estatus', false);
       $grid->add('proveedor','Proveedor', false);
       $grid->addActions('/altocentro/public/clavesEspeciales/consultarDetalle', 'Ver','show','id');
         
       if (isset($_GET['export'])){      
            return $grid->buildCSV('clavesEspeciales','.Y-m-d.His');
        }else{
            $grid->paginate(10);
            return  view('claves.consultarClaveEspeciales', compact('filter','grid'));
        }       

  }
    
  public function show(Request $request)
    {       
      $id['clave'] = $request->input('show'); 
      if (isset($id['clave'])){
            $clave  = DB::table('ac_carta_aval')
                    ->where([['ac_carta_aval.id', '=', $id['clave']]])
                     ->join('ac_afiliados'     , 'ac_afiliados.cedula',"=", 'ac_carta_aval.cedula_afiliado')
                     ->join('ac_tipo_afiliado' , 'ac_afiliados.tipo_afiliado',"=", 'ac_tipo_afiliado.id')
                     ->join('ac_contratos'     , 'ac_contratos.cedula_afiliado',"=",'ac_carta_aval.cedula_afiliado')
                     ->join('ac_colectivos'    , 'ac_colectivos.codigo_colectivo',"=", 'ac_contratos.codigo_colectivo') 
                     ->join('ac_aseguradora'   , 'ac_aseguradora.codigo_aseguradora',"=", 'ac_colectivos.codigo_aseguradora')
                     ->join('ac_estatus'       , 'ac_estatus.id',"=", 'ac_carta_aval.estatus')
                    ->select('ac_carta_aval.cedula_afiliado as cedula_afiliado', 
                             'ac_carta_aval.id as id_carta',
                             'ac_tipo_afiliado.nombre as tipo_afiliado',
                             'ac_afiliados.nombre as nombre' ,
                             'ac_afiliados.apellido as apellido', 
                             'ac_afiliados.fecha_nacimiento as fecha_nacimiento',
                             'ac_afiliados.email as email', 
                             'ac_afiliados.sexo as sexo',
                             'ac_carta_aval.telefono as telefono',
                             'ac_afiliados.cedula_titular as cedula_titular',
                             'ac_afiliados.nombre as nombre_titular' ,
                             'ac_aseguradora.nombre as aseguradora',
                             'ac_colectivos.nombre as colectivo' ,
                             'ac_carta_aval.clave as clave',
                             'ac_carta_aval.codigo_contrato as contrato',
                             'ac_carta_aval.fecha_solicitud as fecha_cita',
                             'ac_carta_aval.motivo as motivo',
                             'ac_carta_aval.diagnostico as observaciones',
                             'ac_estatus.nombre as estatus',
                             'ac_carta_aval.documentos'
                            )
                    ->get(); // +++++++ array(StdClass)
  
            $clave_detalle  = DB::table('ac_carta_aval')
                    ->where([['ac_carta_aval.id', '=', $id['clave']]])
                     ->join('ac_carta_aval_detalle', 'ac_carta_aval_detalle.id_carta',"=", 'ac_carta_aval.id')
                     ->join('ac_servicios_extranet', 'ac_servicios_extranet.codigo_servicio',"=", 'ac_carta_aval_detalle.codigo_servicio')               
                     ->join('ac_especialidades_extranet', 'ac_especialidades_extranet.codigo_especialidad',"=", 'ac_carta_aval_detalle.codigo_especialidad')               
                     ->join('ac_procedimientos_medicos', 'ac_procedimientos_medicos.id',"=", 'ac_carta_aval_detalle.id_procedimiento')               
                     ->join('ac_proveedores_extranet', 'ac_proveedores_extranet.codigo_proveedor',"=", 'ac_carta_aval_detalle.codigo_proveedor')                              
                    ->select('ac_servicios_extranet.descripcion as servicio',
                             'ac_especialidades_extranet.descripcion as especialidad', 
                             'ac_procedimientos_medicos.tipo_examen as procedimiento',
                             'ac_proveedores_extranet.nombre as proveedor',
                             'ac_carta_aval_detalle.costo as costo',
                             'ac_carta_aval_detalle.detalle as detalle'
                            )
                    ->get(); // +++++++ array(StdClass)
                
             return view('claves.consultarClaveEspecialesDetalle', compact('clave','clave_detalle'));
         }   
     }    
     
    protected function download(Request $request)
    {
        $cartaAval = AcCartaAval::where('clave','=', $request->input('clave'))->first();
        $nombre = $cartaAval->documentos;
        $file_path = public_path('archivos/'.$cartaAval->cedula_afiliado.'/'.$cartaAval->clave.'/'.$nombre);
        return response()->download($file_path);
    }      
}
