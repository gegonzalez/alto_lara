<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Models\AcClave;
use App\Models\AcEstatus;
use App\Models\AcColectivo;
use App\Models\AcDocumento;
use App\Models\AcFactura;
use App\Models\AcCartaAval;
use App\Models\AcProveedoresExtranet;


use Zofe;
use DB;
use Session;

class AuditoriaController extends Controller
{  

 public function getFilter(){
     $user = \Auth::user();  
     $query = DB::table('ac_facturas')
            ->where('codigo_estatus','=','5') // PENDIENTE POR APROBACION
            ->join('ac_proveedores_extranet', 'codigo_proveedor',"=", 'codigo_proveedor_creador')
            ->select('ac_facturas.id as id',
                     'ac_proveedores_extranet.id as idProveedor',
                     'ac_facturas.numero_factura as numero_factura',
                     'ac_facturas.numero_control as numero_control',                        
                     'ac_facturas.fecha_factura  as fecha_factura',                                                
                     'ac_facturas.monto as monto',
                     'ac_proveedores_extranet.nombre as proveedor'); 
       $filter = \DataFilter::source($query); 
       $filter->add('ac_facturas.fecha_factura','Fecha Factura','daterange');
       $filter->add('ac_facturas.numero_factura','Número de Factura','number');
       $filter->add('ac_proveedores_extranet.codigo_proveedor','Seleccione una Opción','select')->option('','Seleccione Una Opción')->options(AcProveedoresExtranet::lists('nombre', 'codigo_proveedor')->all()); 
       $filter->submit('Buscar');
       $filter->reset('reset');
       $filter->build();
        
       $grid = \DataGrid::source($filter);
       $url = new Zofe\Rapyd\Url();
       $grid->link($url->append('export',1)->get(),"Exportar a Excel", "TR");
       $grid->attributes(array("class"=>"table table-grid"));
       $grid->add('id','ID', false);
       $grid->add('numero_factura','Número de Factura', false);   
       $grid->add('numero_control','Número de Control', false);   
       $grid->add('numero_factura','Número de Factura', false);       
       $grid->add('fecha_factura|strtotime|date[d/m/Y]','Fecha de Factura', false);
       $grid->add('monto','Monto', false);
       $grid->add('proveedor','Proveedor', false);
       $grid->addActions('/altocentro/public/auditoria/procesarClavesAtencion', 'Ver','show','id');
        
      if (isset($_GET['export'])){        
            return $grid->buildCSV('auditoria','.Y-m-d.His');
        }else{
            $grid->paginate(10);
            return  view('auditorias.auditoriaClavesAtencion', compact('filter','grid'));
        }
    }
    
