<?php namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AcContrato extends Model {

    use SoftDeletes;
    /**
     * Generated
     */

    protected $table = 'ac_contratos';
    protected $fillable = ['id', 'codigo_contrato', 'cedula_afiliado', 'fecha_inicio', 'fecha_fin', 'codigo_colectivo', 'codigo_plan', 'deleted_at'];
    protected $dates = ['fecha_inicio','fecha_fin'];

     /**
     * The storage format of the model's date columns.
     * @var string
     */
    protected $dateFormat = 'Y-m-d';
    
    function setFechaInicioAttribute($date) {
        $this->attributes['fecha_inicio'] = new Carbon($date);
    }
    
    function setFechaFinAttribute($date) {
        $this->attributes['fecha_fin'] = new Carbon($date);
    }
    
    public function acColectivo() {
        return $this->belongsTo(\App\Models\AcColectivo::class, 'codigo_colectivo', 'codigo_colectivo');
    }

    public function acAfiliado() {
        return $this->belongsTo(\App\Models\AcAfiliado::class, 'cedula_afiliado', 'cedula');
    }

    public function acPlanesExtranet() {
        return $this->belongsTo(\App\Models\AcPlanesExtranet::class, 'codigo_plan', 'codigo_plan');
    }


}
