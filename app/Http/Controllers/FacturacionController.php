<?php namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\AcFactura;
use App\Models\AcClave;

use Session;
use Input;
use Illuminate\Http\RedirectResponse;

#use Zofe;
use DB;

class FacturacionController extends Controller
{  
    public function gestionar(Request $request)
    {
        $user = \Auth::user();
        $proveedor = $user->proveedor;
        if( (isset($request->clave_buscar) || isset($request->fecha)) ||
            (!empty($request->fecha_desde) && !empty($request->fecha_hasta)) 
        ){
            if( (!empty($request->clave_buscar) || !empty($request->fecha)) ||
                (!empty($request->fecha_desde) && !empty($request->fecha_hasta)) 
              ){
                $tipo = 'individual';
                $query = DB::table('ac_proveedores_extranet')
                    ->where([
                        ['ac_proveedores_extranet.codigo_proveedor', '=', $proveedor],
                        ['ac_claves.estatus_clave', '=', 3 ]                   
                     ])
                    ->join('ac_claves_detalle', 'ac_claves_detalle.codigo_proveedor', '=', 'ac_proveedores_extranet.codigo_proveedor')
                    ->join('ac_claves', 'ac_claves.id', '=', 'ac_claves_detalle.id_clave')
                    ->join('ac_afiliados', 'ac_afiliados.cedula', '=', 'ac_claves.cedula_afiliado')
                    ->join('ac_procedimientos_medicos', 'ac_procedimientos_medicos.id', '=', 'ac_claves_detalle.id_procedimiento')
                    ->join('ac_estatus', 'ac_estatus.id', '=', 'ac_claves.estatus_clave')
                    ->join('ac_especialidades_extranet', 'ac_especialidades_extranet.id', '=', 'ac_proveedores_extranet.codigo_especialidad')
                    ->select('ac_claves.clave', 'ac_claves.id', 'ac_claves.fecha_cita',
                             'ac_claves.cedula_afiliado', 'ac_afiliados.nombre','ac_afiliados.apellido', 
                             'ac_procedimientos_medicos.tipo_examen', 'ac_estatus.nombre as estatus',
                             'ac_especialidades_extranet.descripcion as especialidad');
                if(!empty($request->clave_buscar)){
                    $query->where('ac_claves.clave', '=', $request->clave_buscar);
                }
                if(!empty($request->fecha)){
                    $query->where('ac_claves.fecha_cita', '=', $request->fecha);
                }
                if(!empty($request->fecha_desde) && !empty($request->fecha_hasta)){
                    $tipo = 'global';
                    $query->where('ac_claves.fecha_cita', '>=', $request->fecha_desde);
                    $query->where('ac_claves.fecha_cita', '<=', $request->fecha_hasta);

                    
                }
                $claves = $query->get();

                $query1 = DB::table('ac_proveedores_extranet')
                    ->where([['ac_proveedores_extranet.codigo_proveedor', '=', $proveedor]
                            ,['ac_carta_aval.estatus', '=', 3 ]
                            ])
                    ->join('ac_carta_aval_detalle', 'ac_carta_aval_detalle.codigo_proveedor', '=', 'ac_proveedores_extranet.codigo_proveedor')
                    ->join('ac_carta_aval', 'ac_carta_aval.id', '=', 'ac_carta_aval_detalle.id_carta')
                    ->join('ac_afiliados', 'ac_afiliados.cedula', '=', 'ac_carta_aval.cedula_afiliado')
                    ->join('ac_procedimientos_medicos', 'ac_procedimientos_medicos.id', '=', 'ac_carta_aval_detalle.id_procedimiento')
                    ->join('ac_estatus', 'ac_estatus.id', '=', 'ac_carta_aval.estatus')
                    ->join('ac_especialidades_extranet', 'ac_especialidades_extranet.id', '=', 'ac_proveedores_extranet.codigo_especialidad')
                    ->select('ac_carta_aval.clave', 'ac_carta_aval.id', 'ac_carta_aval.fecha_solicitud','ac_carta_aval.cedula_afiliado'
                            , 'ac_afiliados.nombre', 'ac_afiliados.apellido', 'ac_procedimientos_medicos.tipo_examen', 'ac_estatus.nombre as estatus',
                            'ac_especialidades_extranet.descripcion as especialidad');
                if(!empty($request->clave_buscar)){
                    $query->where('ac_carta_aval.clave', '=', $request->clave_buscar);
                }
                if(!empty($request->fecha)){
                    $query->where('ac_carta_aval.fecha_solicitud', '=', $request->fecha);
                }
                if(!empty($request->fecha_desde) && !empty($request->fecha_hasta)){
                    $query->where('ac_claves.fecha_cita', '>', $request->fecha_desde);
                    $query->where('ac_claves.fecha_cita', '<', $request->fecha_hasta);
                    $tipo = 'global';

                }
                return view('facturacion.gestionar', compact('claves', 'cartas', 'tipo'));
            }
        }
        //return Response()->json($cartas);
        return view('facturacion.gestionar');

    }
    
