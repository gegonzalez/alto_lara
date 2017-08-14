<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Models\AcClave;
use App\Models\AcAfiliado;
use App\Models\AcProveedoresExtranet;
use App\Models\AcAseguradora;
use App\Models\UserType;

use DB;
use Session;

class ConfirmarClaveController extends Controller
{  

 public function getFilter()
 {      
   $user = \Auth::user();
   // Analista Proveedor   
   if ($user->type == 3){
          $query = DB::table('ac_claves')
                ->where([['users.id','=',$user->id],['ac_claves.estatus_clave','=',5] ])
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
                ->join('users'                     , 'users.proveedor' ,'=','ac_proveedores_extranet.codigo_proveedor')
                ->join('user_types'                , 'users.type','=','user_types.id')
                ->select('ac_claves.id as id',
                         'ac_claves.fecha_cita as fecha_citas',
                         'ac_claves.cedula_afiliado',
                         'ac_claves.clave as clave',
                         'ac_afiliados.nombre as nombre_afiliado',
                         'ac_colectivos.nombre as colectivo',
                         'ac_aseguradora.nombre as aseguradora',
                         'ac_tipo_afiliado.nombre as tipo_afiliado'
                        );
   }
        $filter = \DataFilter::source($query);   
        $filter->add('ac_claves.fecha_cita','Fecha Cita','daterange');
        $filter->add('ac_claves.cedula_afiliado','C.I.','number');//validation;         
        $filter->add('ac_afiliados.nombre','Nombre', 'text'); //validation;        
        $filter->add('ac_aseguradora.codigo_aseguradora','Seleccione una Opción','select')->option('','Seleccione Una Opción')->options(AcAseguradora::lists('nombre', 'codigo_aseguradora')->all());
        $filter->submit('Buscar');
        $filter->reset('reset');
        $filter->build();
        
       $grid = \DataGrid::source($filter);
       $grid->attributes(array("class"=>"table table-grid"));
       $grid->add('id','ID',false);
       $grid->add('fecha_citas|strtotime|date[d/m/Y]','Fecha Cita', false);
       $grid->add('cedula_afiliado','Cédula', false);
       $grid->add('nombre_afiliado','Nombre Afiliado', false);       
       $grid->add('tipo_afiliado','Tipo Afiliado', false);
       $grid->add('aseguradora','Aseguradora', false);
       $grid->addActions('/altocentro/public/claves/verificarClave', 'Confirmar','show','id'); 
       $grid->paginate(10);
       return  view('claves.confirmarClave', compact('filter','grid'));
    }
    
  public function show(Request $request, $id_clave='')
    {       
      
    if (empty($clave)){
       $id['clave'] = $request->input('show'); 
    }else{
        $id['clave'] = $id_clave; 
    } 
      if (isset($id['clave'])){
            $clave  = DB::table('ac_claves')
                    ->where([['ac_claves.id', '=', $id['clave']]])
                     ->join('ac_afiliados', 'ac_afiliados.cedula',"=", 'ac_claves.cedula_afiliado')
                     ->join('ac_tipo_afiliado' , 'ac_afiliados.tipo_afiliado',"=", 'ac_tipo_afiliado.id')
                    ->select('ac_claves.cedula_afiliado as cedula_afiliado', 
                             'ac_claves.id as id_clave',
                             'ac_tipo_afiliado.nombre as tipo_afiliado',
                             'ac_afiliados.nombre as nombre' ,
                             'ac_afiliados.apellido as apellido'
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
            return view('claves.procesarConfirmar', compact('clave','clave_detalle'));            
         }
     }    
    public function confirmar(Request $request){
        try {
            $clave = DB::table('ac_claves')
            ->where('clave', $request->clave)
            ->update(['estatus_clave' => 3]);
            if ($clave == 0){
               Session::flash('message', 'Clave No Encontrada !'); 
            }else{
                   Session::flash('message', 'Clave ´Aprobada !');
            }
        }catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e){
            Session::flash('message', 'Clave No Encontrada !');
        }catch(\Illuminate\Database\QueryException $e){
            Session::flash('message', 'Clave No Encontrada !');
        }catch (Exception $e) {
            Session::flash('message', 'Clave No Encontrada !');
        }
        return redirect('claves/confirmar');
    }          
}