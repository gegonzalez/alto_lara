<?php 

namespace App\Http\Controllers;

use DB;
use Session;
use Carbon\Carbon;
use App\Models\AcClave;
use App\Models\AcFactura;
use App\Models\AcCartaAval;
use App\Models\AcAseguradora;
use App\Models\AcProveedoresExtranet;
use App\Models\AcTransaccionesProveedor;

class GenerateXmlController extends Controller
{

	public function xmlRecursivo($array, \SimpleXMLElement $xml ){
		
		foreach ($array as $k => $v) {
	        is_array($v)
	        ? $this->xmlRecursivo($v, $xml->addChild($k))
	        : $xml->addChild($k, $v);

	    }

	    return $xml;
	}

	public function getBeneficiario($table, $opcion)
	{	

		if($table ==1){
			$table = 'ac_carta_aval';
			$tableDetalle = 'ac_carta_aval_detalle';
			$tableDetalleCampo = 'ac_carta_aval_detalle.id_carta';
			$tableId = 'ac_carta_aval.id' ;
		}else{
			$table = 'ac_claves';
			$tableDetalle = 'ac_claves_detalle';
			$tableDetalleCampo = 'ac_claves_detalle.id_clave';
			$tableId = 'ac_claves.id' ;
		}

		$query = DB::table('ac_proveedores_extranet' );
        
       
        if($opcion == 1)
        { 
        	$query->select('nombre as name', 'cedula as document_number', 'ac_proveedores_extranet.codigo_proveedor',
        	'codigo_estado as state_code', 'ac_estados.es_desc as state_name', 
        	'ciudad', 'telefono_casa', 'telefono_movil', 'urbanizacion',
        	'tipo_cuenta','numero_cuenta', 'ac_facturas.monto', 'ac_facturas.id as id_factura', $tableId );
        }else{

        	$query->select('nombre as name', 'cedula as document_number', 'ac_proveedores_extranet.codigo_proveedor',
        	'codigo_estado as state_code', 'ac_estados.es_desc as state_name', 
        	'ciudad', 'telefono_casa', 'telefono_movil', 'urbanizacion',
        	'tipo_cuenta','numero_cuenta', DB::raw('SUM(ac_facturas.monto) as montoTotal'));
        }
    	
    	$query->join('ac_estados', 'ac_estados.es_id', '=', 'ac_proveedores_extranet.codigo_estado')
        	->join($tableDetalle, $tableDetalle.'.codigo_proveedor', '=', 'ac_proveedores_extranet.codigo_proveedor')
        	->join($table, $table.'.id', '=', $tableDetalleCampo)
			->join('ac_facturas', 'ac_facturas.id', '=', $table.'.id_factura')
			->groupBy('name', 'document_number', 'state_code', 'state_name', 'ac_proveedores_extranet.codigo_proveedor',
	        	'ciudad', 'telefono_casa', 'telefono_movil', 'urbanizacion',
	        	'tipo_cuenta','numero_cuenta');
		
		if($opcion == 1){
        	$query->groupBy('ac_facturas.id', $tableId);
        }
		#$query;

		$query->where('ac_facturas.status', '=', 9);

		return $query->distinct()->get();
	}

	public function getData()
	{	

		$beneficiarioClave 		 = $this->getBeneficiario(0, 0);
		$beneficiarioAval  		 = $this->getBeneficiario(1, 0);
		$beneficiarioClaveWithId = $this->getBeneficiario(0, 1);
		$beneficiarioAvalWithId  = $this->getBeneficiario(1, 1);

		if(count($beneficiarioClave) > 0){
			for ($i=0; $i < count($beneficiarioClave) ; $i++) { 
				$this->generoArchivo($beneficiarioClave[$i], $beneficiarioClaveWithId, $i, 'clave');
			
			}
		}
		if(count($beneficiarioAval) > 0){
			for ($i=0; $i < count($beneficiarioAval) ; $i++) { 
				$this->generoArchivo($beneficiarioAval[$i], $beneficiarioAvalWithId,  $i.'a', 'aval');
			}
		}
		
	}  

