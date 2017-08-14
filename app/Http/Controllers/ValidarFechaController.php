<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\AcAfiliado;
use App\Models\AcFeriado;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Session;

class ValidarFechaController extends Controller
{
  /**
   * Validar Que la Fecha de la cita este en el rango de lunes a viernes de la semana actual
   * @param Request
   * @return Response
   */    
    public function validarFecha(Request $request){
        $ArrayDia = array('','1','2','3','4','5','6','7');
        setlocale(LC_ALL,"es_ES");
        $officialDate = Carbon::now();
        $dia = $ArrayDia[date('N', strtotime($officialDate))]; 
        if ($dia > 5){
            return false;
        }else{
            $fecha_lunes    = strtotime ("-".( $dia - 1).' day' , strtotime ( $officialDate ) ) ;
            $fecha_viernes  = strtotime ("+". (5 - $dia).' day' , strtotime ( $officialDate ) ) ;
            $fecha_cita     = $request->fecha_cita;
            if ($fecha_cita > date('Y-m-d',$fecha_viernes)){
                return false;
            }elseif  ($fecha_cita < date('Y-m-d',$fecha_lunes)){
                return false;
            }else{
                return true;
            }
         }
    }
    
 /**
   * Validar Horario Creación de Claves.
   * 
   * @return Response
   */
    public function validarHorario(){
        $officialDate = Carbon::now();
        $feriado = new AcFeriado();
        if(!$officialDate->isWeekend() && ($officialDate->hour >= 6 && $officialDate->hour <= 19) && !($feriado->isFeriado())){
            return true;
        }else{
            return false; 
        }
    }    
}