    public function store(Request $request)
    {
        $user = \Auth::user();
        $proveedor = $user->proveedor;
        $request = array_add($request, 'codigo_proveedor_creador', $proveedor);
        $factura = AcFactura::create($request->all());
        
        return $factura;
    }
    
 public function procesar(Request $request)
 {   
     /* Validacion de Archivos, que sean menor o igual a 5, y de tipo jpg,pdf,png,doc */
     if (count($request->fileid) > 0) {
        if (($this->validarArchivos($request->fileid, $request ))){   
            $request = array_add($request, 'codigo_estatus', 5) /* Pendiente por Aprobacion */; 
            $request = array_add($request, 'documento', $request->fileid[0]) /* Pendiente por Aprobacion */; 
            $insertFactura = $this->store($request);         
            if ($this->subirArchivo($insertFactura->id, $request->codigo_proveedor_creador,$request->fileid[0])) {               
                if($insertFactura){
                    if(is_array(Input::get('id_clave')) || is_array(Input::get('id_aval'))){
                        if(!empty(Input::get('id_clave'))){
                            foreach(Input::get('id_clave') as $id){
                                $acClave = AcClave::findOrFail($id);
                                $acClave->id_factura        = $insertFactura->id;       
                                $acClave->estatus_clave     = 6; /* Conciliada*/
                                $acClave->save(); 
                            }
                        }
                        if(!empty(Input::get('id_aval'))){
                            foreach($claves as $id){
                                $acAval = AcAval::findOrFail($id);
                                $acAval->id_factura  = $insertFactura->id;      
                                $acAval->estatus     = 6; /* conciliada */; 
                                $acAval->save(); 
                            }
                        }
                    }else{
                        if(!empty(Input::get('id_clave'))){
                            $acClave = AcClave::findOrFail(Input::get('id_clave'));
                            $acClave->id_factura        = $insertFactura->id;                          
                            $acClave->estatus_clave     = 6; /* Conciliada*/
                            $acClave->save(); 
                        }
                        if(!empty(Input::get('id_aval'))){
                            $acAval = AcAval::findOrFail(Input::get('id_clave'));
                            $acAval->id_factura        = $insertFactura->id;                          
                            $acAval->estatus     = 6; /* conciliada */; 
                            $acAval->save(); 
                        }
                    }
                    Session::flash('status', 'Factura Nro '.$insertFactura->numero_factura.' cargada correctamente');
                    return view('facturacion.gestionar');
                }else{
                        Session::flash('respuesta', 'Ocurrió un error en la creacion de la factura '.$request->fileid[0]);
                        return redirect()->to($this->getRedirectUrl())->withInput($request->input());     
                      }
            }else{
                Session::flash('respuesta', 'Ocurrió un error al subir el Archivo '.$request->fileid[0]);
                return redirect()->to($this->getRedirectUrl())->withInput($request->input()); 
            }
        }else{
           return redirect()->to($this->getRedirectUrl())->withInput($request->input());
        }        
     }
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
    public function generarPago(Request $request)
    {
    $xml = new DomDocument('1.0', 'UTF-8');
 
    $biblioteca = $xml->createElement('biblioteca');
    $biblioteca = $xml->appendChild($biblioteca);
 
    $libro = $xml->createElement('libro');
    $libro = $biblioteca->appendChild($libro);
 
    $autor = $xml->createElement('autor','Paulo Coelho');
    $autor = $libro->appendChild($autor);
    $titulo = $xml->createElement('titulo','El Alquimista');
    $titulo = $libro->appendChild($titulo);
    $anio = $xml->createElement('anio','1988');
    $anio = $libro->appendChild($anio);
    $editorial = $xml->createElement('editorial','Maxico D.F. - Editorial Grijalbo');
    $editorial = $libro->appendChild($editorial);
 
    $xml->formatOutput = true;
    $el_xml = $xml->saveXML();
    $xml->save('libros.xml');
        
        
        
        
        
        
        
        
        
        
        
        
        
        
//        $array_xml = array(
//                        ['company code'] =>'1',
//                        ['company_name'] =>'ALTOCENTRO',
//                        ['agencies'] => Array(
//                                            ['agency code'] => '1',
//                                                            Array(['agency_name']=> 'AGENCY NAME' )
//                                            ['transactions'] => Array( ['transaction id'] => 'id Transaccion',
//                                                                                          Array(['type_code']=> 'type code',
//                                                                                                ['payment'] =>'0',
//                                                                                                Array( ['call_id'] =>'callid',
//                                                                                                       ['certificate_number'] => 'T-9',
//                                                                                                       ['product_code'] =>'T-10',
//                                                                                                       ['plan_code'] =>'T-11',
//                                                                                                       ['issue_date'] =>'T-12',
//                                                                                                       ['channel_code'] =>'T-13',
//                                                                                                       ['currency_type'] =>'T-14',
//                                                                                                       ['frequency_code'] =>'T-15'
//                                                                                                     )
//                                                                                              )
//                                                
//                                                
//                                                
//                                                                     )
//                            
//                            
//                                             )
//                                           
//            
//            
//                         );
        return $array_xml;
    }
    
}