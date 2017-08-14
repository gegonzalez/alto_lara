<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\AcClave;
use App\Models\AcAfiliado;
use App\Models\AcAfiliadoTemporal;
use DB;
use Illuminate\Support\Facades\Session;
use App\Models\UserType;


class AutorizarAfiliadosTemporalesController extends Controller
{  
     public function getFilter()
    {   
      $user = \Auth::user();
   // Analista Proveedor   
      if (($user->type == 1) || ($user->type == 2))
     {    
       $query = DB::table('ac_claves')
                    ->where([['ac_claves.estatus_clave','=',5]])
                    ->join('ac_afiliados_temporales'   , 'ac_afiliados_temporales.cedula',"=", 'ac_claves.cedula_afiliado')
                    ->join('ac_tipo_afiliado'          , 'ac_afiliados_temporales.tipo_afiliado',"=", 'ac_tipo_afiliado.id')
                    ->join('ac_estatus'                , 'ac_estatus.id',"=", 'ac_claves.estatus_clave')
                    ->select('ac_claves.id as id_clave',
                             'ac_claves.fecha_cita as fecha_citas',
                             'ac_claves.cedula_afiliado',
                             'ac_claves.clave as clave',
                             'ac_afiliados_temporales.nombre as nombre_afiliado',
                             'ac_tipo_afiliado.nombre as tipo_afiliado',
                             'ac_estatus.nombre as estatus');

            $filter = \DataFilter::source($query);   
            $filter->add('ac_claves.fecha_cita','Fecha','daterange');
            $filter->add('ac_afiliados_temporales.nombre','Nombre', 'text'); 
            $filter->add('ac_claves.cedula_afiliado','C.I.','number');    
            $filter->add('ac_claves.clave','Clave', 'text');
            $filter->submit('search');
            $filter->reset('reset');
            $filter->build();

           $grid = \DataGrid::source($filter);
           $grid->attributes(array("class"=>"table table-grid"));
            $grid->add('id_clave','ID', false);   
           $grid->add('fecha_citas|strtotime|date[d/m/Y]','Fecha Cita', false);
           $grid->add('clave','Clave', false);   
           $grid->add('cedula_afiliado','Cédula', false);
           $grid->add('nombre_afiliado','Paciente', false);
           $grid->add('tipo_afiliado','Tipo Afiliado', false);
           $grid->add('estatus','Estatus', false);
           $grid->addActions('/altocentro/public/claves/showAfiliados', 'Ver','show','id_clave');
           $grid->orderBy('ac_claves.fecha_cita','desc');
           $grid->paginate(10);
           return  view('claves.autorizarClaveAfiliadosTemporales', compact('filter','grid'));
      }else{
              Session::flash('message', 'Para aprobar dede ser analista de Alto Cento o un Adimistrador!');
              return redirect()->back();
           }      
    }
    
    public function show(Request $request)
    {       
      $id['clave'] = $request->input('show'); 
      if (isset($id['clave'])){
       $data_clave  = DB::table('ac_claves')
                    ->where([['ac_claves.id', '=', $id['clave']]])
                     ->join('ac_afiliados_temporales', 'ac_afiliados_temporales.cedula',"=", 'ac_claves.cedula_afiliado')
                     ->join('ac_aseguradora', 'ac_afiliados_temporales.codigo_aseguradora',"=", 'ac_aseguradora.codigo_aseguradora')
                     ->join('ac_colectivos', 'ac_afiliados_temporales.codigo_colectivo',"=", 'ac_colectivos.codigo_colectivo')               
                    ->select('cedula_afiliado', 
                             'ac_claves.id as id_clave',
                             'ac_afiliados_temporales.id as id_afiliado_temporal',
                             'ac_afiliados_temporales.nombre as nombre' ,
                             'ac_afiliados_temporales.apellido as apellido', 
                             'ac_afiliados_temporales.fecha_nacimiento as fecha_nacimiento',
                             'ac_afiliados_temporales.email as email', 
                             'ac_afiliados_temporales.sexo as sexo',
                             'ac_claves.telefono as telefono',
                             'ac_afiliados_temporales.cedula_titular as cedula_titular',
                             'ac_afiliados_temporales.nombre_titular as nombre_titular ',
                             'ac_afiliados_temporales.apellido_titular as apellido_titular',
                             'ac_aseguradora.nombre as aseguradora',
                             'ac_colectivos.nombre as colectivo' ,
                             'ac_claves.clave as clave',
                             'ac_claves.codigo_contrato as contrato',
                             'ac_claves.fecha_cita as fecha_cita',
                             'ac_claves.motivo as motivo',
                             'ac_claves.observaciones as observaciones'
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
         }
         
         return view('claves.autorizarClaves', compact('data_clave','clave_detalle'));
     }

    public function rechazar(Request $request)
    {   
      $claves = AcClave::findOrFail($request->input('id_clave'));
      $claves->estatus_clave = 4;
      $claves->rechazo = $request->rechazo;
      $claves->observaciones = $claves->observaciones. ' Motivo de Rechazo :'.$request->rechazo;
      $claves->save();
      Session::flash('message', 'Clave Rechazada!');
      return redirect('claves/autorizarAfiliadosTemporales');
   
    }        
    
    public function aprobar(Request $request)
    {       
         $afiliado = new AcAfiliado;
         $afiliadoTemporal = AcAfiliadoTemporal::findOrFail($request->input('id_afiliado_temporal'));
         $afiliado->cedula            = $afiliadoTemporal->cedula;  
         $afiliado->nombre            = $afiliadoTemporal->nombre; 
         $afiliado->apellido          = $afiliadoTemporal->apellido; 
         $afiliado->fecha_nacimiento  = $afiliadoTemporal->fecha_nacimiento; 
         $afiliado->email             = $afiliadoTemporal->email; 
         $afiliado->sexo              = $afiliadoTemporal->sexo; 
         $afiliado->val_user          = $afiliadoTemporal->val_user; 
         $afiliado->tipo_afiliado     = $afiliadoTemporal->tipo_afiliado; 
         $afiliado->telefono          = $afiliadoTemporal->telefono; 
         $afiliado->cedula_titular    = $afiliadoTemporal->cedula_titular;
         $afiliado->created_at        = $afiliadoTemporal->created_at;      
        // $afiliado->save();
         Session::flash('store', 'Clave Aprobada!');

        $claves = AcClave::findOrFail($request->input('id_clave'));
        $claves->estatus_clave = 3;
        $claves->save();

         Session::flash('status', 'Clave Aprobada!');
         return redirect('claves/autorizarAfiliadosTemporales');
    }  
}