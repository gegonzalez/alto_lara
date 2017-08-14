<?php namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AcFeriado extends Model {

    use SoftDeletes;
    /**
     * Generated
     */

    protected $table = 'ac_feriados';
    protected $fillable = ['id', 'dia', 'mes', 'periodo', 'fecha', 'descripcion', 'deleted_at'];
    protected $dates = ['fecha'];
    
     /**
     * The storage format of the model's date columns.
     * @var string
     */
    protected $dateFormat = 'Y-m-d';
    
    function setFechaAttribute($date) {
        $this->attributes['fecha'] = new Carbon($date);
    }
    
    public function isFeriado($fecha=null) {
        if(!isset($fecha)){
            $fecha = date('Y-m-d');
        }
        $feriado = AcFeriado::whereDate('fecha', '=', $fecha)->first();
        if(isset($feriado)){
            return true;
        }else{
            return false;
        }
    }

}