	public function generoArchivo($beneficiario, $beneficiarioWithId, $i, $tabla)
	{
		
		$file 	= date('Ymdhis').$i.'_bulk_sales.xml';
		$ruta   	= public_path('archivos/'.$file);
		$rutaMd5	= public_path('archivos/'.date('Ymdhis').$i.'_md5sum.xml');
		$xml    	= $this->generateXml($beneficiario);
		$md5Xml 	= md5($xml);
		
		$arc = fopen($ruta, 'w');
		fwrite($arc, $xml);
		fclose($arc);

		$arcMD5 = fopen($rutaMd5, 'w');
		fwrite($arcMD5, $md5Xml);
		fwrite($arcMD5, "\t".$file);
		fclose($arcMD5);

		$rutaRemote = '/entrada/';
		$mode = 'FTP_BINARY';
        //Hacemos el upload
        #\FTP::connection()->uploadfile($ruta, $rutaRemote, $mode);
		
		/*	Ejemplo simple para subir archivo al serve ftp		 
		 *
		 
		 $resultado = @ftp_login($cid, "ftpAltoCentro","C4r4c452014");
		@ftp_chdir($cid,$rutaRemote);
		@ftp_put($cid,$arc,$arc,FTP_BINARY);
		 */
		$transaccion = $this->storeTransaccion();
		
		if(count($beneficiarioWithId) > 0){ 
			for ($j=0; $j < count($beneficiarioWithId); $j++) { 
				
				 if($beneficiarioWithId[$j]->codigo_proveedor == $beneficiario->codigo_proveedor )
				{ 	
					if($tabla == 'clave'){
						$transaccion->codigo_proveedor = $beneficiarioWithId[$j]->codigo_proveedor;
						$transaccion->save();

						$acClave = AcClave::findOrFail($beneficiarioWithId[$j]->id);
						$acClave->estatus_clave = 6;
						$acClave->save();
					
					}else{

						$transaccion->codigo_proveedor = $beneficiarioWithId[$j]->codigo_proveedor;
						$transaccion->save();
						
						$acClave = AcCartaAval::findOrFail($beneficiarioWithId[$j]->id);
						$acClave->estatus = 6;
						$acClave->save();

					}


					$acFactura = AcFactura::findOrFail($beneficiarioWithId[$j]->id_factura);
					$acFactura->id_transaccion = $transaccion->id;
					$acFactura->save();
				}
				
			}
		}
			
	}

	public function storeTransaccion()
	{
		$transaccion = [
			#'codigo_proveedor' => $proveedor, 
			'status' => 5,
		];
		
		return AcTransaccionesProveedor::create($transaccion);
	}

