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

use Zofe;
use DB;
use Session;
use Mail;

class IncidenciasController extends Controller
{  
 public function getFilter(){
     $user = \Auth::user();  
     $proveedor = $user->proveedor;
     $query = DB::table('ac_facturas')
                ->where([
                        ['ac_proveedores_extranet.codigo_proveedor', '=', $proveedor],
                        ['ac_facturas.codigo_estatus', '=', 4 ]                   
                     ])
            ->join('ac_proveedores_extranet', 'ac_proveedores_extranet.codigo_proveedor',"=", 'ac_facturas.codigo_proveedor_creador')
            ->select('ac_facturas.id as id',
                     'ac_facturas.codigo_proveedor_creador as idProveedor',
                     'ac_facturas.numero_factura as numero_factura',
                     'ac_facturas.numero_control as numero_control',                        
                     'ac_facturas.fecha_factura  as fecha_factura',                                                
                     'ac_facturas.monto as monto',
                     'ac_proveedores_extranet.nombre as proveedor'); 
       $filter = \DataFilter::source($query); 
       $filter->add('ac_facturas.numero_factura','Número de Factura','number');
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
       $grid->add('fecha_factura|strtotime|date[d/m/Y]','Fecha Factura', false);
       $grid->add('monto','Monto', false);
       $grid->add('proveedor','Proveedor', false);
       $grid->addActions('/altocentro/public/incidencias/procesarIncidencias', 'Ver','show','id');
        
      if (isset($_GET['export'])){        
            return $grid->buildCSV('incidencias','.Y-m-d.His');
        }else{
            $grid->paginate(10);
            return  view('incidencias.consultar', compact('filter','grid'));
        }
    }
    
    public function show(Request $request){
        $id['idFactura'] = $request->input('show'); 
        if (isset($id['idFactura'])){
            $factura    = AcFactura::where('id','=',$id['idFactura'])->first();
            $claves     = AcClave::where('id_factura','=',$id['idFactura'])->get();
            $cartasAval = AcCartaAval::where('id_factura','=',$id['idFactura'])->get();
            return view('incidencias.procesar', compact('factura','claves','cartasAval'));
        }else{
            return redirect()->back()->withInput()->with('message', 'Faltan parámetros.');
        }
    }
     
    
 public function gestionar(Request $request)
 {   
     // Pasar Clave a Conciliacio estatus 6
        try {
            $claves  = AcClave::where('id_factura','=',$request->idFactura);
            $claves->estatus_clave = 6; /* Conciliado */  
        }catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e){
            Session::flash('message', 'Factura No Encontrada !');
        }catch(\Illuminate\Database\QueryException $e){
            Session::flash('message', 'Factura No Encontrada !');
        }catch (Exception $e) {
            Session::flash('message', 'Factura No Encontrada !');
        }
        try {
            $cartasAval = AcCartaAval::where('id_factura','=',$request->idFactura);
            $cartasAval->estatus = 6;  /* Conciliado */  
        }catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e){
            Session::flash('message', 'Factura No Encontrada !');
        }catch(\Illuminate\Database\QueryException $e){
            Session::flash('message', 'Factura No Encontrada !');
        }catch (Exception $e) {
            Session::flash('message', 'Factura No Encontrada !');
        }
     $factura = AcFactura::findOrFail($request->idFactura);
     $factura->numero_factura = $request->numero_factura;
     $factura->numero_control = $request->numero_control;
     $factura->monto          = $request->monto;
     $factura->codigo_estatus = 5; /* Pendiente por Aprobacion */
     /* Validacion de Archivos, que sean menor o igual a 5, y de tipo jpg,pdf,png,doc */
     if (count($request->fileid) > 0) {
        if (($this->validarArchivos($request->fileid, $request ))){        
           if ($this->subirArchivo($request->idFactura, $request->idProveedor,$request->fileid[0])) {
               $factura->documento = $request->fileid[0];
           }else{
                    Session::flash('respuesta', 'Ocurrió un error al subir el Archivo '.$request->fileid[0]);
                    return redirect()->to($this->getRedirectUrl())->withInput($request->input()); 
                 }
        }else{
            return redirect()->to($this->getRedirectUrl())->withInput($request->input());
        }        
     }
     $factura->save();
     Session::flash('status', 'Se ha confirmado el cambio!');
     return  redirect()->back();
  }        
  
   public  function subirArchivo($idFactura, $idProveedor,$nombre_archivo){ 
    $path_definitivo = $idProveedor.'/'.$idFactura.'/';
    
    \Storage::disk('local')->put($nombre_archivo,\File::get('/files/'.$nombre_archivo));
    \Storage::makeDirectory($path_definitivo);
    \Storage::move($nombre_archivo, $path_definitivo.$nombre_archivo);
    \Storage::delete($nombre_archivo);
    return true;        
  } 
  
    public function validarArchivos($archivos,$request ){ 
        if (count($archivos) > 1){
            Session::flash('message', 'Cantidad Máxima de Archivo deben ser uno(1).');
             return false;
        } else{
                for($i = 0; $i < count($archivos); $i++):    
                   $FileType = pathinfo('/files/'.$archivos[$i],PATHINFO_EXTENSION);    
                   if( $FileType != "zip" && $FileType != "ZIP"     ) {
                     Session::flash('message', $archivos[$i].' es de un tipo de Archivo invalido. ');
                     return false;
                   }
                endfor;
                return true;
              }   
    }     
    
    public function emailRechazo(){ 

        $mensaje = null;
        $proveedor = 'PRUEBA DE CORRE0';
        $subject   = 'ESTO ES UNA PRUEBA DEL ASUNTO DEL CORREO ELECTRONICO';
        $data = array(
                     'proveedor' => $proveedor,
                     'subject'   => $subject);
        $fromEmail = 'rayepezj@gmail.com';
        $fromName  = 'Ricardo Yepez(IGG)';
        Mail::send('incidencias.mailRechazo', $data, function($messaje) use ($fromName, $fromEmail)
            {
                $messaje->to($fromEmail,$fromName);
                $messaje->from($fromEmail,$fromName);
                $messaje->subject('EMAIL DE RECHAZO ALTOCENTRO');
            }         
       );
    }
}