    public function show(Request $request){
        $id['idFactura'] = $request->input('show'); 
        if (isset($id['idFactura'])){
//            $clave  = DB::table('ac_facturas')
//                    ->where([['ac_facturas.id', '=' , $id['idFactura']]])
//                     ->join('ac_claves', 'ac_claves.id_factura',"=", 'ac_facturas.id')
//                    ->select('ac_claves.clave as clave',
//                            'ac_claves.codigo_contrato as contrato',
//                            'ac_claves.fecha_cita as fecha_cita',                            
//                            'ac_claves.motivo as motivo',
//                            'ac_claves.observaciones as observaciones'
//                            )
//                    ->get(); // +++++++ array(StdClass)  
            $factura    = AcFactura::where('id','=',$id['idFactura'])->first();
            $claves     = AcClave::where('id_factura','=',$id['idFactura'])->get();
            $cartasAval = AcCartaAval::where('id_factura','=',$id['idFactura'])->get();
            return view('auditorias.procesarClavesAtencion', compact('factura','claves','cartasAval'));
        }else{
            return redirect()->back()->withInput()->with('message', 'Faltan parámetros.');
        }
    }
     
     
    public function detalleClaveAtencion(Request $request){
        $id['clave'] = $request->input('clave'); 
        if (isset($id['clave'])){
            $clave  = DB::table('ac_claves')
                    ->where([['ac_claves.clave', '=', $id['clave']]])
                     ->join('ac_afiliados'     , 'ac_afiliados.cedula',"=", 'ac_claves.cedula_afiliado')
                     ->join('ac_tipo_afiliado' , 'ac_afiliados.tipo_afiliado',"=", 'ac_tipo_afiliado.id')
                     ->join('ac_contratos'     , 'ac_contratos.cedula_afiliado',"=",'ac_claves.cedula_afiliado')
                     ->join('ac_colectivos'    , 'ac_colectivos.codigo_colectivo',"=", 'ac_contratos.codigo_colectivo') 
                     ->join('ac_aseguradora'   , 'ac_aseguradora.codigo_aseguradora',"=", 'ac_colectivos.codigo_aseguradora')
                     ->join('ac_estatus'       , 'ac_estatus.id',"=", 'ac_claves.estatus_clave')
                    ->select('ac_claves.cedula_afiliado as cedula_afiliado', 
                             'ac_claves.id as id_clave',
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
                    ->where([['ac_claves.clave', '=', $id['clave']]])
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
                
            return view('auditorias.detalleClaveAtencion', compact('clave','clave_detalle'));            
        }
    }
     
    protected function download(Request $request)
    {
        $doc = AcFactura::findOrFail($request->idFactura);
        $nombre = $doc->documento;
        $file_path = public_path('archivos/'.$request->idProveedor.'/'.$request->idFactura.'/'.$nombre);
        return response()->download($file_path);
    }   
    
    public function aprobar(Request $request){
        try {
            $factura = AcFactura::findOrFail($request->id_factura);
            $factura->codigo_estatus = 3;   //APROBADO  
            $factura->save();
            
            $clave = DB::table('ac_claves')
            ->where('id_factura', $request->id_factura)
            ->update(['estatus_clave' => 9]);
            
             $cartaAval = DB::table('ac_carta_aval')
            ->where('id_factura', $request->id_factura)
            ->update(['estatus' => 9]);            
             
            Session::flash('status', 'Factura ´Aprobada !');
        }catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e){
            Session::flash('message', 'Factura No Encontrada !');
        }catch(\Illuminate\Database\QueryException $e){
            Session::flash('message', 'Factura No Encontrada !');
        }catch (Exception $e) {
            Session::flash('message', 'Factura No Encontrada !');
        }
        return redirect('auditoria/consultar');
    }
    
        
    public function rechazar(Request $request){
        try {
            $factura = AcFactura::findOrFail($request->id_factura);
            $factura->codigo_estatus = 4;              // RECHAZADO
            $factura->save();
            $clave = DB::table('ac_claves')
            ->where('id_factura', $request->id_factura)
            ->update(['estatus_clave' => 10]);
             $cartaAval = DB::table('ac_carta_aval')
            ->where('id_factura', $request->id_factura)
            ->update(['estatus' => 10]);
            Session::flash('message', 'Factura ´Rechazada !');
        }catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e){
            Session::flash('message', 'Factura No Encontrada !');
        }catch(\Illuminate\Database\QueryException $e){
            Session::flash('message', 'Factura No Encontrada !');
        }catch (Exception $e) {
            Session::flash('message', 'Factura No Encontrada !');
        }
        return redirect('auditoria/consultar');
    }
    
    public function emailRechazo(Request $request){ 
        $factura = DB::table('ac_facturas')
            ->where([['id_procedimiento', '=', $request->id_factura]])
            ->select('*' )
            ->get();    
        foreach($factura as $data){
            $nroFactura   = $data->numero_factura;
            $nroControl   = $data->numero_control;
            $fechaFactura = $data->fecha_factura;
            $codigo_proveedor = $data->codigo_proveedor_creador;
        }
        
        $proveedor = DB::table('ac_proveedores_extranet')
            ->where('codigo_proveedor', $codigo_proveedor)
            ->select('*' )
            ->get();    
        foreach($proveedor as $data){
            $nombreProveedor  = $data->nombre;
            $emailProveedor   = $data->email;
        }
       
        $subject   = 'ESTO ES UNA PRUEBA DEL ASUNTO DEL CORREO ELECTRONICO';
        $data = array(
                     'proveedor' => $nombreProveedor,
                     'subject'   => $subject,
                     'factura'   => $nroFactura,
                     'nrocontrol' => $nroControl,
                     'fechafactura' => $fechaFactura
                   );
        $fromEmail = $emailProveedor;
        $fromName  = $nombreProveedor;
        Mail::send('facturas.mailRechazo', $data, function($messaje) use ($fromName, $fromEmail)
            {
                $messaje->to($fromEmail,$fromName);
                $messaje->from($fromEmail,$fromName);
                $messaje->subject('Facturas Rechazadas');
            }         
       );
    }    
    
    
    
    
}