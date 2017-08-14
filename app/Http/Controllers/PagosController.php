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

class PagosController extends Controller
{  
 public function getFilter(){
     $user = \Auth::user();  
     $query = DB::table('ac_facturas')
            ->where('ac_facturas.codigo_estatus','=','3') // FACTURAS RECHAZADAS
            ->join('ac_proveedores_extranet', 'ac_proveedores_extranet.codigo_proveedor',"=", 'ac_facturas.codigo_proveedor_creador')
            ->join('ac_estatus', 'ac_estatus.id',"=", 'ac_facturas.codigo_estatus')             
            ->select('ac_facturas.id as id',
                     'ac_facturas.codigo_proveedor_creador as idProveedor',
                     'ac_facturas.numero_factura as numero_factura',
                     'ac_facturas.numero_control as numero_control',                        
                     'ac_facturas.fecha_factura  as fecha_factura',                                                
                     'ac_facturas.monto as monto',
                     'ac_proveedores_extranet.nombre as proveedor',
                     'ac_estatus.nombre as nombre_estatus'); 
       $filter = \DataFilter::source($query); 
       $filter->add('ac_facturas.numero_factura','Número de Factura','number');
       $filter->add('ac_facturas.fecha_factura','Fecha Factura','daterange');
       $filter->add('ac_estatus.id','Estatus de la Factura ','select')->option('','Seleccione Una Opción')->options(AcEstatus::lists('altocentro.ac_estatus.nombre', 'id')->all());         
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
       $grid->add('nombre_estatus','Estatus', false);      
        
      if (isset($_GET['export'])){        
            return $grid->buildCSV('pagos','.Y-m-d.His');
        }else{
            $grid->paginate(10);
            return  view('pagos.consultar', compact('filter','grid'));
        }
    }    
}
