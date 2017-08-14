<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\AcCartaAval;
use App\Models\AcAfiliado;
use App\Models\AcAfiliadoTemporal;
use DB;
use Illuminate\Support\Facades\Session;
use App\Models\UserType;

class AutorizarClaveEspecialesController extends Controller
{  
 public function getFilter()
 {   
      $user = \Auth::user();
   // Analista Proveedor   
      if (($user->type == 1) || ($user->type == 2))
     {
               $query = DB::table('ac_carta_aval')
                        ->where([['ac_carta_aval.estatus','=',5]])
                        ->join('ac_afiliados'              , 'ac_afiliados.cedula',"=", 'ac_carta_aval.cedula_afiliado')
                        ->join('ac_tipo_afiliado'          , 'ac_afiliados.tipo_afiliado',"=", 'ac_tipo_afiliado.id')
                        ->join('ac_estatus'                , 'ac_estatus.id',"=", 'ac_carta_aval.estatus')
                        ->select('ac_carta_aval.id as id_clave',
                                 'ac_carta_aval.fecha_solicitud as fecha_solicitud',
                                 'ac_carta_aval.cedula_afiliado as cedula_afiliado',
                                 'ac_carta_aval.clave as clave',
                                 'ac_afiliados.nombre as nombre_afiliado',
                                 'ac_tipo_afiliado.nombre as tipo_afiliado',
                                 'ac_estatus.nombre as estatus');
                $filter = \DataFilter::source($query);
                $filter->add('ac_carta_aval.fecha_solicitud','Fecha Solicitud','daterange');
                $filter->add('ac_afiliados.nombre','Nombre', 'text'); 
                $filter->add('ac_carta_aval.cedula_afiliado','C.I.','number');    
                $filter->add('ac_carta_aval.clave','Clave', 'text');
                $filter->submit('Buscar');
                $filter->reset('reset');
                $filter->build();

               $grid = \DataGrid::source($filter);
               $grid->attributes(array("class"=>"table table-grid"));
               $grid->add('id_clave','ID', false);   
               $grid->add('fecha_solicitud|strtotime|date[d/m/Y]','Fecha Solicitud', false);               
               $grid->add('clave','Clave', false);   
               $grid->add('cedula_afiliado','Cédula', false);
               $grid->add('nombre_afiliado','Paciente', false);
               $grid->add('tipo_afiliado','Tipo Afiliado', false);
               $grid->add('estatus','Estatus', false);
               $grid->addActions('/altocentro/public/clavesEspeciales/showAfiliados', 'Ver','show','id_clave');
               $grid->orderBy('cedula_afiliado','desc');
               $grid->paginate(10);
               return  view('claves.autorizarClaveEspeciales', compact('filter','grid'));
     }else{
               Session::flash('message', 'Para aprobar dede ser Analista de Alto Cento o un Adimistrador!');
              return redirect()->back();
          }      
    }
    
    public function show(Request $request)
    {       
      $id['carta'] = $request->input('show'); 
      if (isset($id['carta'])){
       $data_clave  = DB::table('ac_carta_aval')
                    ->where([['ac_carta_aval.id', '=', $id['carta']]])
                     ->join('ac_afiliados'  , 'ac_afiliados.cedula'             ,"=",'ac_carta_aval.cedula_afiliado')
                     ->join('ac_contratos'  , 'ac_contratos.cedula_afiliado'    ,"=",'ac_afiliados.cedula')
                     ->join('ac_colectivos' , 'ac_colectivos.codigo_colectivo'  ,"=",'ac_contratos.codigo_colectivo')               
                     ->join('ac_aseguradora', 'ac_colectivos.codigo_aseguradora',"=",'ac_aseguradora.codigo_aseguradora')
                    ->select('ac_carta_aval.cedula_afiliado as cedula_afiliado', 
                             'ac_carta_aval.id as id_clave',
                             'ac_afiliados.id as id_afiliado_temporal',
                             'ac_afiliados.nombre as nombre' ,
                             'ac_afiliados.apellido as apellido', 
                             'ac_afiliados.fecha_nacimiento as fecha_nacimiento',
                             'ac_afiliados.email as email', 
                             'ac_afiliados.sexo as sexo',
                             'ac_carta_aval.telefono as telefono',
                             'ac_afiliados.cedula_titular as cedula_titular',
                             'ac_afiliados.nombre as nombre_titular ',
                             'ac_afiliados.apellido as apellido_titular',
                             'ac_aseguradora.nombre as aseguradora',
                             'ac_colectivos.nombre as colectivo' ,
                             'ac_carta_aval.clave as clave',
                             'ac_carta_aval.codigo_contrato as contrato',
                             'ac_carta_aval.fecha_solicitud as fecha_cita',
                             'ac_carta_aval.motivo as motivo',
                             'ac_carta_aval.documentos as documentos'
                            )
                    ->get(); // +++++++ array(StdClass)
       
                $clave_detalle  = DB::table('ac_carta_aval')
                    ->where([['ac_carta_aval.id', '=', $id['carta']]])
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
         }
         
         return view('claves.procesarClavesEspeciales', compact('data_clave','clave_detalle'));
     }

    public function rechazar(Request $request)
    {   
      $cartaAval = AcCartaAval::findOrFail($request->input('id_clave'));
      $cartaAval->estatus = 4;
      $cartaAval->rechazo = $request->rechazo;
      $cartaAval->save();
      Session::flash('message', 'Clave Rechazada!');
      return redirect('clavesEspeciales/autorizar');
    }        
    
    public function aprobar(Request $request)
    {       
     
//         $afiliado = new AcAfiliado;
//         $afiliadoTemporal = AcAfiliadoTemporal::findOrFail($request->input('id_afiliado_temporal'));
//         $afiliado->cedula            = $afiliadoTemporal->cedula;  
//         $afiliado->nombre            = $afiliadoTemporal->nombre; 
//         $afiliado->apellido          = $afiliadoTemporal->apellido; 
//         $afiliado->fecha_nacimiento  = $afiliadoTemporal->fecha_nacimiento; 
//         $afiliado->email             = $afiliadoTemporal->email; 
//         $afiliado->sexo              = $afiliadoTemporal->sexo; 
//         $afiliado->val_user          = $afiliadoTemporal->val_user; 
//         $afiliado->tipo_afiliado     = $afiliadoTemporal->tipo_afiliado; 
//         $afiliado->telefono          = $afiliadoTemporal->telefono; 
//         $afiliado->cedula_titular    = $afiliadoTemporal->cedula_titular;
//         $afiliado->created_at        = $afiliadoTemporal->created_at;      
//        // $afiliado->save();
     

        $cartaAval = AcCartaAval::findOrFail($request->input('id_clave'));
        $cartaAval->estatus = 3;
        $cartaAval->save();
        Session::flash('status', 'Clave Aprobada!');
        return redirect('clavesEspeciales/autorizar');
    }  
}