	public function generateXml($person)
	{
		$xml    = new \SimpleXMLElement('<bulk_sales xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="bulk_sales.xsd" encoding="utf8"/> ');
        
        $transaccion = AcTransaccionesProveedor::max('id');
        $transaccion = $transaccion+1;	  
		
        $payment_mean_name = 'AHORRO';

		if($person->tipo_cuenta == 11){
			$payment_mean_name = 'CORRIENTE';
		}

		$numero_cuenta = $this->numeroCuentaFormat($person->numero_cuenta);
		$data = array(
			'company code="6"' => array( 
				'company_name' => 'CORPORACION ALTO CENTRO, C.A.',
				'agencies' 	   => array(
					'agency code="804"' => array(
						'agency_name'	=> 'CARACAS', 
						'transactions'  => array(
							'transactions id="'.$transaccion.'"' => array(
								'type_code'	=> 'E',
								'payment'	=> array(
									'call_id' 		 => '1268131',
									'certificate_number' => '0000001268131',
									'product_code' 	 => '91',
									'plan_code' 	 => 'AMP01',
									'issue_date' 	 =>  date('Ymdh'),
									'channel_code'	 => '20160218',
									'currency_type'	 => '0',
									'frequency_code' => '2',
									'beneficiary'	 => array( 
										'person' => array(
											'name' => $person->name,
											'document_type_code' => 'J',
											'document_number' => $person->document_number,
											'address' => array( 
												'country_code' => '1',
												'country_name' => 'VENEZUELA',
												'state_code' => $person->state_code,
												'state_name' => $person->state_name,
												'city_code'  => '1',
												'city_name' => $person->ciudad,
												'municipality_code' => 'N/A',
												'municipality_name' => 'N/A',
												'parish' => 'N/A',
												'zip_code' => 'N/A',
												'street' => 'N/A',
												'estate' => $person->urbanizacion,
												'building' => 'N/A',
												'floor' => 'N/A',
												'number' => 'N/A',
											),
											'type_person type="J"' => array(
												'legal_person' => array(
													'economy_activity_code' => 'B12', 
													'economy_activity' => 'CLINICAS Y HOSPITALES PARTICULARES', 
													'office_telephone1' => $person->telefono_casa,
													'office_telephone2' => $person->telefono_movil,
												),
											),
											'payment_mean' => array(
												'payment_mean_code' => $person->tipo_cuenta, 
												'payment_mean_name' => $payment_mean_name, 
												'payment_type type="AC"' => array(
													'account' => array(
														'number' => $numero_cuenta, 
													), 
												), 
											),
											'receipt' => array(
												'external_id' =>'1268131' , 
												'report_date' => '20160218', 
												'total_amount' => '354', 
												'payment_detail' => array(
													'payment_date' => date('Ymdh'), 
													'beneficiary_payment_mean_number' => $numero_cuenta, 
													'beneficiary_amount' => $person->montototal, 
													'beneficiary_debit_transaction' => '0', 
													'beneficiary_credit_transaction' => '0', 
												),
											),
														
										),
									),
								),
							),
						),
					),
				),
			),
			
		);
		
		$res = $this->xmlRecursivo($data, $xml);
       	$res = $res->asXML();
		$res = str_replace('</payment_mean type="AC">', '</payment_mean_type>', $res);
		$res = str_replace('</type_person type="J">', '</type_person>', $res);
		$res = str_replace('</payment_type type="AC">', '</payment_type>', $res);
		$res = str_replace('</company code="6">', '<company>', $res);
		$res = str_replace('</transactions id="'.$transaccion.'">', '</transactions>', $res);
		$res = str_replace('</agency code="804">', '</agency>', $res);
		#$res = str_replace('<agencies/>', '<agencies>', $res);
		#$res = str_replace('<agencies/>', '<agencies>', $res);
		$res = str_replace('/>', '>', $res);
		

		return $res;
	}

	public function numeroCuentaFormat($numero_cuenta)
	{
		$size = strlen($numero_cuenta);

		if($size == 20){

			for ($i=0; $i < $size; $i++) { 
			
				$char = $numero_cuenta{$i};
				if($i > 5 && $i < 16) {
					$char = '*';
				}
				$form[] = $char;
			}

			return implode($form);
		} 
	}

	public function procesarResponseXml()
	{
		$estatus = 3;
		$ruta 	 = public_path('archivos/BS_RESPONSE.xml');
		$file 	 = \simplexml_load_file($ruta);
		
		$code = $file->company[0]
				->agencies[0]->agency[0]
				->transactions[0]->transaction[0]
				->response[0]->code;

		$transaction = $file->company[0]
				->agencies[0]->agency[0]
				->transactions[0]->transaction[0]['id'];

		

		if($code == 0){
			$estatus = 10;
		}

		$acTransaccionesProveedor = AcTransaccionesProveedor::findOrFail($transaction);
		$acTransaccionesProveedor->status = $estatus;
		$acTransaccionesProveedor->save();

	}
}
